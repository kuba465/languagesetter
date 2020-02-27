<?php

require_once 'app\languages\GuestLanguage.php';
require_once 'app\App.php';
require_once 'app\helpers\Request.php';

use app\App;
use app\helpers\Request;
use app\languages\GuestLanguage;

class GuestLanguageTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected $guestLanguage;

    protected $app;

    protected $request;
    
    protected function _before()
    {
        $this->guestLanguage = new GuestLanguage();
        $this->app = App::getInstance();
        $this->request = new Request();
    }

    /**
     * @test
     */
    public function shouldMatchLanguageWhenCookieIsNull()
    {
        $matchLanguage = 'pl-PL';
        $_SERVER['HTTP_ACCEPT_LANGUAGE'] = $matchLanguage;
        $lang = $this->guestLanguage->getPreferredLanguage($this->app, $this->request, null);
        $this->assertEquals($matchLanguage, $lang);
        $this->assertEquals('pl', $this->guestLanguage->getLangFromBrowser());
    }

    /**
     * @test
     */
    public function shouldMatchLanguageWhenCookieExists()
    {
        $matchLanguage = 'pl-PL';
        $lang = $this->guestLanguage->getPreferredLanguage($this->app, $this->request, $matchLanguage);
        $this->assertEquals($matchLanguage, $lang);
        $this->assertEquals($matchLanguage, $this->guestLanguage->getLangFromBrowser());
    }
}