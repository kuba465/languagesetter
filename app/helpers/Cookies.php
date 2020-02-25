<?php

namespace app\helpers;

class Cookies
{
    /**
     * @param string $name
     * @return string|null
     */
    public static function getCookie(string $name): ?string
    {
        if (!isset($_COOKIE[$name])) {
            return null;
        }
        return $_COOKIE[$name];
    }

    /**
     * @param string $name
     * @param string $value
     * @return string
     */
    public static function setCookie(string $name, string $value): string
    {
        $expiredTime = time() + 60 * 60 * 24 * 365;
        setcookie($name, $value, $expiredTime);
        return $value;
    }
}