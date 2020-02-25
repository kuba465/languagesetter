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
        //preferredLanguage:  aa-AA
        //user->language aa-AA
        //app->language: aa-AA

        // Find preferred language in cookie, app settings and user settings
        $this->langFromBrowser = substr($this->request->getHeaders()->get('HTTP_ACCEPT_LANGUAGE'), 0, 2);

        $isGuest = $app->user->isGuest;
        $user = $app->user->identity;

        $cookieLanguage = Cookies::getCookie('language');

        if ($isGuest) {
            $preferredLanguage = $this->getPreferredLanguageForGuest($app, $cookieLanguage);
        }


        if (!$isGuest && !empty($user->language)) {
            $preferredLanguage = $user->language;
            Cookies::setCookie('language', $preferredLanguage);
        }

        if (empty($preferredLanguage)) {
            $preferredLanguage = !empty($cookieLanguage) ? $cookieLanguage : $this->request->getPreferredLanguage($this->supportedLanguages);
        }

        // Set preferred language
        if (is_numeric($preferredLanguage)) {
            $preferredLanguage = Languages::getLangCode($preferredLanguage);
        }


        if (!$isGuest) {
            $app->language = $preferredLanguage;
            Cookies::setCookie('language', $preferredLanguage);

            if ((empty($user->language)) || ($user->language != $preferredLanguage)) {
                $this->saveUserLanguage($user, $preferredLanguage);
            }
        }
        $this->setLocale($preferredLanguage);

        return $preferredLanguage;
    }

    /**
     * @param $app
     * @param string|null $cookieLanguage
     * @return string
     */
    private function getPreferredLanguageForGuest($app, ?string $cookieLanguage): string
    {
        $this->langFromBrowser = substr($this->request->getHeaders()->get('HTTP_ACCEPT_LANGUAGE'), 0, 2);
        $preferredLanguage = !is_null($cookieLanguage) ? $cookieLanguage : Languages::getLangCodeFromShortCode($this->langFromBrowser);
        $app->language = $preferredLanguage;

        if (!is_null($cookieLanguage)) {
            $this->langFromBrowser = $preferredLanguage;
            Cookies::setCookie('language', $preferredLanguage);
        }
        return $preferredLanguage;
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
     * @param string $language
     */
    private function setLocale(string $language): void
    {
        $languageUnderscore = str_replace('-', '_', $language);
        setlocale(LC_ALL, $languageUnderscore . '.utf8');
    }
}