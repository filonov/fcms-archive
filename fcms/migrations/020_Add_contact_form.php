<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_contact_form extends CI_Migration
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
		    'name' => array(
			'type' => 'VARCHAR',
			'constraint' => '1024',
		    ),
		    'phone' => array(
			'type' => 'VARCHAR',
			'constraint' => '100',
		    ),
		    'email' => array(
			'type' => 'VARCHAR',
			'constraint' => '100',
		    ),
		    'message' => array(
			'type' => 'text',
		    ),
		    'created' => array(
			'type' => 'TIMESTAMP',
		    ),
		    'updated' => array(
			'type' => 'TIMESTAMP',
		    ),
	));
	$this->dbforge->add_key('id', TRUE);
	$this->dbforge->create_table('feedbacks');

	$this->db->where('key', 'version');
	$this->db->update('settings', array('value' => '4.2.20'));
	echo '<ul>
            <li>Форма обратной связи.</li>
            </ul>';
    }

    public function down()
    {
	$this->db->where('key', 'version');
	$this->db->update('settings', array('value' => '4.2.19'));
    }

}

