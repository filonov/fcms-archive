<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_tg extends CI_Migration
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
		    'item_id' => array(
			'type' => 'INT',
			'unsigned' => TRUE,
		    ),
		    'filename' => array(
			'type' => 'VARCHAR',
			'constraint' => '1024',
		    ),
		    'alt' => array(
			'type' => 'VARCHAR',
			'constraint' => '255',
		    ),
		    'title' => array(
			'type' => 'VARCHAR',
			'constraint' => '255',
		    ),
		    'color' => array(
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
	$this->dbforge->create_table('items_images');

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
			'constraint' => '255',
		    ),
		    'number' => array(
			'type' => 'VARCHAR',
			'constraint' => '255',
		    ),
		    'created' => array(
			'type' => 'TIMESTAMP',
		    ),
		    'updated' => array(
			'type' => 'TIMESTAMP',
		    ),
	));
	$this->dbforge->add_key('id', TRUE);
	$this->dbforge->create_table('colors');


	$this->dbforge->add_field(
		array(
		    'id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
			'auto_increment' => TRUE
		    ),
		    'color_id' => array(
			'type' => 'INT',
			'unsigned' => TRUE,
		    ),
		    'item_id' => array(
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
	$this->dbforge->create_table('items_colors');


	$this->db->where('key', 'version');
	$this->db->update('settings', array('value' => '4.2.23'));
	echo '<ul><li>Добавлены таблицы цветов и галерей TG.</li></ul>';
    }

    public function down()
    {
	$this->db->where('key', 'version');
	$this->db->update('settings', array('value' => '4.2.22'));
    }

}
