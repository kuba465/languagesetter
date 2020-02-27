<?php

namespace app\languages;

require_once 'app\languages\LanguageInterface.php';
require_once 'app\languages\Language.php';
require_once 'app\helpers\Languages.php';
require_once 'app\models\User.php';
require_once 'app\App.php';

use LanguageInterface;

abstract class AbstractLanguage implements LanguageInterface
{
    /**
     * @var null
     */
    private $langFromBrowser = null;

    /**
     * @var array
     */
    private $supportedLanguages = [];

    public function getLangFromBrowser()
    {
        return $this->langFromBrowser;
    }

    public function setLangFromBrowser($language)
    {
        $this->langFromBrowser = $language;
    }

    public function getSupportedLanguages()
    {
        return $this->supportedLanguages;
    }

    public function setSupportedLanguages(array $supportedLanguages)
    {
        $this->supportedLanguages = $supportedLanguages;
    }
}