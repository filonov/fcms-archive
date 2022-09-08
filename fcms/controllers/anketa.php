<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Контроллер формы обратной связи.
 *
 * @author Denis Filonov <denis@filonov.biz>
 * @copyright (c) 2012-2013, Denis Filonov.
 */
class Anketa extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    private function send_mail($param)
    {
        $tpl = new Emailtpl();
        $this->load->library('email');
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';


        // Отправка письма администратору
        $this->email->initialize($config);
        $tpl->get_by_alias('anketa-admin');
        if ($tpl->exists())
        {
            $msg = sprintf($tpl->text, anchor(base_url("cms/forms/edit/" . $param->id), "Подробнее"));
            $this->email->clear();
            $this->email->from($this->config->item('site_email'), $this->config->item('site_title'));
            $this->email->to($this->config->item('admin_email'));
            $this->email->subject($tpl->title);
            $this->email->message($msg);
            $this->email->send();
        }

        // Отправка письма пользователю
        $this->email->initialize($config);
        $tpl->get_by_alias('anketa');
        if ($tpl->exists())
        {
            $this->email->clear();
            $this->email->from($this->config->item('site_email'), $this->config->item('site_title'));
            $this->email->to($param->email);
            $this->email->subject($tpl->title);
            $this->email->message($tpl->text);
            $this->email->send();
        }
    }

    function index()
    {
        $error = '';

        $forms = new Form_bril();
        if ($this->input->post())
        {
            $forms->name = $this->input->post('name', TRUE);
            $forms->email = $this->input->post('email', TRUE);
            $forms->phone = $this->input->post('phone', TRUE);
            $forms->exp = $this->input->post('exp', TRUE);
            $forms->date = $this->input->post('mdate', TRUE);
            $forms->field01 = $this->input->post('mtype', TRUE);
            $forms->field02 = $this->input->post('mpeople', TRUE);
            $forms->field03 = $this->input->post('mdesc', TRUE);
            $captcha = strtolower(trim($this->input->post('captcha'))); // то что пришло из формы
            $word = $this->session->userdata('word'); // то что было сгенерировано
            $this->session->unset_userdata('word');
            if ($word == $captcha)
            {
                $sucsess = $forms->save();
                if (!$sucsess)
                {
                    $error = 'Ошибка сохранения.';
                    if (!($forms->valid))
                    {
                        $error = $forms->error->string;
                    }
                } else
                {
                    $this->send_mail($forms);
                    //$tpl = new Modules_orm();
                    //$tpl->where(array('alias' => 'anketa'))->get();
                    $error = "Спасибо за заявку! Мы свяжемся с вами!";
                }
            } else
            {
                $error = "Пожалуйста, правильно введите код проверки.";
            }
        }
        $data = template_base_tags() +
                array(
                    'active_menu_id' => 0,
                    'meta_title' => $this->config->item('site_title'),
                    'error' => $error,
                    'form' => $forms
        );
        $this->parser->parse($this->config->item('tplpath') . $this->config->item('skin') . '/anketa', $data);
    }

}
