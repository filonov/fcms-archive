<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_fields_to_groups extends CI_Migration
{
    public function up()
    {

        $fields = array(
            'title_for_cources' => array(
                'type' => 'VARCHAR',
                'constraint' => '1024',
            ),
        );
        $this->dbforge->add_column('groups', $fields);
        $this->db->where('key', 'version');
        $this->db->update('settings', array('value' => '4.2.6'));
        echo '<ul>
            <li>Поле для генерации описания группы для поиска.</li>
            </ul>';
    }

    public function down()
    {
        $this->dbforge->drop_column('groups', 'title_for_cources');
        $this->db->where('key', 'version');
        $this->db->update('settings', array('value' => '4.2.5'));
    }

}
