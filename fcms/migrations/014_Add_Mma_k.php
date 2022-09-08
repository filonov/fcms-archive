<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Mma_k extends CI_Migration
{

    public function up()
    {
        $fields = array(
            'base' => array(
                'type' => 'INTEGER',
		'unsigned' => TRUE,
            ),
        );
        $this->dbforge->add_column('mma_car_types', $fields);

        $this->db->where('key', 'version');
        $this->db->update('settings', array('value' => '4.2.13'));
        echo '<ul>
            <li>Коеффициенты для ОСАГО.</li>
            </ul>';
    }

    public function down()
    {
        // Поле намерянно не удаляем, в нём могут быть данные
        $this->db->where('key', 'version');
        $this->db->update('settings', array('value' => '4.2.12'));
    }

}