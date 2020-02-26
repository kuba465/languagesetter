<?php

require 'app\helpers\Request.php';
require 'app\errors\EmptyArrayException.php';

use app\errors\EmptyArrayException;
use app\helpers\Request;

class RequestTest extends \Codeception\Test\Unit
{
    use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

    protected $request;

    protected function _before()
    {
        $this->request = new Request();
    }

    /**
     * @test
     */
    public function getHeaders()
    {
        $this->specify('request should contains headers after get headers', function () {
            $this->request->getHeaders();
            $this->assertNotEmpty($this->request->headers);
        });
    }

    /**
     * @test
     * @depends getHeaders
     */
    public function get()
    {
        $this->specify('should return null when header not exists', function () {
            $header = $this->request->getHeaders()->get('wrong_value');
            $this->assertNull($header);
        });

        $this->specify('should return value when correct header', function () {
            $header = $this->request->getHeaders()->get('USERNAME');
            $this->assertEquals($_SERVER['USERNAME'], $header);
        });
    }

    /**
     * @test
     */
    public function getPreferredLanguage()
    {
        $this->specify('should return first language when preferred not in supported', function () {
            $lang = $this->request->getPreferredLanguage(['pl-PL']);
            $this->assertEquals('pl-PL', $lang);
        });

        $this->specify('should return preferred language when it is in supported', function () {
            $lang = $this->request->getPreferredLanguage(['pl-PL', 'en-GB', 'en-US']);
            $this->assertEquals('en-GB', $lang);
        });

        $this->specify('should throw empty array exception if empty array provided', function () {
            $this->expectException(EmptyArrayException::class);
            $this->request->getPreferredLanguage([]);
        });
    }
}