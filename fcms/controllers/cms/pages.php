<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Администрирование статических страниц.
 * @copyright (c) 2013, Denis Filonov.
 */
class Pages extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_root();
    }

    private function upload_thumbnail($id = 0)
    {

        if (isset($_FILES['thumbnail']))
        {
            $this->load->library('image_lib');
            $post = new Pages_orm($id);
            // Создание каталога для картинок.
            $gallerypath = $this->config->item('path_for_uploads') . 'thumbnails/';
            @mkdir($gallerypath, 0777, TRUE);
            $uploadext = strtolower(strrchr($_FILES["thumbnail"]["name"], "."));

            //debug_print($gallerypath . $id . $uploadext);

            if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $gallerypath .'p' .$id . $uploadext))
            {
                $config['image_library'] = 'gd2';
                $config['maintain_ratio'] = TRUE;
                $config['master_dim'] = 'width';
                $config['source_image'] = $gallerypath .'p'. $id . $uploadext;

                // Изменение размера    
                $config['new_image'] = $gallerypath . 'p'.$id . $uploadext;
                $config['width'] = $this->config->item('content_tmb');
                $config['height'] = $this->config->item('content_tmb');
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                // Добавление имени картинки в базу
                $post->thumbnail ='p'.$id . $uploadext;
                $post->skip_validation()->save();
            }
        }
    }

    /**
     * Таблица событий
     * @param string $category 
     */
    function index($category = '')
    {
        //$visual = new Visual_elements();

        $pages = new Pages_orm();
        $pages->order_by('title, id');


        $data = template_base_tags() + array(
            'pages' => $pages->get()
        );

        $this->parser->parse($this->config->item('tplpath') . 'cms/pages', $data);
    }

    /**
     * Добавление новой страницы.
     */
    function add()
    {
        $s = new Pages_orm();
        $s->title = 'Untitled';
        $s->text = '';
        $s->alias = 'untitled';
        $s->skip_validation()->save();
        redirect('cms/pages/edit/' . $s->id);
    }

    /**
     * Редактировать страницу.
     * @param integer $id
     */
    function edit($id = FALSE)
    {

        $row = new Pages_orm();

        // Сохранение
        if ($this->input->post('eid'))
        {
            $row->get_by_id($id);
            $title = $this->input->post('title', TRUE);
            $this->load->helper('translit');
            $data = array(
                'title' => $title,
                'text' => $this->input->post('text', FALSE),
                'meta_title' => $this->input->post('meta_title', TRUE),
                'meta_keywords' => $this->input->post('meta_keywords', TRUE),
                'meta_description' => $this->input->post('meta_description', TRUE),
                'template' => $this->input->post('template', TRUE),
                'alias' => sanitize_title_with_translit($title)
            );

            $row->title = $data['title'];

            $row->text = $data['text'];
            $row->alias = $data['alias'];
            $row->meta_title = $data['meta_title'];
            $row->meta_keywords = $data['meta_keywords'];
            $row->meta_description = $data['meta_description'];
            $row->template = $data['template'];

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
                    'thumbnail' => $data['thumbnail'],
                    'meta_title' => $data['meta_title'],
                    'meta_keywords' => $data['meta_keywords'],
                    'meta_description' => $data['meta_description'],
                    'template' => $data['template']
                );
                $this->parser->parse($this->config->item('tplpath') . 'cms/pages_entry', $data);
            }
            else
            {
                $this->upload_thumbnail($id);
                redirect('cms/pages/edit/' . $id);
            }
        } elseif ($id == FALSE)
        {
            redirect('cms/pages');
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
                'thumbnail' => $row->thumbnail,
                'meta_title' => $row->meta_title,
                'meta_keywords' => $row->meta_keywords,
                'meta_description' => $row->meta_description,
                'template' => $row->template
            );
            $this->parser->parse($this->config->item('tplpath') . 'cms/pages_entry', $data);
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
                    $s = new Pages_orm();
                    $s->get_by_id($c);
                    @unlink($this->config->item('path_for_uploads') . 'thumbnails/'.$s->thumbnail);
                    $s->delete();
                }
                redirect('cms/pages');
            }
        }
        else
            redirect('cms/pages');
    }

}
