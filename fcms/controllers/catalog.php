<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Контроллер каталога.
 *
 * @author Denis Filonov <denis@filonov.biz>
 * @copyright (c) 2013, Denis Filonov.
 */
class Catalog extends CI_Controller
{

    function __construct()
    {
	parent::__construct();
    }

    /**
     * Функция для конвертаций из VirtueMart
     * #REFACTOR Удалить
     */
    function force_create_aliases()
    {
	// $this->load->helper('translit');

	/* // Создаём алиасы товара   
	  $catalog = new Catalog_orm();
	  $catalog->get_iterated();
	  foreach ($catalog as $item)
	  {
	  echo $item->title . br();
	  $item->alias = sanitize_title_with_translit($item->title);
	  $item->meta_description = $item->descriptionv;
	  $item->meta_title = $item->title;
	  $item->skip_validation()->save();
	  } */

	/* // Импорт категорий без создания древовидной структуры
	  $category = new Categoryes_orm();
	  $category->select_root(CATEGORYES_CATALOG);
	  $query = $this->db->get('dvf_vm_category');
	  $res = $query->result();

	  foreach ($res as $v)
	  {
	  $category->get_root();
	  $category->new_last_child();
	  $category->legacy_id = $v->category_id;
	  $category->title = $v->category_name;
	  $category->alias = sanitize_title_with_translit($v->category_name);
	  $category->description = $v->category_description;
	  $category->image = $v->category_full_image;
	  $category->show = TRUE;
	  $success = $category->save();
	  if (!$success)
	  {
	  $error = 'Ошибка сохранения.';
	  if (!($category->valid))
	  {
	  $error = $category->error->string;
	  }
	  die($error);
	  }
	  else
	  echo "Обработана категория: " . $v->category_name . br();
	  } */
    }

    /**
     * Страница каталога или категории.
     */
    function index()
    {
	$vis = new Visual_elements();
	$category = new Category();
	$parent_category = new Category();
	$category->select_root(CATEGORYES_CATALOG);
	$catalog = new Item();
	$data = $this->uri->segment_array();
	$uri_string = $this->uri->uri_string();
	$num_of_segments = $this->uri->total_segments();

	// Для паджинации
	$countstop = count($data);
	$page = 1;
	$url_seg = '';
	if ((int) $data[count($data)] > 0)
	{
	    $countstop = count($data) - 1;
	    $page = $data[count($data)];
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
	    { // Если категория существует, показываем содержимое категории.
		$parent_category->get_parent($category);
		if (($parent_category->alias == $data[$i - 1]) || ($data[$i - 1] == 'catalog'))
		{
		    if ($i == $countstop)
		    { // И тут проверяем всю цепочку, на примере бага вордпресса
			#REFACTOR Переписать на ORM. Он странно работает.
			$query = $this->db->get_where('catalog_categoryes', array('category_id' => $category->id));
			$res = $query->result_array();
			$inarray = array();
			foreach ($res as $r)
			{
			    $inarray[] = $r['catalog_id'];
			}
			# END REFACTOR

			$paginator = '';
			if (empty($inarray))
			{
			    $catalog = array();
			    $colors_arr = array();
			} else
			{
			    // Здесь для TG получить цвета.
			    $colors = new Items_color();
			    $colors_arr = array();

			    $colr = new Color();
			    foreach ($inarray as $value)
			    {
				$colors->where('item_id', $value)->get();
				$tmp_arr = array();
				foreach ($colors as $col)
				{
				    $colr->get_by_id($col->color_id);
				    $tmp_arr[] = $colr->number;
				}
				$colors_arr[$value] = $tmp_arr;
			    }

			    $catalog->where_in('id', $inarray)->order_by('order, created')->get_paged($page, $this->config->item('catalog_per_page'));
			    $paginator = $vis->paginator(
				    base_url($url_seg), $catalog->where_in('id', $inarray)->order_by('order, created')->count(), $countstop + 1, $this->config->item('catalog_per_page'));
			}

			$menu = new Menu_orm();
			$menu->get_where(array('content_type' => CONTENT_CATALOG_CATEGORY, 'content_id' => $category->id), 1);

			$data = template_base_tags() + array(
			    'meta_title' => $category->title,
			    'meta_keywords' => '',
			    'meta_description' => $this->config->item('site_title') . ' | Интернет-магазин',
			    'uri' => $uri_string,
			    'category' => $category->title,
			    'child_categoryes' => $category->get_all_childs(),
			    'content' => $catalog,
			    'content_colors' => $colors_arr,
			    'paginator' => $paginator,
			    'active_menu_id' => $menu->id,
			);
			$this->parser->parse($this->config->item('tplpath') . $this->config->item('skin') . '/catalog', $data);
			break;
		    }
		} else
		{
		    show_404();
		    break;
		}
	    } else
	    {
		// Страница товара.
		// Если не существует, то перейти к показу материала и прервать цикл, а там уже обработать 404
		$this->show_items($data);
		break;
	    }
	}

	if ($num_of_segments == 1)
	{
	    // Обрабатываем заглавную страницу каталога
	    $category->get_root();
	    $category_1st_lev = new Category();
	    $category_1st_lev->select_root(CATEGORYES_CATALOG);
	    $category_1st_lev->get_root();
	    $category_1st_lev->get_all_childs();

	    $menu = new Menu_orm();
	    $menu->get_where(array('content_type' => CONTENT_CATALOG), 1);

	    $data = template_base_tags() + array(
		'meta_title' => $this->config->item('site_title') . ' | Интернет-магазин',
		'meta_keywords' => '',
		'meta_description' => $this->config->item('site_title') . ' | Интернет-магазин',
		'content' => $catalog,
		'child_categoryes' => $category_1st_lev,
		'tree' => $category->dump_tree(array('title', 'id', 'alias', 'lft'), 'array', TRUE),
		'active_menu_id' => $menu->id,
	    );
	    $this->parser->parse($this->config->item('tplpath') . $this->config->item('skin') . '/catalog_tree', $data);
	}
    }

