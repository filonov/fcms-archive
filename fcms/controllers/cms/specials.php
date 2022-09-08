<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Контроллер админки сентября
 *
 * @author DVF
 */
class Specials extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_root();
    }

    /**
     * Таблица групп
     * @param string $category 
     */
    /* function index()
      {
      $gr = new Group();
      $levels = new Levels_orm();
      $sp = new Specials_orm();
      $pr = new Programs_orm();
      $t = new Teacher();
      $textbooks = new Textbook();
      $status = new Statuses_orm();


      $q = $this->db->select('*')
      ->join('statuses', 'groups.status = statuses.id')
      ->order_by('groups.date')
      ->get('groups');
      $res = $q->result();


      $data = template_base_tags() + array(
      'groups' => $gr->get(),
      'levels' => $levels->get(),
      'specials' => $sp->get(),
      'programs' => $pr->get(),
      'textbooks' => $textbooks->get(),
      'status' => $status->get(),
      'teachers' => $t->get()
      );
      $this->parser->parse($this->config->item('tplpath') . 'cms/groups', $data);
      } */

    function index($lang = 'italiano')
    {
        $specials = new Specials_orm();
        $lng = ITALIAN;

        $page_title = 'Итальянский язык';

        if ($lang == 'italiano')
        {
            $specials->where('language', ITALIAN);
            $page_title = 'Итальянский язык';
        } elseif ($lang == 'espanol')
        {
            $lng = SPAIN;
            $specials->where('language', SPAIN);
            $page_title = 'Испанский язык';
        } else
        {
            show_404();
            exit();
        }

        $data = template_base_tags() +
                array(
                    'specials' => $specials->get(),
                    'language' => $page_title,
                    'meta_title' => $page_title,
                    'meta_description' => $page_title,
                    'meta_keywords' => $page_title
        );
        $this->parser->parse($this->config->item('tplpath') . 'cms/specials2', $data);
    }

    /**
     * Добавление новой записи
     * #REFACTOR Не пере
     */
    function add()
    {
        $s = new Specials_orm();
        $s->skip_validation()->save();
        redirect('cms/specials/edit/' . $s->id);
    }

    private function sl($s, $l)
    {
        $s_l = new Specials_levels_orm();
        $res = $s_l->get_where(array(
            'id_specials' => $s,
            'id_levels' => $l
        ));
        if ($res->exists())
        {
            return 'checked';
        }
        else
            return '';
    }

    /**
     * Редактировать.
     * @param integer $id
     */
    function edit($id = FALSE)
    {
        $special = new Specials_orm();
        $levels = new Levels_orm();

        $error = '';
        $sl = array();
        $special->get_by_id($id);
        if ($this->input->post())
        {
            $special->title = $this->input->post('title', TRUE);
            $special->description = $this->input->post('description', TRUE);
            $special->text = $this->input->post('text', TRUE);
            $special->order = $this->input->post('order', TRUE);


            $this->load->helper('translit');



            if ($this->input->post('link'))
            {
                $special->link = sanitize_title_with_translit($this->input->post('link', TRUE));
            } else
            {
                $special->link = sanitize_title_with_translit($this->input->post('title', TRUE));
            }



            $special->language = $this->input->post('language', TRUE);
            $success = $special->save();
            if (!$success)
            {
                $error = 'Ошибка сохранения.';
                if (!($special->valid))
                {
                    $error = $special->error->string;
                } else
                {
                    $error = 'Неизвестная ошибка валидации.';
                }
            } else
            {
                if ($this->input->post('specials_levels'))
                {
                    $for_lev = $this->input->post('specials_levels', TRUE);
                    //debug_print($for_lev);
                    $s_l = new Specials_levels_orm();
                    $s_l->get_where(array('id_specials' => $id));
                    $s_l->delete_all();
                    foreach ($for_lev as $value)
                    {
                        $s_l2 = new Specials_levels_orm();
                        $s_l2->id_specials = $id;
                        $s_l2->id_levels = $value;
                        $s_l2->skip_validation()->save();
                    }
                }
            }
        }

        foreach ($levels->get() as $l)
        {
            $sl[$l->id] = $this->sl($id, $l->id);
        }
        $levels->order_by('order, title');
        $data = template_base_tags() + array(
            'error' => $error,
            'levels' => $levels->get(),
            'content' => $special,
            'specials_levels' => $sl
        );
        $this->parser->parse($this->config->item('tplpath') . 'cms/specials_entry', $data);
    }

    function edit_order()
    {
        $data = array();
        if ($this->input->post('order') && $this->input->post('id'))
        {
            $id = (int) $this->input->post('id', TRUE);
            $order = (int) $this->input->post('order', TRUE);
            $group = new Group();
            $group->get_by_id($id);
            $group->order = $order;
            $group->save();
            $data += array(
                'order' => $group->order
            );
        }
        echo json_encode($data);
    }

    function delete()
    {
        if ($this->input->post('check'))
        {
            $check = $_POST['check'];
            if ($check)
            {
                foreach ($check as $c)
                {
                    $s = new Specials_orm();
                    $s->get_by_id($c);
                    $s->delete();
                }
                redirect('cms/specials');
            }
        }
        else
            redirect('cms/specials');
    }

}
