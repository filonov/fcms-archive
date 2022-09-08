<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends Model
{
/**
 * @var CI_DB_active_record
 */
    var $db;

    /**
     * Возвращает значение указанной ячейки.
     * Если ничего не найдено — возвращает NULL.
     *
     * @param string $field_name
     * @return mixed|NULL
     */
    function get_cell($field_name)
    {
        $res = $this->db->get();
        return $res->row($field_name);
    }

    /**
     * Возвращает массив результатов или пустой
     * массив если ничего не найдено.
     *
     * @param string $field_name
     * @return mixed
     */
    function get_rows()
    {
        $res = $this->db->get();

        if ($res->num_rows() == 0) return array();

        return $res->result();
    }

    /**
     * Возвращает массив поле-значение или
     * NULL если ничего не найдено.
     *
     * @param string $field_name
     * @return array|NULL
     */
    function get_row()
    {
        $res = $this->db->get();

        if ($res->num_rows() == 0) return NULL;

        return $res->row();
    }
}
