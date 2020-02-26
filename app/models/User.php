<?php

namespace app\models;

class User
{
    /**
     * @var boolean
     */
    public $isGuest = false;

    /**
     * @var User
     */
    public $identity;

    /**
     * @var string
     */
    public $language;

    /**
     * @var User
     */
    private static $instance;

    /**
     * User constructor.
     */
    private function __construct()
    {
        $this->identity = self::getInstance();
    }

    private function __clone()
    {
    }

    /**
     * @return User
     */
    public static function getInstance(): User
    {
        if (self::$instance === null) {
            self::$instance = new User();
        }
        return self::$instance;
    }

    public function save()
    {
        //save User data in database
        return $this;
    }
}