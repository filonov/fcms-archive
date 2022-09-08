<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Поиск по магазину.
 *
 * @copyright (c) 2013, Denis Filonov
 */
class Search extends CI_Controller
{

    function __construct()
    {
	parent::__construct();
    }

    function index()
    {
	if ($this->input->post('searchstr'))
	{

	    $searchstr = $this->input->post('searchstr', TRUE);
	    $searchstr = substr($searchstr, 0, 100);
	    $searchstr = preg_replace("/[^\w\x7F-\xFF\s]/", " ", $searchstr);
	    $category = new Category();
	    $category->select_root(CATEGORYES_CATALOG);
	    $category->get_root();
	    $item = new Item();



	    $this->db->from('items')->
		    select('items.title as title, items.alias as alias, catalog_categoryes.category_id as cat_id')->
		    join('catalog_categoryes', 'catalog_categoryes.catalog_id = items.id')->limit(50)
		    ->where('MATCH (title) AGAINST ("' . $searchstr . '" IN BOOLEAN MODE)', NULL, FALSE);
	    //->like('title', );



	    $q = $this->db->get();
	    $res = $q->result();
	    //debug_print($this->db->last_query());
	    $data = template_base_tags() + array(
		'searchstr' => $searchstr,
		'cat' => $category,
		'items' => $res, // $item->like('title', preg_replace("/[^\w\x7F-\xFF\s]/", " ", $searchstr))->limit($this->config->item('per_page'))->get(),
		'meta_title' => 'Поиск: ' . $searchstr,
		'meta_keywords' => '',
		'meta_description' => '',
	    );

	    $this->parser->parse($this->config->item('tplpath') . $this->config->item('skin') . '/search', $data);
	} else
	{
	    $data = template_base_tags() + array(
		'searchstr' => '',
		'cat' => array(),
		'items' => array(), // $item->like('title', preg_replace("/[^\w\x7F-\xFF\s]/", " ", $searchstr))->limit($this->config->item('per_page'))->get(),
		'meta_title' => 'Поиск ',
		'meta_keywords' => '',
		'meta_description' => '',
	    );

	    $this->parser->parse($this->config->item('tplpath') . $this->config->item('skin') . '/search', $data);
	}
    }

}