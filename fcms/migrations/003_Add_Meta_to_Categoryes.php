<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_meta_to_categoryes extends CI_Migration
{

    public function up()
    {

        $fields = array(
            'meta_title' => array(
                'type' => 'VARCHAR',
                'constraint' => '1024',
            ),
            'meta_keywords' => array(
                'type' => 'VARCHAR',
                'constraint' => '1024',
            ),
            'meta_description' => array(
                'type' => 'VARCHAR',
                'constraint' => '1024',
            ),
        );
        $this->dbforge->add_column('categoryes', $fields);
        $this->db->where('key', 'version');
        $this->db->update('settings',array('value' => '4.2.2'));
        echo '<ul>
            <li>Для категорий добавлены метатеги в базу.</li>
            <li>Контент сортируется по категориям в админке.</li>
            </ul>';
    }

    public function down()
    {
        $this->dbforge->drop_column('categoryes', 'meta_title');
        $this->dbforge->drop_column('categoryes', 'meta_keywords');
        $this->dbforge->drop_column('categoryes', 'meta_description');
        $this->db->where('key', 'version');
        $this->db->update('settings',array('value' => '4.2.1'));
    }

}
