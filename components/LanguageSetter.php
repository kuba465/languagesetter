<?php
namespace app\components;
use yii\base\BootstrapInterface;
use Yii;
use app\helpers\Languages;
use app\helpers\Cookies;


class LanguageSetter implements BootstrapInterface
{
    public $supportedLanguages;
    public $forceLanguage = null;
    public $langFromBrowser = null;
    
    

    public function bootstrap($app)
    {
        //preferredLanguage:  aa-AA
        //user->language aa-AA
        //app->language: aa-AA

        // Find preferred language in cookie, app settings and user settings
        $this->langFromBrowser = substr(Yii::$app->request->getHeaders()->get('accept-language'), 0, 2);
  
        $isGuest = $app->user->isGuest;
        $user = $app->user->identity;
        
        $cookieLanguage = Cookies::getCookie('language');
        
        if  ($isGuest && is_null($cookieLanguage)) {
            $preferredLanguage = Languages::getLangCodeFromShortCode($this->langFromBrowser); //to differ between ex. en-GB and en-US
            $this->langFromBrowser=$preferredLanguage;
            $app->language = $preferredLanguage;
            $langCookie = Cookies::setCookie('language', $preferredLanguage);
           
        } else if  ($isGuest && $cookieLanguage) {
            $preferredLanguage = $cookieLanguage->value;
            $app->language = $preferredLanguage;
        }
       
        
        if( !$isGuest ){
            if( !empty($user->language) ){
                $preferredLanguage = $user->language;
                $langCookie = Cookies::setCookie('language', $preferredLanguage);
            }
        } 
        
        if( empty($preferredLanguage) ){
            if( !empty($cookieLanguage) ){
                $preferredLanguage = $cookieLanguage->value;
            } else {
                $preferredLanguage = $app->request->getPreferredLanguage($this->supportedLanguages);
            }
        }

        // Set preferred language
        if( is_numeric( $preferredLanguage ) ) $preferredLanguage = Languages::getLangCode( $preferredLanguage );
        
        if( $this->forceLanguage ) $preferredLanguage = $this->forceLanguage;

        
        
        if( !$isGuest ){
            $app->language = $preferredLanguage;
            $langCookie = Cookies::setCookie('language', $preferredLanguage);
          
            if ((empty($user->language)) || ($user->language!= $preferredLanguage )) {
                $user->language = $preferredLanguage;
                $user->save();
            }
        }
        $preferredLanguage = str_replace('-', '_', $preferredLanguage);
        setlocale(LC_ALL, $preferredLanguage . '.utf8');
                
        return $preferredLanguage;
    }
}