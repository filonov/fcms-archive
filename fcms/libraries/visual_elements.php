<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Вспомогательная библиотека для отображения визуальных элементов.
 * @author Denis Filonov <denis@dilonov.biz>
 * @copyright (c) 2013, Denis Filonov
 */
class Visual_elements
{

    /**
     * Выводит категории в виде листа. Старая функция, #REFACTOR
     * @param integer $activated
     * @return string
     */
    public function list_categoryes($activated = 0, $for_cms = TRUE)
    {

	$c = new Category();
	$c->select_root(CATEGORYES_CONTENT);
	$c->get_root();
	$tree = "\n";
	if ($c->exists())
	{
	    $children = $c->dump_tree(array('title', 'id', 'alias'), 'array', TRUE);
	    foreach ($children as $child)
	    {
		$act = '';
		$url = '';
		if ($child['id'] == $activated)
		    $act = 'class="active"';
		if ($for_cms == TRUE)
		    $url = base_url("cms/" . $child['alias']);
		else
		    $url = base_url($child['alias']);
		$tree .= '<li ' . $act . '><a href="' . $url
			. '"><i class="icon-tag"></i>'
			. nbs(2 * $child['__level']) . $child['title'] . '</a>' . "\n";
	    }
	}
	$tree .= "</select>\n";
	return $tree;
    }

    /**
     * Контрол категорий. Входящие параметры — массив.
     * $id = 0, $by_lft = FALSE, $exclude = -1, $root
     * @param array $param
     * @return string
     */
    function select_categoryes(array $param = array('id' => 0, 'name' => 'category', 'root' => 10, 'by_lft' => FALSE, 'exclude' => -1), $multiple = FALSE, $selected = array())
    {
	extract($param);
	$c = new Category();
	$c->select_root($root);
	$c->get_root();
	$dop = '';
	$mul = '';
	if ($multiple == TRUE)
	{
	    $dop = 'multiple="multiple"';
	    $mul = '[]';
	}
	$tree = '<select name="' . $name . $mul . '" class="input-xlarge" ' . $dop . ' id="' . $name . '">' . "\n";
	if ($c->exists())
	{
	    $children = $c->dump_tree(array('title', 'id', 'lft', 'alias'), 'array', FALSE);
	    foreach ($children as $child)
	    {
		// Выбранная категория
		$sel = '';

		if ($multiple == TRUE)
		{
		    if ($by_lft == TRUE)
		    {
			if (!isset($selected[$child['lft']]))
			    $sel = ' selected';
		    } else
		    {
			if (!isset($selected[$child['id']]))
			    $sel = ' selected';
		    }
		} else
		{
		    if ($by_lft == TRUE)
		    {
			if ($child['lft'] == $id)
			    $sel = ' selected';
		    } else
		    {
			if ($child['id'] == $id)
			    $sel = ' selected';
		    }
		}
		// Обработка исключений
		$show = TRUE;
		if ($by_lft)
		{
		    if ($child['lft'] == $exclude)
			$show = FALSE;
		}
		else
		{
		    if ($child['id'] == $exclude)
			$show = FALSE;
		}

		if ($show)
		{
		    $tree .= '<option' . $sel . ' value="';
		    if ($by_lft)
			$tree .= $child['lft'];
		    else
			$tree .= $child['id'];
		    $tree .= '">' . nbs($child['__level']) .
			    $child['title'] .
			    "</option>\n";
		}
	    }
	}
	$tree .= "</select>\n";
	return $tree;
    }

    /**
     * UL категорий.
     * [root, baseurl ('cms/'), activated]
     * @param array $param
     * @return string
     */
    public function category_ul(array $param)
    {
	$c = new Category();
	//extract($param);
	$c->select_root($param['root']);
	$c->get_root();
	$tree = "\n";
	if ($c->exists())
	{
	    $children = $c->dump_tree(array('title', 'id', 'alias'), 'array', TRUE);
	    foreach ($children as $child)
	    {
		$act = '';
		$url = '';
		if ($child['id'] == $param['activated'])
		    $act = 'class="active"';

		$url = base_url($param['baseurl'] . $child['alias']);

		$tree .= '<li ' . $act . '><a href="' . $url
			. '"><i class="icon-tag"></i>'
			. nbs(2 * $child['__level']) . $child['title'] . '</a>' . "\n";
	    }
	}
	$tree .= "</select>\n";
	return $tree;
    }

    /**
     * Лист инпутов категорий.
     * [root, baseurl ('cms/'), activated]
     * @param array $param
     * @return string
     */
    public function category_chk($root, $checked = array(), $name = 'category')
    {
	$c = new Category();
	$c->select_root($root);
	$c->get_root();
	$tree = "\n";
	if ($c->exists())
	{
	    //debug_print($checked);

	    $children = $c->dump_tree(array('title', 'id', 'alias'), 'array', TRUE);
	    foreach ($children as $child)
	    {
		$chk = '';
		if (isset($checked[$child['id']]))
		    $chk = ' checked="checked" ';
		$tree .= nbs(3 * $child['__level']) .
			'<input type="checkbox" ' . $chk . ' name="' . $name . '[' . $child['id'] . ']" value="' . $child['id'] . '">' . nbs() . $child['title'] . br()
		;
	    }
	}

	return $tree;
    }

