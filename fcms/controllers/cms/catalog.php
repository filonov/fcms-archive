<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Контроллер каталога
 *
 * @author DVF
 * @copyright 2013, Denis V. Filonov
 */
class Catalog extends CI_Controller
{

    function __construct()
    {
	parent::__construct();
	is_root();
    }

    /**
     * Функция переноса файлов из VirtueMart в мой каталог.
     * Используется разово.
     */
    /* function tmp_convert_img()
      {
      echo '→ → → → → → → Поехали'.  br();
      $catalog = new Catalog_orm();
      $catalog->get_iterated();
      foreach ($catalog as $item)
      {
      // Создание каталога для картинок.
      @mkdir($this->config->item('path_for_uploads') . 'catalog/items/' . $item->id, 0777, TRUE);
      @mkdir($this->config->item('path_for_uploads') . 'catalog/items/' . $item->id . '/b', 0777, TRUE);
      @mkdir($this->config->item('path_for_uploads') . 'catalog/items/' . $item->id . '/s', 0777, TRUE);
      // Копирование картинки
      copy($this->config->item('path_for_uploads') . 'catalog/product/' . $item->picv, $this->config->item('path_for_uploads') . 'catalog/items/' . $item->id . '/' . $item->picv);
      // Создание превью
      $gallerypath = $this->config->item('path_for_uploads') . 'catalog/items/' . $item->id . '/';
      $this->load->library('image_lib');
      $config['image_library'] = 'gd2';
      $config['maintain_ratio'] = TRUE;
      $config['master_dim'] = 'width';
      $config['source_image'] = $gallerypath . $item->picv;

      // Создание большого превью
      $config['new_image'] = $gallerypath . 'b/' . $item->picv;
      $config['width'] = $this->config->item('catalog_tmb_big');
      $config['height'] = $this->config->item('catalog_tmb_big');
      $this->image_lib->initialize($config);
      $this->image_lib->resize();

      // Создание малого превью
      $config['new_image'] = $gallerypath . 's/' . $item->picv;
      $config['width'] = $this->config->item('catalog_tmb_small');
      $config['height'] = $this->config->item('catalog_tmb_small');
      $this->image_lib->initialize($config);
      $this->image_lib->resize();

      // Добавление имени картинки в базу
      $item->picture = $item->picv;
      $item->save();
      echo $item->picv.br();
      }
      echo '→ → → → → → → Закончили';
      } */

    /**
     * Таблица событий
     * @param string $category 
     */
    function index($category = 'all', $page = '1')
    {
	$visual = new Visual_elements();
	$catalog = new Item();
	$data = array();

	if (!empty($category) && ($category != 'all'))
	{
	    $cat = new Category();
	    $cat->get_by_alias($category);

	    #REFACTOR Переписать на ORM. Он странно работает.
	    $query = $this->db->get_where('catalog_categoryes', array('category_id' => $cat->id));
	    $res = $query->result_array();
	    $inarray = array();
	    foreach ($res as $r)
	    {
		$inarray[] = $r['catalog_id'];
	    }
	    # END REFACTOR

	    $data = template_base_tags() + array(
		'category_name' => $cat->title,
		'cattree' => $visual->category_ul(array('root' => CATEGORYES_CATALOG, 'baseurl' => 'cms/catalog/', 'activated' => $cat->id)), //$visual->list_categoryes($cat->id), //$this->list_categoryes($cat->id),
		'content' => empty($inarray) ? array() : $catalog->where_in('id', $inarray)->get_paged($page, 50)->order_by('order'),
		'paginator' => empty($inarray) ? '' : $visual->paginator(base_url('cms/catalog/' . $category . '/'), $catalog->where_in('id', $inarray)->count(), 4, 50)
	    );
	} else
	{
	    $cat = new Category();
	    $cat->get_by_alias($category);
	    $data = template_base_tags() + array(
		'category_name' => $cat->title,
		'cattree' => $visual->category_ul(array('root' => CATEGORYES_CATALOG, 'baseurl' => 'cms/catalog/', 'activated' => NULL)),
		'content' => $catalog->get_paged($page, 50)->order_by('order'),
		'paginator' => $visual->paginator(base_url('cms/catalog/' . $category . '/'), $catalog->count(), 4, 50)
	    );
	}
	$this->parser->parse($this->config->item('tplpath') . '/cms/catalog', $data);
    }

