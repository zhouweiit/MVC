<?php
require_once 'Request.inc';
require_once 'Response.inc';
require_once 'Router.inc';
require_once 'Dispatcher.inc';

class FrontController{
    /**
     * @var FrontController 
     */
    private static $_instance = null;

    /**
     * @var RequestController
     */
    private $_request = null;

    /**
     * @var ResponseController 
     */
    private $_response = null;

    /**
     * @var DispatcherController 
     */
    private $_dispatcher = null;

    /**
     * @var RouterController 
     */
    private $_router = null;

    private function __construct(){
        $this->setRequest();
        $this->setResponse();
        $this->setRouter();
        $this->setDispatcher();
    }

    /**
     * 获取前端控制器的单例模式
     * @return FrontController
     * @author zhouwei 2013-1-23
     */
    public static function getInstance(){
        if (null === self::$_instance){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * 开始运行的入口
     * @return void
     * @author zhouwei 2013-1-23 
     */
    public function run(){
        $this->dispatch();
    }

    /**
     * 分发控制器
     * @return void
     * @author zhouwei 2013-1-23 
     */
    private function dispatch(){
        do {
            $this->_dispatcher->dispatch($this->_request,$this->_response);
        } while ($this->_request->getIsDispatch());
        $this->_response->sendResonse();
    }

    /**
     * 设置请求的对象
     * @return void
     * @author zhouwei 2013-1-23 
     */
    private function setRequest(){
        $this->_request = new RequestController();
    }

    /**
     * 设置响应的对象
     * @return void
     * @author zhouwei 2013-1-23 
     */
    private function setResponse(){
        $this->_response = new ResponseController();
    }

    /**
     * 设置分发器
     * @return void
     * @author zhouwei 2013-1-23 
     */
    private function setDispatcher(){
        $this->_dispatcher = new DispatcherController();
    }

    /**
     * 设置路由器
     * @return void
     * @author zhouwei 2013-1-23 
     */
    private function setRouter(){
        $this->_router = new RouterController();
    }
}
