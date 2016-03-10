<?php

namespace Pengjie\CyutCrawler;

use Symfony\Component\DomCrawler\Crawler;

class CyutCourse
{
    private $crawler;
    private $res;
    private $body;
    private $config;
    private $formParams;

    /**
     * 初始化設定檔
     *
     * @param Array $config
     */
    public function __construct(Array $config)
    {
        $this->config = $config;
    }

    /**
     * 各科系代號
     *
     * @param  string $value 透過 Key 尋找科系
     * @return String 回傳科系
     */
    public function findDepartment($value)
    {
        $department = [
            'TJ9' => '資通系',
            'TJ4' => '資工系',
            'TJ2' => '資管系',
            'TC6' => '財金系',
            'TC7' => '企管系',
            'TC8' => '保險系',
            'TC9' => '會計系',
            'TCA' => '休閒系',
            'TCJ' => '行銷系',
            'TCL' => '銀髮系',
            'TD4' => '營建系',
            'TD5' => '工管系',
            'TD6' => '應化系',
            'TD7' => '環管系',
            'TE2' => '建築系',
            'TE3' => '工設系',
            'TE4' => '視傳系',
            'TE5' => '景都系',
            'TF1' => '傳播系',
            'TF2' => '應英系',
            'TF3' => '幼保系',
            'TF4' => '社工系',
        ];

        $findResult = array_key_exists($value, $department);
        if (!$findResult) {
            return;
        }

        return $department[$value];
    }

    /**
     * 設定 POST 相關參數
     *
     * @param  int $year          學年
     * @param  int $semester      學期
     * @param  string $department 科系
     * @param  int $grade         年級
     * @param  string $classType  班級
     * @return Array
     */
    public function settingClientRequest($year, $semester, $department, $grade, $classType)
    {
        $this->formParams = [
            'verify'       => './config/cacert.pem',
            'form_params'  => $this->config['config']($year, $semester, $department, $grade, $classType),
        ];

        return $this->formParams;
    }

    /**
     * 取得搜尋課表後結果
     *
     * @param  object $client
     * @return String
     */
    public function sendRequest($client)
    {
        $this->res = $client->request('POST', $this->config['URI'], $this->formParams);
        $this->body = (string) $this->res->getBody();

        return $this->body;
    }

    /**
     * 設定爬蟲將資訊並爬取資訊
     *
     * @param string $body
     */
    public function setCrawler($body)
    {
        $this->crawler = new Crawler($body);

        return $this->crawler;
    }

    /**
     * 透過 css selector 過濾結果
     *
     * @param  string $body
     * @return Object
     */
    public function crawlerResult($body)
    {
        $crawlerResult = $this->setCrawler($body)
                       ->filter('tr[style="cursor: hand"] td');

        return $crawlerResult;
    }

    /**
     * 將所有資訊 chunck 成陣列
     *
     * @param  object $crawlerResult
     * @return Array
     */
    public function chunckResult($crawlerResult)
    {
        $tmpArray = [];

        foreach ($crawlerResult as $domElement) {
            $text = $domElement->nodeValue;
            $textLength = mb_strlen($text, 'utf-8');
            $regexPattern = '/([\x{4E00}-\x{9FA5}]{2}(-?\d?)|^\d((,\d|[A-Z])|-([A-Z]|\d))(,(\d|[A-Z]))?|^((\d|[A-Z])-[A-Z])|^\d)[A-Z]([A-Z]?|\d?)-[A-Z]?[0-9]+.\d?$/u';
            preg_match($regexPattern, $text, $textMatches);

            if ($textLength >= 6 && $textMatches) {
                $regexForClass = '/^([\x{4E00}-\x{9FA5}]{2}(-?\d?)|^\d((,\d|[A-Z])$|-([A-Z]|\d))(,(\d|[A-Z])$)?|^((\d|[A-Z])-[A-Z])|^\d)/u';
                $lessonTime = $textMatches[1];
                $lessonInWhere = preg_split($regexForClass, $text);

                array_push($tmpArray, array($lessonTime, $lessonInWhere[1]));
            } else {
                array_push($tmpArray, $text);
            }
        }

        $chunkResultArray = array_chunk($tmpArray, 19);
        $splitIntoMultipleDays = $this->isCourseSplitIntoMultipleDays($chunkResultArray);
        $sortChunkResult = $this->sortChunkResultArray($splitIntoMultipleDays);

        return $sortChunkResult;
    }

    /**
     * 確認是否課程是否被拆成多天
     *
     * @param  array  $chunkResultArray
     * @return Array
     */
    public function isCourseSplitIntoMultipleDays($chunkResultArray)
    {
        $days = 1;
        $checkFlag = 0;

        for ($i = 0; $i < count($chunkResultArray); $i++) {
            for ($j = 10; $j < 17; $j++) {
                if ($chunkResultArray[$i][$j] !== '') {
                    array_push($chunkResultArray[$i], $chunkResultArray[$i][$j], $days);
                }
                unset($chunkResultArray[$i][$j]);
                $days++;
            }
            $days = 1;
            $checkFlag = 0;
        }

        return $chunkResultArray;
    }

    /**
     * 重新排列陣列的 key 值
     *
     * @param  array $chunkResultArray
     * @return Array
     */
    public function sortChunkResultArray($chunkResultArray)
    {
        $sortKeyArray = [];

        foreach ($chunkResultArray as $value) {
            $chunkResultArray = array_map(function ($item) {
                return $item;
            }, $value, array_keys($value));
            array_push($sortKeyArray, $chunkResultArray);
        }

        return $sortKeyArray;
    }

    /**
     * 移除不存在班級資料
     *
     * @codeCoverageIgnore
     * @param  array $course
     * @return Array
     */
    public function removeEmptyDepCourses($courses)
    {
        $getNewCourseResult = [];
        $gradeOneToGradeFourTotalClass = 12;

        // 移除不存在的班級
        for ($i = 0; $i < $gradeOneToGradeFourTotalClass; $i++) {
            if (empty($courses[$i][5])) {
                unset($courses[$i]);
            } else {
                array_push($getNewCourseResult, $courses[$i]);
            }
        }

        return $getNewCourseResult;
    }

    /**
     * 爬取該科系 1 - 4 年級所有課表資訊
     *
     * @codeCoverageIgnore
     * @param  object $client
     * @param  int $year          學年
     * @param  int $semester      學期
     * @param  string $department 科系
     *
     * @return Array
     */
    public function crawlingDepartmentCourses($client, $year, $semester, $department)
    {
        $depName = $this->findDepartment($department);
        $coursesArray = [];
        $grade = 1;
        $classes = ['A', 'B', 'C'];

        for ($i = 0; $i < 4; $i++) {
            for ($j = 0; $j < 3; $j++) {
                $classType = $classes[$j];
                $this->settingClientRequest($year, $semester, $department, $grade, $classType);
                $this->sendRequest($client);

                array_push($coursesArray, ([
                    $year,
                    $semester,
                    $depName,
                    $grade,
                    $classType,
                    $this->chunckResult($this->crawlerResult($this->body)),
                ]));
            }
            $grade++;
        }

        $result = $this->removeEmptyDepCourses($coursesArray);

        return $result;
    }
}
