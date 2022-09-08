<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_MMA_Counter extends CI_Migration
{

    public function up()
    {
        $this->db->insert('settings', array('key' => 'mma_counter', 'value' => '73'));
	$this->db->insert('settings', array('key' => 'mma_counter_rand', 'value' => '10'));
	$this->db->insert('settings', array('key' => 'mma_counter_current', 'value' => '73'));
	
	$this->db->where(array('key'=>'version'))->update('settings', array('value' => '4.2.21'));
        echo '<ul>
	    <li>MMA Counter parameter.</li>
	    </ul>';
    }

    public function down()
    {
        $this->db->where('key', 'version');
	$this->db->update('settings', array('value' => '4.2.20'));
    }
}