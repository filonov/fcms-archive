<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Контроллер вывода курсов.
 *
 * @author Denis Filonov <denis@filonov.biz>
 * @copyright (c) 2013, Denis Filonov.
 */
class Courses extends CI_Controller
{

    function __construct()
    {
	parent::__construct();
    }

    function index($lang = 'italiano')
    {
	$levels = new Levels_orm();
	$formats = new Formats_orm();
	$groups = new Group();
	$groups_s = new Group();
	$c_level = array();
	$c_format = array();
	$lng = ITALIAN;

	$page_title = 'Курсы итальянского языка в Москве';

	if ($lang == 'italiano')
	{
	    $groups->where('language', ITALIAN);
	    $page_title = 'Курсы итальянского языка в Москве';
	} elseif ($lang == 'espanol')
	{
	    $lng = SPAIN;
	    $groups->where('language', SPAIN);
	    $page_title = 'Курсы испанского языка в Москве';
	} else
	{
	    show_404();
	    exit();
	}

	// Если отмечены галки фильтра.
	if ($this->input->post('format') && $this->input->post('level'))
	{
	    $post = $this->input->post(NULL, TRUE);
	    // Для стандартных групп
	    $this->db->select('groups.id as gid, 
                groups.level as level,
                groups.title_for_cources as title_for_cources,
                statuses.status_text as status_text');
	    $groups->where('type', GROUP_STANDART);
	    if (isset($post['format']))
	    {
		$c_format = $post['format'];
		$this->db->where_in('groups.format', $c_format);
	    }
	    if (isset($post['level']))
	    {
		$c_level = $post['level'];
		$this->db->where_in('groups.level', $c_level);
	    }
	    $this->db->from('groups')
		    ->join('statuses', 'groups.status = statuses.id')
		    ->where('groups.language', $lng)
		    ->where('groups.type', GROUP_STANDART)
		    ->order_by('statuses.order, groups.date');
	    $query1 = $this->db->get();
	    $groups = $query1->result();


	    // Для спецкурсов
	    $this->db->select('groups.id as gid,
                groups.title_for_cources as title_for_cources,
                specials_levels.id_levels as glevel, 
                specials.description as sdescription, 
                specials.title as stitle');
	    if (isset($post['format']))
	    {
		$c_format = $post['format'];
		$this->db->where_in('groups.format', $c_format);
	    }
	    if (isset($post['level']))
	    {
		$c_level = $post['level'];
		$this->db->where_in('specials_levels.id_levels', $c_level);
	    }
	    $this->db->from('specials_levels')
		    ->join('specials', 'specials.id = specials_levels.id_specials')
		    //->join('statuses', 'group.status = statuses.id')
		    ->join('groups', 'groups.special = specials.id')
		    ->where('groups.language', $lng)
		    ->where('groups.type', GROUP_SPECIAL)
		    ->order_by('specials.title, groups.id'); //, statuses.order, groups.date
	    $query = $this->db->get();
	    //echo $this->db->last_query();
	    $groups_s = $query->result();
	    $data = template_base_tags() +
		    array(
			'groups' => $groups,
			'groups_s' => $groups_s,
			'levels' => $levels->get(),
			'chk_levels' => $c_level,
			'chk_formats' => $c_format,
			'formats' => $formats->get(),
			'language' => $page_title,
			'meta_title' => $page_title,
			'meta_description' => $page_title,
			'meta_keywords' => $page_title,
			'lng_id' => $lng
	    );
	    $this->parser->parse($this->config->item('tplpath') . $this->config->item('skin') . '/courses', $data);
	} else
	{
	    // По-умолчанию, если галки фильтра не отмечены.
	    $levels->get();
	    $formats->get();
	    foreach ($levels as $level)
	    {
		$c_level[$level->id] = $level->id;
	    }
	    foreach ($formats as $format)
	    {
		$c_format[$format->id] = $format->id;
	    }
	    $this->db->select('groups.id as gid, 
                groups.title_for_cources as title_for_cources,
                groups.level as level')
		    ->from('groups')
		    ->join('statuses', 'groups.status = statuses.id')
		    ->where('groups.language', $lng)
		    ->where('groups.type', GROUP_STANDART)
		    ->order_by('statuses.order, groups.date');
	    $query1 = $this->db->get();
	    $groups = $query1->result();

	    // Спецкурсы
	    $this->db->select('
                groups.id as gid, 
                specials_levels.id_levels as glevel, 
                specials.description as sdescription, 
                specials.title as stitle,   
                groups.title_for_cources as title_for_cources,
                groups.days as days,
                groups.time as time')
		    ->from('specials_levels')
		    ->join('specials', 'specials.id = specials_levels.id_specials')
		    ->join('groups', 'groups.special = specials.id')
		    ->where('groups.language', $lng)
		    ->where('groups.type', GROUP_SPECIAL)
		    ->order_by('specials.title, groups.id');
	    $query = $this->db->get();
	    $groups_s = $query->result();
	    $data = template_base_tags() +
		    array(
			'groups' => $groups,
			'groups_s' => $groups_s,
			'levels' => $levels->get(),
			'chk_levels' => $c_level,
			'chk_formats' => $c_format,
			'formats' => $formats->get(),
			'language' => $page_title,
			'meta_title' => $page_title,
			'meta_description' => $page_title,
			'meta_keywords' => $page_title,
			'lng_id' => $lng
	    );
	    $this->parser->parse($this->config->item('tplpath') . $this->config->item('skin') . '/courses', $data);
	}
    }

    private function send_mail($param /* FORM */)
    {
	$tpl = new Emailtpl();
	$this->load->library('email');
	$config['wordwrap'] = TRUE;
	$config['mailtype'] = 'html';
	$config['charset'] = 'utf-8';


	// Отправка письма администратору
	$this->email->initialize($config);
	$tpl->get_by_alias('cources-admin');
	if ($tpl->exists())
	{
	    // Выцепить данные из сессии
	    $this->table->set_template(array('table_open' => '<table border="1" cellpadding="4" cellspacing="0">'));
	    $this->table->add_row('Имя', $param->name);
	    $this->table->add_row('Дата и время заполнения:', $param->created);
	    $this->table->add_row('Телефон', $param->phone);
	    $this->table->add_row('E-mail', $param->email);

	    $group = new Group($param->group_id);
	    $gr_link = anchor('courses/group/' . $param->group_id, $group->title_for_cources);

	    $this->table->add_row('Группа', $gr_link);
	    $this->table->add_row('Комментарий', $param->exp);
	    $tab_client = $this->table->generate();

	    //debug_print($this->session->all_userdata());

	    $this->table->clear();
	    $this->table->set_template(array('table_open' => '<table border="1" cellpadding="4" cellspacing="0">'));
	    $this->table->set_heading('Вопрос', 'Ответ', 'Вес');



	    /*	     * **************************
	     * 
	     */


	    $gr = new Group($param->group_id);
	    $page = new Tests_page();
	    $pages_num = $page->where('tests_id', $gr->tests_id)->count();

	    $this->table->set_heading(array('Вопрос', 'Номер ответа', 'Вес'));


	    $page->where('tests_id', $gr->tests_id)->order_by('number')->get();

	    foreach ($page as $p)
	    {
		$userdata = new Tests_Userdata();
		$userdata->where(array('session_id' => $this->session->userdata('session_id'), 'page_id' => $p->id))
			->order_by('question_id')->get();
		foreach ($userdata as $u)
		{
		    $question = new Tests_question($u->question_id);
		    $answer = new Tests_answer($u->answer_id);
		    $this->table->add_row($question->number . ') ' . $question->title, $answer->number . ') ' . $answer->title, $u->weight);
		}
	    }
	    $res = br() . $this->session->userdata('test_res') . br() . $this->table->generate();
	    //debug_print($this->session->all_userdata());
	    //die($res);
	    // Обновление полей
	    $userdata = new Tests_Userdata();
	    $userdata->where(array('session_id' => $this->session->userdata('session_id')))->update('forms_id', $param->id);


	    /*
	     * 
	     * ************************** */




	    $msg = sprintf($tpl->text, $tab_client, $res, anchor(base_url("cms/forms/edit/" . $param->id), "Подробнее"));
	    $this->email->clear();
	    $this->email->from($this->config->item('site_email'), $this->config->item('site_title'));
	    $this->email->to($this->config->item('admin_email'));
	    $this->email->subject($tpl->title);
	    $this->email->message($msg);
	    if (!$this->email->send())
	    {
		
	    }
		    
	    $this->session->sess_destroy();
	    $this->session->sess_create();
	}

	// Отправка письма пользователю
	$this->email->initialize($config);
	$tpl->get_by_alias('courses');
	if ($tpl->exists())
	{
	    $this->email->clear();
	    $this->email->from($this->config->item('site_email'), $this->config->item('site_title'));
	    $this->email->to($param->email);
	    $this->email->subject($tpl->title);
	    $this->email->message($tpl->text);
	    $this->email->send();
	}
    }

    private function test_finished()
    {
	// Генерация финальной таблицы
	if ($this->session->userdata('test_finished'))
	{
	    $answer = $this->session->userdata('test_res');
	    //$this->session->sess_destroy();
	    return $answer;
	}
    }

    /**
     * Страница группы
     * @param type $id
     */
    function group($id = FALSE)
    {
	if ($id == FALSE)
	{
	    show_404();
	    exit();
	}

	$error = '';
	
	$this->session->unset_userdata('group_number');
	$this->session->unset_userdata('form_id');

	$forms = new Form();
	if ($this->input->post())
	{
	    $forms->group_id = $id;
	    $forms->name = $this->input->post('name', TRUE);
	    $forms->email = $this->input->post('email', TRUE);
	    $forms->phone = $this->input->post('phone', TRUE);
	    $forms->level = $this->input->post('level', TRUE);
	    $forms->exp = $this->input->post('exp', TRUE);

	    if (ENVIRONMENT != 'development')
	    {
		$captcha = strtolower(trim($this->input->post('captcha'))); // то что пришло с формы
		$word = $this->session->userdata('word'); // то что было сгенерировано
		$this->session->unset_userdata('word');
		if ($word == $captcha)
		{
		    $sucsess = $forms->save();
		    if (!$sucsess)
		    {
			$error = 'Ошибка сохранения.';
			if (!($forms->valid))
			{
			    $error = $forms->error->string;
			}
		    } else
		    {
			/// Проверка на наличие теста для группы. Если есть тест, 
			// то запомнить
			$gr = new Group($id);
			if ($gr->tests_id != 0)
			{
			    // Запомнить ID формы
			    $this->session->set_userdata('form_id', $forms->id);
			    $tests = new Test($gr->tests_id);
			    redirect('tests/' . $tests->alias);
			} else
			{
			    $this->send_mail($forms);
			    $tpl = new Modules_orm();
			    $tpl->where(array('alias' => 'courses'))->get();
			    $error = $tpl->text;
			}
		    }
		} else
		{
		    $error = "Пожалуйста, правильно введите код проверки.";
		}
	    } else
	    {
		// Для тестирования
		$sucsess = $forms->save();
		if (!$sucsess)
		{
		    $error = 'Ошибка сохранения.';
		    if (!($forms->valid))
		    {
			$error = $forms->error->string;
		    }
		} else
		{
		        // Проверка на наличие теста для группы. Если есть тест, 
			// то запомнить
			$gr = new Group($id);
			if ($gr->tests_id != 0)
			{
			    // Запомнить ID формы
			    $this->session->set_userdata('form_id', $forms->id);
			    $this->session->set_userdata('group_number', $id);
			    $tests = new Test($gr->tests_id);
			    redirect('tests/' . $tests->alias);
			} else
			{
			    $this->session->unset_userdata('group_number');
			    $this->session->unset_userdata('form_id');
			    $this->send_mail($forms);
			    $tpl = new Modules_orm();
			    $tpl->where(array('alias' => 'courses'))->get();
			    $error = $tpl->text;
			}
		}
	    }
	}

	$groups = new Group();
	$levels = new Levels_orm();
	$programs = new Programs_orm();
	$textbooks = new Textbook();
	$statuses = new Statuses_orm();
	$teachers = new Teacher();
	$durations = new Durations_orm();
	$prices = new Prices_orm();
	$tests = new Test(); //new Tests_orm();
	$specials = new Specials_orm();
	$groups->get_by_id($id);
	$groups->textbook->get();

	//$this->session->set_userdata('group_number', $id);

	$test_out = $this->test_finished();

	$data = template_base_tags() + array(
	    'error' => $error,
	    'group' => $groups,
	    'levels' => $levels->get_by_id($groups->level),
	    'program' => $programs->get_by_id($groups->program),
	    'textbook' => $groups->textbook, //$textbooks->get_by_id($groups->textbook_old),
	    'status' => $statuses->get_by_id($groups->status),
	    'teacher' => $teachers->get_by_id($groups->teacher),
	    'duration' => $durations->get_by_id($groups->duration),
	    'price' => $prices->get_by_id($groups->price),
	    'special' => $specials->get_by_id($groups->special),
	    'test' => $tests->get_by_id($groups->tests_id),
	    'test_out' => $test_out,
	    'fdata' => $forms,
	    'meta_title' => $groups->title,
	    'meta_description' => $groups->title,
	    'meta_keywords' => ''
	);
	$this->parser->parse($this->config->item('tplpath') . $this->config->item('skin') . '/group', $data);
    }

}

