<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Отображение теста.
 *
 * @copyright (c) 2013, Denis Filonov
 */
class Tests extends CI_Controller
{

    function __construct()
    {
	parent::__construct();
    }

    function index()
    {
	$tests = new Test();
	$data = template_base_tags() +
		array(
		    'meta_title' => 'Тесты',
		    'meta_description' => '',
		    'meta_keywords' => '',
		    'content' => $tests->get_paged()
	);
	$this->parser->parse($this->config->item('tplpath') . $this->config->item('skin') . '/' . 'tests', $data);
    }

    function test($alias, $page = 1)
    {
	// Находить по алиасу.


	$test = new Test();
	$test->get_by_alias($alias);

	if (!$test->exists())
	{
	    show_404();
	    die();
	}

	$id = $test->id;


	$pages = new Tests_page();
	$pages->order_by('number, id')->where(array('tests_id' => $id, 'number' => $page))->get();

	$questions = new Tests_question();
	$questions->order_by('number')->get_by_tests_pages_id($pages->id);

	$a_id = array();
	foreach ($questions as $q)
	{
	    $a_id[] = $q->id;
	}

	$answers = new Tests_answer();
	$answers->order_by('number')->where_in('tests_questions_id', $a_id)->get();

	$data = template_base_tags() +
		array(
		    'test' => $test,
		    'page' => $pages,
		    'questions' => $questions,
		    'answers' => $answers,
		    'meta_title' => $test->title,
		    'meta_description' => '',
		    'meta_keywords' => ''
	);
	$this->parser->parse($this->config->item('tplpath') . $this->config->item('skin') . '/' . 'tests_item', $data);
    }

    private function send_mail($param)
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
	    $this->table->set_template(array('table_open' => '<table border="1" cellpadding="4" cellspacing="0">'));
	    $this->table->add_row('Имя', $param->name);
	    $this->table->add_row('Дата и время заполнения:', $param->created);
	    $this->table->add_row('Телефон', $param->phone);
	    $this->table->add_row('E-mail', $param->email);

	    if ($param->group_id > 0)
	    {
		$group = new Group($param->group_id);
		$gr_link = anchor('courses/group/' . $param->group_id, $group->title_for_cources);
		$this->table->add_row('Группа', $gr_link);
	    }
	    $this->table->add_row('Комментарий', $param->exp);
	    $tab_client = $this->table->generate();

	    $this->table->clear();
	    $this->table->set_template(array('table_open' => '<table border="1" cellpadding="4" cellspacing="0">'));
	    $this->table->set_heading('Вопрос', 'Ответ', 'Вес');

	    /*	     * **************************
	     * 
	     */
	    $test_id = $param->field01;
	    if ($param->group_id > 0)
	    {
		$gr = new Group($param->group_id);
		$test_id = $gr->tests_id;
	    }
	    
	    $page = new Tests_page();
	    $pages_num = $page->where('tests_id', $test_id)->count();

	    $this->table->set_heading(array('Вопрос', 'Номер ответа', 'Вес'));


	    $page->where('tests_id', $test_id)->order_by('number')->get();

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
	    $param->exp = $param->exp . br() . $res;
	    $param->skip_validation()->save();
	    

	    $msg = sprintf($tpl->text, $tab_client, $res, anchor(base_url("cms/forms/edit/" . $param->id), "Подробнее"));
	    $this->email->clear();
	    $this->email->from($this->config->item('site_email'), $this->config->item('site_title'));
	    $this->email->to($this->config->item('admin_email'));
	    $this->email->subject($tpl->title);
	    $this->email->message($msg);
	    $this->email->send();
	    //$this->session->sess_destroy();
	    //$this->session->sess_create();
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

    private function answer_end($test, $out)
    {
	$this->session->set_userdata('test_res', $out);
	// Если пришёл со страницы группы
	if ($this->session->userdata('group_number') > 0)
	{
	    $out .= br() . anchor('courses/group/' . $this->session->userdata('group_number'), 'Вернуться к описанию группы');
	    $this->session->set_userdata('test_finished', TRUE);
	    // И вот здесь отправить админу письмо, если в сессии есть form_id
	    if ($this->session->userdata('form_id'))
	    {
		$forms = new Form($this->session->userdata('form_id'));
		//$this->session->unset_userdata('form_id');
		$this->session->unset_userdata('group_number');
	        $this->session->unset_userdata('form_id');
		$this->send_mail($forms);
	    }
	} else // Если пришёл не со страницы группы
	{
	    if ($this->session->userdata('nogroup_form_created'))
	    {
		$form = new Form();
		$form->get_by_created($this->session->userdata('nogroup_form_created'));
		$this->session->unset_userdata('nogroup_form_created');
		$this->send_mail($form);
	    }
	    if ($test->language == ITALIAN)
		$out .= br() . anchor('courses/italiano/', 'Вернуться к расписанию.');
	    if ($test->language == SPAIN)
		$out .= br() . anchor('courses/espanol/', 'Вернуться к расписанию.');
	}
	$this->session->unset_userdata('test_finished');
	return $out;
    }