    /**
     * Показать элемент каталога.
     * @param array $data
     */
    private function show_items(array $data)
    {

	$catalog = new Item();
	$category = new Category();
	$catalog->get_by_alias(array_pop($data));
	//die($data[count($data)]);

	$category->get_by_alias($data[count($data)]);



	$url_seg = '';
	for ($i = 2; $i < count($data); $i++)
	{
	    $url_seg .= '/' . $data[$i];
	}

	if ($catalog->exists())
	{
	    $rew = new Items_review();
	    $rew->order_by('created')->limit(10)->where('show', TRUE)->get_by_items_id($catalog->id);
	    $icons = new Items_icon();
	    $icons->order_by('filename')->get_by_items_id($catalog->id);

	    $error = '';
	    if ($this->session->userdata('add_review_error'))
	    {
		$error = $this->session->userdata('add_review_error');
		$this->session->unset_userdata('add_review_error');
	    }

	    // Добываем аксессуары
	    $query1 = $this->db->get_where('items_accs', array('items_id' => $catalog->id));
	    $res1 = $query1->result_array();
	    $acc_checked = array();
	    foreach ($res1 as $achk)
	    {
		$acc_checked[$achk['acc_id']] = $achk['acc_id'];
	    }
	    $acc = new Item();
	    $acc->where_in('id', $acc_checked)->get();
	    $acc_cat = new Category();
	    $acc_cat->get_by_id($this->config->item('catalog_acc_category'));
	    $acc_category_url = base_url('catalog/' . $acc_cat->get_alias_path(CATEGORYES_CATALOG));

	    // Добываем «Так же покупают»
	    #REFACTOR — where_in → Join
	    $query2 = $this->db->get_where('items_also', array('items_id' => $catalog->id));
	    $res2 = $query2->result_array();
	    $also_checked = array();
	    foreach ($res2 as $al)
	    {
		$also_checked[$al['also_id']] = $al['also_id'];
	    }
	    $also = new Item();
	    $also->where_in('id', $also_checked)->get();

	    $also_paths = array();

	    foreach ($also as $al)
	    {
		$q = $this->db->get_where('catalog_categoryes', array('catalog_id' => $al->id));
		$cc = $q->row();
		//$cc->where('catalog_id',)->get();
		$also_cat = new Category($cc->category_id);
		$also_paths[$al->id] = $also_cat->get_tree_full_path($also_cat->id, CATEGORYES_CATALOG);
	    }
	    //debug_print($also_paths);
	    // Создать массив [id][path]
	    // $also_cat = new Category();
//	    $acc_cat->get_by_id($this->config->item('catalog_acc_category'));
//	    $acc_category_url = base_url('catalog/'.$acc_cat->get_alias_path(CATEGORYES_CATALOG));
//	    
	    // Показываем цвета

	    $query_ic = $this->db->select('color_id AS id, name, number')
		    ->from('items_colors')
		    ->where(array('item_id' => $catalog->id))
		    ->join('colors', 'colors.id=color_id')
		    ->distinct()
		    ->get();
	    $colors = $query_ic->result();

	    // Показываем картинки

	    $query_i = $this->db->select('filename, name, number, colors.id AS color_id')
		    ->from('items_images')
		    ->where(array('item_id' => $catalog->id))
		    ->join('colors', 'colors.id=items_images.color')
		    ->distinct()
		    ->get();
	    $i_images = $query_i->result();



	    $data = template_base_tags() + array(
		'error' => $error,
		'meta_title' => $catalog->meta_title,
		'meta_keywords' => $catalog->meta_keywords,
		'meta_description' => $catalog->meta_description,
		'item' => $catalog,
		'category' => $category,
		'reviews' => $rew,
		'icons' => $icons,
		'accs' => $acc,
		'colors' => $colors,
		'images' => $i_images,
		'acc_category_url' => $acc_category_url,
		'also' => $also,
		'also_paths' => $also_paths,
		'active_menu_id' => 0
		    
	    );
	    $this->parser->parse($this->config->item('tplpath') . $this->config->item('skin') . '/catalog_item', $data);
	} else
	{
	    show_404();
	}
    }

