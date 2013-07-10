<?php

require_once 'SweetSmarty.inc';
require_once 'SweetLayout.inc';
require_once 'Controller/Exception.inc';

function base_block_headScript($params, $content, &$smarty, &$repeat) {
    if (null !== $content) {
        $layout = SweetLayout::getInstance();
        $layout->appendHeadScript($content);
    }
}

function base_block_headStyle($params, $content, &$smarty, &$repeat) {
    if (null !== $content) {
        $layout = SweetLayout::getInstance();
        $layout->appendHeadStyle($content);
    }
}

function base_block_tdk($params, $content, &$smarty, &$repeat) {
    if (null !== $content) {
        $layout = SweetLayout::getInstance();
        $layout->appendTDK($content);
    }
}

function base_block_head($params, $content, &$smarty, &$repeat) {
    if (null !== $content) {
        $layout = SweetLayout::getInstance();
        $layout->appendHead($content);
    }
}

function base_block_foorscript($params, $content, &$smarty, &$repeat) {
    if (null !== $content) {
        $layout = SweetLayout::getInstance();
        $layout->appendFootScript($content);
    }
}

function base_block_foot($params, $content, &$smarty, &$repeat) {
    if (null !== $content) {
        $layout = SweetLayout::getInstance();
        $layout->appendFoot($content);
    }
}

function base_function_plugin($params, &$smarty) {
    if (!$params['pluginClass']) {
        throw new ExceptionController('param pluginClass is null');
    }
    $pluginInstance = SweetPlugin::getInstance($params);
    $pluginInstance->load();
    $sweetSmarty = new SweetSmarty();
    $pluginParams = $pluginInstance->getPluginParams();
    return $sweetSmarty->fetch($pluginInstance->getPluginTplUri(), $pluginParams);
}

function base_function_category($params, &$smarty) {
    require_once ROOT . '/inc/facade/CategoryManager.inc';
    $string = '<script type="text/javascript" src="/js/form_tool.js"></script>';
    $string .= '<script type="text/javascript" src="/js/plugin_category.js"></script>';
    $cat01 = CategoryManager::getFirstCategory();
    $replace = '<option value="">选择1级分类</option>';
    foreach ($cat01 as $category) {
        $replace .= "<option value=\"{$category['catid']}\">{$category['name']}</option>";
    }
    $string .= "<select name='cat01' id='cat01' onChange=\"changeCat01();\" >{$replace}</select>";
    $string .= "<select name='cat02' id='cat02' style=\"display:none\" onChange=\"changeCat02();\" ></select>";
    $string .= "<select name='cat03' id='cat03' style=\"display:none\" onChange=\"changeCat03();\" ></select>";
    $string .= "<select name='cat04' id='cat04' style=\"display:none\" onChange=\"changeCat04();\" ></select>";
    return $string;
}