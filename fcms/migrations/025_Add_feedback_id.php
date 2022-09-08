<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_feedback_id extends CI_Migration
{

    public function up()
    {
	$fields = array(
	    'session_id' => array(
		'type' => 'VARCHAR',
		'constraint' => '32',
	    ),
	);
	$this->dbforge->add_column('forms', $fields);

	$this->db->where('key', 'version');
	$this->db->update('settings', array('value' => '4.2.25'));
	echo '<ul>
            <li>Добавлено поле session_id.</li>
            </ul>';
    }

    public function down()
    {
	$this->db->where('key', 'version');
	$this->db->update('settings', array('value' => '4.2.24'));
    }

}
