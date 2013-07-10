<?php

class RequestController {
    const NVALID_KEY = 0;
    const ROOT_URL_KEY = 1;
    const CONTROLLER_KEY = 2;
    const ACTION_KEY = 3;
    /**
     * 请求的uri
     * @var string 
     */
    private $_requestUri = null;
    /**
     * 请求的控制器名称
     * @var string 
     */
    private $_controllerName = null;
    /**
     * 请求的动作名称
     * @var string 
     */
    private $_actionName = null;
    /**
     * 请求url解析出的参数
     * @var array 
     */
    private $_requestUrlParams = array();
    /**
     * 请求提交的参数
     * @var array 
     */
    private $_params = array();
    /**
     * 是否还需分发
     * @var string
     */
    private $_isDispatch = false;
    /**
     * url的根
     * @var string 
     */
    private $_urlRoot = null;
    /**
     * 基础的url
     * @var string 
     */
    private $_baseUrl = null;

    public function __construct() {
        $this->setRequestUri();
        $this->explainRequestUri();
        $this->setRootUrl();
        $this->setBaseUrl();
        $this->initParams();
    }

    /**
     * 解析requsetUri
     * @return void
     * @author zhouwei 2013-1-23 
     */
    private function explainRequestUri() {
        $explainParams = explode('/', $this->_requestUri);
        $this->setControllerName($explainParams[self::CONTROLLER_KEY]);
        $this->setActionName($explainParams[self::ACTION_KEY]);
        $this->setRequestUriParams($explainParams);
    }

    /**
     * 设置根的Url
     * @return void
     * @author zhouwei 2013-1-23 
     */
    private function setRootUrl() {
        $this->_urlRoot = SweetConfig::getInstance()->getUrlRoot();
    }

    /**
     * 获取根的Url
     * @return string
     * @author zhouwei 2013-1-5 
     */
    public function getRootUrl() {
        return $this->_urlRoot;
    }

    /**
     * 设置基础的url
     * @return void
     * @author zhouwei 2013-1-25 
     */
    private function setBaseUrl() {
        $this->_baseUrl = $this->_urlRoot . $this->_controllerName . '/' . $this->_actionName;
    }

    /**
     * 获取基本的url
     * @return void
     * @author zhouwei 2013-1-25 
     */
    public function getBaseUrl() {
        return $this->_baseUrl;
    }

    /**
     * 得到请求的uri
     * @return string
     * @author zhouwei 2013-1-26 
     */
    public function getRequestUri() {
        return $this->_requestUri;
    }

    /**
     * 设置requestUri
     * @return void
     * @author zhouwei 2013-1-23 
     */
    private function setRequestUri() {
        $this->_requestUri = urldecode($this->getServer('REQUEST_URI'));
    }

    /**
     * 设置控制器的名称
     * @param string $controllerName 
     * @return void
     * @author zhouwei 2013-1-23
     */
    public function setControllerName($controllerName) {
        $controllerName = trim((string) $controllerName);
        if (null === $controllerName || '' === $controllerName) {
            $controllerName = 'index';
        }
        $this->_controllerName = $controllerName;
    }

    /**
     * 设置动作的名称
     * @param string $actionName
     * @return void
     * @author zhouwei 2013-1-23 
     */
    public function setActionName($actionName) {
        $actionName = trim((string) $actionName);
        if (null === $actionName || '' === $actionName) {
            $actionName = 'index';
        }
        $this->_actionName = $actionName;
    }

    /**
     * 获取当前控制器的名称
     * @return void
     * @author zhouwei 2013-1-23 
     */
    public function getControllerName() {
        return $this->_controllerName;
    }

    /**
     * 获取当前动作的名称
     * @return string
     * @author zhouwei 2013-1-23 
     */
    public function getActionName() {
        return $this->_actionName;
    }

    /**
     * 是否是GET提交
     * @return boolean
     * @author zhouwei 2013-1-23 
     */
    public function isGet() {
        if ('GET' == $this->getMethod()) {
            return true;
        }
        return false;
    }

