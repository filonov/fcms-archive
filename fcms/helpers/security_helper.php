<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Функции безопасности, авторизации и т.д.
 *
 */

/**
 * Заполняет сессию данными пользователя:
 *  - ID пользователя
 *  - login (user)
 *  - id_rights
 *  -
 * @param <type> $login
 * @param <type> $password
 */
function sec_auth($login, $password)
{
//session_start($s);
    $CI=&get_instance();
    $CI->load->model('Users_model');
    $CI->load->model('Rights_model');
    $rgh = $CI->Users_model->check_user_rights($login,$password);
    $id = $CI->Users_model->check_user_id($login,$password);
    $name = $CI->Users_model->name_by_id($id);
    $zakupka = $CI->Rights_model->zak_by_id($rgh);
    $clietskaja = $CI->Rights_model->cli_by_id($rgh);
    $clietskaja = $CI->Rights_model->cli_by_id($rgh);
    $gostevaja = $CI->Rights_model->gst_by_id($rgh);
    if ($rgh>0)
    {
    //set_usersec($login,$res);
        $CI->session->set_userdata(array('user'=>$login,
            'rights'=>$rgh,
            'id' => $id,
            'name' => $name,
            'show_zak' => $zakupka,
            'show_cli' => $clietskaja,
            'show_gst' => $gostevaja
        ));
    }
}

/**
 * Залогинится как гость
 */
function sec_login_as_guest()
{
    $CI=&get_instance();
    $CI->session->set_userdata(array('user'=>'Гость',
        'rights'=> 4,
        'name'=> 'Гость',
        'id' => 2,
    ));
}

/**
 * Отлогиниться
 */
function logout()
{
    $CI=&get_instance();
    $CI->session->unset_userdata(array('rights'=>''));
}

/**
 * Проверка на залогиненность
 * Возвращает -1, если не залогинен.
 * @return <type>
 */
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
    }
}

/**
 *  Доступ только админу
 */
function admin_only()
{
    if (!(sec_check_rights() == SEC_RIGHTS_ADMIN))
    {
        redirect('login');
    }
}

function login_root()
{
    $CI=&get_instance();
    $CI->session->set_userdata(array('rights'=> SEC_RIGHTS_ROOT));
}

function is_root()
{
    $CI =&get_instance();
    if (!(rights() == SEC_RIGHTS_ROOT))
    {
        redirect('login');
    }
}