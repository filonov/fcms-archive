<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Контроллер админки списка учителей для liberum-center.ru
 * @author Denis Filonov <denis@filonov.biz>
 * @copyright (c) 2013, Denis Filonov
 */
class Teachers extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_root();
    }

    function index()
    {
        $teachers = new Teacher();
        $teachers->order_by('order, title');
        $teachers->get();
        $data = template_base_tags() + array(
            'content' => $teachers->get()
        );
        $this->parser->parse($this->config->item('tplpath') . 'cms/teachers', $data);
    }

    /**
     * Добавление новой страницы.
     */
    function add()
    {
        $teacher = new Teacher();
        $teacher->skip_validation()->save();
        redirect('cms/teachers/edit/' . $teacher->id);
    }

    /**
     * Редактировать страницу.
     * @param integer $id
     */
    function edit($id = FALSE)
    {
        $teacher = new Teacher();
        $visual = new Visual_elements();
        $error = '';
        // Сохранение
        if ($this->input->post())
        {
            #REFACTOR Изменить загрузку на стандартную для php с генерацией preview
            $config['upload_path'] = $this->config->item('path_for_uploads') . 'teachers';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '900';
            $config['max_width'] = '800';
            $config['max_height'] = '800';

            $this->load->library('upload', $config);
            $result = array();
            if ($this->upload->do_upload('photo'))
                $result = $this->upload->data();
            #END REFACTOR
            $teacher->get_by_id($id);
            $teacher->title = $this->input->post('title', TRUE);
            $teacher->title_short = $this->input->post('title_short', TRUE);
            $teacher->order = (int) $this->input->post('order', TRUE);
            $teacher->language = $this->input->post('language', TRUE);
            $teacher->description = $this->input->post('description', TRUE);
            $teacher->gallery_id = $this->input->post('category', TRUE);
            if (isset($result['file_name']) && !empty($result['file_name']))
                $teacher->photo = $result['file_name'];
            $success = $teacher->save();
            if (!$success)
            {
                $error = 'Ошибка сохранения.';
                if (!($teacher->valid))
                {
                    $error = $teacher->error->string;
                }
                $data = template_base_tags() + array(
                    'error' => $error) + (array) $teacher->stored;

                $this->parser->parse($this->config->item('tplpath') . 'cms/teachers_entry', $data);
            }
            else
                redirect('cms/teachers/edit/' . $id);
        }
        else
        {
            // Редактирование
            $teacher->get_by_id($id);
            $data = template_base_tags() + array(
                'error' => $error,
                'cat_drop' => $visual->select_categoryes(array('id' => $teacher->gallery_id, 'name' => 'category', 'root' => CATEGORYES_GALLERY, 'by_lft' => FALSE, 'exclude' => -1)),
                    ) + (array) $teacher->stored;
            $this->parser->parse($this->config->item('tplpath') . 'cms/teachers_entry', $data);
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
                    $l = new Teacher();
                    $l->get_by_id($c);
                    $l->delete();
                }
                redirect('cms/teachers');
            }
        }
        else
            redirect('cms/teachers');
    }

    function edit_order()
    {
        $data = array();
        if ($this->input->post('order') && $this->input->post('id'))
        {
            $id = (int) $this->input->post('id', TRUE);
            $order = (int) $this->input->post('order', TRUE);
            $teacher = new Teacher();
            $teacher->get_by_id($id);
            $teacher->order = $order;
            $teacher->save();
            $data += array(
                'order' => $teacher->order
            );
        }
        echo json_encode($data);
    }

}
