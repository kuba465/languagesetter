<?php

namespace app\languages;

require_once 'app\languages\AbstractLanguage.php';

use app\App;
use app\helpers\Request;
use LanguageInterface;

class UserLanguage extends AbstractLanguage implements LanguageInterface
{
    /**
     * UserLanguage constructor.
     * @param array $supportedLanguages
     */
    public function __construct(array $supportedLanguages)
    {
        $this->setSupportedLanguages($supportedLanguages);
    }

    /**
     * @inheritDoc
     */
    public function getPreferredLanguage(App $app, Request $request, ?string $cookieLanguage)
    {
        $user = $app->user;
        if (!empty($user->language)) {
            return $user->language;
        }
        if (!empty($cookieLanguage)) {
            return $cookieLanguage;
        }
        return $request->getPreferredLanguage($this->getSupportedLanguages());
    }
}