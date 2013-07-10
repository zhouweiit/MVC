<?php

require_once 'SweetSmarty.inc';
require_once 'SweetLayout.inc';
require_once 'SweetPlugin.inc';
require_once 'ActionHelp.inc';

class ActionController {

    /**
     * @var RequestController
     */
    protected $_request = null;
    /**
     * @var ResponseController 
     */
    protected $_response = null;
    /**
     * @var SweetSmarty 
     */
    private $_smarty = null;
    /**
     * @var SweetLayout 
     */
    private $_layout = null;
    /**
     * @var ActionHelpController 
     */
    protected $_actionHelp = null;
    /**
     * 是否使用页面分层
     * @var boolean 
     */
    private $_isLayout = null;
    /**
     * layout的名称
     * @var string 
     */
    private $_layoutName = null;
    /**
     * 渲染smarty提交的参数
     * @var array  
     */
    private $_rendParams = array();
    /**
     * 渲染layout提交的参数
     * @var array 
     */
    private $_layoutParams = array();

    /**
     * 构造函数
     * @param RequestController $request
     * @param ResponseController $response
     * @return void
     * @author zhouwei 2013-11-24 
     */
    public function __construct(RequestController $request, ResponseController $response) {
        $this->_request = $request;
        $this->_response = $response;
        $this->_actionHelp = ActionHelpController::getInstance();
        $this->initView();
        $this->initController();
    }

    /**
     * 初始化控制器
     * @return void
     * @author zhouwei 2013-1-26  
     */
    private function initController() {
        $this->init();
    }

    /**
     * 初始化控制器
     * @return void
     * @author zhouwei 2013-1-26 
     */
    protected function init() {
        
    }

    /**
     * 初始出view层
     * @return void
     * @author zhouwei 2013-1-24 
     */
    protected function initView() {
        $this->_smarty = SweetSmarty::getInstance();
        $this->_layout = SweetLayout::getInstance();
        $this->_layout->initLayout();
        $this->_layoutName = 'layout';
        $this->_isLayout = true;
        $this->_rendParams['rootUrl'] = $this->_request->getRootUrl();
        $this->_rendParams['baseUrl'] = $this->_request->getBaseUrl();
        $this->_rendParams['controllerName'] = $this->_request->getControllerName();
        $this->_rendParams['actionName'] = $this->_request->getActionName();
    }

    /**
     * 渲染页面
     * @param array $params 提交的参数
     * @param string $tpl     渲染页面的名称  默认：当前action
     * @param string $controller 渲染页面的控制器名称 默认：当前的controller
     * @return void
     * @author zhouwei 2013-1-24
     */
    public function render($params = array(), $tpl = null, $controller = null) {
        if (!empty($params) && is_array($params)) {
            $this->setRenderParams($params);
        }
        $actionSmartyUri = $this->getActionSmartyUri($tpl, $controller);
        $smartyBody = $this->_smarty->fetch($actionSmartyUri, $this->_rendParams, true);

        if ($this->_isLayout) {
            $layoutSmartyUri = $this->getLayoutSmartyUri();
            $this->setLayoutParams($this->_layout->getLayoutBodys(array(SweetLayout::LAYOUT_BODY => $smartyBody)));
            $smartyBody = $this->_smarty->fetch($layoutSmartyUri, $this->_layoutParams, true);
        }
        $this->_response->appendBody('smarty', $smartyBody);
    }

    /**
     * 设置render的参数，必须是一个数组
     * @return void
     * @author zhouwei 2013-1-26 
     */
    protected function setRenderParams(array $params = array()) {
        $this->_rendParams = array_merge($this->_rendParams, $params);
    }

    /**
     * 设置render的参数，必须传递key与value
     * @param string $key
     * @param string $value 
     * @return void
     * @author zhouwei 2013-1-26
     */
    protected function setRenderParam($key, $value) {
        $this->_rendParams = array_merge($this->_rendParams, array($key => $value));
    }