    /**
     * 是否是POST提交
     * @return boolean
     * @author zhouwei 2013-1-23 
     */
    public function isPost() {
        if ('POST' == $this->getMethod()) {
            return true;
        }
        return false;
    }

    /**
     * 是否是put提交
     * @return boolean
     * @author zhouwei 2013-1-23 
     */
    public function isPut() {
        if ('PUT' == $this->getMethod()) {
            return true;
        }
        return false;
    }

    /**
     * 是否是delete提交
     * @return boolean
     * @author zhouwei 2013-1-23 
     */
    public function isDelete() {
        if ('DELETE' == $this->getMethod()) {
            return true;
        }
        return false;
    }

    /**
     * 获取http请求的方法类型
     * @return string
     * @author zhouwei 2013-1-23 
     */
    public function getMethod() {
        return strtoupper($this->getServer('REQUEST_METHOD'));
    }

    /**
     * 获取server的变量
     * @param string $key key的名称
     * @return string
     * @author zhouwei 2013-1-23 
     */
    public function getServer($key = null) {
        if (null === $key) {
            return $_SERVER;
        }
        return $_SERVER[$key];
    }

    /**
     * 根据key获取提交的参数信息
     * @param string $key
     * @return mix
     * @author zhouwei 2013-1-23 
     */
    public function getParam($key) {
        return $this->_params[$key];
    }

    /**
     * 设置值
     * @param string $key
     * @param mix $val
     * @author zhouwei 2013-1-23 
     */
    public function setParam($key, $val) {
        return $this->_params[$key] = $val;
    }

    /**
     * 获取所有提交的参数
     * @return array
     * @author zhouwei 2013-1-23 
     */
    public function getParams() {
        return $this->_params;
    }

    /**
     * 设置提交url中的参数
     * @param type $requestUriParams 
     * @return void
     * @author zhouwei 2013-1-23
     */
    private function setRequestUriParams($requestUriParams) {
        unset($requestUriParams[self::NVALID_KEY], $requestUriParams[self::ROOT_URL_KEY], $requestUriParams[self::CONTROLLER_KEY], $requestUriParams[self::ACTION_KEY]);
        $this->_requestUrlParams = $requestUriParams;
    }

    /**
     * 初始化请求提交的参数
     * @return void
     * @author zhouwei 2013-1-23 
     */
    private function initParams() {
        $this->appendParams($this->initRequestUriParams());
        $this->appendParams($_GET);
        $this->appendParams($_POST);
    }

    /**
     * 初始化requestUri上的参数信息
     * @return array 返回解析好的参数信息
     * @author zhouwei 2013-2-5 
     */
    private function initRequestUriParams() {
        $params = array();
        $uriCount = round(count($this->_requestUrlParams) / 2);
        for ($i = 1; $i <= $uriCount; $i++) {
            $key = array_shift($this->_requestUrlParams);
            $value = array_shift($this->_requestUrlParams);
            if ('' === trim($key)) {
                continue;
            }
            $params[$key] = $value;
        }
        return $params;
    }

    /**
     * 手动添加参数
     * @param array $params 
     * @author zhouwei 2013-1-23
     */
    public function appendParams(array $params) {
        $this->_params = array_merge($this->_params, $params);
    }

    /**
     * 手动添加参数
     * @param array $params 
     * @author zhouwei 2013-1-23
     */
    public function appendParam($key, $param) {
        $this->_params[(string) $key] = $param;
    }

    /**
     * 获取是否需要分发
     * @return boolean
     * @author zhouwei 2013-1-23 
     */
    public function getIsDispatch() {
        return $this->_isDispatch;
    }

    /**
     * 设置是否分发
     * @param boolean $isDispatch 
     * @author zhouwei 2013-1-23
     */
    public function setIsDispatch($isDispatch) {
        $this->_isDispatch = (boolean) $isDispatch;
    }

}