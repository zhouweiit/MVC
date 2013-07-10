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
     * tpl��·��
     * @var string 
     */
    private $_tplDir = null;
    /**
     * �����ģ��·�� 
     * @var string
     */
    private $_pluginDir = null;
    /**
     * smarty��������Ϣ
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
     * ��ȡsmarty�ĵ���
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
     * �Ѵ��ݵ�ҳ���ֵд�뵽smartyģ��
     * @param array $params
     * @return void
     * @author zhouwei 2013-1-23
     */
    private function assignParams(array $params = array()) {
        if (!is_array($params)) {
            throw new ExceptionController('�ύ��TPL�Ĳ������ͱ���������');
        }
        foreach ($params as $key => $value) {
            $this->assign($key, $value);
        }
    }

    /**
     * ��ָsmarty��Ĭ��ֵ
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
     * ��ʼ��smarty
     * @return void
     * @author zhouwei 2013-1-23 
     */
    private function initSmarty() {
        
    }

    /**
     * smartyע���Զ��庯��
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
     * smartyע���Զ��庯��
     * @return void
     * @author zhouwei 2013-1-23
     */
    private function registerModifier() {
        //���������ļ�����������������
    } 

    /**
     * ��ȡģ��������string
     * @param string $tpluri ģ���·��
     * @param array $params ���Ƹ�ģ��Ĳ���
     * @param boolean $clearParams �Ƿ�������Ѿ����ƵĲ��� 
     * @return string
     * @author zhouwei 2013-1-23
     */
    public function fetch($tplUri, array $params = array(), $clearParams = true) {
        if (!file_exists($tplUri)) {
            throw new ExceptionController('ģ��δ�ҵ���tpl:' . $tplUri);
        }
        if (true === $clearParams) {
            $this->clearAssing();
        }
        $this->assignParams($params);
        return parent::fetch($tplUri);
    }

    /**
     * ����key�����һ��smarty�Ѿ����ƵĲ���
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
     * ��ȡtpl��·��
     * @return string
     * @author zhouwei 2013-1-23 
     */
    public function getTplDir() {
        return $this->_tplDir;
    }

    /**
     * ���ز����dir
     * @return string
     * @author zhouwei 2013-1-23  
     */
    public function getPluginDir() {
        return $this->_pluginDir;
    }

}