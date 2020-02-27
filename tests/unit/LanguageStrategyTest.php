<?php

require_once 'app\languages\GuestLanguage.php';
require_once 'app\languages\UserLanguage.php';
require_once 'app\languages\Language.php';

use app\languages\GuestLanguage;
use app\languages\Language;
use app\languages\UserLanguage;

class LanguageStrategyTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected $language;
    
    protected function _before()
    {
        $this->language = new Language();
    }

    /**
     * @test
     */
    public function shouldMatchCorrectInstance()
    {
        $this->language->setLanguage(new GuestLanguage());
        $this->assertInstanceOf(LanguageInterface::class, $this->language->getLanguage());
        $this->assertInstanceOf(GuestLanguage::class, $this->language->getLanguage());

        $this->language->setLanguage(new UserLanguage(['pl-PL']));
        $this->assertInstanceOf(LanguageInterface::class, $this->language->getLanguage());
        $this->assertInstanceOf(UserLanguage::class, $this->language->getLanguage());
    }
}