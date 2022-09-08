<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Test extends CI_Migration
{

    public function up()
    {
        // Добавляем страницу тестов
        $this->dbforge->add_field(
                array(
                    'id' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE,
                        'auto_increment' => TRUE
                    ),
                    'title' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '1024',
                    ),
                    'alias' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '1024',
                    ),
                    'description' => array(
                        'type' => 'TEXT',
                        'null' => TRUE,
                    ),
                    'created' => array(
                        'type' => 'TIMESTAMP',
                    ),
                    'updated' => array(
                        'type' => 'TIMESTAMP',
                    ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('testings');

        // Таблица страниц
        $this->dbforge->add_field(
                array(
                    'id' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE,
                        'auto_increment' => TRUE
                    ),
                    'tests_id' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE,
                        'null' => TRUE,
                    ),
                    'number' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE,
                    ),
                    'title' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '1024',
                    ),
                    'description' => array(
                        'type' => 'TEXT',
                        'null' => TRUE,
                    ),
                    'perfectly' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE,
                    ),
                    'perfectly_description' => array(
                        'type' => 'TEXT',
                        'null' => TRUE,
                    ),
                    'passably' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE,
                    ),
                    'passably_description' => array(
                        'type' => 'TEXT',
                        'null' => TRUE,
                    ),
                    'poorly' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE,
                    ),
                    'poorly_description' => array(
                        'type' => 'TEXT',
                        'null' => TRUE,
                    ),
                    'created' => array(
                        'type' => 'TIMESTAMP',
                    ),
                    'updated' => array(
                        'type' => 'TIMESTAMP',
                    ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('tests_pages');

        // Таблица вопросов и ответов
        $this->dbforge->add_field(
                array(
                    'id' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE,
                        'auto_increment' => TRUE
                    ),
                    'tests_id' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE,
                        'null' => TRUE,
                    ),
                    'tests_pages_id' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE,
                        'null' => TRUE,
                    ),
                    'number' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE,
                    ),
                    'title' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '1024',
                    ),
                    'description' => array(
                        'type' => 'TEXT',
                        'null' => TRUE,
                    ),
                    'created' => array(
                        'type' => 'TIMESTAMP',
                    ),
                    'updated' => array(
                        'type' => 'TIMESTAMP',
                    ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('tests_questions');

        // Таблица ответов
        $this->dbforge->add_field(
                array(
                    'id' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE,
                        'auto_increment' => TRUE
                    ),
                    'tests_questions_id' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE,
                        'null' => TRUE,
                    ),
                    'number' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE,
                    ),
                    'title' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '1024',
                    ),
                    'weight' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE,
                    ),
                    'created' => array(
                        'type' => 'TIMESTAMP',
                    ),
                    'updated' => array(
                        'type' => 'TIMESTAMP',
                    ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('tests_answers');
        
        $this->db->where('key', 'version');
        $this->db->update('settings', array('value' => '4.2.7'));
        echo '<ul>
            <li>Таблицы тестов.</li>
            </ul>';
    }

    public function down()
    {
        $this->dbforge->drop_table('testings');
        $this->dbforge->drop_table('tests_pages');
        $this->dbforge->drop_table('tests_questions');
        $this->dbforge->drop_table('tests_answers');
        $this->db->where('key', 'version');
        $this->db->update('settings', array('value' => '4.2.6'));     
    }

}