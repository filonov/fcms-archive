<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Администрирование MMA - функции для работы по наполнению баз данных.
 * @copyright (c) 2013, Denis Filonov.
 */
class Mma extends CI_Controller
{

    function __construct()
    {
	parent::__construct();
	is_root();
    }

    /**
     *  Марки автомобилей
     */
    function marks()
    {
	$marks = new Mma_mark();
	$marks->order_by('mark');
	$data = template_base_tags() + array(
	    'content' => $marks->get()
	);
	$this->parser->parse($this->config->item('tplpath') . 'cms/mma_marks', $data);
    }

    function add_mark()
    {
	$mark = new Mma_mark();
	if ($this->input->post())
	{
	    $mark->mark = $this->input->post('mark', TRUE);
	    $success = $mark->save();
	    if (!$success)
	    {
		$error = 'Ошибка сохранения.';
		if (!($mark->valid))
		{
		    $error = $mark->error->string;
		} else
		{
		    $error = 'Неизвестная ошибка проверки данных.';
		}

		$data = template_base_tags() + array(
		    'content' => $mark->get(), 'error' => $error
		);
		$this->parser->parse($this->config->item('tplpath') . 'cms/mma_marks', $data);
	    } else
	    {
		redirect('cms/mma/marks');
	    }
	} else
	{
	    redirect('cms/mma/marks');
	}
    }

    function edit_mark()
    {
	$data = array();
	if ($this->input->post())
	{
	    $mark = new Mma_mark();
	    $id = $this->input->post('id', TRUE);
	    $mark_txt = $this->input->post('mark', TRUE);
	    $mark->get_by_id($id);
	    $mark->mark = $mark_txt;
	    $mark->save();
	    $data += array(
		'mark' => $mark->mark,
	    );
	}
	echo json_encode($data);
    }

    function delete_mark()
    {
	if ($this->input->post('check'))
	{
	    $check = $_POST['check'];
	    if ($check)
	    {
		foreach ($check as $c)
		{
		    $l = new Mma_mark();
		    $l->get_by_id($c);
		    $l->delete();
		}
	    }
	}
	redirect('cms/mma/marks');
    }

    /**
     * Модели автомобилей
     */
    function models($page = 1)
    {
	$vis = new Visual_elements();
	$marks = new Mma_mark();
	$marks->order_by('mark');

	$model = new Mma_model();
	$model->order_by('mark_id, model');

	$data = template_base_tags() + array(
	    'marks' => $marks->get(),
	    'content' => $model->get_paged($page, 50),
	    'paginator' => $vis->paginator(base_url('cms/mma/models/'), $model->count(), 4, 50)
	);
	$this->parser->parse($this->config->item('tplpath') . 'cms/mma_models', $data);
    }

    function add_model()
    {
	$model = new Mma_model();
	if ($this->input->post())
	{
	    $model->model = $this->input->post('model', TRUE);
	    $model->mark_id = $this->input->post('mark_id', TRUE);

	    $success = $model->save();
	    if (!$success)
	    {
		$error = 'Ошибка сохранения.';
		if (!($model->valid))
		{
		    $error = $model->error->string;
		} else
		{
		    $error = 'Неизвестная ошибка проверки данных.';
		}

		$data = template_base_tags() + array(
		    'content' => $model->get(), 'error' => $error
		);
		$this->parser->parse($this->config->item('tplpath') . 'cms/mma_models', $data);
	    } else
	    {
		redirect('cms/mma/models');
	    }
	} else
	{
	    redirect('cms/mma/models');
	}
    }

    function edit_model()
    {
	$data = array();
	if ($this->input->post())
	{
	    $model = new Mma_model();
	    $id = $this->input->post('id', TRUE);
	    $model->get_by_id($id);
	    $model->model = $this->input->post('model', TRUE);
	    $model->mark_id = $this->input->post('mark_id', TRUE);
	    $model->save();
	    $data += array(
		'model' => $model->model,
	    );
	}
	echo json_encode($data);
    }

    function delete_model()
    {
	if ($this->input->post('check'))
	{
	    $check = $_POST['check'];
	    if ($check)
	    {
		foreach ($check as $c)
		{
		    $l = new Mma_model();
		    $l->get_by_id($c);
		    $l->delete();
		}
	    }
	}
	redirect('cms/mma/models');
    }