    /**
     * Добавление товара в корзину.
     */
    function cart_add()
    {
	if ($this->input->post('id'))
	{
	    $data = array(
		'id' => $this->input->post('id', TRUE),
		'qty' => (int) $this->input->post('qty', TRUE),
		'price' => $this->input->post('price', TRUE),
		'name' => $this->input->post('name', TRUE)
	    );
	    $this->cart->insert($data);
	}
	//echo $this->cart_block();
	redirect($this->input->post('url', TRUE));
    }

    /**
     * Обновление корзины
     */
    function cart_update()
    {
	if ($this->input->post('id'))
	{
	    $data = array(
		'rowid' => $this->input->post('id', TRUE),
		'qty' => (int) $this->input->post('qty', TRUE),
		'price' => $this->input->post('price', TRUE),
		'name' => $this->input->post('name', TRUE)
	    );
	    $this->cart->update($data);
	}
	echo $this->cart_block();
    }

    /**
     * Показывает корзину
     * @return string
     */
    function cart_block()
    {
	$data = template_base_tags();
	return $this->load->view($this->config->item('tplpath') . $this->config->item('skin') . '/block_cart_sidebar', $data, FALSE);
    }

    /**
     * Корзина, подтверждение заказа
     */
    function cart()
    {
	// Отказываемся от заказа, если нажата соотв. кнопка
	if ($this->input->post('reset'))
	{
	    unset($_POST);
	    $this->cart->destroy();
	    redirect('catalog/cart');
	}
	$order = new Orders_orm();
	if ($this->input->post() && $this->input->post('agree'))
	{

	    $order->name = $this->input->post('fio', TRUE);
	    $order->adress = $this->input->post('adress', TRUE);
	    $order->phone = $this->input->post('phone', TRUE);
	    $order->email = $this->input->post('email', TRUE);
	    $order->adress = $this->input->post('adress', TRUE);
	    $order->comment = $this->input->post('comment', TRUE);
	    $order->options = $this->input->post('optionsPay', TRUE);
	    $order->status = ORDER_NEW;
	    $order->total = $this->cart->format_number($this->cart->total());
	    // Чистим POST

	    unset($_POST['fio'], $_POST['adress'], $_POST['phone'], $_POST['email'], $_POST['comment'], $_POST['optionsPay'], $_POST['total'], $_POST['add']);

	    $sucsess = $order->save();
	    if (!$sucsess)
	    {
		$error = 'Ошибка сохранения.';
		if (!($order->valid))
		{
		    $error = $order->error->string;
		}
		$data = template_base_tags() + array(
		    'meta_title' => $this->config->item('site_title') . ' | Оформление заказа',
		    'meta_keywords' => '',
		    'meta_description' => $this->config->item('site_title') . ' | Оформление заказа',
		    'title' => 'Оформление заказа',
		    'order' => $order,
		    'error' => $error);
		$this->parser->parse($this->config->item('tplpath') . $this->config->item('skin') . '/catalog_cart', $data);
	    } else
	    {
		$oid = $order->id;
		#REFACTOR Здесь почему-то не срабатывает ORM
		//$o_items = new Orders_items_orm();
		//debug_print($_POST);
		// Создаём элементы заказа
		foreach ($_POST as $key => $value)
		{
		    /* $o_items->catalog_id = $value['id'];
		      $o_items->quantity = $value['qty'];
		      $o_items->orders_id = $oid;
		      $sucsess = $o_items->skip_validation->save(); */

		    $this->db->insert('orders_items', array(
			'orders_id' => $oid,
			'catalog_id' => $value['id'],
			'quantity' => $value['qty']
		    ));
		    /* if (!$sucsess)
		      {
		      $error = 'Неизвестная ошибка';
		      if (!($order->valid))
		      {
		      $error = $o_items->error->string;
		      }
		      die($error);
		      } */
		}

		// Чистим корзину
		unset($_POST);

		$this->cart->destroy();

		// Подтверждаем заказ
		$this->session->set_userdata(array('order_id' => $oid));

		redirect('catalog/order');
	    }
	} else
	{
	    $err = '';
	    if ($this->input->post() && !$this->input->post('agree'))
		$err = 'Вам нужно согласиться с условиями обслуживания, чтобы оформить заказ.';
	    $data = template_base_tags() + array(
		'meta_title' => $this->config->item('site_title') . ' | Оформление заказа',
		'meta_keywords' => '',
		'meta_description' => $this->config->item('site_title') . ' | Оформление заказа',
		'title' => 'Оформление заказа',
		'order' => $order,
		'error' => $err);
	    $this->parser->parse($this->config->item('tplpath') . $this->config->item('skin') . '/catalog_cart', $data);
	}
    }

