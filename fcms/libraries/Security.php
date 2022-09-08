<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Библиотека авторизации пользователей.
 * В сессии храняться
 * имя пользователя, ID, группа
 * Пользователь принадлежит группе, и наследует её права.
 *
 * @author DVF
 * @copyright Denis V. Filonov
 * @@link http://filonov.biz
 */

class Security
{
    function login($name, $password)
    {
        $CI=&get_instance();
        $CI->load->model('Users_model');
        $CI->load->model('Rights_model');
        $rgh = $CI->Users_model->check_user_rights($login,$password);
        $id = $CI->Users_model->check_user_id($login,$password);
        $name = $CI->Users_model->name_by_id($id);
        if ($rgh>0)
        {
            $CI->session->set_userdata(array('user'=>$login,
                'rights'=>$rgh,
                'id' => $id,
                'name' => $name));
        };
    }

    function logout()
    {
        $CI=&get_instance();
        $CI->session->unset_userdata(array('rights'=>'','name'=>'','id'=>''));;
    }

    function rights()
    {
        $CI = &get_instance();
        if ($CI->session->userdata('rights') == FALSE)
        {
            return SEC_RIGHTS_NONE;
        }
        else
        {
            return $CI->session->userdata('rights');
        };
    }

    function is_root()
    {
        $CI =&get_instance();
        if (!($this->rights() == SEC_RIGHTS_ROOT))
        {
            redirect('login');
        }
    }
}
