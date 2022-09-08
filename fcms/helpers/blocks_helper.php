<?php

if (!defined('BASEPATH'))
    exit('Нет доступа к скрипту');

function block_catalog_categoryes($ul_attributes = '', $active_id = 0, $show_image = FALSE, $li_attributes = '')
{
    $CI = &get_instance();
    $root = CATEGORYES_CATALOG;
    $cat = new Category();
    $cat->select_root($root);
    $cat->get_root();

    if ($cat->has_children())
    {
	$m_array = $cat->dump_tree(array('title', 'id', 'lft', 'alias', 'image'), 'array', TRUE);
	$current_depth = 0;
	$counter = 0;
	$result = '<ul ' . $ul_attributes . '>';
	foreach ($m_array as $node)
	{
	    $node_depth = $node['__level'];
	    if ($node_depth == $current_depth)
	    {
		if ($counter > 0)
		    $result .= '</li>' . "\n";
	    }
	    elseif ($node_depth > $current_depth)
	    {
		$result .= '<ul>';
		$current_depth = $current_depth + ($node_depth - $current_depth);
	    } elseif ($node_depth < $current_depth)
	    {
		$result .= str_repeat('</li></ul>', $current_depth - $node_depth) . '</li>';
		$current_depth = $current_depth - ($current_depth - $node_depth);
	    }
	    $active_attr = ''; // Активный аттрибут
	    if ($node['id'] == $active_id)
		$active_attr = 'class="current"';
	    {
		$c_cat = new Category();
		$c_cat->select_root(CATEGORYES_CATALOG);
		$c_cat->get_by_id($node['id']);
		if ($c_cat->exists())
		{
		    $img = '';
		    if ($show_image and !empty($c_cat->image))
			$img = '<img src="' . $CI->config->item('url_for_uploads') . 'thumbnails/' . $c_cat->image . '" alt="' . $c_cat->title . '"/>';
		    $result.= '<li ' . $li_attributes . '>' . anchor(base_url('catalog/'  . $c_cat->get_alias_path(CATEGORYES_CATALOG)),$img. $node['title'], $active_attr);
		}
	    }
	    ++$counter;
	}
	$result .= str_repeat('</li></ul>', $node_depth) . '</li>';
	$result .= '</ul>';
    } else
    {
	$result = '';
    }
    return $result;
}

function block_menu($ul_attributes = 'id="menu" class="nav"', $active_id = 0)
{
    $root = 10;
    $page = new Pages_orm();
    $cat = new Menu_orm();
    $cat->select_root($root);
    $cat->get_root();

    if ($cat->has_children())
    {

	$m_array = $cat->dump_tree(array('title', 'id', 'lft', 'alias', 'content_type', 'content_id'), 'array', TRUE);

	$current_depth = 0;
	$counter = 0;
	$result = '<ul ' . $ul_attributes . '>';
	foreach ($m_array as $node)
	{
	    $node_depth = $node['__level'];
	    if ($node_depth == $current_depth)
	    {
		if ($counter > 0)
		    $result .= '</li>' . "\n";
	    }
	    elseif ($node_depth > $current_depth)
	    {
		$result .= '<ul>';
		$current_depth = $current_depth + ($node_depth - $current_depth);
	    } elseif ($node_depth < $current_depth)
	    {
		$result .= str_repeat('</li></ul>', $current_depth - $node_depth) . '</li>';
		$current_depth = $current_depth - ($current_depth - $node_depth);
	    }
	    $active_attr = ''; // Активный аттрибут
	    if ($node['id'] == $active_id)
		$active_attr = 'class="current"';
	    switch ($node['content_type'])
	    {
		case CONTENT_PAGE:

		    $page->get_by_id($node['content_id']);
		    $result.= '<li>' . anchor(base_url($page->alias), $node['title'], $active_attr);
		    break;
		case CONTENT_CATEGORY:
		    $categ = new Category();
		    $categ->select_root(CATEGORYES_CONTENT);
		    $categ->get_by_id($node['content_id']);
		    if ($categ->exists())
			$result.= '<li>' . anchor(base_url('content/' . $categ->get_alias_path(CATEGORYES_CONTENT)), $node['title'], $active_attr);
		    break;
		case CONTENT_CATALOG:
		    $result.= '<li>' . anchor(base_url('catalog/'), $node['title']);
		    break;
		case CONTENT_CATALOG_CATEGORY:
		    $c_cat = new Category();
		    $c_cat->select_root(CATEGORYES_CATALOG);
		    $c_cat->get_by_id($node['content_id']);
		    if ($c_cat->exists())
			$result.= '<li>' . anchor(base_url('catalog/' . $c_cat->get_alias_path(CATEGORYES_CATALOG)), $node['title'], $active_attr);
		    break;
		case CONTENT_GALLERY:
		    $result.= '<li>' . anchor(base_url('gallery/'), $node['title'], $active_attr);
		    break;
		case CONTENT_GALLERY_CATEGORY:
		    $g_cat = new Category();
		    $g_cat->select_root(CATEGORYES_GALLERY);
		    $g_cat->get_by_id($node['content_id']);
		    if ($g_cat->exists())
			$result.= '<li>' . anchor(base_url('gallery/' . $g_cat->get_alias_path(CATEGORYES_GALLERY)), $node['title'], $active_attr);
		    break;
		case CONTENT_LINK:
		    $result.= '<li>' . anchor($node['alias'], $node['title']);
		    break;
		case CONTENT_LINK_INTERNAL:
		    $result.= '<li>' . anchor(base_url($node['alias']), $node['title']);
		    break;
	    }
	    ++$counter;
	}
	$result .= str_repeat('</li></ul>', $node_depth) . '</li>';

	$result .= '</ul>';
    }
    else
    {
	$result = '';
    }
    return $result;
}

