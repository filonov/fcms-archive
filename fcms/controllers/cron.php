<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Контроллер задач cron.
 *
 * @author Denis Filonov <denis@filonov.biz>
 * @copyright (c) 2012-2013, Denis Filonov.
 */
class Cron extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Меняет статусы групп по дате.
     * Выполнять по крону раз в сутки.
     */
    function groups_update()
    {
        echo "Cron job begin" . br();
        $current_date = time();
        $groups = new Group();

        $groups->where_in('status', '3, 2, 4')
                ->where('date <', date('Y-m-d H:i:s', $current_date))
                ->update('status', 6);

        $groups->where_in('status', '5')
                ->where('date =>', date('Y-m-d H:i:s', $current_date))
                ->update('status', 7);
        ;


        echo "Cron job end" . br();
    }
    
    function mma_counter()
    {
	$settings = new Settings_orm();
	$settings->get_by_key('mma_counter');
	$mma_count = $settings->value;
	$settings->get_by_key('mma_counter_rand');
	$mma_count_rand = $settings->value;
	$mma_count_current = rand($mma_count - $mma_count_rand, $mma_count + $mma_count_rand);
	$this->db->where(array('key'=>'mma_counter_current'))->update('settings', array('value' => $mma_count_current));
	echo $mma_count_current;
    }

}