    public function items_chk($category_id, $name = 'acc', $checked = array())
    {
	$CI = &get_instance();
	$query = $CI->db->get_where('catalog_categoryes', array('category_id' => $category_id));
	$res = $query->result_array();
	$acc_ids_array = array();
	foreach ($res as $r)
	{
	    $acc_ids_array[] = $r['catalog_id'];
	}
	//print_r($res);

	$items = new Item();
	$out = '';
	if (!empty($acc_ids_array))
	{
	    $items->where_in('id', $acc_ids_array)->get_iterated();
	    foreach ($items as $item)
	    {
		$chk = '';
		if (isset($checked[$item->id]))
		    $chk = ' checked="checked" ';
		$out .='<input type="checkbox" ' . $chk . ' name="' . $name . '[' . $item->id . ']" value="' . $item->id . '">' . nbs() . $item->title . br();
	    }
	}
	return $out;
    }

    public function items_all_chk($name = 'acc', $checked = array())
    {
	$CI = &get_instance();
	$items = new Item();
	$items->order_by('title')->get_iterated();
	$out = '';
	foreach ($items as $item)
	{
	    $chk = '';
	    if (isset($checked[$item->id]))
		$chk = ' checked="checked" ';
	    $out .='<input type="checkbox" ' . $chk . ' name="' . $name . '[' . $item->id . ']" value="' . $item->id . '">' . nbs() . $item->title . br();
	}
	return $out;
    }

    /**
     * Сокращение для паджинатора.
     * @param type $base_url
     * @param type $total_rows
     * @param type $uri_segment
     * @param type $per_page
     * @param type $full_tag_open
     * @param type $full_tag_close
     * @return type
     */
    public function paginator($base_url, $total_rows, $uri_segment, $per_page, $full_tag_open = '<div class="pagination pagination-centered"><ul>', $full_tag_close = '</ul></div>')
    {
	$CI = &get_instance();
	$CI->load->library('pagination');
	$config['base_url'] = $base_url;
	$config['total_rows'] = $total_rows;
	$config['uri_segment'] = $uri_segment;
	$config['per_page'] = $per_page;
	$config['full_tag_open'] = $full_tag_open;
	$config['full_tag_close'] = $full_tag_close;
	$config['first_link'] = 'Первая';
	$config['first_tag_open'] = '<li>';
	$config['first_tag_close'] = '</li>';
	$config['last_link'] = 'Последняя';
	$config['last_tag_open'] = '<li>';
	$config['last_tag_close'] = '</li>';
	$config['next_link'] = '&RightArrow;';
	$config['next_tag_open'] = '<li>';
	$config['next_tag_close'] = '</li>';
	$config['prev_link'] = '&LeftArrow;';
	$config['prev_tag_open'] = '<li>';
	$config['prev_tag_close'] = '</li>';
	$config['cur_tag_open'] = '<li class="active"><a href="#">';
	$config['cur_tag_close'] = '</a></li>';
	$config['num_tag_open'] = '<li>';
	$config['num_tag_close'] = '</li>';
	$config['use_page_numbers'] = TRUE;
	$CI->pagination->initialize($config);
	return $CI->pagination->create_links();
    }

    function select_menu(array $param = array('id' => 0, 'root' => 10, 'by_lft' => FALSE, 'exclude' => -1))
    {
	extract($param);
	$c = new Menu_orm();
	$c->select_root($root);
	$c->get_root();
	$tree = '<select name="menu" id="menu">' . "\n";
	if ($c->exists())
	{
	    $children = $c->dump_tree(array('title', 'id', 'lft', 'alias'), 'array', FALSE);
	    foreach ($children as $child)
	    {
		// Выбранная категория
		$sel = '';
		if ($by_lft == TRUE)
		{
		    if ($child['lft'] == $id)
			$sel = ' selected';
		} else
		{
		    if ($child['id'] == $id)
			$sel = ' selected';
		}

		// Обработка исключений
		$show = TRUE;
		if ($by_lft)
		{
		    if ($child['lft'] == $exclude)
			$show = FALSE;
		}
		else
		{
		    if ($child['id'] == $exclude)
			$show = FALSE;
		}

		if ($show)
		{
		    $tree .= '<option' . $sel . ' value="';
		    if ($by_lft)
			$tree .= $child['lft'];
		    else
			$tree .= $child['id'];
		    $tree .= '">' . nbs($child['__level']) .
			    $child['title'] .
			    "</option>\n";
		}
	    }
	}
	$tree .= "</select>\n";
	return $tree;
    }

    /**
     * Возвращает dropdown list со списком статических страниц.
     */
    function select_page($name = 'page', $class = '', $id = 'page')
    {
	$pages = new Pages_orm();

	$pages->get();
	$tree = '<select name="' . $name . '" class="' . $class . '" id="' . $id . '">' . "\n";
	foreach ($pages as $i)
	{
	    $tree .= '<option value="' . $i->id . '">' . $i->title . "</option>\n";
	}
	$tree .= "</select>\n";
	return $tree;
    }

}