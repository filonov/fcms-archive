<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
  |--------------------------------------------------------------------------
  | Параметры CMS
  |--------------------------------------------------------------------------
  |
  | Настройки CMS. Здесь храняться все постоянные настройки сайта.
 */

// #REFACTOR!

$config['password'] = '*******';

$config['cache_time'] = 1300;

$config['wwwpath'] = str_replace("\\", "/", pathinfo(FCPATH, PATHINFO_DIRNAME));
$config['tplpath'] = "../../templates/";

// Настройки шаблона панели администрирования.

$config['cms_html'] = $this->config['base_url'] . 'templates/cms/';
$config['cms_css'] = $this->config['base_url'] . 'templates/cms/css/';
$config['cms_js'] = $this->config['base_url'] . 'templates/cms/js/';
$config['cms_images'] = $this->config['base_url'] . 'templates/cms/images/';
$config['cms_img'] = $this->config['base_url'] . 'templates/cms/img/';
$config['cms_swf'] = $this->config['base_url'] . 'templates/cms/swf/';



// Настройки шаблона сайта.
//$config['skin'] = 'default';
//$config['skin'] = 'liberum';
//$config['skin'] = 'filonov';
//$config['skin'] = 'brillanza';
//$config['skin'] = 'mma';
//$config['skin'] = 'white-forest';
//$config['skin'] = 'hygiene-at-nature';
$config['skin'] = FCMS_PROJECT;

$config['skin_html_path'] = $config['tplpath'] . $config['skin'].'/';
$config['skin_html'] = $this->config['base_url'] . 'templates/'.$config['skin'].'/';
$config['skin_css'] = $this->config['base_url'] . 'templates/'.$config['skin'].'/css/';
$config['skin_js'] = $this->config['base_url'] . 'templates/'.$config['skin'].'/js/';
$config['skin_img'] = $this->config['base_url'] . 'templates/'.$config['skin'].'/img/';
$config['skin_images'] = $this->config['base_url'] . 'templates/'.$config['skin'].'/images/';

/*
 * 'skin_html' => $CI->config->item('skin_html'),
        'skin_css' => $CI->config->item('skin_css'),
        'skin_js' => $CI->config->item('skin_js'),
        'skin_img' => $CI->config->item('skin_img'),
        'skin_images' => $CI->config->item('skin_images'),
        'skin_swf' => $CI->config->item('skin_swf'),
        'site_title' => $CI->config->item('site_title')
 */

switch ($config['skin'])
{
    case 'liberum':
	$config['path_for_uploads'] = $config['wwwpath'] . '/cms.loc/files-liberum/';
	$config['url_for_uploads'] = $this->config['base_url'] . 'files-liberum/';
	$config['site_title'] = 'Итальяно-испанский учебный центр Либерум'; // Название сайт
	$config['site_keywords'] = 'итальянский, испанский';
	$config['site_description'] = 'итальянский, испанский';
	$config['site_email'] = 'denis@filonov.biz'; // От кого 
	$config['admin_email'] = 'denis@filonov.biz'; // Почта админа
	$config['per_page'] = 20; // Паджинация по-умолчанию
	$config['catalog_per_page'] = 9;
	break;
    case 'default':
	$config['path_for_uploads'] = $config['wwwpath'] . '/cms.loc/files-default/';
	$config['url_for_uploads'] = $this->config['base_url'] . 'files-default/';
	$config['site_title'] = 'Студия Филонова';
	$config['site_keywords'] = 'разрботка сайтов, сайты, блоги';
	$config['site_email'] = 'denis@filonov.pro'; // От кого 
	$config['admin_email'] = 'denis@filonov.pro'; // Почта админа
	$config['per_page'] = 12; // Паджинация по-умолчанию
	$config['catalog_per_page'] = 9;
	break;
}


// Для filonov.pro
// Размеры картинок в каталоге. Малая и большая картинка.
$config['catalog_tmb_small'] = 150;
$config['catalog_tmb_big'] = 300;

// Размеры картинок галереи. Малая, средняя и большая картинки.
$config['gallery_tmb_small'] = 150;
$config['catalog_tmb_medium'] = 300;
$config['catalog_tmb_big'] = 640;

//Размеры картинок категории.
$config['category_tmb'] = 182;

//Размеры картинок контента.
