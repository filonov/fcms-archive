<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
/**
 * Контроллер отвечает за 404.
 * @copyright (c) 2012-2013, Denis Filonov
 */

class Error extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    function error_404()
    {
        show_404();
    }

}