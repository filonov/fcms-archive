<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Контроллер админки
 *
 * @author DVF
 */
class Index extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_root();
    }

    function index()
    {
        $data = template_base_tags();
        $this->parser->parse($this->config->item('tplpath') . 'cms/index', $data);
    }

}
