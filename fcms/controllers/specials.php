<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Контроллер вывода спецкурсов.
 *
 * @author Denis Filonov <denis@filonov.biz>
 * @copyright (c) 2013, Denis Filonov.
 */
class Specials extends CI_Controller
{

    function index()
    {
        $specials_i = new Specials_orm();
        $specials_e = new Specials_orm();
        $data = template_base_tags() +
                array(
                    'specials_i' => $specials_i->get_by_language(ITALIAN),
                    'specials_e' => $specials_e->get_by_language(SPAIN),
                    'meta_title' => 'Авторские курсы Liberum',
                    'meta_description' => 'Авторские курсы Liberum',
                    'meta_keywords' => 'Авторские курсы Liberum'
        );
        $this->parser->parse($this->config->item('tplpath') . $this->config->item('skin') . '/specials', $data);
    }

    private function sp_page($alias)
    {
        $special = new Specials_orm();
        $special->get_by_link($alias);
        if ($special->exists())
        {
            //$groups = new Group();
            //$groups->get_by_special($special->id);
            #REFACTOR сделать на ORM
            $this->db->select('groups.title as gtitle, 
                groups.id as gid, 
                groups.date as date,
                teachers.title_short as title_short,
                groups.days as days,
                groups.time as time,
                statuses.status_text as status_text');
            $this->db->from('groups')
                    ->join('teachers', 'groups.teacher = teachers.id')
                    ->join('statuses', 'groups.status = statuses.id')
                    ->where('groups.special', $special->id)
                    ->where('groups.type', GROUP_SPECIAL);
            $query = $this->db->get();
            $groups_s = $query->result();
            $data = template_base_tags() +
                    array(
                        'item' => $special,
                        'groups' => $groups_s,
                        'meta_title' => $special->title,
                        'meta_description' => $special->description,
                        'meta_keywords' => ''
            );
            $this->parser->parse($this->config->item('tplpath') . $this->config->item('skin') . '/specials_item', $data);
        }
        else
            show_404();
    }

    function italiano($alias = NUll)
    {
        if ($alias != NULL)
        {
            $this->sp_page($alias);
        }
    }

    function espanol($alias = NUll)
    {
        if ($alias != NULL)
        {
            $this->sp_page($alias);
        }
    }

}