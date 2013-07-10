<?php
require_once 'Action.inc';
require_once 'ActionHelp.inc';
require_once 'Controller/Exception.inc';
class DispatcherController{
    /**
     * controller��·��
     * @var string 
     */
    private $_controllerDir = null;
    
    public function __construct(){
        $this->_controllerDir = SweetConfig::getInstance()->getControllerDir();
	}
	
    /**
     * �ַ�url
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
            throw new ExceptionController('������������:'.$controllerName);
        }
        
		require_once $controllerName.'.inc';
		if (!class_exists($controllerName)){
			throw new ExceptionController('������������:'.$controllerName);
		}
        
		$controller = new $controllerName($request,$response);
		if (!method_exists($controller, $actionName)){
			throw new ExceptionController('�������Ķ���������:'.$actionName);
		}
        
        $actionHelp = ActionHelpController::getInstance();
        $request->setIsDispatch(false);
        $actionHelp->proxyAction($controller,$actionName);
	}
}