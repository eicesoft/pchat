<?php
namespace PHPChat;

/**
 * Class Config
 * @package PHPChat
 * @author kelezyb
 */
class Config
{
    private static $instance = null;

    /**
     * @return Config
     */
    public static function Instance()
    {
        if (null == self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct()
    {
        
    }
}