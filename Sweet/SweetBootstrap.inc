<?php

require_once 'Controller/Front.inc';
require_once 'SweetConfig.inc';  

/**
 * Sweet的初始化类
 * @category   Sweet
 * @package    Sweet
 * @author zhouwei 2013-01-22
 */
class SweetBootstrap{
    
    /**
     * SweetBootstrap
     * @var SweetBootstrap 
     */
    private static $_instance = null;
    
    private function __construct() {
    }
    
    /**
     * 获取单例类
     * 
     * @return SweetBootstrap
     * @author zhouwei 2013-1-22
     */
    public static function getInstance(){
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }    
    
    /**
     * Sweet初始化
     * 
     * @return void
     * @author zhouwei 2013-1-22
     */
    public function run(){
        $frontInstance  = FrontController::getInstance();
        $frontInstance->run();
    }
    
    /**
     * 初始化Sweet的配置信息
     * @param array $config
     * @author zhouwei 2013-1-25 
     */
    public function initConfig(array $config){
        $configInstance = SweetConfig::getInstance();
        $configInstance->init($config);
    }
}