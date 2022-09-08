<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Tst_lang extends CI_Migration
{

    public function up()
    {
        $fields = array(
            'language' => array(
                'type' => 'INTEGER',
		'unsigned' => TRUE,
            ),
        );
        $this->dbforge->add_column('testings', $fields);

        $this->db->where('key', 'version');
        $this->db->update('settings', array('value' => '4.2.14'));
        echo '<ul>
            <li>Тестам добавлен признак языка.</li>
            </ul>';
    }

    public function down()
    {
        // Поле намерянно не удаляем, в нём могут быть данные
        $this->db->where('key', 'version');
        $this->db->update('settings', array('value' => '4.2.13'));
    }

}