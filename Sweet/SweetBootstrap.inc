<?php

require_once 'Controller/Front.inc';
require_once 'SweetConfig.inc';  

/**
 * Sweet�ĳ�ʼ����
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
     * ��ȡ������
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
     * Sweet��ʼ��
     * 
     * @return void
     * @author zhouwei 2013-1-22
     */
    public function run(){
        $frontInstance  = FrontController::getInstance();
        $frontInstance->run();
    }
    
    /**
     * ��ʼ��Sweet��������Ϣ
     * @param array $config
     * @author zhouwei 2013-1-25 
     */
    public function initConfig(array $config){
        $configInstance = SweetConfig::getInstance();
        $configInstance->init($config);
    }
}