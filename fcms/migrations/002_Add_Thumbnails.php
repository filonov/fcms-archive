<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Thumbnails extends CI_Migration
{

    public function up()
    {

        $fields = array(
            'thumbnail' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
        );
        $this->dbforge->add_column('content', $fields);
        $this->dbforge->add_column('pages', $fields);
        $this->db->where('key', 'version');
        $this->db->update('settings',array('value' => '4.2.1'));
        echo '<ul><li>Content thumbnails added.</li><li>Pages thumbnails added.</li></ul>';
    }

    public function down()
    {
        $this->dbforge->drop_column('content', 'thumbnail');
        $this->dbforge->drop_column('pages', 'thumbnail');
        $this->db->where('key', 'version');
        $this->db->update('settings',array('value' => '4.2.0'));
    }

}