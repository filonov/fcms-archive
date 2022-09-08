<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Mma_Osago extends CI_Migration
{

    public function up()
    {
	// Таблица возрастов для расчёта ОСАГО
	$this->dbforge->add_field(
		array(
		    'id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
			'auto_increment' => TRUE
		    ),
		    'text' => array(
			'type' => 'VARCHAR',
			'constraint' => '1024',
		    ),
		    'koeff' => array(
			'type' => 'FLOAT',
		
		    ),
		    'created' => array(
			'type' => 'TIMESTAMP',
		    ),
		    'updated' => array(
			'type' => 'TIMESTAMP',
		    ),
	));
	$this->dbforge->add_key('id', TRUE);
	$this->dbforge->create_table('mma_osago_age');
	
	
	// Таблица мощностей для расчёта ОСАГО
	$this->dbforge->add_field(
		array(
		    'id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
			'auto_increment' => TRUE
		    ),
		    'text' => array(
			'type' => 'VARCHAR',
			'constraint' => '1024',
		    ),
		    'koeff' => array(
			'type' => 'FLOAT',
			
		    ),
		    'created' => array(
			'type' => 'TIMESTAMP',
		    ),
		    'updated' => array(
			'type' => 'TIMESTAMP',
		    ),
	));
	$this->dbforge->add_key('id', TRUE);
	$this->dbforge->create_table('mma_osago_power');
	
	// Таблица Областей для расчёта ОСАГО
	$this->dbforge->add_field(
		array(
		    'id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
			'auto_increment' => TRUE
		    ),
		    'title' => array(
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
	$this->dbforge->create_table('mma_osago_oblast');
	
	
	// Таблица населённых пунктов для расчёта ОСАГО
	$this->dbforge->add_field(
		array(
		    'id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
			'auto_increment' => TRUE
		    ),
		    'oblast_id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		    ),
		    'title' => array(
			'type' => 'VARCHAR',
			'constraint' => '1024',
		    ),
		    'koeff' => array(
			'type' => 'FLOAT',
		
		    ),
		    'koeff_tr' => array(
			'type' => 'FLOAT',
			
		    ),
		    'created' => array(
			'type' => 'TIMESTAMP',
		    ),
		    'updated' => array(
			'type' => 'TIMESTAMP',
		    ),
	));
	$this->dbforge->add_key('id', TRUE);
	$this->dbforge->create_table('mma_osago_np');
	
	// Таблица бонус-малус для расчёта ОСАГО
	$this->dbforge->add_field(
		array(
		    'id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
			'auto_increment' => TRUE
		    ),
		    'class' => array(
			'type' => 'VARCHAR',
			'constraint' => '1024',
		    ),
		    'koeff' => array(
			'type' => 'FLOAT',
			
		    ),
		    'created' => array(
			'type' => 'TIMESTAMP',
		    ),
		    'updated' => array(
			'type' => 'TIMESTAMP',
		    ),
	));
	$this->dbforge->add_key('id', TRUE);
	$this->dbforge->create_table('mma_osago_bm');
	

	$this->db->where('key', 'version');
        $this->db->update('settings', array('value' => '4.2.22'));
	echo '<ul><li>Добавлены таблицы ОСАГО.</li></ul>';
    }

    public function down()
    {
	$this->db->where('key', 'version');
        $this->db->update('settings', array('value' => '4.2.21'));
    }

}