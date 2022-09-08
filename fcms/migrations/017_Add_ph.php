<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_ph extends CI_Migration
{

    public function up()
    {
        $fields = array(
            'ph' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '10',
                    ),
	     'volume' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '10',
                    ),
        );
        $this->dbforge->add_column('items', $fields);

        $this->db->where('key', 'version');
        $this->db->update('settings', array('value' => '4.2.17'));
        echo '<ul>
            <li>Добавлены поля в таблицу магазина.</li>
            </ul>';
    }

    public function down()
    {
        // Поле намерянно не удаляем, в нём могут быть данные
        $this->db->where('key', 'version');
        $this->db->update('settings', array('value' => '4.2.16'));
    }

}