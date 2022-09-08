<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Контроллер админки категорий
 *
 * @author DVF
 */
class Categoryes extends CI_Controller
{

    function __construct()
    {
	parent::__construct();
	is_root();
    }

    private function upload_thumbnail($id = 0)
    {

	if (isset($_FILES['thumbnail']))
	{
	    $this->load->library('image_lib');
	    $c = new Category($id);
	    // Создание каталога для картинок.
	    $gallerypath = $this->config->item('path_for_uploads') . 'thumbnails/';
	    @mkdir($gallerypath, 0777, TRUE);
	    $uploadext = strtolower(strrchr($_FILES["thumbnail"]["name"], "."));

	    //debug_print($gallerypath . $id . $uploadext);

	    if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $gallerypath . 'c' . $id . $uploadext))
	    {
		$config['image_library'] = 'gd2';
		$config['maintain_ratio'] = TRUE;
		$config['master_dim'] = 'width';
		$config['source_image'] = $gallerypath . 'c' . $id . $uploadext;

		// Изменение размера    
		$config['new_image'] = $gallerypath . 'c' . $id . $uploadext;
		$config['width'] = $this->config->item('category_tmb');
		$config['height'] = $this->config->item('category_tmb');
		$this->image_lib->initialize($config);
		$this->image_lib->resize();

		// Добавление имени картинки в базу
		$c->image = 'c' . $id . $uploadext;
		$c->skip_validation()->save();
	    }
	}
    }

    private function delete_image($id)
    {
	$c = new Category($id);
	$gallerypath = $this->config->item('path_for_uploads') . 'thumbnails/';
	if (unlink($gallerypath . $c->image))
	{
	    $c->image = '';
	    $c->skip_validation()->save();
	}
    }

    function index($root = CATEGORYES_CONTENT)
    {
	$visual = new Visual_elements();
	$cat = new Category();
	$cat->select_root($root);
	$cat->get_root();
	$data = template_base_tags() + array(
	    'title' => 'Категории',
	    'root' => $root,
	    'category_dropbox' => $visual->select_categoryes(array('id' => 1, 'name' => 'category', 'root' => $root, 'by_lft' => TRUE, 'exclude' => -1))
	);
	if ($cat->exists())
	    $data += array('tree' => $cat->dump_tree(array('title', 'id', 'alias', 'lft', 'legacy_id'), 'array', TRUE));
	else
	    $data += array('tree' => array());
	$this->parser->parse($this->config->item('tplpath') . 'cms/categoryes', $data);
    }

    function add()
    {
	$root = $this->input->post('root', TRUE);
	$this->load->helper('translit');
	$c = new Category();
	$c->select_root($root);
	$c->get_node_where_left($this->input->post('category', TRUE));
	$c->new_last_child();
	$c->title = $this->input->post('title', TRUE);
	$c->template = $this->input->post('template', TRUE);
	$c->alias = sanitize_title_with_translit((string) $c->title);
	$c->description = $this->input->post('description');
	$success = $c->save();
	if (!$success)
	{
	    $error = 'Ошибка сохранения.';
	    if (!($c->valid))
	    {
		$error = $c->error->string;
		// #REFACTOR - вывод нормального сообщения.
	    }
	    die($error);
	} else
	{
	    $id = $c->id;
	    $this->upload_thumbnail($id);
	}
	redirect('cms/categoryes/' . $root);
    }

    function delete()
    {

	$root = $this->input->post('root', TRUE);
	$n_id = array();
	foreach ($_POST['item'] as $left)
	{
	    $c = new Category();
	    $c->select_root($root);
	    $c->get_node_where_left($left);
	    $n_id[] = $c->id;
	    //$c->remove_node();
	}
	foreach ($n_id as $idn)
	{
	    $c = new Category();
	    $c->select_root($root);
	    $c->where('id', $idn)->get();
	    $c->remove_node();
	}
	redirect('cms/categoryes/' . $root);
    }

    function ajaxGetCategory()
    {
	$arr = array();
	$visual = new Visual_elements();

	if ($this->input->post('lft'))
	{
	    $lft = $this->input->post('lft', TRUE);
	    $root = $this->input->post('root', TRUE);
	    $c = new Category();
	    $c->select_root($root);
	    $c->get_node_where_left($lft);
	    $p = new Category();
	    $p->select_root($root);
	    $p->get_parent($c);

	    $arr = $arr +
		    array(
			'title' => $c->title,
			'alias' => $c->alias,
			'template' => $c->template,
			'description' => $c->description,
			'image' => $c->image,
			'dropbox' => $visual->select_categoryes(array('id' => $p->lft, 'name' => 'category', 'root' => $root, 'by_lft' => TRUE, 'exclude' => $c->lft))
	    );
	}
	else
	    $arr = $arr +
		    array(
			'title' => 'Без названия',
			'alias' => '',
			'template' => '',
			'description' => '',
			'image' => '',
			'dropbox' => $visual->select_categoryes(array('id' => $p->lft, 'name' => 'category', 'root' => $root, 'by_lft' => TRUE, 'exclude' => $c->lft))
	    );
	echo json_encode($arr);
    }

    /**
     * Редактирование категорий. Все входящие параметры POST.
     */
    function edit()
    {
	$lft = (int) $this->input->post('left', TRUE);
	$title = $this->input->post('title', TRUE);
	$alias = $this->input->post('alias', TRUE);
	$description = $this->input->post('description');
	$template = $this->input->post('template', TRUE);
	$root = (int) $this->input->post('root', TRUE);
	$new_parent_lft = (int) $this->input->post('category', TRUE);
	$del_img = FALSE;
	if ($this->input->post('delImage'))
	    $del_img = TRUE;

	//debug_print($_POST);

	$c = new Category();
	$c->select_root($root);
	$c->get_node_where_left($lft);

	$parent_of_c = new Category();
	$parent_of_c->get_parent($c);

	if ($parent_of_c->lft != $new_parent_lft)
	{
	    $new_parent = new Category();
	    $new_parent->select_root($root);
	    $new_parent->get_node_where_left($new_parent_lft);
	    $c->make_last_child_of($new_parent);
	}
	$c->title = $title;
	$c->alias = $alias;
	$c->template = $template;
	$c->description = $description;
	$success = $c->save();
	if (!$success)
	{
	    $error = 'Ошибка сохранения.';
	    if (!($c->valid))
	    {
		$error = $c->error->string;
		// #REFACTOR - вывод нормального сообщения.
		die($error);
	    }
	} else
	{
	    $id = $c->id;
	    if ($del_img)
		$this->delete_image($id);
	    $this->upload_thumbnail($id);
	}
	redirect('cms/categoryes/' . $root);
    }

    function move()
    {
	if ($this->input->post())
	{
	    $pdata = $this->input->post(NULL, TRUE);
	    $category = new Category();
	    $category->get_root($pdata['root']);
	    $category->get_node_where_left($pdata['lft']);
	    $bro = new Category();
	    $bro->get_root($pdata['root']);
	    $bro->get_node_where_left($pdata['lft']);

	    if ($pdata['direction'] == 'up')
	    {
		$bro->get_previous_sibling();
		$category->make_previous_sibling_of($bro);
	    } elseif ($pdata['direction'] == 'down')
	    {
		$bro->get_next_sibling();
		$category->make_next_sibling_of($bro);
	    }
	}
	redirect('cms/categoryes/' . $pdata['root']);
    }

}