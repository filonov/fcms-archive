<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_mma extends CI_Migration
{

    public function up()
    {
        // Добавляем таблицу форм
        $this->dbforge->add_field(
                array(
                    'id' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE,
                        'auto_increment' => TRUE
                    ),
                    'type' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE
                    ),
                    'mma_mark_id' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE
                    ),
		    'mma_model_id' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE
                    ),
                    'release_date' => array(
                        'type' => 'TIMESTAMP',
                    ),
                    'mma_region_id' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                    ),
                    'num_of_drivers' => array(
                        'type' => 'VARCHAR',
                        'constraint' => 255,
                    ),
                    'minimum_age' => array(
                        'type' => 'VARCHAR',
                        'constraint' => 255,
                    ),
                    'driving_experience' => array(
                        'type' => 'VARCHAR',
                        'constraint' => 255,
                    ),
                    'name' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '255',
                    ),
                    'phone' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '255',
                    ),
                    'email' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '255',
                    ),
                    'owner_type' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                    ),
                    'reg_place_type' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                    ),
                    'mma_car_type_id' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                    ),
                    'power' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                    ),
                    'mma_community_id' => array(
                        'type' => 'VARCHAR',
                        'constraint' => 255,
                    ),
                    'term_insurance' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                    ),
                    'period_of_use' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                    ),
                    'class' => array(
                        'type' => 'VARCHAR',
                        'constraint' => 255,
                    ),
                    'insurance_payments' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                    ),
                    'security_violations' => array(
                        'type' => 'VARCHAR',
                        'constraint' => 255,
                    ),
                    'contact_name' => array(
                        'type' => 'VARCHAR',
                        'constraint' => 255,
                    ),
                    'number_of_users' => array(
                        'type' => 'VARCHAR',
                        'constraint' => 255,
                    ),
                    'age' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                    ),
                    'scope' => array(
                        'type' => 'VARCHAR',
                        'constraint' => 255,
                    ),
                    'wishes' => array(
                        'type' => 'TEXT',
                        'null' => TRUE,
                    ),
                    'mma_dms_options' => array(
                        'type' => 'VARCHAR',
                        'constraint' => 1024,
                    ),
                    'comments' => array(
                        'type' => 'TEXT',
                        'null' => TRUE,
                    ),
		    'mma_other' => array(
                        'type' => 'VARCHAR',
                        'constraint' => 1024,
                    ),
                    'created' => array(
                        'type' => 'TIMESTAMP',
                    ),
                    'updated' => array(
                        'type' => 'TIMESTAMP',
                    ),
                )
        );
        $this->dbforge->add_key('id',TRUE);
        $this->dbforge->create_table('mma_forms');
        // Добавляем справочник марок автомобилей
        $this->dbforge->add_field(
                array(
                    'id' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE,
                        'auto_increment' => TRUE
                    ),
                    'mark' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '255',
                    ),
                    'created' => array(
                        'type' => 'TIMESTAMP',
                    ),
                    'updated' => array(
                        'type' => 'TIMESTAMP',
                    ),
        ));
        $this->dbforge->add_key('id',TRUE);
        $this->dbforge->create_table('mma_marks');
        // Добавляем справочник моделей
        $this->dbforge->add_field(
                array(
                    'id' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE,
                        'auto_increment' => TRUE
                    ),
                    'mark_id' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE,
                    ),
                    'model' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '255',
                    ),
                    'created' => array(
                        'type' => 'TIMESTAMP',
                    ),
                    'updated' => array(
                        'type' => 'TIMESTAMP',
                    ),
        ));
        $this->dbforge->add_key('id',TRUE);
        $this->dbforge->create_table('mma_models');
        // Добавляем справочник регионов
        $this->dbforge->add_field(
                array(
                    'id' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE,
                        'auto_increment' => TRUE
                    ),
                    'number' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE,
                    ),
                    'name' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '255',
                    ),
                    'created' => array(
                        'type' => 'TIMESTAMP',
                    ),
                    'updated' => array(
                        'type' => 'TIMESTAMP',
                    ),
        ));
        $this->dbforge->add_key('id',TRUE);
        $this->dbforge->create_table('mma_regions');
        // Добавляем справочник видов ТС
        $this->dbforge->add_field(
                array(
                    'id' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE,
                        'auto_increment' => TRUE
                    ),
                    'type' => array(
                        'type' => 'VARCHAR',
                        'constraint' => 255,
                    ),
		    'base' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                    ),
                    'created' => array(
                        'type' => 'TIMESTAMP',
                    ),
                    'updated' => array(
                        'type' => 'TIMESTAMP',
                    ),
        ));
        $this->dbforge->add_key('id',TRUE);
        $this->dbforge->create_table('mma_car_types');
        // Добавляем справочник населённых пунктов
        $this->dbforge->add_field(
                array(
                    'id' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE,
                        'auto_increment' => TRUE
                    ),
                    'mma_regions_id' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE,
                    ),
                    'name' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '255',
                    ),
                    'created' => array(
                        'type' => 'TIMESTAMP',
                    ),
                    'updated' => array(
                        'type' => 'TIMESTAMP',
                    ),
        ));
        $this->dbforge->add_key('id',TRUE);
        $this->dbforge->create_table('mma_communityes');

        $this->db->where('key', 'version');
        $this->db->update('settings', array('value' => '4.2.5'));
        echo '<ul>
            <li>Таблицы страхования.</li>
            <li>Редактор описания картинок.</li>
            </ul>';
    }

    public function down()
    {
        $this->dbforge->drop_table('mma_forms');
        $this->dbforge->drop_table('mma_marks');
        $this->dbforge->drop_table('mma_models');
        $this->dbforge->drop_table('mma_regions');
        $this->dbforge->drop_table('mma_car_types');
        $this->dbforge->drop_table('mma_communityes');
        $this->db->where('key', 'version');
        $this->db->update('settings', array('value' => '4.2.4'));
    }

}

