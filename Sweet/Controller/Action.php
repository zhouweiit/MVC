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
     * �Ƿ�ʹ��ҳ��ֲ�
     * @var boolean 
     */
    private $_isLayout = null;
    /**
     * layout������
     * @var string 
     */
    private $_layoutName = null;
    /**
     * ��Ⱦsmarty�ύ�Ĳ���
     * @var array  
     */
    private $_rendParams = array();
    /**
     * ��Ⱦlayout�ύ�Ĳ���
     * @var array 
     */
    private $_layoutParams = array();

    /**
     * ���캯��
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
     * ��ʼ��������
     * @return void
     * @author zhouwei 2013-1-26  
     */
    private function initController() {
        $this->init();
    }

    /**
     * ��ʼ��������
     * @return void
     * @author zhouwei 2013-1-26 
     */
    protected function init() {
        
    }

    /**
     * ��ʼ��view��
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
     * ��Ⱦҳ��
     * @param array $params �ύ�Ĳ���
     * @param string $tpl     ��Ⱦҳ�������  Ĭ�ϣ���ǰaction
     * @param string $controller ��Ⱦҳ��Ŀ��������� Ĭ�ϣ���ǰ��controller
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
     * ����render�Ĳ�����������һ������
     * @return void
     * @author zhouwei 2013-1-26 
     */
    protected function setRenderParams(array $params = array()) {
        $this->_rendParams = array_merge($this->_rendParams, $params);
    }

    /**
     * ����render�Ĳ��������봫��key��value
     * @param string $key
     * @param string $value 
     * @return void
     * @author zhouwei 2013-1-26
     */
    protected function setRenderParam($key, $value) {
        $this->_rendParams = array_merge($this->_rendParams, array($key => $value));
    }

    /**
     * ����layout�ǣ�render�Ĳ�����������һ������
     * @return void
     * @author zhouwei 2013-1-26 
     */
    protected function setLayoutParams(array $params = array()) {
        $this->_layoutParams = array_merge($this->_layoutParams, $params);
    }

    /**
     * ����layout����Ⱦʱ�Ĳ��������봫��key��value
     * @param string $key
     * @param string $value 
     * @return void
     * @author zhouwei 2013-1-26
     */
    protected function setLayoutParam($key, $value) {
        $this->_layoutParams = array_merge($this->_layoutParams, array($key => $value));
    }

    /**
     * �õ���ǰaction��uri
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
     * �õ�Layout��URI
     * @return string 
     */
    private function getLayoutSmartyUri() {
        return $this->_layout->getLayoutDir() . '/' . $this->_layoutName . '.' . SweetSmarty::SMATY_TPLNAME;
        ;
    }

    /**
     * ��ȡrequest
     * @return RequestController 
     * @author zhouwei 2013-1-24
     */
    protected function getRequest() {
        return $this->_request;
    }

    /**
     * ��ȡreponse
     * @return ResponseController
     * @author zhouwei 2013-1-24
     */
    protected function getResponse() {
        return $this->_response;
    }

    /**
     * �����Ƿ�ʹ��ҳ��ֲ�
     * @param int $isLayout
     * @return void
     * @author zhouwei 2013-1-24 
     */
    protected function setIsLayout($isLayout) {
        return $this->_isLayout = $isLayout;
    }

    /**
     * ����ʹ����һ��ҳ���
     * @param string $layoutName 
     * @author zhouwei 2013-1-24
     */
    protected function setLayoutName($layoutName) {
        $this->_layoutName = $layoutName;
    }

    /**
     * �ڲ���ת
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
     * ͨ��action��controller�����ض���
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
     * ͨ��url�����ض���
     * @param string $redirectUrl ��Ҫ�ض����url
     * @author zhouwei 2013-1-25 
     */
    protected function redirectUrl($redirectUrl) {
        $this->_response->redirect($redirectUrl);
    }

    /**
     * ��action֮ǰ���Ķ���
     * @return void
     * @author zhouwei 2013-1-26 
     */
    public function doBeforeAcion() {
        
    }

    /**
     * ��action֮�����Ķ���
     * @return void
     * @author zhouwei 2013-1-26 
     */
    public function doAfterAction() {
        
    }

    /**
     * ��ȡ��Ⱦҳ��
     * @param array $params �ύ�Ĳ���
     * @param string $tpl     ��Ⱦҳ�������  Ĭ�ϣ���ǰaction
     * @param string $controller ��Ⱦҳ��Ŀ��������� Ĭ�ϣ���ǰ��controller
     * @return string ץȡ��ҳ��
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
