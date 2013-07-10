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
     * SweetConfig�ĵ���
     * @var SweetConfig�ĵ��� 
     */
    private static $_instance = null;
    
    /**
     * ��������·��
     * @var string 
     */
    private $_contronllerDir = null;
    
    /**
     * ģ���·��
     * @var string 
     */
    private $_tplDir = null;
    
    /**
     * ҳ��ֲ��dir
     * @var type 
     */
    private $_layoutDir = null;
    
    /**
     * smarty��������Ϣ
     * @var array 
     */
    private $_smartyConfig = array();
    
    /**
     * mvc�ĸ�url
     * @var string 
     */
    private $_urlRoot = null;
    
    /**
     * �����ĵ�ַ
     * @var string 
     */
    private $_pluginDir = null;
    
    /**
     * �����tpl�ֶ���Ϣ
     * @var string 
     */
    private $_pluginTplDir = null;
    
    /**
     * �Ƿ��Ѿ���ʼ��
     * @var boolean 
     */
    private $_isInit = false;
    
    /**
     * ���캯��
     * @author zhouwei 2013-1-23 
     */
    private function __construct() {
    }      
            
    /**
     * ��ȡ�����ļ��ĵ���ģʽ
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
     * ��ʼ��������Ϣ
     * @param array $config 
     * @return void
     * @author zhouwei 2013-1-23
     */
    public function init($config){
        if (true === $this->_isInit){
            throw new ExceptionController('SweetConfig�������³�ʼ��');
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
     * ��ȡģ���tpl��·����������Ϣ
     * @return string
     * @author zhouwei 2013-1-25 
     */
    public function getTplDir(){
        return $this->_tplDir;
    }
    
    /**
     * ��ȡlayout��dir��·����������Ϣ
     * @return string
     * @author zhouwei 2013-1-25 
     */
    public function getLayoutDir(){
        return $this->_layoutDir;
    }
    
    /**
     * ��ȡ������dir��·����������Ϣ
     * @return string
     * @author zhouwei 2013-1-25 
     */
    public function getControllerDir(){
        return $this->_contronllerDir;
    }
    
    /**
     * ��ȡsmarty������Ϣ
     * @return array
     * @author zhouwei 2013-1-25 
     */
    public function getSmartyConfig(){
        return $this->_smartyConfig;
    }
    
    /**
     * ��վ��mvc�ĸ�
     * @return string
     * @author zhouwei 2013-1-25 
     */
    public function getUrlRoot(){
        return $this->_urlRoot;
    }
    
    /**
     * ��ȡ�����tpl��·��
     * @return string
     * @author zhouwei 2013-1-28  
     */
    public function getPluginTplDir(){
        return $this->_pluginTplDir;
    }
    
    /**
     * ��ȡ������·��
     * @return string
     * @author zhouwei 2013-1-28  
     */
    public function getPluginDir(){
        return $this->_pluginDir;
    }
}