<?php

$CI = &get_instance();
$CI->output->set_status_header('404');
$data['title'] = $message;
$data['meta_title'] = $CI->config->item('site_title');
$data['meta_description'] = $message;
$data['meta_keywords'] = '404';
$data['content'] = '<h1>Страница не найдена.</h1> Посмотрите существующие страницы в меню, или перейдите <a href="' . base_url() . '">на главную.</a>';
echo $CI->parser->parse($CI->config->item('tplpath') . $CI->config->item('skin') . '/error_404', template_base_tags() + $data);


