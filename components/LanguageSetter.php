<?php

namespace components;

use app\helpers\Request;
use app\contracts\BootstrapInterface;
use app\helpers\Languages;
use app\helpers\Cookies;


class LanguageSetter implements BootstrapInterface
{
    /**
     * @var array
     */
    public $supportedLanguages = [
        'pl-PL',
        'en-GB',
        'es-ES'
    ];
    /**
     * @var null
     */
    public $langFromBrowser = null;

    /**
     * @var Request
     */
    private $request;

    /**
     * LanguageSetter constructor.
     */
    public function __construct()
    {
        $this->request = new Request();
    }


    public function bootstrap($app)
    {
        $isGuest = $app->user->isGuest;
        $user = $app->user->identity;

        $cookieLanguage = Cookies::getCookie('language');

        if ($isGuest) {
            $preferredLanguage = $this->getPreferredLanguageForGuest($cookieLanguage);
        } else {
            $preferredLanguage = $this->getPreferredLanguageForUser($user, $cookieLanguage);

            if (is_numeric($preferredLanguage)) {
                $preferredLanguage = Languages::getLangCode($preferredLanguage);
            }

            if ((empty($user->language)) || ($user->language != $preferredLanguage)) {
                $this->saveUserLanguage($user, $preferredLanguage);
            }
        }

        Cookies::setCookie('language', $preferredLanguage);
        $this->setLocale($app, $preferredLanguage);

        return $preferredLanguage;
    }

    /**
     * @param string|null $cookieLanguage
     * @return string
     */
    private function getPreferredLanguageForGuest(?string $cookieLanguage): string
    {
        $this->langFromBrowser = substr($this->request->getHeaders()->get('HTTP_ACCEPT_LANGUAGE'), 0, 2);

        if (!is_null($cookieLanguage)) {
            $preferredLanguage = $cookieLanguage;
            $this->langFromBrowser = $preferredLanguage;
            return $preferredLanguage;
        }
        return Languages::getLangCodeFromShortCode($this->langFromBrowser);
    }

    /**
     * @param $user
     * @param string|null $cookieLanguage
     * @return string
     */
    private function getPreferredLanguageForUser($user, ?string $cookieLanguage): string
    {
        if (!empty($user->language)) {
            return $user->language;
        } elseif (!empty($cookieLanguage)) {
            return $cookieLanguage;
        }
        return $this->request->getPreferredLanguage($this->supportedLanguages);
    }

    /**
     * @param $user
     * @param string $language
     */
    private function saveUserLanguage($user, string $language): void
    {
        $user->language = $language;
        $user->save();
    }

    /**
     * @param $app
     * @param string $language
     */
    private function setLocale($app, string $language): void
    {
        $app->language = $language;
        $languageUnderscore = str_replace('-', '_', $language);
        setlocale(LC_ALL, $languageUnderscore . '.utf8');
    }
}