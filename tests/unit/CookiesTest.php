<?php

use app\helpers\Cookies;

require_once 'app\helpers\Cookies.php';

class CookiesTest extends \Codeception\Test\Unit
{
    use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @test
     */
    public function getCookie()
    {
        $this->specify('should return null when no language in cookies', function () {
            $lang = Cookies::getCookie('empty language');
            $this->assertNull($lang);
        });

        $this->specify('should return string when language in cookies', function () {
            $_COOKIE['language'] = 'en-GB';
            $lang = Cookies::getCookie('language');
            $this->assertEquals('en-GB', $lang);
            $this->assertIsString($lang);
        });
    }
}