<?php

class RequestController {
    const NVALID_KEY = 0;
    const ROOT_URL_KEY = 1;
    const CONTROLLER_KEY = 2;
    const ACTION_KEY = 3;
    /**
     * �����uri
     * @var string 
     */
    private $_requestUri = null;
    /**
     * ����Ŀ���������
     * @var string 
     */
    private $_controllerName = null;
    /**
     * ����Ķ�������
     * @var string 
     */
    private $_actionName = null;
    /**
     * ����url�������Ĳ���
     * @var array 
     */
    private $_requestUrlParams = array();
    /**
     * �����ύ�Ĳ���
     * @var array 
     */
    private $_params = array();
    /**
     * �Ƿ���ַ�
     * @var string
     */
    private $_isDispatch = false;
    /**
     * url�ĸ�
     * @var string 
     */
    private $_urlRoot = null;
    /**
     * ������url
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
     * ����requsetUri
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
     * ���ø���Url
     * @return void
     * @author zhouwei 2013-1-23 
     */
    private function setRootUrl() {
        $this->_urlRoot = SweetConfig::getInstance()->getUrlRoot();
    }

    /**
     * ��ȡ����Url
     * @return string
     * @author zhouwei 2013-1-5 
     */
    public function getRootUrl() {
        return $this->_urlRoot;
    }

    /**
     * ���û�����url
     * @return void
     * @author zhouwei 2013-1-25 
     */
    private function setBaseUrl() {
        $this->_baseUrl = $this->_urlRoot . $this->_controllerName . '/' . $this->_actionName;
    }

    /**
     * ��ȡ������url
     * @return void
     * @author zhouwei 2013-1-25 
     */
    public function getBaseUrl() {
        return $this->_baseUrl;
    }

    /**
     * �õ������uri
     * @return string
     * @author zhouwei 2013-1-26 
     */
    public function getRequestUri() {
        return $this->_requestUri;
    }

    /**
     * ����requestUri
     * @return void
     * @author zhouwei 2013-1-23 
     */
    private function setRequestUri() {
        $this->_requestUri = urldecode($this->getServer('REQUEST_URI'));
    }

    /**
     * ���ÿ�����������
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
     * ���ö���������
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
     * ��ȡ��ǰ������������
     * @return void
     * @author zhouwei 2013-1-23 
     */
    public function getControllerName() {
        return $this->_controllerName;
    }

    /**
     * ��ȡ��ǰ����������
     * @return string
     * @author zhouwei 2013-1-23 
     */
    public function getActionName() {
        return $this->_actionName;
    }

    /**
     * �Ƿ���GET�ύ
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
     * �Ƿ���POST�ύ
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
     * �Ƿ���put�ύ
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
     * �Ƿ���delete�ύ
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
     * ��ȡhttp����ķ�������
     * @return string
     * @author zhouwei 2013-1-23 
     */
    public function getMethod() {
        return strtoupper($this->getServer('REQUEST_METHOD'));
    }

    /**
     * ��ȡserver�ı���
     * @param string $key key������
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
     * ����key��ȡ�ύ�Ĳ�����Ϣ
     * @param string $key
     * @return mix
     * @author zhouwei 2013-1-23 
     */
    public function getParam($key) {
        return $this->_params[$key];
    }

    /**
     * ����ֵ
     * @param string $key
     * @param mix $val
     * @author zhouwei 2013-1-23 
     */
    public function setParam($key, $val) {
        return $this->_params[$key] = $val;
    }

    /**
     * ��ȡ�����ύ�Ĳ���
     * @return array
     * @author zhouwei 2013-1-23 
     */
    public function getParams() {
        return $this->_params;
    }

    /**
     * �����ύurl�еĲ���
     * @param type $requestUriParams 
     * @return void
     * @author zhouwei 2013-1-23
     */
    private function setRequestUriParams($requestUriParams) {
        unset($requestUriParams[self::NVALID_KEY], $requestUriParams[self::ROOT_URL_KEY], $requestUriParams[self::CONTROLLER_KEY], $requestUriParams[self::ACTION_KEY]);
        $this->_requestUrlParams = $requestUriParams;
    }

    /**
     * ��ʼ�������ύ�Ĳ���
     * @return void
     * @author zhouwei 2013-1-23 
     */
    private function initParams() {
        $this->appendParams($this->initRequestUriParams());
        $this->appendParams($_GET);
        $this->appendParams($_POST);
    }

    /**
     * ��ʼ��requestUri�ϵĲ�����Ϣ
     * @return array ���ؽ����õĲ�����Ϣ
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
     * �ֶ���Ӳ���
     * @param array $params 
     * @author zhouwei 2013-1-23
     */
    public function appendParams(array $params) {
        $this->_params = array_merge($this->_params, $params);
    }

    /**
     * �ֶ���Ӳ���
     * @param array $params 
     * @author zhouwei 2013-1-23
     */
    public function appendParam($key, $param) {
        $this->_params[(string) $key] = $param;
    }

    /**
     * ��ȡ�Ƿ���Ҫ�ַ�
     * @return boolean
     * @author zhouwei 2013-1-23 
     */
    public function getIsDispatch() {
        return $this->_isDispatch;
    }

    /**
     * �����Ƿ�ַ�
     * @param boolean $isDispatch 
     * @author zhouwei 2013-1-23
     */
    public function setIsDispatch($isDispatch) {
        $this->_isDispatch = (boolean) $isDispatch;
    }

}