    /**
     * Функция проверки ответа и предложения следующей страницы.
     * Сохранение в сессию всех возможных ответов для последующей пересылки.
     */
    function answer()
    {
	if ($this->input->post())
	{


	    $out = '';
	    $summ = 0; // Сумма баллов страницы.

	    $test_id = $this->input->post('test_id');
	    $page_id = $this->input->post('page_id');

	    // Здесь прочитать и сохранить данные пользователя.
	    if ($this->input->post('name'))
	    {
		$t_userdata = new Form();
		$t_userdata->name = $this->input->post('name', true);
		$t_userdata->email = $this->input->post('email', true);
		$t_userdata->phone = $this->input->post('phone', true);
		$t_userdata->session_id = $this->session->userdata('session_id');
		$t_userdata->group_id = 0;
		$t_userdata->level = 'Тест';
		$t_userdata->field01 = $test_id; // Сюда пишем номер теста.
		$t_userdata->skip_validation()->save_as_new();
		$this->session->set_userdata('nogroup_form_created',$t_userdata->created);
	    }


	    $test = new Test($test_id);
	    $page = new Tests_page($page_id);

	    $answers = new Tests_answer();
	    $questions = new Tests_question();
	    // Количество вопросов страницы
	    $questions_num = $questions->where('tests_pages_id', $page_id)->count();
	    $questions->where('tests_pages_id', $page_id)->order_by('number')->get();

	    // Зачистка от старых вопросов этой страницы, если они уже были.
	    $userdataс = new Tests_Userdata();
	    $userdataс->where(array('session_id' => $this->session->userdata('session_id'), 'page_id' => $page_id))->get();
	    $userdataс->delete_all();

	    foreach ($questions as $q)
	    {
		if ($this->input->post('answer-' . $q->id))
		{
		    $answers_ids = $this->input->post('answer-' . $q->id); // Массив с постами

		    foreach ($answers_ids as $ans)
		    {
			$answers->get_by_id($ans);
			// Добавление в базу данных.
			$userdata = new Tests_Userdata();

			// Проверка на существование
			//$this->db->where(array('session_id' => $this->session->userdata('session_id'), 'page_id' => $page_id))->get();
			//$this->db->where(array('session_id' => $this->session->userdata('session_id'), 'page_id' => $page_id))->delete('tests_userdata');
			$userdata->session_id = $this->session->userdata('session_id');
			$userdata->page_id = $page_id;
			$userdata->question_id = $q->id;
			$userdata->answer_id = $ans;
			$userdata->weight = $answers->weight;
			$userdata->skip_validation()->save();
			//
			$summ += $answers->weight;
		    }
		}
	    }


	    /*	     * ****************************************************************
	     *  Вывод результатов за предыдущую страницу и за текущую.
	     */
	    // Получить количество страниц.
	    $page_c = new Tests_page();
	    $page_num = $page_c->where('tests_id', $test_id)->count();
	    $page_c->where('tests_id', $test_id)->order_by('number')->get();
	    $table_head = array();
	    $table_row = array();

	    foreach ($page_c as $pg)
	    {
		$table_head[] = $pg->title;
		if ($pg->number != $page->number)
		{
		    $userdata = new Tests_Userdata();
		    $userdata->select_sum('weight', 'sw')->
			    where(array('page_id' => $pg->number, 'session_id' => $this->session->userdata('session_id')))->
			    get();
//		    debug_print($userdata->select_sum('weight', 'sw')->
//			    where(array('page_id' => $pg->number, 'session_id' => $this->session->userdata('session_id')))->get_sql());
		    $q = new Tests_question();
		    $table_row[] = $userdata->sw;
		} else
		    $table_row[] = $summ;
	    }

	    $this->load->library('table');
	    $this->table->set_heading($table_head);
	    $this->table->add_row($table_row);
	    $this->table->set_template(array('table_open' => '<table class="table table-condensed table-bordered">'));
	    $out.=$this->table->generate();


	    // Проверка на плохо 
	    if ($summ >= $page->perfectly)
	    {
		$out .= $page->perfectly_description;
		if ($page->number < $page_num)
		    $out .= br() . anchor('tests/' . $test->alias . '/' . ((int) $page->number + 1), 'Следующая страница теста');
		else
		{
		    $out = $this->answer_end($test, $out);
		}
	    }

	    if (($summ >= $page->passably) && ($summ < $page->perfectly))
	    {
		$out .= $page->passably_description;

		$out = $this->answer_end($test, $out);
	    }

	    if ($summ < $page->passably)
	    {
		$out .= $page->poorly_description;
		$this->session->set_userdata('test_res', $out);

		$out = $this->answer_end($test, $out);
		$this->session->set_userdata('test_finished', TRUE);
	    }

	    $data = template_base_tags() +
		    array(
			'error' => '',
			'test' => $test,
			'page' => $page,
			'text' => $out,
			'meta_title' => $test->title,
			'meta_description' => '',
			'meta_keywords' => ''
	    );
	    $this->parser->parse($this->config->item('tplpath') . $this->config->item('skin') . '/' . 'tests_answer', $data);
	}
    }

}
