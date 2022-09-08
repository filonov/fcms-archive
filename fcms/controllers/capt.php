<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Контроллер капчи. Выводит оную в поток.
 *
 * @author Denis Filonov <denis@filonov.biz>
 * @copyright (c) 2013, Denis Filonov.
 */

class Capt extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->load->helper('captcha');

        $prefs = array(// настройки капчи, все элементы являются необязательными
            //'word' => 'text', // текст
            'img_width' => 100, // ширина изображения (int)
            'img_height' => 30, // высота изображения (int)
            'random_str_length' => 5, // длина случайной строки (int)
            'border' => FALSE, // добавлять рамку (bool)
            'font_path' => $this->config->item('path_for_uploads'). 'fonts/DroidSans-Bold.ttf' // путь к файлу шрифта
        );

        $word = create_captcha_stream($prefs);
        $this->session->set_userdata('word', strtolower($word));
    }

}
