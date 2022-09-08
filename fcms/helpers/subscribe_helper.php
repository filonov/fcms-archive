<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function start_subscribe($title = 'Калужский областной драматический театр - новости', $msg = '')
{
    $CI = & get_instance();
    $CI->load->library('email');

    $subscribe_base = $CI->db->select('email')->getwhere('subscribe', array('accept' => 1))->result();

    foreach ($subscribe_base as $object) {
        $unsub = "\nДля того, что бы отказаться от рассылки нажмите на эту ссылку " . base_url() . "unsubscribe/" . $object->id;
        $CI->email->from('not-replay@teatrkaluga.ru', $title);
        $CI->email->to($object->email);
        $CI->email->subject('Калужский областной драматический театр');
        $CI->email->message($msg . $unsub);
        $CI->email->send();
    }
}

function add_subscribe_news($id = 0)
{
    if (empty($id))
        return FALSE;

    $CI = & get_instance();
    $filename = $CI->config->item('wwwpath') . '/subscrie.list';
    if (is_file($filename)) {
        $list_news = file_get_contents($filename);
        if (!empty($list_news)) {
            $list_news = unserialize($list_news);
            array_push($list_news, $id);
        }else
            $list_news = array($id);
    }else
        $list_news = array($id);

    $list_news = serialize($list_news);
    file_put_contents($filename, $list_news);
}