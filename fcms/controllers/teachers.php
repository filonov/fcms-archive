<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Отображение каталога преподавателей и каждого преподавателя.
 *
 * @copyright (c) 2013, Denis Filonov
 */
class Teachers extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $teachers_i = new Teacher();
        $teachers_s = new Teacher();
        $data = template_base_tags() +
                array(
                    'items_i' => $teachers_i->get_by_language(ITALIAN),
                    'items_s' => $teachers_s->get_by_language(SPAIN),
                    'meta_title' => 'Преподаватели',
                    'meta_description' => '',
                    'meta_keywords' => ''
        );
        $this->parser->parse($this->config->item('tplpath') . $this->config->item('skin') . '/' . 'teachers', $data);
    }

    function teacher($id)
    {
        #REFACTOR в модель
        $teachers = new Teacher();
        $teachers->get_by_id($id);

        // Группы для учителей
        $this->db
                ->select('groups.id as id, 
                groups.title as title, 
                groups.date as date,
                levels.title as level,
                groups.days as days,
                groups.time as time,
                statuses.status_text as status_text')
                ->from('groups')
                ->join('teachers', 'groups.teacher = teachers.id')
                ->join('statuses', 'groups.status = statuses.id')
                ->join('levels', 'groups.level = levels.id')
                ->where('groups.type', GROUP_STANDART)
                ->where('teachers.id',$id)
                ->order_by('groups.date');
        $query1 = $this->db->get();
        $groups = $query1->result();





        // Спецкурсы для учителей
        $this->db->select('specials.title as title, 
                groups.id as id, 
                groups.date as date,
                teachers.title_short as title_short,
                groups.days as days,
                groups.time as time,
                statuses.status_text as status_text');
        $this->db->from('groups')
                ->join('teachers', 'groups.teacher = teachers.id')
                ->join('statuses', 'groups.status = statuses.id')
                ->join('specials', 'groups.special = specials.id')
                ->where('teachers.id', $id)
                ->where('groups.type', GROUP_SPECIAL);
        $query = $this->db->get();
        $groups_s = $query->result();

        $gallery = new Image();
        $gallery->where(array('category_id' => $teachers->gallery_id))->get();

        $data = template_base_tags() +
                array(
                    'item' => $teachers,
                    'gallery' => $gallery,
                    'groups' => $groups,
                    'groups_s' => $groups_s,
                    'meta_title' => $teachers->title,
                    'meta_description' => $teachers->title,
                    'meta_keywords' => $teachers->title
        );
        $this->parser->parse($this->config->item('tplpath') . $this->config->item('skin') . '/' . 'teachers_item', $data);
    }

}