    function search($page = '1')
    {
	if ($this->input->post('searchstr'))
	{
	    $searchstr = $this->input->post('searchstr', TRUE);
	    $searchstr = substr($searchstr, 0, 100);
	    $visual = new Visual_elements();
	    $catalog = new Item();

	    $data = template_base_tags() + array(
		'cattree' => $visual->category_ul(array('root' => CATEGORYES_CATALOG, 'baseurl' => 'cms/catalog/', 'activated' => NULL)),
		'content' => $catalog->like('title', $searchstr)->get_paged($page, 50),
		'paginator' => $visual->paginator(base_url('cms/catalog/search/'), $catalog->like('title', $searchstr)->count(), 4, 50)
	    );
	    $this->parser->parse($this->config->item('tplpath') . '/cms/catalog', $data);
	} else
	    redirect('cms/catalog');
    }

    private function upload_thumbnail($id = 0)
    {
	if (isset($_FILES['picture']))
	{
	    $cat = new Item($id);
	    $this->load->library('image_lib');
	    $post = new Content_orm($id);
	    // Создание каталога для картинок.
	    @mkdir($this->config->item('path_for_uploads') . 'catalog/items/' . $id, 0777, TRUE);
	    @mkdir($this->config->item('path_for_uploads') . 'catalog/items/' . $id . '/b', 0777, TRUE);
	    @mkdir($this->config->item('path_for_uploads') . 'catalog/items/' . $id . '/s', 0777, TRUE);
	    // Загрузка файла            
	    $gallerypath = $this->config->item('path_for_uploads') . 'catalog/items/' . $id . '/';
	    if (move_uploaded_file($_FILES["picture"]['tmp_name'], $gallerypath . $_FILES["picture"]['name']))
	    {
		$this->load->library('image_lib');
		$config['image_library'] = 'gd2';
		$config['maintain_ratio'] = TRUE;
		$config['master_dim'] = 'width';
		$config['source_image'] = $gallerypath . $_FILES["picture"]['name'];

		// Создание большого превью      
		$config['new_image'] = $gallerypath . 'b/' . $_FILES["picture"]['name'];
		$config['width'] = $this->config->item('catalog_tmb_big');
		$config['height'] = $this->config->item('catalog_tmb_big');
		$this->image_lib->initialize($config);
		$this->image_lib->resize();

		// Создание малого превью
		$config['new_image'] = $gallerypath . 's/' . $_FILES["picture"]['name'];
		$config['width'] = $this->config->item('catalog_tmb_small');
		$config['height'] = $this->config->item('catalog_tmb_small');
		$this->image_lib->initialize($config);
		$this->image_lib->resize();

		// Добавление имени картинки в базу
		$cat->picture = $_FILES["picture"]['name'];
		$cat->skip_validation()->save();
	    }
	}
    }

