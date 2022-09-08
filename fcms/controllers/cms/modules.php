<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Администрирование модулей.
 * @copyright (c) 2013, Denis Filonov.
 */
class Modules extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_root();
    }

    /**
     * Таблица модулей
     * @param string $category 
     */
    function index($category = '')
    {
        //$visual = new Visual_elements();

        $modules = new Modules_orm();
        $modules->order_by('title, id');


        $data = template_base_tags() + array(
            'modules' => $modules->get()
        );

        $this->parser->parse($this->config->item('tplpath') . 'cms/modules', $data);
    }

    /**
     * Добавление новой страницы.
     */
    function add()
    {
        $s = new Modules_orm();
        $s->title = '';
        $s->text = '';
        $s->alias = '';
        $s->skip_validation()->save();
        redirect('cms/modules/edit/' . $s->id);
    }

    /**
     * Редактировать страницу.
     * @param integer $id
     */
    function edit($id = FALSE)
    {
        
        $row = new Modules_orm();

        // Сохранение
        if ($this->input->post('eid'))
        {
            $row->get_by_id($id);
            $title = $this->input->post('title', TRUE);
            $this->load->helper('translit');
            $data = array(
                'title' => $title,
                'text' => $this->input->post('text', TRUE)
                
            );
            
            
            if($this->input->post('alias'))
            {
                $data += array('alias' => sanitize_title_with_translit($this->input->post('alias', TRUE)));
            }
            else
            {
                $data += array('alias' => sanitize_title_with_translit($this->input->post('title', TRUE)));
            }

            $row->title = $data['title'];
        
            $row->text = $data['text'];
            $row->alias = $data['alias'];
           

            $success = $row->save();

            if (!$success)
            {
                $error = 'Ошибка сохранения.';
                if (!($row->valid))
                {
                    $error = $row->error->string;
                }
                $data = template_base_tags() + array(
                    'error' => $error,
                    'id' => $id,
                    'text' => $data['text'],
                    'title' => $data['title'],
                    'alias' => $data['alias'],
                    
                );
                $this->parser->parse($this->config->item('tplpath') . 'cms/modules_entry', $data);
            } else
                redirect('cms/modules/edit/' . $id);
        } elseif ($id == FALSE)
        {
            redirect('cms/modules');
        } else
        {

            // Редактируем запись.

            $row->get_by_id($id);

            $data = template_base_tags() + array(
                'error' => '',
                'id' => $id,
                'text' => $row->text,
                'title' => $row->title,
                'alias' => $row->alias,
                
            );
            $this->parser->parse($this->config->item('tplpath') . 'cms/modules_entry', $data);
        }
    }

    function delete()
    {
        if ($this->input->post('check'))
        {
            $check = $_POST['check'];
            if ($check)
            {
                foreach ($check as $c)
                {
                    $s = new Modules_orm();
                    $s->get_by_id($c);
                    $s->delete();
                }
                redirect('cms/modules');
            }
        } else
            redirect('cms/modules');
    }

}
