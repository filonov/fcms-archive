<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_tests_id extends CI_Migration
{

    public function up()
    {
        $fields = array(
            'tests_id' => array(
                'type' => 'INTEGER',
                'constraint' => '5',
		'unsigned' => TRUE,
            ),
        );
        $this->dbforge->add_column('groups', $fields);
        $this->db->where('key', 'version');
        $this->db->update('settings', array('value' => '4.2.10'));
        echo '<ul>
            <li>Поле для тестов добавлено.</li>
            </ul>';
    }

    public function down()
    {
        // Поле намерянно не удаляем, в нём могут быть данные
	$this->dbforge->drop_column('groups', 'tests_id');
        $this->db->where('key', 'version');
        $this->db->update('settings', array('value' => '4.2.9'));
    }

}