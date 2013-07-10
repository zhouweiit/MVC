<?php

defined('ROOT') ||
	define('ROOT',realpath(dirname(__FILE__)));

set_include_path(implode(PATH_SEPARATOR,array(
	ROOT,
    ROOT.'/inc/lib/Sweet',//配置框架根目录
    ROOT.'/inc/lib/Smarty',//配置smarty的library的根目录
    ROOT.'/inc/app',//配置controller目录
    ROOT.'/theme/smarty/pluginClass',//配置插件类目录
    ROOT.'/inc/lib/classes',//配置PHPExcel
	get_include_path()
)));

/**
 * 框架的基本配置信息 
 */
$sweetConfig = array(
    SweetConfig::SWEETCONFIG_CONTROLLERDIR  => ROOT.'/inc/app',//controller路径
    SweetConfig::SWEETCONFIG_SMARTYTPDIR    => ROOT.'/inc/tpl',//tpl路径
    SweetConfig::SWEETCONFIG_LAYOUTDIR      => ROOT.'/inc/tpl',//layout路径
    SweetConfig::SWEETCONFIG_URL_ROOT       => '/',//url的root设置为/
    SweetConfig::SWEETCONFIG_PLUGINDIR      => ROOT.'/theme/smarty/pluginClass',//插件类存放的路径
    SweetConfig::SWEETCONFIG_PLUGINTPLDIR   => ROOT.'/theme/smarty/pluginTpl',//插件模板存放的路径
    SweetConfig::SWEETCONFIG_ERROR          => E_ALL ^ E_NOTICE,
    SweetConfig::SWEETCONFIG_SMARTYCONFIG   => //smarty的基本配置信息
        array(
            SweetSmarty::COMPILE_DIR    => ROOT . '/theme/smarty/compile',//编译文件的存的路径
            SweetSmarty::CACHE_DIR      => ROOT . '/theme/smarty/cache',//缓存文件的存放的路径
            SweetSmarty::TEMPLATE_DIR   => ROOT . '/inc/tpl',//模板文件的存放路径
            SweetSmarty::LEFT_DELIMITER => '<?',//左标记
            SweetSmarty::RIGHT_DELIMITER=> '?>',//又标记
        ),
);

/**
 * 获取框架引擎类的单例
 */
$bootstrap = SweetBootstrap::getInstance();

/**
 * 初始化配置信息
 */
$bootstrap->initConfig($sweetConfig);

/**
 * 运行 
 */
$bootstrap->run();