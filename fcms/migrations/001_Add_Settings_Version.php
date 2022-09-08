<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Settings_Version extends CI_Migration
{

    public function up()
    {
        // Добавляем справочник марок автомобилей
        $this->dbforge->add_field(
                array(
                    'id' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE,
                        'auto_increment' => TRUE
                    ),
                    'key' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '1024',
                    ),
                    'value' => array(
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
        $this->dbforge->create_table('settings');

        $this->db->insert('settings', array('key' => 'version', 'value' => '4.2.0'));
        echo '<ul><li>Version added.</li><li>Version update implemented.</li></ul>';
    }

    public function down()
    {
        $this->dbforge->drop_table('settings');
    }

}