<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Контроллер админки списка учителей для liberum-center.ru
 * @author Denis Filonov <denis@filonov.biz>
 * @copyright (c) 2013, Denis Filonov
 */
class Testing extends CI_Controller
{

    function __construct()
    {
	parent::__construct();
	is_root();
    }

    function index()
    {
	$test = new Test();

	$data = template_base_tags() +
		array('content' => $test->get());
	$this->parser->parse($this->config->item('tplpath') . 'cms/testing', $data);
    }

    /**
     * Добавление новой страницы.
     */
    function add()
    {
	$test = new Test();
	$test->title = 'Без названия';
	$test->skip_validation()->save();
	redirect('cms/testing/edit/' . $test->id);
    }

    /**
     * Редактировать тест.
     * @param integer $id
     */
    function edit($id = FALSE)
    {
	$this->load->helper('translit');
	$test = new Test($id);
	$tests_page = new Tests_page();
	$tests_page->get_by_tests_id($id);
	$questions = new Tests_question();
	$questions->get_by_tests_id($id);
	$answers = new Tests_answer();
	$error = '';
// Обработка результатов
	if ($this->input->post())
	{
	    $test->title = $this->input->post('title', TRUE);
	    $alias = $this->input->post('alias', TRUE);
	    if (empty($alias))
		$test->alias = sanitize_title_with_translit($this->input->post('title', TRUE));
	    else
		$test->alias = $this->input->post('alias', TRUE);
	    $test->description = $this->input->post('description');
	    $success = $test->save();
	    if (!$success)
	    {
		$error = 'Ошибка сохранения.';
		if (!($test->valid))
		{
		    $error = $test->error->string;
		}
	    }
	}
// Вывод шаблона
	$data = template_base_tags() +
		array(
		    'item' => $test,
		    'pages' => $tests_page,
		    'error' => $error,
		    'questions' => $questions,
		    'answers' => $answers,
	);
	$this->parser->parse($this->config->item('tplpath') . 'cms/testing_entry', $data);
    }

    function delete()
    {
	/*if ($this->input->post('check'))
	{
	    $check = $_POST['check'];
	    if ($check)
	    {
		foreach ($check as $c)
		{
		    $test = new Test($c);
		    $page = new Tests_page();
		    $page->where('tests_id',$c)->get();
		    
		    $question = new Tests_question();
		    $question->get_by_tests_pages_id($page->id);
		    $answer = new Tests_answer();
		    $answer->get_by_tests_questions_id($question->id);
		    
		    $answer->delete_all();
		    $question->delete_all();
		    $page->delete_all();
		    $test->delete_all();
		}
		redirect('cms/testing');
	    }
	}
	else*/
	    redirect('cms/testing');
    }

    function add_page($tests_id)
    {
	$tests_page = new Tests_page();
	$tests_page->tests_id = $tests_id;
	$tests_page->title = 'Без имени';
	$success = $tests_page->save();
	if (!$success)
	{
	    $error = 'Ошибка сохранения.';
	    if (!($tests_page->valid))
	    {
		$error = $tests_page->error->string;
	    }
	}
	redirect('cms/testing/edit/' . $tests_id . '#pages');
    }

    function edit_page()
    {
	if ($this->input->post())
	{
	    $page_id = $this->input->post('page_id', TRUE);
	    $tests_page = new Tests_page($page_id);
	    //$tests_page->tests_id = $this->input->post('tests_id', TRUE);
	    $tests_page->title = $this->input->post('title', TRUE);
	    $tests_page->number = $this->input->post('number', TRUE);
	    $tests_page->description = $this->input->post('description');
	    $tests_page->perfectly = $this->input->post('perfectly', TRUE);
	    $tests_page->perfectly_description = $this->input->post('perfectly_description', TRUE);
	    $tests_page->passably = $this->input->post('passably', TRUE);
	    $tests_page->passably_description = $this->input->post('passably_description', TRUE);
	    $tests_page->poorly = $this->input->post('poorly', TRUE);
	    $tests_page->poorly_description = $this->input->post('poorly_description', TRUE);
	    $success = $tests_page->save();
	    if (!$success)
	    {
		$error = 'Ошибка сохранения.';
		if (!($tests_page->valid))
		{
		    $error = $tests_page->error->string;
		}
	    }
	    redirect('cms/testing/edit/' . $tests_page->tests_id . '#pages');
	}
    }