    /**
     *  Регионы
     */
    function regions()
    {
	$reg = new Mma_region();
	$reg->order_by('number');

	$data = template_base_tags() + array(
	    'content' => $reg->get(),
	);
	$this->parser->parse($this->config->item('tplpath') . 'cms/mma_regions', $data);
    }

    function add_region()
    {
	$reg = new Mma_region();
	if ($this->input->post())
	{
	    $reg->name = $this->input->post('name', TRUE);
	    $reg->number = $this->input->post('number', TRUE);

	    $success = $reg->save();
	    if (!$success)
	    {
		$error = 'Ошибка сохранения.';
		if (!($reg->valid))
		{
		    $error = $reg->error->string;
		} else
		{
		    $error = 'Неизвестная ошибка проверки данных.';
		}

		$data = template_base_tags() + array(
		    'content' => $reg->get(), 'error' => $error
		);
		$this->parser->parse($this->config->item('tplpath') . 'cms/mma_regions', $data);
	    } else
	    {
		redirect('cms/mma/regions');
	    }
	} else
	{
	    redirect('cms/mma/regions');
	}
    }

    function edit_region()
    {
	$data = array();
	if ($this->input->post())
	{
	    $reg = new Mma_region();
	    $id = $this->input->post('id', TRUE);
	    $reg->get_by_id($id);
	    $reg->name = $this->input->post('name', TRUE);
	    $reg->number = $this->input->post('number', TRUE);
	    $reg->save();
	    $data += array(
		'name' => $reg->name,
		'number' => $reg->number,
	    );
	}
	echo json_encode($data);
    }

    function delete_region()
    {
	if ($this->input->post('check'))
	{
	    $check = $_POST['check'];
	    if ($check)
	    {
		foreach ($check as $c)
		{
		    $l = new Mma_region();
		    $l->get_by_id($c);
		    $l->delete();
		}
	    }
	}
	redirect('cms/mma/regions');
    }

    function forms($type = 10, $page = 1)
    {
	$vis = new Visual_elements();
	$forms = new Mma_form();
	$data = template_base_tags() + array(
	    'content' => $forms->where('type', $type)->get_paged($page, 50),
	    'type' => $type,
	    'paginator' => $vis->paginator(base_url('cms/mma/forms/' . $type . '/'), $forms->where('type', $type)->count(), 5, 50)
	);
	$this->parser->parse($this->config->item('tplpath') . 'cms/mma_forms', $data);
    }

    function viewform($id)
    {
	$mark = new Mma_mark();
	$model = new Mma_model();
	$region = new Mma_region();
	$tstype = new Mma_car_type();
	$form = new Mma_form($id);
	$age = new Mma_osago_age();
	$power = new Mma_osago_power();
	$osago_oblast = new Mma_osago_oblast();
	$osago_np = new Mma_osago_np();
	$osago_class = new Mma_osago_bm();
	$data = template_base_tags() + array(
	    'item' => $form,
	    'mark' => $mark,
	    'model' => $model,
	    'region' => $region,
	    'tstype' => $tstype,
	    'osago_age' => $age,
	    'osago_power' => $power,
	    'osago_oblast' => $osago_oblast,
	    'osago_np' => $osago_np,
	    'osago_class'=> $osago_class
	);
	$this->parser->parse($this->config->item('tplpath') . 'cms/mma_forms_entry', $data);
    }

    function counter()
    {
	$count = new Settings_orm();
	if ($this->input->post())
	{
	    $count->get_by_key('mma_counter');
	    $count->value = $this->input->post('mma_counter');
	    $count->skip_validation()->save();
	    $count->get_by_key('mma_counter_rand');
	    $count->value = $this->input->post('mma_counter_rand');
	    $count->skip_validation()->save();
	}
	$count->get_by_key('mma_counter');
	$mma_counter = $count->value;
	$count->get_by_key('mma_counter_rand');
	$mma_counter_rand = $count->value;
	$data = template_base_tags() + array(
	    'mma_counter' => $mma_counter,
	    'mma_counter_rand' => $mma_counter_rand,
	);
	$this->parser->parse($this->config->item('tplpath') . 'cms/mma_counter', $data);
    }


}
