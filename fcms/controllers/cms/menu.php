<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Управление меню сайта.
 * @copyright (c) 2013, Denis Filonov
 */
class Menu extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_root();
    }

    function index($root = 10)
    {
        $visual = new Visual_elements();
        $cat = new Menu_orm();
        $cat->select_root($root);
        $cat->get_root();
        if (!$cat->exists())
        {
            $cat->new_root($root);
            $cat->save();
            $cat->get_root();
        }
        $data = template_base_tags() + array(
            'title' => 'Меню',
            'menu_title' => $cat->title,
            'root' => $root,
            'category_dropbox' => $visual->select_categoryes(array('id' => 1, 'name' => 'category', 'root' => CATEGORYES_CONTENT, 'by_lft' => FALSE, 'exclude' => -1)),
            'category_catalog_dropbox' => $visual->select_categoryes(array('id' => 1, 'name' => 'category_catalog', 'root' => CATEGORYES_CATALOG, 'by_lft' => FALSE, 'exclude' => -1)),
            'category_gallery_dropbox' => $visual->select_categoryes(array('id' => 1, 'name' => 'category_gallery', 'root' => CATEGORYES_GALLERY, 'by_lft' => FALSE, 'exclude' => -1)),
            'menu_dropbox' => $visual->select_menu(array('id' => 1, 'root' => $root, 'by_lft' => TRUE, 'exclude' => -1)),
            'select_page' => $visual->select_page()
        );


        if ($cat->exists())
            $data += array('tree' => $cat->dump_tree(array('title', 'id', 'lft', 'alias', 'content_type','content_id'), 'array', TRUE));
        else
            $data += array('tree' => array());
        $this->parser->parse($this->config->item('tplpath') . 'cms/menu', $data);
    }

    /**
     * Добавить пункт меню.
     */
    function add()
    {
        $pdata = $this->input->post(NULL, TRUE);
        $menu = new Menu_orm();
        $menu->select_root($pdata['root']);
        $menu->get_root();
        if (isset($pdata['menu']))
            $menu->get_node_where_left($pdata['menu']);
       
            
        $menu->new_last_child();
        $menu->title = $pdata['title'];
        $menu->content_type = $pdata['content_type'];
        switch ($pdata['content_type'])
        {
            case CONTENT_PAGE:
                $menu->content_id = $pdata['page'];
                break;
            case CONTENT_CATEGORY:
                $menu->content_id = $pdata['category'];
                break;
            case CONTENT_CATALOG:
                $menu->content_id = CONTENT_CATALOG;
                break;
            case CONTENT_CATALOG_CATEGORY:
                $menu->content_id = $pdata['category_catalog'];
                break;
            case CONTENT_GALLERY:
                $gcat = new Category();
                $gcat->get_root(CATEGORYES_GALLERY);
                $menu->content_id = $gcat->id;
                break;
            case CONTENT_GALLERY_CATEGORY:
                $menu->content_id = $pdata['category_gallery'];
                break;
            case CONTENT_LINK:
                $menu->content_id = CONTENT_LINK;
                $menu->alias = $pdata['link'];
                break;
            case CONTENT_LINK_INTERNAL:
                $menu->content_id = CONTENT_LINK_INTERNAL;
                $menu->alias = $pdata['link_internal'];
                break;
        }
        $success = $menu->save();
        $error = '';
        if (!$success)
        {
            $error = 'Ошибка сохранения.';
            if (!($menu->valid))
            {
                $error = $menu->error->string;
                die($error);
            }
        }
        redirect('cms/menu/' . $pdata['root']);
    }

    /**
     * Удаление пункта меню.
     */
    function delete()
    {
        $menu = new Menu_orm();
        $root = $this->input->post('root', TRUE);
        $menu->select_root($root);
        foreach ($_POST['item'] as $left)
        {
            $menu->get_node_where_left($left);
            $menu->remove_node();
        }
        redirect('cms/menu/');
    }

    function move()
    {
        if ($this->input->post())
        {
            $pdata = $this->input->post(NULL, TRUE);
            $menu = new Menu_orm();
            $menu->get_root($pdata['root']);
            $menu->get_node_where_left($pdata['lft']);
            $bro = new Menu_orm();
            $bro->get_root($pdata['root']);
            $bro->get_node_where_left($pdata['lft']);

            if ($pdata['direction'] == 'up')
            {
                $bro->get_previous_sibling();
                $menu->make_previous_sibling_of($bro);
            } elseif ($pdata['direction'] == 'down')
            {
                $bro->get_next_sibling();
                $menu->make_next_sibling_of($bro);
            }
        }
        redirect('cms/menu');
    }

}