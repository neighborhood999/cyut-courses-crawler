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

    public function __construct(Array $config)
    {
        $this->client = new Client();
        // Optional: $this->db = new DB();
        $this->config = $config;
    }

    public function getCourse()
    {
        $this->res = $this->client->request('POST', $this->config['URI'], [
            'verify'       => './config/cacert.pem',
            'form_params'  => $this->config,
        ]);

        $this->body = (string) $this->res->getBody();

        $getBody = ([
            'body'       => $this->body,
            'config'     => ([
                'acy'    => $this->config['h_acy'],
                'sem'    => $this->config['h_sem'],
                'year'   => $this->config['h_year'],
            ])
        ]);

        return $getBody;
    }

    public function crawlerResult($body)
    {
        $this->crawler = new Crawler($body);
        $result = $this->crawler->filter('tr[style="cursor: hand"] td');

        return $result;
    }

    public function chunckResult($result)
    {
        $courseArray = array();

        foreach ($result as $domElement) {
            array_push($courseArray, $domElement->nodeValue);
        }

        $chunk = array_chunk($courseArray, 19);

        return $chunk;
    }

    public function coursesCrawler($data, $config)
    {
        return $this->db->insertCourses($data, $config);
    }
}
