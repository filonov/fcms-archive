<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Контроллер главной страницы.
 *
 * @author Denis Filonov <denis@filonov.biz>
 * @copyright (c) 2012-2013, Denis Filonov.
 */
class Index extends CI_Controller
{

    function __construct()
    {
	parent::__construct();
	//$this->output->enable_profiler(TRUE);
    }

    function index($alias = '')
    {
	if (FCMS_PROJECT == 'liberum')
	{
	    if (empty($alias))
	    {
//		$this->load->driver('cache', array('adapter' => 'file'));
//		$res = '';
//		if (!$res = $this->cache->get('index'))
//		{
		$group = new Group();
		$data = template_base_tags() +
			array(
			    'meta_title' => $this->config->item('site_title'),
			    'meta_keywords' => $this->config->item('site_keywords'),
			    'meta_description' => $this->config->item('site_description'),
			    'groups' => $group->limit(5)
				    ->where_in('status', explode(',', '2,3,4'))
				    ->order_by('date')
				    ->get()
		);
		$this->parser->parse($this->config->item('tplpath') . $this->config->item('skin') . '/index', $data, FALSE);
//		    $res = $this->parser->parse($this->config->item('tplpath') . $this->config->item('skin') . '/index', $data, TRUE);
//		    $this->cache->save('index', $res, $this->config->item('cache_time'));
//		}
//		echo $res;
	    } else
	    {
		$this->show_page($alias);
	    }
	} elseif (FCMS_PROJECT == 'garsia')
	{
	    $catalog = new Item();
	    $data = template_base_tags() +
		    array(
			'catalog' => $catalog->get(),
			'active_menu_id' => 0,
			'meta_title' => $this->config->item('site_title'),
			'meta_keywords' => $this->config->item('site_keywords'),
			'meta_description' => $this->config->item('site_description')
	    );
	    if (empty($alias))
	    {
		$this->parser->parse($this->config->item('tplpath') . $this->config->item('skin') . '/index', $data, FALSE);
	    } else
	    {
		$this->show_page($alias);
	    }
	} else
	{
	    $data = template_base_tags() +
		    array(
			'active_menu_id' => 0,
			'meta_title' => $this->config->item('site_title'),
			'meta_keywords' => $this->config->item('site_keywords'),
			'meta_description' => $this->config->item('site_description')
	    );
	    if (empty($alias))
	    {
		$this->parser->parse($this->config->item('tplpath') . $this->config->item('skin') . '/index', $data, FALSE);
	    } else
	    {
		$this->show_page($alias);
	    }
	}
    }

    /**
     * Показывает статические страницы.
     * @param type $alias
     */
    private function show_page($alias)
    {
	$page = new Pages_orm();
	$page->get_by_alias($alias);
// Определение активного пункта меню
	$menu = new Menu_orm();
	$menu->get_where(array('content_type' => CONTENT_PAGE, 'content_id' => $page->id), 1);

	$error = '';
	$message = '';
	if ($this->session->userdata('message'))
	{
	    $message = $this->session->userdata('message');
	    $this->session->unset_userdata('message');
	}
	if ($this->session->userdata('error'))
	{
	    $message = $this->session->userdata('error');
	    $this->session->unset_userdata('error');
	}


	$data = array(
	    'message' => $message,
	    'error' => $error,
	    'title' => $page->title,
	    'meta_title' => $page->meta_title,
	    'meta_keywords' => $page->meta_keywords,
	    'meta_description' => $page->meta_description,
	    'item' => $page,
	    'active_menu_id' => $menu->id
	);
	if ($page->exists())
	{
	    if (isset($page->template) && !empty($page->template))
	    {
		$filename = FCPATH . 'templates/' . $this->config->item('skin') . '/' . $page->template . '.php';
		if (file_exists($filename))
		    $this->parser->parse($this->config->item('skin_html_path') . '/' . $page->template, template_base_tags() + $data);
		else
		    show_404();
	    }
	    else
	    {

		$filename = FCPATH . 'templates/' . $this->config->item('skin') . '/' . 'page.php';
		if (file_exists($filename))
		    $this->parser->parse($this->config->item('skin_html_path') . '/' . 'page', template_base_tags() + $data);
		else
		    $this->parser->parse($this->config->item('skin_html_path') . '/' . 'content_item', template_base_tags() + $data);
	    }
	} else
	    show_404();
    }

}
