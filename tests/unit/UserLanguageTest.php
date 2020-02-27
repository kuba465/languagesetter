<?php

use app\App;
use app\helpers\Request;
use app\languages\UserLanguage;

require_once 'app\languages\UserLanguage.php';
require_once 'app\App.php';
require_once 'app\helpers\Request.php';

class UserLanguageTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected $userLanguage;

    private $supportedLanguages = [
        'pl-PL',
        'en-GB',
        'en-US'
    ];

    protected $app;

    protected $request;

    protected function _before()
    {
        $this->userLanguage = new UserLanguage($this->supportedLanguages);
        $this->app = App::getInstance();
        $this->request = new Request();
    }

    /**
     * @test
     */
    public function shouldGetUserLanguageIfItIsNotEmpty()
    {
        $matchLanguage = 'pl-PL';
        $this->app->user->language = 'pl-PL';
        $lang = $this->userLanguage->getPreferredLanguage($this->app, $this->request, null);
        $this->assertEquals($matchLanguage, $lang);
    }

    /**
     * @test
     */
    public function shouldGetCookieLanguageIfItIsNotEmpty()
    {
        $matchLanguage = 'pl-PL';
        $lang = $this->userLanguage->getPreferredLanguage($this->app, $this->request, null);
        $this->assertEquals($matchLanguage, $lang);
    }

    /**
     * @test
     */
    public function shouldGetPreferredLanguageIfEmptyUserAndCookieLanguage()
    {
        $matchLanguage = 'en-US';
        $this->app->user->language = null;
        $lang = $this->userLanguage->getPreferredLanguage($this->app, $this->request, $matchLanguage);
        $this->assertEquals($matchLanguage, $lang);
    }
}