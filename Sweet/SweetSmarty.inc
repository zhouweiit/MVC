<?php

require_once 'Smarty.class.php';
require_once 'SmartyFunction.inc';

class SweetSmarty extends Smarty {
    const SMATY_TPLNAME = 'tpl';
    const COMPILE_DIR = '1';
    const CACHE_DIR = '2';
    const TEMPLATE_DIR = '3';
    const LEFT_DELIMITER = '4';
    const RIGHT_DELIMITER = '5';
    const PLUGIN_DIR = '6';

    private static $_instance = null;
    /**
     * tpl的路径
     * @var string 
     */
    private $_tplDir = null;
    /**
     * 插件的模板路径 
     * @var string
     */
    private $_pluginDir = null;
    /**
     * smarty的配置信息
     * @var array 
     */
    private $_smartyConfig = array();

    public function __construct() {
        $sweetConfig = SweetConfig::getInstance();
        $this->_smartyConfig = $sweetConfig->getSmartyConfig();
        $this->_pluginDir = $sweetConfig->getPluginTplDir();
        $this->_tplDir = $sweetConfig->getTplDir();
        $this->initDefaultSmarty();
        $this->initSmarty();
        $this->registerFunction();
        $this->registerModifier();
    }

    /**
     * 获取smarty的单列
     * @return SweetSmarty
     * @author zhouwei 2013-1-25 
     */
    public static function getInstance() {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * 把传递到页面的值写入到smarty模板
     * @param array $params
     * @return void
     * @author zhouwei 2013-1-23
     */
    private function assignParams(array $params = array()) {
        if (!is_array($params)) {
            throw new ExceptionController('提交给TPL的参数类型必须是数组');
        }
        foreach ($params as $key => $value) {
            $this->assign($key, $value);
        }
    }

    /**
     * 是指smarty的默认值
     * @return void
     * @author zhouwei 2013-1-23
     */
    private function initDefaultSmarty() {
        $this->compile_dir = $this->_smartyConfig[self::COMPILE_DIR];
        $this->cache_dir = $this->_smartyConfig[self::CACHE_DIR];
        $this->left_delimiter = $this->_smartyConfig[self::LEFT_DELIMITER];
        $this->right_delimiter = $this->_smartyConfig[self::RIGHT_DELIMITER];
        $this->template_dir = $this->_smartyConfig[self::TEMPLATE_DIR];
    }

    /**
     * 初始化smarty
     * @return void
     * @author zhouwei 2013-1-23 
     */
    private function initSmarty() {
        
    }

    /**
     * smarty注册自定义函数
     * @return void
     * @author zhouwei 2013-1-23
     */
    private function registerFunction() {
        $this->register_block('appendHeadScript', 'base_block_headScript');
        $this->register_block('appendHeadStyle', 'base_block_headStyle');
        $this->register_block('appendTDK', 'base_block_tdk');
        $this->register_block('appendHead', 'base_block_head');
        $this->register_block('appendFootScript', 'base_block_foorscript');
        $this->register_block('appendFoot', 'base_block_foot');
        $this->register_function('appendPlugin', 'base_function_plugin');
    }

    /**
     * smarty注册自定义函数
     * @return void
     * @author zhouwei 2013-1-23
     */
    private function registerModifier() {
        //解析配置文件，读入修饰器方法
    } 

    /**
     * 获取模板解析后的string
     * @param string $tpluri 模板的路径
     * @param array $params 复制给模板的参数
     * @param boolean $clearParams 是否清理掉已经复制的参数 
     * @return string
     * @author zhouwei 2013-1-23
     */
    public function fetch($tplUri, array $params = array(), $clearParams = true) {
        if (!file_exists($tplUri)) {
            throw new ExceptionController('模板未找到！tpl:' . $tplUri);
        }
        if (true === $clearParams) {
            $this->clearAssing();
        }
        $this->assignParams($params);
        return parent::fetch($tplUri);
    }

    /**
     * 根据key清理掉一个smarty已经复制的参数
     * @param string $key
     * @author zhouwei 2013-1-23  
     */
    public function clearAssing($key = null) {
        if (null === $key) {
            $this->clear_all_assign();
        }
        $this->clear_assign($key);
    }

    /**
     * 获取tpl的路径
     * @return string
     * @author zhouwei 2013-1-23 
     */
    public function getTplDir() {
        return $this->_tplDir;
    }

    /**
     * 返回插件的dir
     * @return string
     * @author zhouwei 2013-1-23  
     */
    public function getPluginDir() {
        return $this->_pluginDir;
    }

}