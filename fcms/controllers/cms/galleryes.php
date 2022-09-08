<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Контроллер галерей.
 *
 * @author Denis V. Filonov
 * @copyright 2013, Denis V. Filonov
 */
class Galleryes extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_root();
    }

    private function upload_pictures($category_id = 0)
    {
        if (isset($_FILES['pictures']))
        {
            $this->load->library('image_lib');
            $gallery = new Image();
            // Создание каталога для картинок.
            $gallerypath = $this->config->item('path_for_uploads') . 'gallery/' . $category_id . '/';
            @mkdir($gallerypath, 0777, TRUE);
            @mkdir($gallerypath . 'b', 0777, TRUE);
            @mkdir($gallerypath . 's', 0777, TRUE);
            foreach ($_FILES["pictures"]["error"] as $key => $error)
            {
                if ($error == UPLOAD_ERR_OK)
                {
                    if (move_uploaded_file($_FILES["pictures"]["tmp_name"][$key], $gallerypath . $_FILES["pictures"]["name"][$key]))
                    {
                        $config['image_library'] = 'gd2';
                        $config['maintain_ratio'] = TRUE;
                        $config['master_dim'] = 'width';
                        $config['source_image'] = $gallerypath . $_FILES["pictures"]['name'][$key];

                        // Создание большого превью      
                        $config['new_image'] = $gallerypath . 'b/' . $_FILES["pictures"]['name'][$key];
                        $config['width'] = $this->config->item('gallery_tmb_big');
                        $config['height'] = $this->config->item('gallery_tmb_big');
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();

                        // Создание малого превью
                        $config['new_image'] = $gallerypath . 's/' . $_FILES["pictures"]['name'][$key];
                        $config['width'] = $this->config->item('gallery_tmb_small');
                        $config['height'] = $this->config->item('gallery_tmb_small');
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();

                        // Добавление имени картинки в базу
                        $gallery->filename = $_FILES["pictures"]['name'][$key];
                        $gallery->category_id = $category_id;
                        $gallery->save_as_new();
                    }
                }
            }
        }
    }

    function index($category = 'all', $page = '1')
    {
        $visual = new Visual_elements();
        $gallery = new Image();
        $activated_category = NULL;
        $category_name = '';
        $count = 0;

        if (!empty($category) && ($category != 'all'))
        {
            $cat = new Category();
            $cat->get_by_alias($category);
            $count = $gallery->where('category_id', $cat->id)->count();
            $gallery->where('category_id', $cat->id);

            $activated_category = $cat->id;
            $category_name = $cat->title;
            $this->upload_pictures($cat->id);
        } else
        {
            $count = $gallery->count();
            $activated_category = NULL;
            $this->upload_pictures();
        }
        // Загрузка изображений
        $data = template_base_tags() + array(
            'category_name' => $category_name,
            'cat_drop' => $visual->select_categoryes(array('id' => $activated_category, 'name' => 'category', 'root' => CATEGORYES_GALLERY, 'by_lft' => FALSE, 'exclude' => -1)),
            'cattree' => $visual->category_ul(array('root' => CATEGORYES_GALLERY, 'baseurl' => 'cms/galleryes/', 'activated' => $activated_category)),
            'content' => $gallery->get_paged($page, 24),
            'paginator' => $visual->paginator(base_url('cms/galleryes/' . $category . '/'), $count, 4, 24)
        );
        $this->parser->parse($this->config->item('tplpath') . '/cms/galleryes', $data);
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
                    $pic = new Image();
                    $pic->get_by_id($c);
                    $gallerypath = $this->config->item('path_for_uploads') . 'gallery/' . $pic->category_id . '/';
                    //debug_print($gallerypath);
                    if (!empty($pic->filename))
                    {
                        if (file_exists($gallerypath . $pic->filename))
                        {
                            @unlink($gallerypath . $pic->filename);
                            @unlink($gallerypath . '/s/' . $pic->filename);
                            @unlink($gallerypath . '/b/' . $pic->filename);
                        }
                        $pic->delete();
                    }
                }
            }
        }
        if ($this->input->post('desc'))
        {
            $desc = $_POST['desc'];

            $pic = new Image();

            foreach ($desc as $key => $d)
            {
                $pic->get_by_id($key);
                $pic->description = $d;
                $pic->save();
            }
        }
        redirect('cms/galleryes');
    }

    function move()
    {
        if ($this->input->post('check'))
        {
            $new_category = $this->input->post('category', TRUE);
            // Создание каталога для картинок.
            $new_gallerypath = $this->config->item('path_for_uploads') . 'gallery/' . $new_category . '/';
            @mkdir($new_gallerypath, 0777, TRUE);
            @mkdir($new_gallerypath . 'b', 0777, TRUE);
            @mkdir($new_gallerypath . 's', 0777, TRUE);

            $check = $_POST['check'];
            if ($check)
            {
                foreach ($check as $c)
                {
                    $pic = new Image();
                    $pic->get_by_id($c);
                    $gallerypath = $this->config->item('path_for_uploads') . 'gallery/' . $pic->category_id . '/';
                    if (!empty($pic->filename))
                    {
                        if (file_exists($gallerypath . $pic->filename))
                        {
                            @rename($gallerypath . $pic->filename, $new_gallerypath . $pic->filename);
                            @rename($gallerypath . '/s/' . $pic->filename, $new_gallerypath . '/s/' . $pic->filename);
                            @rename($gallerypath . '/b/' . $pic->filename, $new_gallerypath . '/b/' . $pic->filename);
                        }
                        $pic->category_id = $new_category;
                        $pic->save();
                    }
                }
                redirect('cms/galleryes');
            }
        }
        else
            redirect('cms/galleryes');
    }

}