    function ajax_add_question()
    {
	$error = '';
	$page_id = '';
	if ($this->input->post())
	{
	    $page_id = $this->input->post('page_id', TRUE);
	    $question = new Tests_question();
	    $question->tests_pages_id = $page_id;
	    $question->title = $this->input->post('title', TRUE);
	    $question->number = $this->input->post('number', TRUE);
	    $success = $question->save();
	    if (!$success)
	    {
		$error = 'Ошибка сохранения.';
		if (!($question->valid))
		{
		    $error = $question->error->string;
		}
	    } else
	    {
		// Здесь сохраняем вопросы

		for ($i = 1; $i <= 4; $i++)
		{
		    $answer = new Tests_answer();
		    $answer->number = $i;
		    $answer->tests_questions_id = $question->id;
		    $answer->title = $this->input->post('a' . $i, TRUE);
		    $answer->weight = $this->input->post('b' . $i, TRUE);
		    $answer->save();
		}
	    }
	}

	$questions = new Tests_question();
	$questions->order_by('number')->get_by_tests_pages_id($page_id);
	$data = template_base_tags() +
		array(
		    'error' => $error,
		    'questions' => $questions,
		    'page_id' => $page_id
	);
	$this->parser->parse($this->config->item('tplpath') . 'cms/testing_ajax_questions', $data);
    }

    function ajax_get_question()
    {
	$arr = array();
	if ($this->input->post('id'))
	{
	    $id = $this->input->post('id');
	    $question = new Tests_question($id);
	    $a = array();
	    $b = array();
	    for ($i = 1; $i <= 4; $i++)
	    {
		$answer = new Tests_answer();
		$answer->where(array('tests_questions_id' => $id, 'number' => $i))->get();
		$a[$i] = $answer->title;
		$b[$i] = $answer->weight;
	    }

	    $arr = array(
		'question_id' => $question->id,
		'number' => $question->number,
		'title' => $question->title,
		'a1' => $a[1],
		'a2' => $a[2],
		'a3' => $a[3],
		'a4' => $a[4],
		'b1' => $b[1],
		'b2' => $b[2],
		'b3' => $b[3],
		'b4' => $b[4],
	    );
	}
	echo json_encode($arr);
    }

    function ajax_edit_question()
    {
	$error = '';
	$page_id = '';
	if ($this->input->post())
	{
	    $page_id = $this->input->post('page_id', TRUE);
	    $q_id = $this->input->post('question_id', TRUE);
	    $question = new Tests_question($q_id);
	    $question->tests_pages_id = $page_id;
	    $question->title = $this->input->post('title', TRUE);
	    $question->number = $this->input->post('number', TRUE);
	    $success = $question->save();
	    if (!$success)
	    {
		$error = 'Ошибка сохранения.';
		if (!($question->valid))
		{
		    $error = $question->error->string;
		}
	    } else
	    {
		// Здесь удаляем вопросы


		$answer = new Tests_answer();
		$answer->where('tests_questions_id', $q_id)->get();
		$answer->delete_all();


		// Здесь сохраняем вопросы

		for ($i = 1; $i <= 4; $i++)
		{
		    $answer = new Tests_answer();
		    $answer->number = $i;
		    $answer->tests_questions_id = $q_id;
		    $answer->title = $this->input->post('a' . $i, TRUE);
		    $answer->weight = $this->input->post('b' . $i, TRUE);
		    $answer->save();
		}
	    }
	}

	$questions = new Tests_question();
	$questions->order_by('number')->get_by_tests_pages_id($page_id);
	$data = template_base_tags() +
		array(
		    'error' => $error,
		    'questions' => $questions,
		    'page_id' => $page_id
	);
	$this->parser->parse($this->config->item('tplpath') . 'cms/testing_ajax_questions', $data);
    }

    function ajax_delete_question()
    {
	$error = '';
	$page_id = '';
	if ($this->input->post())
	{
	    $page_id = $this->input->post('page_id', TRUE);
	    $q_id = $this->input->post('question_id', TRUE);

	    // Сначала удаляем ответы, принадлежащие вопросу.
	    $answer = new Tests_answer();
	    $answer->where('tests_questions_id', $q_id)->get();
	    $answer->delete_all();

	    // Потом удаляем вопрос.

	    $question = new Tests_question($q_id);
	    $question->delete();
	}

	$questions = new Tests_question();
	$questions->order_by('number')->get_by_tests_pages_id($page_id);
	$data = template_base_tags() +
		array(
		    'error' => $error,
		    'questions' => $questions,
		    'page_id' => $page_id
	);
	$this->parser->parse($this->config->item('tplpath') . 'cms/testing_ajax_questions', $data);
    }

}
