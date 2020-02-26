<?php

namespace app\languages;

use LanguageInterface;

class Language
{
    /**
     * @var LanguageInterface
     */
    private $language;

    /**
     * @return LanguageInterface
     */
    public function getLanguage(): LanguageInterface
    {
        return $this->language;
    }

    /**
     * @param LanguageInterface $language
     */
    public function setLanguage(LanguageInterface $language): void
    {
        $this->language = $language;
    }
}