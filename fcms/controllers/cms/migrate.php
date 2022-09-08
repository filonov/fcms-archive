<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Контроллер обновлений
 *
 * @author DVF
 * @copyright 2013, Denis V. Filonov
 */
class Migrate extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_root();
    }

    function index()
    {
        echo "<h1>Обновление системы</h1>".br();
        $this->load->library('migration');
        if (!$this->migration->current())
        {
            show_error($this->migration->error_string().br());
        }
        echo '<b>Завершено.</b>'.br();
        echo anchor(base_url('cms'), 'Назад, в админку');
    }
    
    function import_csv_mma()
    {
	//die(FCPATH);
//	$f = fopen(FCPATH . 'obl' , 'r');
	// В таблицу населённых пунктов
//	while (!feof($f)) { 
//	   $arr= explode(";", mb_convert_encoding(fgets($f),'UTF-8','Windows-1251')); 
//	   $this->db->insert('mma_osago_np', array('title'=>$arr[0],'koeff'=>$arr[1],'koeff_tr'=>$arr[2]));
//	      echo "$arr[0] - $arr[1] - $arr[2] <br/>"; 
//
//	}
	// В таблицу Областей
//	while (!feof($f)) { 
//	   $arr= fgets($f); 
//	   $this->db->insert('mma_osago_oblast', array('title'=>$arr));
//	      echo "$arr<br/>"; 
//
//	}	
	

//	fclose($f);
	
    }

}