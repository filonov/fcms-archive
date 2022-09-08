<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_showcase_order extends CI_Migration
{

    public function up()
    {
        $fields = array(
            'showcase_order' => array(
                        'type' => 'INT',
                        'unsigned' => TRUE,
                    ),
        );
        $this->dbforge->add_column('content', $fields);

        $this->db->where('key', 'version');
        $this->db->update('settings', array('value' => '4.2.24'));
        echo '<ul>
            <li>Добавлено поле Showcase Order.</li>
            </ul>';
    }

    public function down()
    {
        $this->db->where('key', 'version');
        $this->db->update('settings', array('value' => '4.2.23'));
    }

}