    /**
     * 设置layout是，render的参数，必须是一个数组
     * @return void
     * @author zhouwei 2013-1-26 
     */
    protected function setLayoutParams(array $params = array()) {
        $this->_layoutParams = array_merge($this->_layoutParams, $params);
    }

    /**
     * 设置layout，渲染时的参数，必须传递key与value
     * @param string $key
     * @param string $value 
     * @return void
     * @author zhouwei 2013-1-26
     */
    protected function setLayoutParam($key, $value) {
        $this->_layoutParams = array_merge($this->_layoutParams, array($key => $value));
    }

    /**
     * 得到当前action的uri
     * @param string $tpl
     * @param string $controller
     * @return string
     * @author zhouwei 2013-1-24 
     */
    private function getActionSmartyUri($tpl, $controller) {
        if (null === $tpl) {
            $tpl = $this->_request->getActionName();
        }

        if (null === $controller) {
            $controller = $this->_request->getControllerName();
        }

        return $this->_smarty->getTplDir() . '/' . $controller . '/' . $tpl . '.' . SweetSmarty::SMATY_TPLNAME;
    }

    /**
     * 得到Layout的URI
     * @return string 
     */
    private function getLayoutSmartyUri() {
        return $this->_layout->getLayoutDir() . '/' . $this->_layoutName . '.' . SweetSmarty::SMATY_TPLNAME;
        ;
    }

    /**
     * 获取request
     * @return RequestController 
     * @author zhouwei 2013-1-24
     */
    protected function getRequest() {
        return $this->_request;
    }

    /**
     * 获取reponse
     * @return ResponseController
     * @author zhouwei 2013-1-24
     */
    protected function getResponse() {
        return $this->_response;
    }

    /**
     * 设置是否使用页面分层
     * @param int $isLayout
     * @return void
     * @author zhouwei 2013-1-24 
     */
    protected function setIsLayout($isLayout) {
        return $this->_isLayout = $isLayout;
    }

    /**
     * 设置使用哪一个页面层
     * @param string $layoutName 
     * @author zhouwei 2013-1-24
     */
    protected function setLayoutName($layoutName) {
        $this->_layoutName = $layoutName;
    }

    /**
     * 内部跳转
     * @param string $action
     * @param string $controller
     * @param array $params 
     * @return void
     * @author 2013-1-24
     */
    protected function forward($action, $controller = null, $params = array()) {
        $this->_request->setActionName($action);
        $this->_request->setControllerName($controller);
        $this->_request->setIsDispatch(true);
        $this->_request->appendParams($params);
    }

    /**
     * 通过action与controller进行重定向
     * @param string $action
     * @param string $controller
     * @author zhouwei 2013-1-25
     */
    protected function redirectSweet($action, $controller = null) {
        if (null === $controller) {
            $controller = $this->_request->getControllerName();
        }
        $redirectUrl = $this->_request->getRootUrl() . $controller . '/' . $action;
        $this->_response->redirect($redirectUrl);
    }

    /**
     * 通过url进行重定向
     * @param string $redirectUrl 需要重定向的url
     * @author zhouwei 2013-1-25 
     */
    protected function redirectUrl($redirectUrl) {
        $this->_response->redirect($redirectUrl);
    }

    /**
     * 在action之前做的动作
     * @return void
     * @author zhouwei 2013-1-26 
     */
    public function doBeforeAcion() {
        
    }

    /**
     * 在action之后做的动作
     * @return void
     * @author zhouwei 2013-1-26 
     */
    public function doAfterAction() {
        
    }

    /**
     * 获取渲染页面
     * @param array $params 提交的参数
     * @param string $tpl     渲染页面的名称  默认：当前action
     * @param string $controller 渲染页面的控制器名称 默认：当前的controller
     * @return string 抓取的页面
     * @author zhouwei 2013-1-24
     */
    public function renderFetch($params = array(), $tpl = null, $controller = null) {
        if (!empty($params) && is_array($params)) {
            $this->setRenderParams($params);
        }
        $actionSmartyUri = $this->getActionSmartyUri($tpl, $controller);
        return $this->_smarty->fetch($actionSmartyUri, $this->_rendParams, false);
    }
}
