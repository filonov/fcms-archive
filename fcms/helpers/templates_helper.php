<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Возвращает скрипты из skin/js в виде строки 
 * @param <type> $file
 * @param <type> $data
 * @return <type>
 */
function template_inc_js($file = '', $data = array())
{
    $CI = &get_instance();
    return '<script type="text/javascript">' . $CI->parser->parse('cms/js/' . $file, $data, TRUE) . '</script>';
}

/**
 * Возвращает переменные для шаблона.
 * @return string
 */
function template_base_tags()
{
    $CI = &get_instance();
    $ver = 0;
    $settings = new Settings_orm();
    $settings->get_where(array('key' => 'version'), 1);
    if ($settings->exists())
        $ver = $settings->value;
    $data = array(
        'base' => $CI->config->item('base_url'),
        'url_for_uploads' => $CI->config->item('url_for_uploads'),
        'path_for_uploads' => $CI->config->item('path_for_uploads'),
        'version' => $ver,
        'cms_html' => $CI->config->item('cms_html'),
        'cms_css' => $CI->config->item('cms_css'),
        'cms_js' => $CI->config->item('cms_js'),
        'cms_images' => $CI->config->item('cms_images'),
        'cms_img' => $CI->config->item('cms_img'),
        'cms_swf' => $CI->config->item('cms_swf'),
        'skin' => $CI->config->item('skin'),
        'skin_html' => $CI->config->item('skin_html'),
        'skin_css' => $CI->config->item('skin_css'),
        'skin_js' => $CI->config->item('skin_js'),
        'skin_img' => $CI->config->item('skin_img'),
        'skin_images' => $CI->config->item('skin_images'),
        'skin_swf' => $CI->config->item('skin_swf'),
        'site_title' => $CI->config->item('site_title')
    );
    return $data;
}
