<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_date_to_forms extends CI_Migration
{
    public function up()
    {

        $fields = array(
            'date' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'field01' => array(
                'type' => 'VARCHAR',
                'constraint' => '1024',
            ),
            'field02' => array(
                'type' => 'VARCHAR',
                'constraint' => '1024',
            ),
        );
        $this->dbforge->add_column('forms', $fields);
        $this->db->where('key', 'version');
        $this->db->update('settings', array('value' => '4.2.3'));
        echo '<ul>
            <li>Дата мероприятия добавлена в таблицу форм.</li>
            </ul>';
    }

    public function down()
    {
        $this->dbforge->drop_column('forms', 'date');
        $this->dbforge->drop_column('forms', 'field01');
        $this->dbforge->drop_column('forms', 'field02');
        $this->db->where('key', 'version');
        $this->db->update('settings', array('value' => '4.2.2'));
    }

}
