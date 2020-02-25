<?php

namespace app\helpers;

class Languages
{
    /**
     * @param string $lang
     * @return string
     */
    public static function getLangCodeFromShortCode(string $lang): string
    {
        $langUpperCase = strtoupper($lang);
        return "$lang-$langUpperCase";
    }

    /**
     * @param string $lang
     * @return string
     */
    public static function getLangCode(string $lang): string
    {
        return $lang;
    }
}