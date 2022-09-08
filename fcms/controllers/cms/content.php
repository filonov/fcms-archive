<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Администрирование контента
 * @author Denis Filonov <denis@filonov.biz>
 */
class Content extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_root();
    }

    /**
     * Список статей.
     * @param string $category 
     */
    function index($category = 'all', $page = 1)
    {
        $pages = new Content_orm();
        $visual = new Visual_elements();

        if (!empty($category) && ($category != 'all'))
        {
            $cat = new Category();
            $cat->get_by_alias($category);

            $data = template_base_tags() + array(
                'category_name' => $cat->title,
                'cattree' => $visual->category_ul(array('root' => CATEGORYES_CONTENT, 'baseurl' => 'cms/content/', 'activated' => $cat->id)), //$visual->list_categoryes($cat->id), //$this->list_categoryes($cat->id),
                'pages' => $pages->where(array('category' => $cat->id))->get_paged($page, 50),
                'paginator' => $visual->paginator(base_url('cms/content/' . $category . '/'), $pages->where(array('category' => $cat->id))->count(), 4, 50)
            );
        } else
        {
            $cat = new Category();
            $cat->get_by_alias($category);
            $data = template_base_tags() + array(
                'category_name' => $cat->title,
                'cattree' => $visual->category_ul(array('root' => CATEGORYES_CONTENT, 'baseurl' => 'cms/content/', 'activated' => NULL)),
                'pages' => $pages->get_paged($page, 50),
                'paginator' => $visual->paginator(base_url('cms/content/' . $category . '/'), $pages->count(), 4, 50)
            );
        }
        $this->parser->parse($this->config->item('tplpath') . '/cms/content', $data);
    }

    private function upload_thumbnail($id = 0)
    {

        if (isset($_FILES['thumbnail']))
        {
            $this->load->library('image_lib');
            $post = new Content_orm($id);
            // Создание каталога для картинок.
            $gallerypath = $this->config->item('path_for_uploads') . 'thumbnails/';
            @mkdir($gallerypath, 0777, TRUE);
            $uploadext = strtolower(strrchr($_FILES["thumbnail"]["name"], "."));

            //debug_print($gallerypath . $id . $uploadext);
            #REFACTOR Удалить, если существует
            if (file_exists($gallerypath . $id . $uploadext))
                @unlink($gallerypath . $id . $uploadext);

            if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $gallerypath . $id . $uploadext))
            {
                $config['image_library'] = 'gd2';
                $config['maintain_ratio'] = TRUE;
                $config['master_dim'] = 'width';
                $config['source_image'] = $gallerypath . $id . $uploadext;

                // Изменение размера    
                $config['new_image'] = $gallerypath . $id . $uploadext;
                $config['width'] = $this->config->item('content_tmb');
                $config['height'] = $this->config->item('content_tmb');
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                // Добавление имени картинки в базу
                $post->thumbnail = $id . $uploadext;
                $post->skip_validation()->save();
            }
        }
    }

    /**
     * Добавление новой статьи.
     * 
     */
    function add()
    {
        $visual = new Visual_elements();
        $row = new Content_orm();

        // Сохранение
        if ($this->input->post())
        {
            $this->load->helper('translit');
            $row->title = $this->input->post('title', TRUE);
            $row->alias = sanitize_title_with_translit($row->title);
            $row->text = $this->input->post('text', FALSE);
            $row->alias = sanitize_title_with_translit($row->title);
            $row->meta_title = $this->input->post('meta_title', TRUE);
            $row->meta_keywords = $this->input->post('meta_keywords', TRUE);
            $row->meta_description = $this->input->post('meta_description', TRUE);
            $row->template = $this->input->post('template', TRUE);
            $row->category = $this->input->post('category', TRUE);
            $show_in_showcase = FALSE;
            if ($this->input->post('show_in_showcase'))
                $show_in_showcase = TRUE;
            $row->show_in_showcase = $show_in_showcase;

            $success = $row->save();

            if (!$success)
            {
                // Если ошибка, то снова показать форму.
                $error = 'Ошибка сохранения.';
                if (!($row->valid))
                {
                    $error = $row->error->string;
                }
                $data = template_base_tags() + array(
                    'error' => $error,
                    'id' => -1,
                    'item' => $row,
                    'method_path' => base_url('cms/content/add'),
                    'category' => $visual->select_categoryes(array('id' => 0, 'name' => 'category', 'root' => CATEGORYES_CONTENT, 'by_lft' => FALSE, 'exclude' => -1))
                );
                $this->parser->parse($this->config->item('tplpath') . 'cms/content_entry', $data);
            } else
            {
                // Если всё в порядке, то перейти к редактированию.
                $id = $row->id;
                $this->upload_thumbnail($id);
                redirect('cms/content/edit/' . $id);
            }
        } else
        {
            $data = template_base_tags() + array(
                'error' => '',
                'id' => -1,
                'item' => $row,
                'method_path' => base_url('cms/content/add'),
                'category' => $visual->select_categoryes(array('id' => 0, 'name' => 'category', 'root' => CATEGORYES_CONTENT, 'by_lft' => FALSE, 'exclude' => -1))
            );
            $this->parser->parse($this->config->item('tplpath') . 'cms/content_entry', $data);
        }
    }

    /**
     * Редактировать статью.
     * @param integer $id
     */
    function edit($id = FALSE)
    {
        $visual = new Visual_elements();
        $row = new Content_orm();

        // Сохранение
        if ($this->input->post('eid'))
        {
            $row->get_by_id($id);
            $title = $this->input->post('title', TRUE);
            $this->load->helper('translit');

            $row->title = $this->input->post('title', TRUE);
            $row->text = $this->input->post('text', FALSE);
            $row->alias = sanitize_title_with_translit($title);
            $row->meta_title = $this->input->post('meta_title', TRUE);
            $row->meta_keywords = $this->input->post('meta_keywords', TRUE);
            $row->meta_description = $this->input->post('meta_description', TRUE);
            $row->template = $this->input->post('template', TRUE);
            $row->category = $this->input->post('category', TRUE);
            $show_in_showcase = FALSE;
            if ($this->input->post('show_in_showcase'))
                $show_in_showcase = TRUE;
            $row->show_in_showcase = $show_in_showcase;

            $success = $row->save();

            if (!$success)
            {
                $error = 'Ошибка сохранения.';
                if (!($row->valid))
                {
                    $error = $row->error->string;
                }
                $data = template_base_tags() + array(
                    'error' => '',
                    'id' => $id,
                    'item' => $row,
                    'method_path' => base_url('cms/content/edit/' . $id),
                    'category' => $visual->select_categoryes(array('id' => $row->category, 'name' => 'category', 'root' => CATEGORYES_CONTENT, 'by_lft' => FALSE, 'exclude' => -1))
                );
                $this->parser->parse($this->config->item('tplpath') . 'cms/content_entry', $data);
            } else
            {
                $this->upload_thumbnail($id);
                redirect('cms/content/edit/' . $id);
            }
        } elseif ($id == FALSE)
        {
            redirect('cms/content');
        } else
        {

            // Редактируем запись.

            $row->get_by_id($id);

            $data = template_base_tags() + array(
                'error' => '',
                'id' => $id,
                'item' => $row,
                'method_path' => base_url('cms/content/edit/' . $id),
                'category' => $visual->select_categoryes(array('id' => $row->category, 'name' => 'category', 'root' => CATEGORYES_CONTENT, 'by_lft' => FALSE, 'exclude' => -1))
            );
            $this->parser->parse($this->config->item('tplpath') . 'cms/content_entry', $data);
        }
    }

    /**
     * Удалить статью.
     */
    function delete()
    {
        if ($this->input->post('check'))
        {
            $check = $_POST['check'];
            if ($check)
            {
                foreach ($check as $c)
                {
                    $s = new Content_orm();
                    $s->get_by_id($c);
                    $s->delete();
                }
                redirect('cms/content');
            }
        }
        else
            redirect('cms/content');
    }

}
