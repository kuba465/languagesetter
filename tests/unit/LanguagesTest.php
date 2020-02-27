<?php

require_once 'app\helpers\Languages.php';

use app\helpers\Languages;

class LanguagesTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @test
     */
    public function shouldReturnUppercaseSecondPartAndString()
    {
        $lang = 'pl';
        $newLang = Languages::getLangCodeFromShortCode($lang);
        $this->assertEquals('pl-PL', $newLang);
        $this->assertIsString($newLang);
    }

    /**
     * @test
     */
    public function shouldReturnStringAfterConversion()
    {
        $lang = Languages::getLangCode(1);
        $this->assertIsString($lang);
    }
}