<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of login
 *
 * @author DVF
 */
class Logout extends CI_Controller
{
//put your code here
    function index()
    {
       if ($this->input->post('exit', TRUE))
       {
           logout();
           redirect('');
       }
       if (rights() == SEC_RIGHTS_NONE)
       {
           redirect('login');
       }
       $data = template_base_tags()+ array(
            'meta_title' => $this->config->item('site_title'),
            'meta_keywords' => '',
            'meta_description' => '',
        );
       $this->load->view($this->config->item('tplpath').$this->config->item('skin').'/logout', $data);
    }
}

/* End of file  */
/* Location: ./system/application/config/ */