/**
 * Выводит в блоке содержимое страницы.
 * @param string $id_page
 */
function block_page_content($id_page, $template = 'block_page_content')
{
    $CI = &get_instance();
    $res = new Pages_orm($id_page);
    $data = template_base_tags() +
	    array(
		'id' => $res->id,
		'alias' => $res->alias,
		'thumbnail' => $res->thumbnail,
		'title' => $res->title,
		'text' => $res->text
    );
    return $CI->load->view($CI->config->item('tplpath') . $CI->config->item('skin') . '/' . $template, $data, TRUE);
}

/**
 * Выводит содержимое модуля $alias
 * @param type $alias
 * @param type $template
 * @return type 
 */
function block_module($alias, $template = 'block_module')
{
    $CI = &get_instance();
    $module = new Modules_orm();
    $module->get_by_alias($alias);
    $data = template_base_tags() +
	    array(
		'id' => $module->id,
		'alias' => $module->alias,
		'title' => $module->title,
		'text' => $module->text
    );
    return $CI->load->view($CI->config->item('tplpath') . $CI->config->item('skin') . '/' . $template, $data, TRUE);
}

/**
 * Отображение ленты контента по категории.
 * @copyright (c) 2013, Denis Filonov
 * @param integer $category
 * @param integer $number
 * @param string $template
 * @return string
 */
function block_content($category = 0, $number = 1, $template = 'block_content')
{
    $CI = &get_instance();
    $cat = new Category();
    $cat->select_root(CATEGORYES_CONTENT);
    $cat->get_by_id($category);
    $content = new Content_orm();
    $content->limit($number);
    if ($cat->exists())
    {
	$path = $cat->get_tree_full_path($category);
	$content->get_by_category($category);
    } else
    {
	$content->get();
    }
    $data = template_base_tags() +
	    array(
		'content' => empty($content) ? array() : $content,
		'path' => empty($path) ? '' : $path,
		'uri' => empty($path) ? '' : $path
    );
    return $CI->load->view($CI->config->item('tplpath') . $CI->config->item('skin') . '/' . $template, $data, TRUE);
}

function block_reviews($template = 'block_reviews')
{
    $CI = &get_instance();
    $rew = new Items_review();
    $rew->where('show', TRUE)->order_by('created', 'DESC')->get(4);

    $data = template_base_tags() +
	    array(
		'reviews' => empty($rew) ? array() : $rew,
    );
    return $CI->load->view($CI->config->item('tplpath') . $CI->config->item('skin') . '/' . $template, $data, TRUE);
}

/**
 * Отображение ленты контента по категориям. Можно использовать несколько категорий.
 * @copyright (c) 2013, Denis Filonov
 * @param integer $category
 * @param integer $number
 * @param string $template
 * @return string
 */
function block_content_showcase($template = 'block_content_showcase')
{
    $CI = &get_instance();
    $cat = new Category();
    $cat->select_root(CATEGORYES_CONTENT);
    $cat->get();

    $content = new Content_orm();
    $content->order_by('showcase_order, created, id')->get_by_show_in_showcase(TRUE);

    $data = template_base_tags() +
	    array(
		'content' => empty($content) ? array() : $content,
		'category' => $cat,
    );
    return $CI->load->view($CI->config->item('tplpath') . $CI->config->item('skin') . '/' . $template, $data, TRUE);
}

/**
 * Отображает галереи. Все.
 * @param type $template
 * @return type
 */
function block_gallery($template = 'block_gallery')
{
    $CI = &get_instance();
    $vis = new Visual_elements();
    $category = new Category();
    $category->select_root(CATEGORYES_GALLERY);
    $category->get_root();
    $data = template_base_tags() +
	    array(
		'items' => $category->get_all_childs()
    );

    return $CI->load->view($CI->config->item('tplpath') . $CI->config->item('skin') . '/' . $template, $data, TRUE);
}

/**
 * Отображает галереи. Одну.
 * @param type $template
 * @return type
 */
function block_gallery_category($id, $template = 'block_gallery_category')
{
    $CI = &get_instance();

    $images = new Image();
    $images->get_by_category_id($id);
    $data = template_base_tags() +
	    array(
		'items' => $images
    );

    return $CI->load->view($CI->config->item('tplpath') . $CI->config->item('skin') . '/' . $template, $data, TRUE);
}