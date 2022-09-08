<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Review_Table extends CI_Migration
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
		    'name' => array(
			'type' => 'VARCHAR',
			'constraint' => '1024',
		    ),
		    'rate' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		    ),
		    'text' => array(
			'type' => 'TEXT',
			'null' => TRUE,
		    ),
		    'show' => array(
			'type' => 'TINYINT',
			'constraint' => 5,
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
	$this->dbforge->create_table('items_reviews');

	$this->db->where('key', 'version');
        $this->db->update('settings', array('value' => '4.2.11'));
	echo '<ul><li>Добавлены отзывы о товаре.</li></ul>';
    }

    public function down()
    {
	// Не удаляем во избежание случаянной потери данных.
	//$this->dbforge->drop_table('items_reviews');
	$this->db->where('key', 'version');
        $this->db->update('settings', array('value' => '4.2.10'));
    }

}