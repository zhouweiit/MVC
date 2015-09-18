<?php
require_once 'Controller/Exception.inc';
abstract class SweetPlugin{
    const PARAMS_KEY_NAME = 'pluginParams';
    const CLASS_KEY_NAME = 'pluginClass';

    /**
     * 插件类的路径
     * @var string 
     */
    private $_pluginDir = null;

    /**
     * 插件模板的路径
     * @var string 
     */
    private $_pluginTplDir = null;

    /**
     * 需要返回给模板的参数
     * @var array 
     */
    private $_pluginParams = array();

    /**
     * 提交给插件的参数
     * @var array 
     */
    private $_params = array();

    /**
     * pluginClass
     * @var string 
     */
    private $_pluginClass = null;

    /**
     * 插件的tpl的uri
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
     * 初始化参数信息
     * @return void
     * @author zhouwei 2013-1-26 
     */
    protected function init(){
        $this->initParams();
    }

    /**
     * 设置PluginTplUri
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
     * 获取插件tpl的uri
     * @return string
     * @author zhouwei 2013-1-28  
     */
    public function getPluginTplUri(){
        return $this->_pluginTplUri;
    }

    /**
     * 批量设置返回给插件的变量
     * @param array $params 
     * @return void
     * @author zhouwei 2013-1-27
     */
    protected function setPluginParams(array $params){
        $this->_pluginParams = array_merge($this->_pluginParams,$params);
    }

    /**
     * 单笔设置返回给插件的变量
     * @param string $key
     * @param array $params 
     * @return void
     * @author zhouwei 2013-1-27
     */
    protected function setPluginParam($key,$params){
        $this->_pluginParams[$key] = $params;
    }

    /**
     * 返回设置的plugParams
     * @return array
     * @author zhouwei 2013-1-27 
     */
    public function getPluginParams(){
        return $this->_pluginParams;
    }

    /**
     * 返回所有的params
     * @return void
     * @author zhouwei 2013-1-27 
     */
    public function getParams(){
        return $this->_params;
    }

    /**
     * 根据key返回值
     * @return void
     * @author zhouwei 2013-1-27 
     */
    public function getParam($key){
        $key = (string) $key;
        return $this->_params[$key];
    }

    /**
     * 获取插件类
     * @param string $pluginName 插件类的名称
     * @param array $params 新建对象需要提交的参数
     * @return SweetPlugin
     * @author zhouwei 2013-1-28
     */
    public static function getInstance($params){
        $pluginName = $params[SweetPlugin::CLASS_KEY_NAME];
        if (!file_exists(SweetConfig::getInstance()->getPluginDir().'/'.$pluginName.'.inc')){
            throw new ExceptionController('插件类不存在:'.$pluginName);
        }
        require_once $pluginName.'.inc';
        if (!class_exists($pluginName)){
            throw new ExceptionController('插件类不存在:'.$pluginName);
        }
        return new $pluginName($params,$pluginName);
    }


    /**
     * 插件展示
     * @return void
     * @author zhouwei 2013-1-26 
     */
    abstract public function load();

    /**
     * 初始化必要的参数
     * @return void
     * @author zhouwei 2013-1-26 
     */
    abstract protected function initParams();
}
