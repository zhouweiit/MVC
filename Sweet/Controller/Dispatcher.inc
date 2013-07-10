<?php
require_once 'Action.inc';
require_once 'ActionHelp.inc';
require_once 'Controller/Exception.inc';
class DispatcherController{
    /**
     * controller的路径
     * @var string 
     */
    private $_controllerDir = null;
    
    public function __construct(){
        $this->_controllerDir = SweetConfig::getInstance()->getControllerDir();
	}
	
    /**
     * 分发url
     * @param RequestController $request
     * @param ResponseController $response
     * @throws ExceptionController 
     * @return void
     * @author zhouwei 2013-1-23
     */
	public function dispatch(RequestController $request,ResponseController $response){
		$controllerName = ucfirst($request->getControllerName()).'Controller';
		$actionName = $request->getActionName().'Action';
        
        if (!file_exists($this->_controllerDir.'/'.$controllerName.'.inc')){
            throw new ExceptionController('控制器不存在:'.$controllerName);
        }
        
		require_once $controllerName.'.inc';
		if (!class_exists($controllerName)){
			throw new ExceptionController('控制器不存在:'.$controllerName);
		}
        
		$controller = new $controllerName($request,$response);
		if (!method_exists($controller, $actionName)){
			throw new ExceptionController('控制器的动作不存在:'.$actionName);
		}
        
        $actionHelp = ActionHelpController::getInstance();
        $request->setIsDispatch(false);
        $actionHelp->proxyAction($controller,$actionName);
	}
}