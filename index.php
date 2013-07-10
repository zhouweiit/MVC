<?php

defined('ROOT') ||
	define('ROOT',realpath(dirname(__FILE__)));

set_include_path(implode(PATH_SEPARATOR,array(
	ROOT,
    ROOT.'/inc/lib/Sweet',//���ÿ�ܸ�Ŀ¼
    ROOT.'/inc/lib/Smarty',//����smarty��library�ĸ�Ŀ¼
    ROOT.'/inc/app',//����controllerĿ¼
    ROOT.'/theme/smarty/pluginClass',//���ò����Ŀ¼
    ROOT.'/inc/lib/classes',//����PHPExcel
	get_include_path()
)));

/**
 * ��ܵĻ���������Ϣ 
 */
$sweetConfig = array(
    SweetConfig::SWEETCONFIG_CONTROLLERDIR  => ROOT.'/inc/app',//controller·��
    SweetConfig::SWEETCONFIG_SMARTYTPDIR    => ROOT.'/inc/tpl',//tpl·��
    SweetConfig::SWEETCONFIG_LAYOUTDIR      => ROOT.'/inc/tpl',//layout·��
    SweetConfig::SWEETCONFIG_URL_ROOT       => '/',//url��root����Ϊ/
    SweetConfig::SWEETCONFIG_PLUGINDIR      => ROOT.'/theme/smarty/pluginClass',//������ŵ�·��
    SweetConfig::SWEETCONFIG_PLUGINTPLDIR   => ROOT.'/theme/smarty/pluginTpl',//���ģ���ŵ�·��
    SweetConfig::SWEETCONFIG_ERROR          => E_ALL ^ E_NOTICE,
    SweetConfig::SWEETCONFIG_SMARTYCONFIG   => //smarty�Ļ���������Ϣ
        array(
            SweetSmarty::COMPILE_DIR    => ROOT . '/theme/smarty/compile',//�����ļ��Ĵ��·��
            SweetSmarty::CACHE_DIR      => ROOT . '/theme/smarty/cache',//�����ļ��Ĵ�ŵ�·��
            SweetSmarty::TEMPLATE_DIR   => ROOT . '/inc/tpl',//ģ���ļ��Ĵ��·��
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