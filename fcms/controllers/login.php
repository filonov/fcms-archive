<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of login
 *
 * @author DVF
 */
class Login extends CI_Controller
{

    function index()
    {
        if ($this->input->post('password', TRUE))
        {
            if ($this->input->post('password', TRUE) == $this->config->item('password'))
            {
                login_root();
                redirect('cms');
            } else
            {
                redirect('');
            }
        }
        
        if (rights() == SEC_RIGHTS_ROOT)
        {
            redirect('logout');
        }
        $data = template_base_tags() + array(
            'meta_title' => $this->config->item('site_title'),
            'meta_keywords' => '',
            'meta_description' => '',
        );
        $this->parser->parse($this->config->item('tplpath') . $this->config->item('skin') . '/login', $data);
    }
}

/* End of file  */
/* Location: ./system/application/config/ */
