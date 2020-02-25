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
     * @param int $langCode
     * @return string
     */
    public static function getLangCode(int $langCode): string
    {
        //I think I should convert lang code to string by download languages table and find correct language
        //return is mock
        return 'en-GB';
    }
}