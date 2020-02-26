<?php

namespace components;

use app\App;
use app\contracts\BootstrapInterface;
use app\errors\EmptyArrayException;
use app\helpers\Request;
use app\helpers\Languages;
use app\helpers\Cookies;
use app\languages\GuestLanguage;
use app\languages\Language;
use app\languages\UserLanguage;
use app\models\User;


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

    public function bootstrap($app)
    {
        $isGuest = $app->user->isGuest;
        $user = $app->user->identity;
        $request = new Request();

        $cookieLanguage = Cookies::getCookie('language');

        $language = new Language();
        if ($isGuest) {
            $language->setLanguage(new GuestLanguage());
        } else {
            $language->setLanguage(new UserLanguage($this->supportedLanguages));
        }

        try {
            $preferredLanguage = $language->getLanguage()->getPreferredLanguage($app, $request, $cookieLanguage);
        } catch (EmptyArrayException $exception) {
            return $exception->getMessage();
        }
        $this->langFromBrowser = $language->getLanguage()->getLangFromBrowser();

        $this->convertNumericLanguage($preferredLanguage);

        if (!$isGuest && ((empty($user->language)) || ($user->language != $preferredLanguage))) {
            $this->saveUserLanguage($user, $preferredLanguage);
        }

        Cookies::setCookie('language', $preferredLanguage);
        $this->setLocale($app, $preferredLanguage);

        return $preferredLanguage;
    }

    /**
     * @param $preferredLanguage
     */
    private function convertNumericLanguage(&$preferredLanguage): void
    {
        if (is_numeric($preferredLanguage)) {
            $preferredLanguage = Languages::getLangCode($preferredLanguage);
        }
    }

    /**
     * @param User $user
     * @param string $language
     */
    private function saveUserLanguage(User $user, string $language): void
    {
        $user->language = $language;
        $user->save();
    }

    /**
     * @param App $app
     * @param string $language
     */
    private function setLocale(App $app, string $language): void
    {
        $app->language = $language;
        $languageUnderscore = str_replace('-', '_', $language);
        setlocale(LC_ALL, $languageUnderscore . '.utf8');
    }
}