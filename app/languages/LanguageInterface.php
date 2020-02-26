<?php

use app\App;
use app\helpers\Request;

interface LanguageInterface
{
    /**
     * @param App $app
     * @param Request $request
     * @param string|null $cookieLanguage
     * @return mixed
     */
    public function getPreferredLanguage(App $app, Request $request, ?string $cookieLanguage);
}