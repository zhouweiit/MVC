<?php
require_once 'Controller/Exception.inc';
abstract class SweetPlugin{
    const PARAMS_KEY_NAME = 'pluginParams';
    const CLASS_KEY_NAME = 'pluginClass';
    
    /**
     * ������·��
     * @var string 
     */
    private $_pluginDir = null;
    
    /**
     * ���ģ���·��
     * @var string 
     */
    private $_pluginTplDir = null;
    
    /**
     * ��Ҫ���ظ�ģ��Ĳ���
     * @var array 
     */
    private $_pluginParams = array();
    
    /**
     * �ύ������Ĳ���
     * @var array 
     */
    private $_params = array();
    
    /**
     * pluginClass
     * @var string 
     */
    private $_pluginClass = null;
    
    /**
     * �����tpl��uri
     * @var string 
     */
    private $_pluginTplUri = null;
    
    public function __construct($params) {
        $this->_params          = $params[SweetPlugin::PARAMS_KEY_NAME];
        $this->_pluginClass     = $params[SweetPlugin::CLASS_KEY_NAME];
        $this->_pluginDir       = SweetConfig::getInstance()->getPluginDir();
        $this->_pluginTplDir    = SweetConfig::getInstance()->getPluginTplDir();
        $this->setPluginTplUri();
        $this->init();
    }
    
    /**
     * ��ʼ��������Ϣ
     * @return void
     * @author zhouwei 2013-1-26 
     */
    protected function init(){
        $this->initParams();
    }

    /**
     * ����PluginTplUri
     * @param string $pluginTplUri 
     * @return void
     * @author zhouwei 2013-1-28
     */
    protected function setPluginTplUri($pluginTplUri = null){
        if (null === $pluginTplUri){
            $className = str_replace('Plugin','',$this->_pluginClass);
            $className = chr(ord(substr($className,0,1))+32).substr($className,1);
            $pluginTplUri = $this->_pluginTplDir.'/'.$className.'.'.SweetSmarty::SMATY_TPLNAME;
        }
        $this->_pluginTplUri = $pluginTplUri;
    }
    
    /**
     * ��ȡ���tpl��uri
     * @return string
     * @author zhouwei 2013-1-28  
     */
    public function getPluginTplUri(){
        return $this->_pluginTplUri;
    }
    
    /**
     * �������÷��ظ�����ı���
     * @param array $params 
     * @return void
     * @author zhouwei 2013-1-27
     */
    protected function setPluginParams(array $params){
        $this->_pluginParams = array_merge($this->_pluginParams,$params);
    }
    
    /**
     * �������÷��ظ�����ı���
     * @param string $key
     * @param array $params 
     * @return void
     * @author zhouwei 2013-1-27
     */
    protected function setPluginParam($key,$params){
        $this->_pluginParams[$key] = $params;
    }
    
    /**
     * �������õ�plugParams
     * @return array
     * @author zhouwei 2013-1-27 
     */
    public function getPluginParams(){
        return $this->_pluginParams;
    }
    
    /**
     * �������е�params
     * @return void
     * @author zhouwei 2013-1-27 
     */
    public function getParams(){
        return $this->_params;
    }
    
    /**
     * ����key����ֵ
     * @return void
     * @author zhouwei 2013-1-27 
     */
    public function getParam($key){
        $key = (string) $key;
        return $this->_params[$key];
    }
    
    /**
     * ��ȡ�����
     * @param string $pluginName ����������
     * @param array $params �½�������Ҫ�ύ�Ĳ���
     * @return SweetPlugin
     * @author zhouwei 2013-1-28
     */
    public static function getInstance($params){
        $pluginName = $params[SweetPlugin::CLASS_KEY_NAME];
        if (!file_exists(SweetConfig::getInstance()->getPluginDir().'/'.$pluginName.'.inc')){
            throw new ExceptionController('����಻����:'.$pluginName);
        }
        require_once $pluginName.'.inc';
        if (!class_exists($pluginName)){
            throw new ExceptionController('����಻����:'.$pluginName);
        }
        return new $pluginName($params,$pluginName);
    }
    
        
    /**
     * ���չʾ
     * @return void
     * @author zhouwei 2013-1-26 
     */
    abstract public function load();
    
    /**
     * ��ʼ����Ҫ�Ĳ���
     * @return void
     * @author zhouwei 2013-1-26 
     */
    abstract protected function initParams();
}