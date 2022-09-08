<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_fields_to_forms extends CI_Migration
{
    public function up()
    {

        $fields = array(
            'field03' => array(
                'type' => 'VARCHAR',
                'constraint' => '1024',
            ),
            'field04' => array(
                'type' => 'VARCHAR',
                'constraint' => '1024',
            ),
        );
        $fields_i = array(
            'description' => array(
                'type' => 'TEXT',
            )
        );
        $this->dbforge->add_column('forms', $fields);
        $this->dbforge->add_column('images', $fields_i);
        $this->db->where('key', 'version');
        $this->db->update('settings', array('value' => '4.2.4'));
        echo '<ul>
            <li>Дополнительные поля в таблице форм.</li>
            <li>Описание для картинок.</li>
            </ul>';
    }

    public function down()
    {
        $this->dbforge->drop_column('forms', 'date');
        $this->dbforge->drop_column('forms', 'field03');
        $this->dbforge->drop_column('forms', 'field04');
        $this->dbforge->drop_column('images', 'descriprion');
        $this->db->where('key', 'version');
        $this->db->update('settings', array('value' => '4.2.3'));
    }

}
