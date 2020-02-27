<?php

namespace app\languages;

require_once 'app\languages\AbstractLanguage.php';

use app\App;
use app\helpers\Languages;
use app\helpers\Request;
use LanguageInterface;

class GuestLanguage extends AbstractLanguage implements LanguageInterface
{
    /**
     * @inheritDoc
     */
    public function getPreferredLanguage(App $app, Request $request, ?string $cookieLanguage)
    {
        $this->setLangFromBrowser(substr($request->getHeaders()->get('HTTP_ACCEPT_LANGUAGE'), 0, 2));

        if (!is_null($cookieLanguage)) {
            $preferredLanguage = $cookieLanguage;
            $this->setLangFromBrowser($preferredLanguage);
            return $preferredLanguage;
        }
        return Languages::getLangCodeFromShortCode($this->getLangFromBrowser());
    }
}