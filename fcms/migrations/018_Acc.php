<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Acc extends CI_Migration
{

    public function up()
    {


        // Таблица ответов
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
                        'null' => TRUE,
                    ),
		    'acc_id' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE,
                        'null' => TRUE,
                    ),
                    'created' => array(
                        'type' => 'TIMESTAMP',
                    ),
                    'updated' => array(
                        'type' => 'TIMESTAMP',
                    ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('items_accs');
        
        $this->db->where('key', 'version');
        $this->db->update('settings', array('value' => '4.2.18'));
        echo '<ul>
            <li>Таблица аксессуаров.</li>
            </ul>';
    }

    public function down()
    {
        $this->db->where('key', 'version');
        $this->db->update('settings', array('value' => '4.2.17'));     
    }

}