    /**
     * Рассылка писем.
     * @param object $order
     * @param object $orderentryes
     */
    private function send_mail($order, $orderentryes)
    {
	$tpl = new Emailtpl();
	$this->load->library('email');
	$this->load->library('table');
	$config['wordwrap'] = TRUE;
	$config['mailtype'] = 'html';

	$summ = 0;
	$ttmpl = array('table_open' => '<table border="1" cellpadding="1" cellspacing="1">');
	$this->table->set_template($ttmpl);
	$this->table->set_heading('Название', 'Количество', 'Стоимость');

	foreach ($orderentryes as $oitem)
	{
	    $pr = $oitem->quantity * $oitem->price;
	    $summ += $pr;
	    $this->table->add_row($oitem->title, $oitem->quantity, $pr . ' руб.');
	}
	$str_items = $this->table->generate();

	// Отправка письма администратору
	$this->email->initialize($config);
	$tpl->get_by_alias('order-admin');
	if ($tpl->exists())
	{
	    $this->email->clear();
	    $msg = sprintf($tpl->text, $order->id, $summ, $str_items, anchor(base_url("cms/orders/edit/" . $order->id), "Заказ " . $order->id), $order->name, $order->adress, $order->phone, $order->comment);
	    $this->email->from($this->config->item('site_email'), $this->config->item('site_title'));
	    $this->email->to($this->config->item('admin_email'));
	    $this->email->subject($tpl->title);
	    $this->email->message($msg);
	    $this->email->send();
	}

	// Отправка письма пользователю
	$this->email->initialize($config);
	$tpl->get_by_alias('order');
	if ($tpl->exists())
	{
	    $this->email->clear();
	    $this->email->from($this->config->item('site_email'), $this->config->item('site_title'));
	    $this->email->to($order->email);
	    $this->email->subject($tpl->title);
	    $msg = sprintf($tpl->text, $order->id, $summ, $str_items);
	    $this->email->message($msg);
	    $this->email->send();
	}
    }

