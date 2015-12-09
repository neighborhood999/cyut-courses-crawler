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
        $courseArray = array();

        foreach ($result as $domElement) {
            array_push($courseArray, $domElement->nodeValue);
        }

        $chunk = array_chunk($courseArray, 19);

        for ($i = 0; $i < sizeof($chunk); $i++) {
            if (sizeof($chunk[$i] !== 19)) {
                array_push($chunk[$i], '');
            }
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

        $result = (['dep' => strtolower($department), 'courses' => $depCourses]);

        return $result;
    }

    public function coursesCrawler($data, $config)
    {
        return $this->db->insertCourses($data, $config);
    }
}
