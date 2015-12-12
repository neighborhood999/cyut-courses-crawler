<?php

namespace Pengjie\CyutCrawler;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Pengjie\Config\DB;

class CyutCourse
{
    private $client;
    private $crawler;
    private $res;
    private $body;
    private $config;
    private $db;
    private $year;
    private $semester;
    private $department;
    private $grade;
    private $classType;

    public function __construct(Array $config)
    {
        $this->client = new Client();
        // Optional: $this->db = new DB();
        $this->config = $config;
    }

    public function settingClientRequest()
    {
        $formParams = [
            'verify'       => './config/cacert.pem',
            'form_params'  => $this->config['config']($this->year, $this->semester, $this->department, $this->grade, $this->classType),
        ];

        $this->res = $this->client->request('POST', $this->config['URI'], $formParams);
        $this->body = (string) $this->res->getBody();

        return $this->body;
    }

    public function setCrawler($body)
    {
        $this->crawler = new Crawler($body);

        return $this->crawler;
    }

    public function crawlerResult($body)
    {
        $result = $this->setCrawler($body)
                       ->filter('tr[style="cursor: hand"] td');

        return $result;
    }

    public function chunckResult($result)
    {
        $tmp = array();
        $courseArray = array();

        foreach ($result as $domElement) {
            $text = $domElement->nodeValue;
            $length = mb_strlen($text, 'utf-8');

            if ($length = range(6, 10)) {
                $regex = preg_match(
                    '/([\x{4E00}-\x{9FA5}]+(-?\d?)|\d-\d?|\d?|(\d-[A-Z]))[A-Z]\d?-[0-9]+.\d?/u',
                    $text,
                    $matches
                );
                if ($regex) {
                    $whatTime = preg_split('/[A-Z]\d?-[0-9]+.\d?/u', $matches[0]);
                    $whereClass = preg_split('/^([\x{4E00}-\x{9FA5}]+(-?\d?)|\d-\d?|\d?|(\d-[A-Z]))/u', $matches[0]);
                    array_push($tmp, array($whatTime[0], $whereClass[1]));
                } else {
                    array_push($tmp, $text);
                }
            } else {
                array_push($tmp, $text);
            }
        }

        $chunk = array_chunk($tmp, 19);
        unset($tmp);
        $count = 1;
        $tag = 0;

        for ($i = 0; $i < sizeof($chunk); $i++) {
            for ($j = 10; $j < 17; $j++) {
                if ($chunk[$i][$j] === '') {
                    $count++;
                    unset($chunk[$i][$j]);
                } else {
                    if ($j === 10 && $chunk[$i][10] !== '') {
                        array_push($chunk[$i], array($count));
                        gettype($chunk[$i][10]) !== 'array' ? $chunk[$i][10] = array($chunk[$i][$j]) :
                                                              $chunk[$i][10][0] = $chunk[$i][$j];
                        $tag += 1;
                    } else {
                        if ($tag === 1) {
                            $chunk[$i][19][1] = $count + 1;
                            $chunk[$i][10][1] = $chunk[$i][$j];
                            unset($chunk[$i][$j]);
                        } else {
                            array_push($chunk[$i], array($count));
                            $tag += 1;
                            $chunk[$i][10][0] = $chunk[$i][$j];
                            unset($chunk[$i][$j]);
                        }
                    }
                }
            }
            $count = 1; $tag = 0;
        }

        return $chunk;
    }

    public function crawlingDepartmentCourses($year, $semester, $department)
    {
        $this->year = $year;
        $this->semester = $semester;
        $this->department = $department;
        $tmp = array();
        $depCourses = array();

        for ($i = 1; $i < 5; $i++) {
            for ($j = 0; $j < sizeof($this->config['classType']); $j++) {
                $this->classType = $this->config['classType'][$j];
                $this->grade = $i;
                $this->settingClientRequest();
                array_push($tmp, ([
                    $this->year,
                    $this->grade,
                    $this->semester,
                    $this->chunckResult($this->crawlerResult($this->body)),
                ]));
            }

            if ($i === 4) {
                for ($j = 0; $j < sizeof($this->config['classType']); $j++) {
                    $this->classType = $this->config['classType'][$j];
                    $this->grade = $i;
                    $this->settingClientRequest();
                    array_push($tmp, ([
                        $this->year,
                        $this->grade,
                        $this->semester,
                        $this->chunckResult($this->crawlerResult($this->body)),
                    ]));
                }
            }
        }

        for ($i = 0; $i < sizeof($tmp); $i++) {
            if (sizeof($tmp[$i][3]) === 0) {
                unset($tmp[$i]);
            } else {
                array_push($depCourses, $tmp[$i]);
            }
        }

        unset($tmp);

        for ($i = 0; $i < sizeof($depCourses); $i++) {
            for ($j = 0; $j < sizeof($depCourses[$i][3]); $j++) {
                if ($depCourses[$i][3][$j][0] === '') {
                    unset($depCourses[$i][3][$j]);
                }
            }
        }

        // $result = (['dep' => strtolower($department), 'courses' => $depCourses]);

        return $depCourses;
    }

    public function coursesCrawler($data, $config)
    {
        return $this->db->insertCourses($data, $config);
    }
}