    /**
     * Подтверждение заказа и отсылка к системам оплаты
     */
    function order()
    {
	// Читаем номер заказа из сессии
	$order_id = $this->session->userdata('order_id');

	$this->session->unset_userdata('order_id');
	// Читаем заказ из базы
	$order = new Orders_orm();
	$order->get_by_id($order_id);
	// Формируем страницу подтверждения заказа налом или отправляем платить.
	$optionsPay = $order->options; //$r->optionsPay;
	#REFACTOR -> ORM
	$this->db->select('items.title AS title, items.price AS price, orders_items.quantity AS quantity')->from('items')->join('orders_items', 'orders_items.catalog_id = items.id')->where(array('orders_items.orders_id' => $order_id));
	$qitems = $this->db->get();
	$orderentryes = $qitems->result();
	switch ($optionsPay)
	{
	    case DELIVERY_CASH:
	    case DELIVERY_COURIER:
	    case DELIVERY_BANK:
		$this->send_mail($order, $orderentryes);
		// Благодарим
		$data = template_base_tags() +
			array(
			    'meta_title' => $this->config->item('site_title') . ' | Подтверждение и оплата',
			    'meta_keywords' => '',
			    'meta_description' => $this->config->item('site_title') . ' | Подтверждение и оплата',
			    'title' => 'Подтверждение и оплата',
			    'optionsPay' => $optionsPay,
			    'id' => $order_id,
			    'orderentryes' => $orderentryes
		);
		$this->parser->parse($this->config->item('tplpath') . $this->config->item('skin') . '/catalog_order', $data);
		break;
	    case DELIVERY_CARD:
		$this->send_mail($order, $orderentryes);
		// Благодарим и просим оплатить
		$data = template_base_tags() +
			array(
			    'meta_title' => $this->config->item('site_title') . ' | Подтверждение и оплата',
			    'meta_keywords' => '',
			    'meta_description' => $this->config->item('site_title') . ' | Подтверждение и оплата',
			    'title' => 'Подтверждение и оплата',
			    'optionsPay' => $optionsPay,
			    'id' => $order_id,
			    'orderentryes' => $orderentryes,
			    'email' => $r->email
		);
		$this->load->view($this->config->item('tplpath') . $this->config->item('skin') . '/catalog_order', $data);
		break;
	}
    }

    /**
     * Сохранение отзыва о товаре.
     * @param type $id
     */
    function add_review()
    {

	if ($this->input->post())
	{
	    $rew = new Items_review();
	    $rew->items_id = $this->input->post('item_id', TRUE);
	    $rew->name = $this->input->post('name', TRUE);
	    $rew->text = $this->input->post('text', TRUE);
	    $rew->rate = $this->input->post('rate', TRUE);
	    $rew->show = FALSE;
	    $captcha = strtolower(trim($this->input->post('captcha'))); // то что пришло из формы
	    $word = $this->session->userdata('word'); // то что было сгенерировано
	    $this->session->unset_userdata('word');
	    if ($word == $captcha)
	    {
		$sucsess = $rew->save();
		if (!$sucsess)
		{
		    $error = 'Ошибка сохранения.';
		    if (!($rew->valid))
		    {
			$error = $rew->error->string;
		    }
		    $this->session->set_userdata('add_review_error', $error);
		}
	    } else
	    {
		$error = "Пожалуйста, правильно введите код проверки.";
		$this->session->set_userdata('add_review_error', $error);
	    }
	    redirect($this->input->post('url'));
	}
    }

}
