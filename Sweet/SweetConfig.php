<?php
class SweetConfig{
    const SWEETCONFIG_CONTROLLERDIR = '1';
    const SWEETCONFIG_SMARTYTPDIR   = '2';
    const SWEETCONFIG_LAYOUTDIR     = '3';
    const SWEETCONFIG_SMARTYCONFIG  = '4';
    const SWEETCONFIG_URL_ROOT      = '5';
    const SWEETCONFIG_PLUGINDIR     = '6';
    const SWEETCONFIG_PLUGINTPLDIR  = '7';
    const SWEETCONFIG_ERROR         = '8';
    /**
     * SweetConfig的单例
     * @var SweetConfig的单例 
     */
    private static $_instance = null;
    
    /**
     * 控制器的路径
     * @var string 
     */
    private $_contronllerDir = null;
    
    /**
     * 模板的路径
     * @var string 
     */
    private $_tplDir = null;
    
    /**
     * 页面分层的dir
     * @var type 
     */
    private $_layoutDir = null;
    
    /**
     * smarty的配置信息
     * @var array 
     */
    private $_smartyConfig = array();
    
    /**
     * mvc的根url
     * @var string 
     */
    private $_urlRoot = null;
    
    /**
     * 插件类的地址
     * @var string 
     */
    private $_pluginDir = null;
    
    /**
     * 插件的tpl字段信息
     * @var string 
     */
    private $_pluginTplDir = null;
    
    /**
     * 是否已经初始化
     * @var boolean 
     */
    private $_isInit = false;
    
    /**
     * 构造函数
     * @author zhouwei 2013-1-23 
     */
    private function __construct() {
    }      
            
    /**
     * 获取配置文件的单例模式
     * @return SweetConfig
     * @author zhouwei 2013-1-23
     */
	public static function getInstance(){
		if (null === self::$_instance){
			self::$_instance = new self();
		}
		return self::$_instance;
	}
    
    /**
     * 初始化配置信息
     * @param array $config 
     * @return void
     * @author zhouwei 2013-1-23
     */
    public function init($config){
        if (true === $this->_isInit){
            throw new ExceptionController('SweetConfig不能重新初始化');
        }
        $this->_contronllerDir  = $config[SweetConfig::SWEETCONFIG_CONTROLLERDIR];
        $this->_tplDir          = $config[SweetConfig::SWEETCONFIG_SMARTYTPDIR];
        $this->_layoutDir       = $config[SweetConfig::SWEETCONFIG_LAYOUTDIR];
        $this->_smartyConfig    = $config[SweetConfig::SWEETCONFIG_SMARTYCONFIG];
        $this->_urlRoot         = $config[SweetConfig::SWEETCONFIG_URL_ROOT];
        $this->_pluginDir       = $config[SweetConfig::SWEETCONFIG_PLUGINDIR];
        $this->_pluginTplDir    = $config[SweetConfig::SWEETCONFIG_PLUGINTPLDIR];
        $this->_isInit          = true;
        if (isset($config[SweetConfig::SWEETCONFIG_ERROR])){
            error_reporting($config[SweetConfig::SWEETCONFIG_ERROR]);
        }
    }
    
    /**
     * 获取模板的tpl的路径的配置信息
     * @return string
     * @author zhouwei 2013-1-25 
     */
    public function getTplDir(){
        return $this->_tplDir;
    }
    
    /**
     * 获取layout的dir的路径的配置信息
     * @return string
     * @author zhouwei 2013-1-25 
     */
    public function getLayoutDir(){
        return $this->_layoutDir;
    }
    
    /**
     * 获取控制器dir的路径的配置信息
     * @return string
     * @author zhouwei 2013-1-25 
     */
    public function getControllerDir(){
        return $this->_contronllerDir;
    }
    
    /**
     * 获取smarty配置信息
     * @return array
     * @author zhouwei 2013-1-25 
     */
    public function getSmartyConfig(){
        return $this->_smartyConfig;
    }
    
    /**
     * 网站的mvc的根
     * @return string
     * @author zhouwei 2013-1-25 
     */
    public function getUrlRoot(){
        return $this->_urlRoot;
    }
    
    /**
     * 获取插件的tpl的路径
     * @return string
     * @author zhouwei 2013-1-28  
     */
    public function getPluginTplDir(){
        return $this->_pluginTplDir;
    }
    
    /**
     * 获取插件类的路径
     * @return string
     * @author zhouwei 2013-1-28  
     */
    public function getPluginDir(){
        return $this->_pluginDir;
    }
}