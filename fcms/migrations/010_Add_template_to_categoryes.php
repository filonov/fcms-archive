<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_template_to_categoryes extends CI_Migration
{

    public function up()
    {
        $fields = array(
            'template' => array(
                'type' => 'VARCHAR',
                'constraint' => '1024',
            ),
        );
        $this->dbforge->add_column('categoryes', $fields);

        $this->db->where('key', 'version');
        $this->db->update('settings', array('value' => '4.2.9'));
        echo '<ul>
            <li>Исправление — шаблон для категорий.</li>
            </ul>';
    }

    public function down()
    {
        // Поле намерянно не удаляем, в нём могут быть данные
        $this->db->where('key', 'version');
        $this->db->update('settings', array('value' => '4.2.8'));
    }

}