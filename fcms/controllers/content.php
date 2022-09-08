<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Контроллер вывода контента.
 *
 * @author Denis Filonov <denis@filonov.biz>
 * @copyright (c) 2013, Denis Filonov.
 */
class Content extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    private function child_c_categoryes($root, $category_id)
    {
        $cat = new Category();
        $parent = new Category();
        $cat->select_root($root);
        $cat->get_by_id($category_id);
        $ids = array();
        $parent = $cat;
        $cat->get_first_child();
        $ids[] = $cat->id;
        while ($cat->is_child($parent))
        {
            if ($cat->get_next_sibling()->exists())
                $ids[] = $cat->id;
        }
        $res = $cat->where_in('id', $ids)->order_by('lft')->get_iterated();
        return $res;
    }

    function index()
    {
        $vis = new Visual_elements();
        $category = new Category();
        $parent_category = new Category();
        $category->select_root(CATEGORYES_CONTENT);
        $content = new Content_orm();
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
                if (($parent_category->alias == $data[$i - 1]) || ($data[$i - 1] == 'content'))
                {
                    if ($i == $countstop)
                    {
                        $menu = new Menu_orm();
                        $menu->get_where(array('content_type' => CONTENT_CATEGORY, 'content_id' => $category->id), 1);
                        $data = template_base_tags() + array(
                            'meta_title' => $category->title,
                            'meta_keywords' => $category->title,
                            'meta_description' => $category->title,
                            'uri' => $uri_string,
                            'category' => $category,
                            'child_categoryes' => $this->child_c_categoryes(CATEGORYES_CONTENT, $category->id),
                            'content' => $content->where('category', $category->id)->get_paged($page, $this->config->item('per_page')),
                            'paginator' => $vis->paginator(
                                    base_url($url_seg), $content->where('category', $category->id)->count(), $countstop + 1, $this->config->item('per_page'), '<nav class="pagination"><ul>', '</ul></nav>'),
                            'active_menu_id' => $menu->id
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
                            $this->parser->parse($this->config->item('skin_html_path') . '/' . 'content', template_base_tags() + $data);

                        break;
                    }
                } else
                {
                    $this->show_content($data);
                    break;
                }
            } else
            { // Если не существует, то перейти к показу материала и прервать цикл, а там уже обработать 404
                // Проверить на паджинацию
                $this->show_content($data);
                break;
            }
        }
        if (count($data) == 1)
        {

            $category->get_root();
            $content->where('category', $category->id);
            $content->get_paged(1, $this->config->item('per_page'));
            // Определение активного пункта меню
            $menu = new Menu_orm();
            $menu->get_where(array('content_type' => CONTENT_CATEGORY, 'content_id' => $category->id), 1);
            $data = template_base_tags() + array(
                'meta_title' => $category->title,
                'meta_keywords' => $category->title,
                'meta_description' => $category->title,
                'uri' => $uri_string,
                'content' => $content,
                'category' => $category,
                'child_categoryes' => $this->child_c_categoryes(CATEGORYES_CONTENT, $category->id),
                'active_menu_id' => $menu->id,
                'paginator' => $vis->paginator($this->uri->uri_string(), $content->count(), $this->uri->total_segments(), $this->config->item('per_page'), '<nav class="pagination"><ul>', '</ul></nav>')
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
                $this->parser->parse($this->config->item('skin_html_path') . '/' . 'content', template_base_tags() + $data);
        }
    }

    private function show_content(array $data)
    {
        $content = new Content_orm();
        $content->get_by_alias(array_pop($data));

        // Формируем URL
        $url_seg = '';
        for ($i = 2; $i < count($data); $i++)
        {
            $url_seg .= '/' . $data[$i];
        }

        if ($content->exists())
        {
            $category = new Category($content->category);
            $menu = new Menu_orm();
            $menu->get_where(array('content_type' => CONTENT_CATEGORY, 'content_id' => $category->id), 1);
            $data = template_base_tags() + array(
                'meta_title' => !empty($content->meta_title) ? $content->meta_title : $this->config->item('site_title'),
                'meta_keywords' => $content->meta_keywords,
                'meta_description' => $content->meta_description,
                'item' => $content,
                'category' => $category,
                'active_menu_id' => $menu->id
            );
            $this->parser->parse($this->config->item('tplpath') . $this->config->item('skin') . '/content_item', $data);
        } else
        {
            show_404();
        }
    }

}
