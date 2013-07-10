<?php
class ActionHelpController{

    /**
     * @var ActionHelpController 
     */
    private static $_instance = null;

    private function __construct() {
    }

    /**
     * ��ȡ���������ֵĵ���ģʽ
     * @return ActionHelpController
     * @author zhouwei 2013-1-23
     */
    public static function getInstance(){
        if (null === self::$_instance){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * ������ʽcontroller��action
     * @param ActionController $controller
     * @param string $actionName 
     * @return void
     * @author zhouwei 2013-1-26
     */
    public function proxyAction(ActionController $controller,$actionName){
        $controller->doBeforeAcion();
        $controller->$actionName();
        $controller->doAfterAction();
    }
}
