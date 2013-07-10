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
