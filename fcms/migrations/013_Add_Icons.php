<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Icons extends CI_Migration
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
		    'items_id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		    ),
		    'filename' => array(
			'type' => 'VARCHAR',
			'constraint' => '1024',
		    ),
		    'created' => array(
			'type' => 'TIMESTAMP',
		    ),
		    'updated' => array(
			'type' => 'TIMESTAMP',
		    ),
	));
	$this->dbforge->add_key('id', TRUE);
	$this->dbforge->create_table('items_icons');

	$this->db->where('key', 'version');
        $this->db->update('settings', array('value' => '4.2.12'));
	echo '<ul><li>Значки товара.</li></ul>';
    }

    public function down()
    {
	// Не удаляем во избежание случаянной потери данных.
	//$this->dbforge->drop_table('items_icons');
	$this->db->where('key', 'version');
        $this->db->update('settings', array('value' => '4.2.11'));
    }

}