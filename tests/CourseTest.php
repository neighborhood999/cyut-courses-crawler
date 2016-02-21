<?php

use Pengjie\CyutCrawler\CyutCourse;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class CourseTest extends PHPUnit_Framework_TestCase
{
    private $course;
    private $config;
    private $mockBody;
    private $client;
    private $formParams;

    public function initConfig()
    {
        $this->config = [
            'URI' => '/',
            'classType' => ['A', 'B', 'C'],
            'config' => function ($year, $sem, $dep, $grade, $classType) {
                return [
                    'h_status' => 'run',
                    'h_acy'    => $year,
                    'h_sem'    => $sem,
                    'h_depno'  => $dep,
                    'h_secid'  => 1,
                    'h_subid'  => 4,
                    'h_year'   => $grade,
                    'h_class'  => $classType
                ];
            },
        ];

        return $this->config;
    }

    public function setUp()
    {
        $file = fopen('./config/mockContent.php', 'r');
        $this->mockBody = fgets($file);
        fclose($file);

        $mock = new MockHandler([
            new Response(200, [], $this->mockBody)
        ]);
        $handler = HandlerStack::create($mock);
        $this->client = new Client(['handler' => $handler]);
        $this->course = new CyutCourse($this->initConfig());
        $this->formParams = $this->course->settingClientRequest(104, 2, 'TJ9', 4, 'A');
    }

    public function tearDown()
    {
        $this->course = null;
        $this->config = null;
        $this->client = null;
        $this->mock   = null;
    }

    public function testSettingClientRequest()
    {
        $status = $this->client->request('POST', $this->config['URI'], $this->formParams);

        $this->assertEquals(200, $status->getStatusCode());
    }

    public function testSendRequest()
    {
        // $file = fopen('./config/mockContent.html', 'r');
        // $mockBody = fgets($file);
        // fclose($file);

        $body = $this->course->sendRequest($this->client);
        $this->assertSame($this->mockBody, $body);

        return $body;
    }

    /**
     * @depends testSendRequest
     */
    public function testsCrawler($body)
    {
        $crawler = $this->course->setCrawler($body);
        $getText = $crawler->filter('tr[style="cursor: hand"] td')->text();

        $this->assertEquals(2601, $getText);
    }

    public function testFindDepartment()
    {
        $getDepartment = $this->course->findDepartment('TJ9');

        $this->assertEquals('資通系', $getDepartment);
    }

    /**
     * @expectedException
     */
    public function testFindDepartmentException()
    {
        $getDepartment = $this->course->findDepartment('fuck');
    }

    public function testCrawlerResult()
    {
        $getCrawlerResult = $this->course->crawlerResult($this->mockBody);
        $this->assertEquals(2601, $getCrawlerResult->text());

        return $getCrawlerResult;
    }

    /**
     * @depends testCrawlerResult
     */
    public function testChunkResult($getCrawlerResult)
    {
        $result = $this->course->chunckResult($getCrawlerResult);

        $this->assertCount(9, $result);
    }
}