<?php

namespace app\helpers;

use app\errors\EmptyArrayException;

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
            return $this->headers[$header];
        }
        return null;
    }

    /**
     * @param array $supportedLanguages
     * @return string
     * @throws EmptyArrayException
     */
    public function getPreferredLanguage(array $supportedLanguages): string
    {
        $preferredLanguage = 'en-GB';
        if (!count($supportedLanguages)) {
            throw new EmptyArrayException('Supported array is empty.');
        }

        if (in_array($preferredLanguage, $supportedLanguages)) {
            return $preferredLanguage;
        }
        return $supportedLanguages[0];
    }
}