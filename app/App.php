<?php

namespace app;

use app\models\User;

class App
{
    /**
     * @var string
     */
    public $language;

    /**
     * @var User
     */
    public $user;

    /**
     * @var App
     */
    private static $instance;

    /**
     * App constructor.
     */
    private function __construct()
    {
        $this->user = User::getInstance();
    }
    
    private function __clone()
    {
    }

    /**
     * @return App
     */
    public static function getInstance(): App
    {
        if (self::$instance === null) {
            self::$instance = new App();
        }
        return self::$instance;
    }
}