<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Контроллер админки групп
 *
 * @author DVF
 */
class Groups extends CI_Controller
{

    function __construct()
    {
	parent::__construct();
	is_root();
    }

    /**
     * Таблица групп
     * @param string $category 
     */
    /* function index()
      {
      $gr = new Group();
      $levels = new Levels_orm();
      $sp = new Specials_orm();
      $pr = new Programs_orm();
      $t = new Teacher();
      $textbooks = new Textbook();
      $status = new Statuses_orm();


      $q = $this->db->select('*')
      ->join('statuses', 'groups.status = statuses.id')
      ->order_by('groups.date')
      ->get('groups');
      $res = $q->result();


      $data = template_base_tags() + array(
      'groups' => $gr->get(),
      'levels' => $levels->get(),
      'specials' => $sp->get(),
      'programs' => $pr->get(),
      'textbooks' => $textbooks->get(),
      'status' => $status->get(),
      'teachers' => $t->get()
      );
      $this->parser->parse($this->config->item('tplpath') . 'cms/groups', $data);
      } */

    function index($lang = 'italiano')
    {
	#REFACTOR всю функцию следует переписать на ORM, но она тогда будет медленнее работать.
	$levels = new Levels_orm();
	$formats = new Formats_orm();
	$groups = new Group();
	$groups_s = new Group();
	$c_level = array();
	$c_format = array();
	$lng = ITALIAN;

	$page_title = 'Итальянский язык';

	if ($lang == 'italiano')
	{
	    $groups->where('language', ITALIAN);
	    $page_title = 'Итальянский язык';
	} elseif ($lang == 'espanol')
	{
	    $lng = SPAIN;
	    $groups->where('language', SPAIN);
	    $page_title = 'Испанский язык';
	} else
	{
	    show_404();
	    exit();
	}

	if ($this->input->post('format') && $this->input->post('level'))
	{
	    $post = $this->input->post(NULL, TRUE);


	    // Для стандартных групп

	    $this->db->select('groups.id as gid, 
                groups.title as gtitle, 
                groups.date as date,
                groups.level as level,
                groups.created as created,
                groups.updated as updated,
                teachers.title_short as title_short,
                groups.days as days,
                groups.time as time,
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
	    //$groups->get();

	    $this->db->from('groups')
		    ->join('teachers', 'groups.teacher = teachers.id')
		    ->join('statuses', 'groups.status = statuses.id')
		    ->where('groups.language', $lng)
		    ->where('groups.type', GROUP_STANDART)
		    ->order_by('groups.date');
	    $query1 = $this->db->get();
	    $groups = $query1->result();


	    // Для спецкурсов
	    $this->db->select('groups.title as gtitle, 
                groups.id as gid, 
                groups.title as gtitle, 
                groups.date as date,
                groups.created as created,
                groups.updated as updated,
                specials_levels.id_levels as glevel, 
                specials.description as sdescription, 
                specials.title as stitle,
                teachers.title_short as title_short,
                groups.days as days,
                groups.time as time,
                statuses.status_text as status_text');
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
		    ->join('groups', 'groups.special = specials.id')
		    ->join('teachers', 'groups.teacher = teachers.id')
		    ->join('statuses', 'groups.status = statuses.id')
		    ->where('groups.language', $lng)
		    ->where('groups.type', GROUP_SPECIAL)
		    ->order_by('groups.date');
	    $query_s = $this->db->get();
	    $groups_s = $query_s->result();


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
			'meta_keywords' => $page_title
	    );
	    $this->parser->parse($this->config->item('tplpath') . 'cms/groups', $data);
	} else
	{
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
                groups.date as date,
                groups.level as level,
                groups.title as gtitle, 
                groups.created as created,
                groups.updated as updated,
                teachers.title_short as title_short,
                groups.days as days,
                groups.time as time,
                statuses.status_text as status_text')
		    ->from('groups')
		    ->join('teachers', 'groups.teacher = teachers.id')
		    ->join('statuses', 'groups.status = statuses.id')
		    ->where('groups.language', $lng)
		    ->where('groups.type', GROUP_STANDART)
		    ->order_by('groups.date');
	    $query1 = $this->db->get();
	    $groups = $query1->result();

	    // Спецкурсы
	    $this->db->select('groups.title as gtitle, 
                groups.id as gid, 
                groups.title as gtitle, 
                groups.date as date,
                groups.created as created,
                groups.updated as updated,
                specials_levels.id_levels as glevel, 
                specials.description as sdescription, 
                specials.title as stitle,
                teachers.title_short as title_short,
                groups.days as days,
                groups.time as time,
                statuses.status_text as status_text')
		    ->from('specials_levels')
		    ->join('specials', 'specials.id = specials_levels.id_specials')
		    ->join('groups', 'groups.special = specials.id')
		    ->join('teachers', 'groups.teacher = teachers.id')
		    ->join('statuses', 'groups.status = statuses.id')
		    ->where('groups.language', $lng)
		    ->where('groups.type', GROUP_SPECIAL)
		    ->order_by('groups.date');
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
			'meta_keywords' => $page_title
	    );
	    $this->parser->parse($this->config->item('tplpath') . 'cms/groups', $data);
	}
    }

    function generate_title_for_cources($id)
    {
	$group = new Group($id);
	if ($group->exists())
	{
	    $teacher = new Teacher($group->teacher);
	    $status = new Statuses_orm($group->status);
	    if ($group->type == GROUP_STANDART)
	    {
		$title_fc = $group->days . nbs() . $group->time;
		$title_fc.= ' – Преподаватель: ' . $teacher->title_short . '; ';
		$title_fc .= $status->status_text;
		$title_fc .= $group->status_text . nbs() . dateToRus($group->date);
		$group->title_for_cources = $title_fc;
		$group->skip_validation()->save();
	    } elseif ($group->type == GROUP_SPECIAL)
	    {
		$title_fc = $group->days . nbs() . $group->time;
		$title_fc.= ' – Преподаватель: ' . $teacher->title_short . '; ';
		$title_fc .= $status->status_text;
		$title_fc .= nbs() . dateToRus($group->date);
		$group->title_for_cources = $title_fc;
		$group->skip_validation()->save();
	    }
	}
    }

    function regenerate_titles()
    {
	echo "<h1>Генерация названий для страницы поиска курсов</h1><ul>";
	$group = new Group();
	$group->get();
	foreach ($group as $gr)
	{
	    $this->generate_title_for_cources($gr->id);
	    echo '<li>' . $gr->title_for_cources . '</li>';
	}
	echo '</ul>Всё';
    }

    /**
     * Добавление новой записи
     * #REFACTOR Не пере
     */
    function add()
    {
	$s = new Group();
	$s->title = 'Безымянная';
	$s->skip_validation()->save();
	redirect('cms/groups/edit/' . $s->id);
    }

    /**
     * Редактировать событие.
     * @param integer $id
     */
    function edit($id = FALSE)
    {
	$group = new Group();
	$levels = new Levels_orm();
	$specials = new Specials_orm();
	$programs = new Programs_orm();
	$textbooks = new Textbook();
	$statuses = new Statuses_orm();
	$teachers = new Teacher();
	$formats = new Formats_orm();
	$durations = new Durations_orm();
	$prices = new Prices_orm();
	$tests = new Tests_orm();
	$tst = new Test();
	// Сохранение
	if ($this->input->post())
	{
	    //debug_print($_POST);
	    $group->get_by_id($id);
	    $group->order = (int) $this->input->post('order', TRUE);
	    $group->type = (int) $this->input->post('type', TRUE);
	    $group->language = (int) $this->input->post('language', TRUE);
	    $group->level = (int) $this->input->post('level', TRUE);
	    $group->special = (int) $this->input->post('special', TRUE);
	    $group->program = (int) $this->input->post('program', TRUE);
	    $group->textbook_old = (int) $this->input->post('textbook', TRUE);
	    $group->days = $this->input->post('days', TRUE);
	    $group->time = $this->input->post('time', TRUE);
	    $group->date = $this->input->post('date_submit', TRUE);
	    $group->teacher = (int) $this->input->post('teacher', TRUE);
	    $group->status = (int) $this->input->post('status', TRUE);
	    $group->format = (int) $this->input->post('format', TRUE);
	    $group->duration = (int) $this->input->post('duration', TRUE);
	    $group->price = (int) $this->input->post('price', TRUE);
	    $group->tests_id = (int) $this->input->post('test', TRUE);
	    $group->comment = $this->input->post('comment', TRUE);
	    // Синтез названия
	    $title = '';
	    switch ($group->type)
	    {
		case GROUP_STANDART:
		    {
			if ($group->language == ITALIAN)
			    $title = 'Итальянский ';
			else
			    $title = 'Испанский ';
			$levels->get_by_id($group->level);
			$title .= $levels->title . ' ' . $group->days . ' ' . $group->time . ' ';
			$teachers->get_by_id($group->teacher);
			$title .= 'преподаватель: ' . $teachers->title_short;
		    }
		    break;
		case GROUP_SPECIAL:
		    {
			if ($group->language == ITALIAN)
			    $title = 'Итальянский ';
			else
			    $title = 'Испанский ';
			$specials->get_by_id($group->special);
			$title .= $specials->title . ' ' . $group->days . ' ' . $group->time . ' ';
			$teachers->get_by_id($group->teacher);
			$title .= 'преподаватель: ' . $teachers->title_short;
		    }
		    break;
		default:
	    }
	    $group->title = $title;
	    $success = $group->save();
	    if (!$success)
	    {
		$error = 'Ошибка сохранения.';
		if (!($group->valid))
		{
		    $error = $group->error->string;
		}
		$group->textbook->get();
		$checked_textbook = array();
		foreach ($group->textbook as $value)
		{
		    $checked_textbook[$value->id] = $value->id;
		}
		$data = template_base_tags() + array(
		    'error' => $error,
		    'checked_textbook' => $checked_textbook,
		    'levels' => $levels->get(),
		    'specials' => $specials->get(),
		    'programs' => $programs->get(),
		    'textbooks' => $textbooks->get(),
		    'statuses' => $statuses->get(),
		    'teachers' => $teachers->get(),
		    'formats' => $formats->get(),
		    'durations' => $durations->get(),
		    'prices' => $prices->get(),
		    'tests' => $tests->get(),
		    'tst' =>$tst->get(),
		    'content' => $group
		);
		$this->parser->parse($this->config->item('tplpath') . 'cms/groups_entry', $data);
	    } else
	    {
		// Удаление связанных с группой учебников
		if ($this->input->post('textbooks'))
		{
		    $textbooks->get();
		    $group->delete($textbooks->all);
		    // Добавление присланных в $_POST
		    foreach ($this->input->post('textbooks') as $value)
		    {
			$textbooks->get_by_id($value);
			$textbooks->save($group);
		    }
		}
		$this->generate_title_for_cources($id);
		redirect('cms/groups/edit/' . $id);
	    }
	} elseif ($id == FALSE)
	{
	    redirect('cms');
	} else
	{
	    // Редактируем запись.
	    $group->get_by_id($id);
	    $group->textbook->get();
	    $checked_textbook = array();
	    foreach ($group->textbook as $value)
	    {
		$checked_textbook[$value->id] = $value->id;
	    }
	    $data = template_base_tags() + array(
		'checked_textbook' => $checked_textbook,
		'levels' => $levels->get(),
		'specials' => $specials->get(),
		'programs' => $programs->get(),
		'textbooks' => $textbooks->get(),
		'statuses' => $statuses->get(),
		'teachers' => $teachers->get(),
		'formats' => $formats->get(),
		'durations' => $durations->get(),
		'prices' => $prices->get(),
		'tests' => $tests->get(),
		'tst' =>$tst->get(),
		'content' => $group
	    );
	    $this->parser->parse($this->config->item('tplpath') . 'cms/groups_entry', $data);
	}
    }

    function edit_order()
    {
	$data = array();
	if ($this->input->post('order') && $this->input->post('id'))
	{
	    $id = (int) $this->input->post('id', TRUE);
	    $order = (int) $this->input->post('order', TRUE);
	    $group = new Group();
	    $group->get_by_id($id);
	    $group->order = $order;
	    $group->save();
	    $data += array(
		'order' => $group->order
	    );
	}
	echo json_encode($data);
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
		    $s = new Group();
		    $s->get_by_id($c);
		    $s->delete();
		}
		redirect('cms/groups');
	    }
	}
	else
	    redirect('cms/groups');
    }

}
