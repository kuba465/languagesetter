<?php

namespace app\helpers;

class Request
{
    /**
     * @var array
     */
    public $headers = [];

    /**
     * @return $this
     */
    public function getHeaders()
    {
        $this->headers = $_SERVER;
        return $this;
    }

    /**
     * @param string $header
     * @return string|float|int|null
     */
    public function get(string $header)
    {
        if (isset($this->headers[$header])) {
            return$this->headers[$header];
        }
        return null;
    }

    /**
     * @param array $supportedLanguages
     * @return string
     */
    public function getPreferredLanguage(array $supportedLanguages): string
    {
        $preferredLanguage = 'en-GB';
        if (in_array($preferredLanguage, $supportedLanguages)) {
            return $preferredLanguage;
        }
        return $supportedLanguages[0];
    }
}