    private function upload_pictures($item_id = 0)
    {
	if (isset($_FILES['pictures']))
	{
	    $this->load->library('image_lib');

	    // Создание каталога для картинок.
	    $gallerypath = $this->config->item('path_for_uploads') . 'catalog/gallery/' . $item_id . '/';
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

			// Добавление имени файла в базу
			$gallery = new Items_image();
			$gallery->filename = $_FILES["pictures"]['name'][$key];
			$gallery->item_id = $item_id;
			$gallery->save_as_new();
		    }
		}
	    }
	}
    }

    private function pictures_meta_update()
    {
	if ($this->input->post('piccolor'))
	{
	    $color = $this->input->post('piccolor');
	    $pic = new Items_image();
	    foreach ($color as $key => $value)
	    {
		$pic->get_by_id($key);
		$pic->color = $value;
		$pic->skip_validation()->save();
	    }
	}
    }
    
    private function delete_images()
    {
	if ($this->input->post('check'))
        {

            $check = $_POST['check'];
            if ($check)
            {
                foreach ($check as $c)
                {
                    $pic = new Items_image();
                    $pic->get_by_id($c);
		    $gallerypath = $this->config->item('path_for_uploads') . 'catalog/gallery/' . $pic->item_id . '/';
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
    }

    /**
     * Добавление новой записи
     */
    function add()
    {
	$cat = new Item();
	$cat->title = 'Без имени';
	$cat->skip_validation()->save();
	redirect('cms/catalog/edit/' . $cat->id);
    }

    /**
     * Редактировать элемент каталога.
     * @param bool|int $id
     */
    function edit($id = FALSE)
    {
	$cat = new Item();
	$visual = new Visual_elements();
	$rev = new Items_review();
	// Сохранение
	if ($this->input->post())
	{
	    $cat->get_by_id($id);
	    $cat->order = $this->input->post('order', TRUE);
	    $cat->SKU = $this->input->post('SKU', TRUE);
	    $cat->price = $this->input->post('price', TRUE);
	    $cat->title = $this->input->post('title', TRUE);

	    $this->load->helper('translit');

	    if ($this->input->post('alias'))
	    {
		$cat->alias = $this->input->post('alias', TRUE);
	    } else
	    {
		$cat->alias = sanitize_title_with_translit($cat->title);
	    }
	    $cat->meta_title = $this->input->post('meta_title', TRUE);
	    $cat->meta_keywords = $this->input->post('meta_keywords', TRUE);
	    $cat->meta_description = $this->input->post('meta_description', TRUE);
	    $cat->description = $this->input->post('description');

	    if ($this->input->post('ph'))
	    {
		$cat->ph = $this->input->post('ph');
	    }
	    if ($this->input->post('volume'))
	    {
		$cat->volume = $this->input->post('volume');
	    }
	    $success = $cat->save();
	    if (!$success)
	    {
		$error = 'Ошибка сохранения.';
		if (!($cat->valid))
		{
		    $error = $cat->error->string;
		}
		$query = $this->db->get_where('catalog_categoryes', array('catalog_id' => $id));
		$res = $query->result_array();
		$checked = array();
		foreach ($res as $chk)
		{
		    $checked[$chk['category_id']] = $chk['category_id'];
		}

		$data = template_base_tags() + array(
		    'error' => $error,
		    'id' => -1,
		    'item' => $cat,
		    'method_path' => base_url('cms/catalog/edit/' . $id),
		    'category' => $visual->category_chk(CATEGORYES_CATALOG, $checked)
		);
		$this->parser->parse($this->config->item('tplpath') . 'cms/catalog_entry', $data);
	    } else
	    { // Если сохранение успешное
		$id = $cat->id;

		// Сохранение категории
		$this->db->delete('catalog_categoryes', array('catalog_id' => $id));
		$category = $this->input->post('category');
		foreach ($category as $c)
		{
		    $this->db->insert('catalog_categoryes', array(
			'catalog_id' => $id,
			'category_id' => $c
		    ));
		}
		// Сохранение аксессуаров
		if ($this->input->post('acc'))
		{
		    $this->db->delete('items_accs', array('items_id' => $id));
		    $accs = $this->input->post('acc');
		    foreach ($accs as $acc)
		    {
			$this->db->insert('items_accs', array(
			    'items_id' => $id,
			    'acc_id' => $acc
			));
		    }
		}
		// Сохранение «also»
		if ($this->input->post('also'))
		{
		    $this->db->delete('items_also', array('items_id' => $id));
		    $also = $this->input->post('also');
		    foreach ($also as $al)
		    {
			$this->db->insert('items_also', array(
			    'items_id' => $id,
			    'also_id' => $al
			));
		    }
		}

		// Замена картинки
		$this->upload_thumbnail($id);

		// Отзывы
		$names = $this->input->post('name');
		$shows = $this->input->post('show');
		$texts = $this->input->post('text');
		$rates = $this->input->post('rate');
		if (is_array($names))
		{
		    foreach ($names as $key => $value)
		    {
			$rev->where('id', $key)->get();
			$rev->name = $value;
			if (isset($texts[$key]))
			    $rev->text = $texts[$key];
			$rev->rate = $rates[$key];
			if (isset($shows[$key]))
			    $rev->show = TRUE;
			else
			    $rev->show = FALSE;
			$rev->save();
		    }
		}
		// Иконки
		$icons = $this->input->post('icon');
		$itic = new Items_icon();
		$itic->where('items_id', $id)->get();
		if ($itic->exists())
		    $itic->delete_all();
		if (is_array($icons))
		{
		    foreach ($icons as $ic)
		    {
			$itic->items_id = $id;
			$itic->filename = $ic;
			$itic->save_as_new();
		    }
		}

		// Цвета    
		$colors = $this->input->post('color');
		$itco = new Items_color();
		$itco->where('item_id', $id)->get();
		if ($itco->exists())
		    $itco->delete_all();
		if (is_array($colors))
		{
		    foreach ($colors as $co)
		    {
			$itco->item_id = $id;
			$itco->color_id = $co;
			$itco->save_as_new();
		    }
		}

		// Загрузка картинок
		$this->upload_pictures($id);
		$this->delete_images();
		$this->pictures_meta_update();
		


		redirect('cms/catalog/edit/' . $id);
	    }
	} else
	{
	    // Чтение
	    $rev->order_by('created')->get_by_items_id($id);
	    // Редактируем запись.
	    // #REFACTOR - переделать на ORM 
	    // Добываем категории, к которым принадлежит объект
	    $query = $this->db->get_where('catalog_categoryes', array('catalog_id' => $id));
	    $res = $query->result_array();
	    $checked = array();
	    foreach ($res as $chk)
	    {
		$checked[$chk['category_id']] = $chk['category_id'];
	    }

	    // Добываем аксессуары
	    $query1 = $this->db->get_where('items_accs', array('items_id' => $id));
	    $res1 = $query1->result_array();
	    $acc_checked = array();
	    foreach ($res1 as $achk)
	    {
		$acc_checked[$achk['acc_id']] = $achk['acc_id'];
	    }

	    // Добываем «also»
	    $query2 = $this->db->get_where('items_also', array('items_id' => $id));
	    $res2 = $query2->result_array();
	    $also_checked = array();
	    foreach ($res2 as $alchk)
	    {
		$also_checked[$alchk['also_id']] = $alchk['also_id'];
	    }

	    // Добываем картинки 
	    $icons_checked = new Items_icon();
	    $icons_checked->where('items_id', $id)->get();
	    $icons_chk = array();
	    foreach ($icons_checked as $ic)
	    {
		$icons_chk[] = $ic->filename;
	    }
	    if (is_dir($this->config->item('path_for_uploads') . 'catalog/icons/'))
		$icons = get_files($this->config->item('path_for_uploads') . 'catalog/icons/');
	    else
		$icons = array();

	    // Цвета
	    $colors = new Color();
	    $colors_checked = new Items_color();
	    $colors_checked->where('item_id', $id)->get();
	    $colors_chk = array();
	    foreach ($colors_checked as $cc)
	    {
		$colors_chk[] = $cc->color_id;
	    }

	    // Добываем галерею
	    $gallery = new Items_image();
	    $gallery->where(array('item_id' => $id))->get();


	    $data = template_base_tags() + array(
		'error' => '',
		'id' => $id,
		'reviews' => $rev,
		'images' => '', //get_files($this->config->item('path_for_uploads') . 'catalog/' . $id . '/'),
		'item' => $cat->get_by_id($id),
		'icons' => $icons,
		'icons_chk' => $icons_chk,
		'colors' => $colors->get(),
		'colors_chk' => $colors_chk,
		'gallery' => $gallery,
		'method_path' => base_url('cms/catalog/edit/' . $id),
		'acc' => $visual->items_chk($this->config->item('catalog_acc_category'), 'acc', $acc_checked),
		'also' => $visual->items_all_chk('also', $also_checked),
		'category' => $visual->category_chk(CATEGORYES_CATALOG, $checked)//$visual->select_categoryes(array('id' => $cat->category, 'name' => 'category', 'root' => 20, 'by_lft' => FALSE, 'exclude' => -1), TRUE),
	    );

	    $this->parser->parse($this->config->item('tplpath') . 'cms/catalog_entry', $data);
	}
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
		    $s = new Item();
		    $s->get_by_id($c);
		    $gallerypath = $this->config->item('path_for_uploads') . 'catalog/items/' . $c . '/';
		    if (!empty($s->picture) && file_exists($gallerypath . $s->picture))
		    {
			@delete_directory($gallerypath);
		    }
		    $s->delete();
		    $this->db->delete('catalog_categoryes', array('catalog_id' => $c));
		}
		redirect('cms/catalog');
	    }
	} else
	    redirect('cms/catalog');
    }

    function make_tmb()
    {
	if ($this->input->post('id'))
	{

	    $id = $this->input->post('id', TRUE);

	    $gallerypath = $this->config->item('path_for_uploads') . 'catalog/' . $id . '/';
	    @mkdir($gallerypath . '/tmb', 0777, TRUE);
	    @chmod($gallerypath . '/tmb', 0777);

	    $map = get_files($gallerypath);

	    $this->load->library('image_lib');
	    $config['image_library'] = 'GD2';
	    $config['maintain_ratio'] = TRUE;
	    $config['master_dim'] = 'height';


	    foreach ($map as $pic)
	    {
		if (!file_exists($gallerypath . 'tmb/' . $pic))
		{
		    $config['source_image'] = $gallerypath . $pic;
		    $config['new_image'] = $gallerypath . 'tmb/' . $pic;
		    $config['width'] = 150;
		    $config['height'] = 150;
		    $this->image_lib->initialize($config);
		    $sucsess = $this->image_lib->resize();
		    if (!$sucsess)
		    {
			$this->image_lib->display_errors('<p>', '</p>');
		    }
		}
	    }
	}
    }

}
