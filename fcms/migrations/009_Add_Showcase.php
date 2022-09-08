<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Showcase extends CI_Migration
{

    public function up()
    {
        $fields = array(
            'show_in_showcase' => array(
                'type' => 'TINYINT',
                'unsigned' => TRUE,
            ),
        );
        $this->dbforge->add_column('content', $fields);

        $this->db->where('key', 'version');
        $this->db->update('settings', array('value' => '4.2.8'));
        echo '<ul>
            <li>Добавлена возможность добавлять контент в витрину.</li>
            </ul>';
    }

    public function down()
    {
        $this->db->where('key', 'version');
        $this->db->update('settings', array('value' => '4.2.7'));
    }

}