<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Контроллер редактирования конфига.
 *
 * @author Denis Filonov <denis@filonov.biz>
 * @copyright (c) 2013, Denis Filonov.
 */
class Configuration extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_root();
    }

    function index()
    {
        $filename = APPPATH.'config/cms.php';
        
        if($this->input->post('text'))
        {
            $handle = fopen($filename, 'w');
            $content = $this->input->post('text');
            fwrite($handle, $content);
            fclose($handle);
        }

        $handle = fopen($filename, 'r');
        $contents = fread($handle, filesize($filename));
        $data = template_base_tags() + array(
            'text' => $contents
        );
        fclose($handle);
        $this->parser->parse($this->config->item('tplpath') . 'cms/configuration', $data);
    }

}