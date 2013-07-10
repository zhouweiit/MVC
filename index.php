<?php

defined('ROOT') ||
	define('ROOT',realpath(dirname(__FILE__)));

set_include_path(implode(PATH_SEPARATOR,array(
	ROOT,
    ROOT.'/Sweet',//���ÿ�ܸ�Ŀ¼
    ROOT.'/Smarty',//����smarty��library�ĸ�Ŀ¼
    ROOT.'/controller',//����controllerĿ¼
    ROOT.'/pluginClass',//���ò����Ŀ¼
	get_include_path()
)));

/**
 * ��ܵĻ���������Ϣ 
 */
$sweetConfig = array(
    SweetConfig::SWEETCONFIG_CONTROLLERDIR  => ROOT.'/controller',//controller·��
    SweetConfig::SWEETCONFIG_SMARTYTPDIR    => ROOT.'/tpl',//tpl·��
    SweetConfig::SWEETCONFIG_LAYOUTDIR      => ROOT.'/tpl',//layout·��
    SweetConfig::SWEETCONFIG_URL_ROOT       => '/',//url��root����Ϊ/
    SweetConfig::SWEETCONFIG_PLUGINDIR      => ROOT.'/pluginClass',//������ŵ�·��
    SweetConfig::SWEETCONFIG_PLUGINTPLDIR   => ROOT.'/pluginTpl',//���ģ���ŵ�·��
    SweetConfig::SWEETCONFIG_ERROR          => E_ALL ^ E_NOTICE,
    SweetConfig::SWEETCONFIG_SMARTYCONFIG   => //smarty�Ļ���������Ϣ
        array(
            SweetSmarty::COMPILE_DIR    => ROOT . '/smarty/compile',//�����ļ��Ĵ��·��
            SweetSmarty::CACHE_DIR      => ROOT . '/smarty/cache',//�����ļ��Ĵ�ŵ�·��
            SweetSmarty::TEMPLATE_DIR   => ROOT . '/tpl',//ģ���ļ��Ĵ��·��
            SweetSmarty::LEFT_DELIMITER => '<?',//����
            SweetSmarty::RIGHT_DELIMITER=> '?>',//�ֱ��
        ),
);

/**
 * ��ȡ���������ĵ���
 */
$bootstrap = SweetBootstrap::getInstance();

/**
 * ��ʼ��������Ϣ
 */
$bootstrap->initConfig($sweetConfig);

/**
 * ���� 
 */
$bootstrap->run();
