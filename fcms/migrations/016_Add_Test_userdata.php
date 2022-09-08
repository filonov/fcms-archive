<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Test_userdata extends CI_Migration
{

    public function up()
    {
	$this->dbforge->add_field(
		array(
		    'id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
			'auto_increment' => TRUE
		    ),
		    'session_id' => array(
			'type' => 'VARCHAR',
			'constraint' => '32',
		    ),
		    'forms_id' => array(
			'type' => 'INT',
			'unsigned' => TRUE,
		    ),
		    'page_id' => array(
			'type' => 'INT',
			'unsigned' => TRUE,
		    ),
		    'question_id' => array(
			'type' => 'INT',
			'unsigned' => TRUE,
		    ),
		    'answer_id' => array(
			'type' => 'INT',
			'unsigned' => TRUE,
		    ),
		    'weight' => array(
			'type' => 'INT',
			'unsigned' => TRUE,
		    ),
		    'created' => array(
                        'type' => 'TIMESTAMP',
                    ),
                    'updated' => array(
                        'type' => 'TIMESTAMP',
                    ),
	));
	$this->dbforge->add_key('id', TRUE);
	$this->dbforge->create_table('tests_userdata');
	$this->db->where('key', 'version');
	$this->db->update('settings', array('value' => '4.2.16'));
	echo '<ul>
            <li>Таблицы пользовательских данных тестов.</li>
            </ul>';
    }

    public function down()
    {
	$this->db->where('key', 'version');
	$this->db->update('settings', array('value' => '4.2.14'));
    }

}