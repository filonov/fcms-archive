<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Контроллер вывода Галерей.
 *
 * @author Denis Filonov <denis@filonov.biz>
 * @copyright (c) 2013, Denis Filonov.
 */
class Gallery extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $vis = new Visual_elements();
        $category = new Category();
        $parent_category = new Category();
        $category->select_root(CATEGORYES_GALLERY);
        $gallery = new Image();
        $data = $this->uri->segment_array();
        $uri_string = $this->uri->uri_string();

        // Для паджинации
        $countstop = count($data);
        $page = 1;
        $url_seg = '';
        if ((int) $data[count($data)] > 0)
        {
            $countstop = count($data) - 1;
            $page = $data[count($data)];
            // Формируем URL
            for ($i = 1; $i < (count($data)); $i++)
            {
                $url_seg .= $data[$i] . '/';
            }
        } else
        {
            for ($i = 1; $i <= (count($data)); $i++)
            {
                $url_seg .= $data[$i] . '/';
            }
        }

        for ($i = 2; $i <= $countstop; $i++)
        {
            $category->get_by_alias($data[$i]);
            if ($category->exists())
            { // Если категория существует   
                $parent_category->get_parent($category);
                if (($parent_category->alias == $data[$i - 1]) || ($data[$i - 1] == 'gallery'))
                {
                    if ($i == $countstop)
                    {
                        $menu = new Menu_orm();
                        if ($data[$i - 1] == 'gallery')
                        {
                            $menu->get_where(array('content_type' => CONTENT_GALLERY), 1);
                        } else
                        {
                            $menu->get_where(array('content_type' => CONTENT_GALLERY_CATEGORY, 'content_id' => $category->id), 1);
                        }
                        $data = template_base_tags() + array(
                            'meta_title' => $category->title,
                            'meta_keywords' => $category->title,
                            'meta_description' => $category->title,
                            'uri' => $uri_string,
                            'category' => $category->title,
                            'description' => $category->description,
                            'child_categoryes' => $category->get_all_childs(),
                            'gallery' => $gallery->where('category_id', $category->id)->get(),
                            'active_menu_id' => $menu->id,
                            'paginator' => $vis->paginator(
                                    base_url($url_seg), $gallery->where('category_id', $category->id)->count(), $countstop + 1, $this->config->item('per_page')
                            )
                        );
                        if (isset($category->template) && !empty($category->template))
                        {
                            $filename = FCPATH . 'templates/' . $this->config->item('skin') . '/' . $category->template . '.php';
                            if (file_exists($filename))
                                $this->parser->parse($this->config->item('skin_html_path') . '/' . $category->template, template_base_tags() + $data);
                            else
                                show_404();
                        }
                        else
                            $this->parser->parse($this->config->item('skin_html_path') . '/' . 'gallery', template_base_tags() + $data);
                        break;
                    }
                } else
                {
                    show_404();
                    break;
                }
            } else
            { // Если не существует, то перейти к показу материала и прервать цикл, а там уже обработать 404
                // Проверить на паджинацию
                show_404();
                break;
            }
        }
        if (count($data) == 1)
        {
            $category->get_root();
            $gallery->where('category_id', $category->id);
            $gallery->get_paged(1, $this->config->item('per_page'));
            $menu = new Menu_orm();
            if ($data[$i - 1] == 'gallery')
            {
                $menu->get_where(array('content_type' => CONTENT_GALLERY), 1);
                //debug_print($category->id);
            } else
            {
                $menu->get_where(array('content_type' => CONTENT_GALLERY), 1);
                //$menu->get_where(array('content_type' => CONTENT_GALLERY_CATEGORY, 'content_id' => $category->id), 1);
            }
            $data = template_base_tags() + array(
                'meta_title' => $category->title,
                'meta_keywords' => $category->title,
                'meta_description' => $category->title,
                'uri' => $uri_string,
                'category' => $category->title,
                'description' => $category->description,
                'child_categoryes' => $category->get_all_childs(),
                'gallery' => $gallery,
                'active_menu_id' => $menu->id,
                'paginator' => $vis->paginator($this->uri->uri_string(), $gallery->count(), $this->uri->total_segments(), $this->config->item('per_page'))
            );
            #REFACTOR Дублирующийся код.
            if (isset($category->template) && !empty($category->template))
            {
                $filename = FCPATH . 'templates/' . $this->config->item('skin') . '/' . $category->template . '.php';
                if (file_exists($filename))
                    $this->parser->parse($this->config->item('skin_html_path') . '/' . $category->template, template_base_tags() + $data);
                else
                    show_404();
            }
            else
                $this->parser->parse($this->config->item('skin_html_path') . '/' . 'gallery', template_base_tags() + $data);
        }
    }

}
