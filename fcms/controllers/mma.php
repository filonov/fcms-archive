<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mma extends CI_Controller
{

    function __construct()
    {
	parent::__construct();
    }

    private function send_mail($type, $form)
    {
	$tpl = new Emailtpl();
	$this->load->library('email');
	$config['wordwrap'] = TRUE;
	$config['mailtype'] = 'html';
	$config['charset'] = 'utf-8';


	// Отправка письма администратору
	$this->email->initialize($config);
	$tpl->get_by_alias('anketa');
	if ($tpl->exists())
	{
	    $mark = new Mma_mark();
	    $model = new Mma_model();
	    $region = new Mma_region();
	    $tstype = new Mma_car_type();
	    //$form = new Mma_form($id);
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
		'osago_class' => $osago_class
	    );
	    $out_str = $this->parser->parse($this->config->item('tplpath') . 'cms/mma_mail', $data, TRUE);
	    $msg = sprintf($tpl->text, $out_str);
	    $this->email->clear();
	    $this->email->from($this->config->item('site_email'), $this->config->item('site_title'));
	    $this->email->to($this->config->item('admin_email'));
	    $this->email->subject($tpl->title);
	    $this->email->message($msg);
	    @$this->email->send();
	}
    }

    function kasko()
    {
	if ($this->input->post())
	{
	    $kasko = new Mma_form();
	    $kasko->type = MMA_KASKO;
	    $kasko->mma_mark_id = $this->input->post('mma_mark_id');
	    $kasko->mma_model_id = $this->input->post('mma_model_id');
	    $kasko->release_date = $this->input->post('release_date');
	    $kasko->num_of_drivers = $this->input->post('num_of_drivers');
	    $kasko->mma_region_id = $this->input->post('mma_region_id');
	    $kasko->minimum_age = $this->input->post('minimum_age');
	    $kasko->driving_experience = $this->input->post('driving_experience');
	    $kasko->name = $this->input->post('name');
	    $kasko->phone = $this->input->post('phone');
	    $kasko->email = $this->input->post('email');
	    $sucsess = $kasko->save();
	    if (!$sucsess)
	    {
		$error = 'Ошибка сохранения.';
		if (!($kasko->valid))
		{
		    $error = $kasko->error->string;
		}
	    } else
	    {
		$this->send_mail(MMA_KASKO, $kasko);
	    }
	}
	redirect('kasko');
    }

    function osago()
    {
	if ($this->input->post())
	{
	    $osago = new Mma_form();
	    $osago->type = MMA_OSAGO;
	    $osago->owner_type = $this->input->post('owner_type');
	    $osago->reg_place_type = $this->input->post('reg_place_type');

	    $osago->mma_car_type_id = $this->input->post('mma_car_type_id');
	    $osago->power = $this->input->post('power'); //
	    $osago->mma_region_id = $this->input->post('mma_region_id');
	    $osago->mma_community_id = $this->input->post('mma_community_id'); //
	    $osago->number_of_users = $this->input->post('number_of_users'); //
	    $osago->term_insurance = $this->input->post('term_insurance');
	    $osago->period_of_use = $this->input->post('period_of_use');
	    $osago->class = $this->input->post('class'); //
	    $osago->insurance_payments = $this->input->post('insurance_payments');
	    $osago->security_violations = $this->input->post('security_violations');
	    $osago->name = $this->input->post('contact_name');

	    $osago->phone = $this->input->post('phone');
	    $osago->email = $this->input->post('email');
	    $sucsess = $osago->save();
	    if (!$sucsess)
	    {
		$error = 'Ошибка сохранения.';
		if (!($osago->valid))
		{
		    $error = $osago->error->string;
		}
	    } else
	    {
		// Расчитать и сохранить в сессии базовые тарифы осаго.
		$car = new Mma_car_type((int) $osago->mma_car_type_id);
		$terr = new Mma_osago_np((int) $osago->mma_community_id);

		$kterr = $terr->koeff;
		if ($car->trak == 1)
		{
		    $kterr = $terr->koeff_tr;
		}

		$ko = $this->input->post('Ko');

		$kvs = new Mma_osago_age((int) $osago->number_of_users);

		$power = new Mma_osago_power($osago->power);

		$kbm = new Mma_osago_bm($osago->class);

		if ($osago->owner_type == 10)
		    $osago_summ = $car->base * $kterr * $ko * $kvs->koeff * $power->koeff * $kbm->koeff;
		else
		{
		    $ko = 1.8;
		    $osago_summ = $car->base * $kterr * $ko * $power->koeff * $kbm->koeff;
		}
		$osago_out = "<b>Стоимость полиса — " . $osago_summ . ' руб.</b><br/>';
		$osago_out .= "Базовый тариф — " . $car->base . br()
			. "Коэффициенты:<br/>"
			. 'по мощности — ' . $power->koeff . br()
			. 'по классу — ' . $kbm->koeff . br()
			. 'по территории — ' . $kterr . br()
			. 'по допуску лиц к управлению — ' . $ko;
		if ($osago->owner_type == 10)
		    $osago_out .= br().'по возрасту и стажу — ' . $kvs->koeff . br();

		$this->session->set_userdata('message', $osago_out);

		$this->send_mail(MMA_OSAGO, $osago);
		$error = "Спасибо за заявку! Мы свяжемся с вами!";
		$this->session->set_userdata('mma_error', $error);
	    }
	}
	redirect('osago#res');
    }

    function ajax_osago()
    {
	if ($this->input->post())
	{

	    // Расчитать и сохранить в сессии базовые тарифы осаго.
	    $car = new Mma_car_type((int) $this->input->post('mma_car_type_id',TRUE));
	    $terr = new Mma_osago_np((int) $this->input->post('mma_community_id',TRUE));

	    $kterr = $terr->koeff;
	    if ($car->trak == 1)
	    {
		$kterr = $terr->koeff_tr;
	    }

	    $ko = $this->input->post('Ko');

	    $kvs = new Mma_osago_age((int) $this->input->post('number_of_users',TRUE));

	    $power = new Mma_osago_power($this->input->post('power',TRUE));

	    $kbm = new Mma_osago_bm($this->input->post('class',TRUE));

	    if ($this->input->post('owner_type',TRUE) == 10)
		$osago_summ = $car->base * $kterr * $ko * $kvs->koeff * $power->koeff * $kbm->koeff;
	    else
	    {
		$ko = 1.8;
		$osago_summ = $car->base * $kterr * $ko * $power->koeff * $kbm->koeff;
	    }
	    $osago_out = "<b>Стоимость полиса — " . $osago_summ . ' руб.</b><br/>';
	    $osago_out .= "Базовый тариф — " . $car->base . br()
		    . "Коэффициенты:<br/>"
		    . 'по мощности — ' . $power->koeff . br()
		    . 'по классу — ' . $kbm->koeff . br()
		    . 'по территории — ' . $kterr . br()
		    . 'по допуску лиц к управлению — ' . $ko;
	    if ($this->input->post('owner_type',TRUE) == 10)
		$osago_out .= br().'по возрасту и стажу — ' . $kvs->koeff . br();
	    echo $osago_out;
	    
	}
    }

    function dms()
    {
	if ($this->input->post())
	{
	    //debug_print($_POST);
	    $dms = new Mma_form();
	    $dms->type = MMA_DMS;
	    $dms->owner_type = $this->input->post('owner_type');
	    $dms->contact_name = $this->input->post('contact_name');
	    $dms->phone = $this->input->post('phone');
	    $dms->email = $this->input->post('email');
	    $dms->number_of_users = $this->input->post('number_of_users');
	    $dms->age = $this->input->post('age');
	    $dms->scope = $this->input->post('scope');
	    $dms->wishes = $this->input->post('wishes');
	    $dms->comments = $this->input->post('comments');
	    // Здесь что-то сделать
	    foreach ($this->input->post('mma_dms_options') as $opt)
	    {
		$dms->mma_dms_options .= $opt . ' ';
	    }
	    $dms->class = $this->input->post('class');
	    $dms->insurance_payments = $this->input->post('insurance_payments');
	    $dms->security_violations = $this->input->post('security_violations');
	    $sucsess = $dms->save();
	    if (!$sucsess)
	    {
		$error = 'Ошибка сохранения.';
		if (!($dms->valid))
		{
		    $error = $dms->error->string;
		}
	    } else
	    {
		$this->send_mail(MMA_DMS, $dms);
		//$tpl = new Modules_orm();
		//$tpl->where(array('alias' => 'anketa'))->get();
		$error = "Спасибо за заявку! Мы свяжемся с вами!";
	    }
	}
	redirect('dms');
    }

    function other()
    {
	$url = '';
	if ($this->input->post())
	{
	    //debug_print($_POST);
	    $url = $this->input->post('url', TRUE);
	    $other = new Mma_form();
	    $other->type = MMA_OTHER;
	    $other->mma_other = $this->input->post('mma_other');
	    ;
	    $other->contact_name = $this->input->post('contact_name');
	    $other->phone = $this->input->post('phone');
	    $other->email = $this->input->post('email');
	    $other->comments = $this->input->post('comments');
	    $sucsess = $other->save();
	    if (!$sucsess)
	    {
		$error = 'Ошибка сохранения.';
		if (!($other->valid))
		{
		    $error = $other->error->string;
		}
	    } else
	    {
		$this->send_mail(MMA_OTHER, $other);
		$error = "Спасибо за заявку! Мы свяжемся с вами!";
	    }
	}
	redirect($url);
    }

    function models()
    {
	if ($this->input->post('mark_id'))
	{
	    $out = '<select name="mma_model_id" class="input-xxlarge" required="">';
	    $models = new Mma_model();
	    $models->order_by('model')->get_by_mark_id($this->input->post('mark_id'));
	    foreach ($models as $m)
	    {
		$out .= '<option value="' . $m->id . '">' . $m->model . '</option>';
	    }
	    $out .= '</select>';
	    echo $out;
	}
    }

    function np()
    {
	if ($this->input->post('oblast_id'))
	{
	    $out = '<select name="mma_community_id" class="input-xlarge">';
	    $nps = new Mma_osago_np();
	    $nps->order_by('id')->get_by_oblast_id($this->input->post('oblast_id'));
	    foreach ($nps as $m)
	    {
		$out .= '<option value="' . $m->id . '">' . $m->title . '</option>';
	    }
	    $out .= '</select>';
	    echo $out;
	}
    }

}

