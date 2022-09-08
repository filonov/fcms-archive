<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Администрирование MMA - функции для работы по наполнению баз данных.
 * @copyright (c) 2013, Denis Filonov.
 */
class Showcase extends CI_Controller
{

    function __construct()
    {
	parent::__construct();
	is_root();
    }
    
    function index()
    {
	$items = new Content_orm();
	if($this->input->post('showcase_order'))
	{
	    $orders = $this->input->post('showcase_order', TRUE);
	    foreach ($orders as $key => $value)
	    {
		$items->get_by_id($key);
		$items->showcase_order = $value;
		$items->skip_validation()->save();
	    }    
	}
	
	$items->where('show_in_showcase',TRUE)->order_by('showcase_order, created, id');
	$data = template_base_tags() + array(
	    'content' => $items->get()
	);
	$this->parser->parse($this->config->item('tplpath') . 'cms/showcase', $data);
    }
    
}