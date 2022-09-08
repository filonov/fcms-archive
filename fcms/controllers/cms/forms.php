<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Администрирование форм
 * @author Denis Filonov <denis@filonov.biz>
 */
class Forms extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_root();
    }

    /**
     * Список Форм.
     * @param string $category 
     */
    function index($category = 'new', $page = 1)
    {
        $visual = new Visual_elements();
        $forms = new Form();
        $forms->order_by('created', 'DESC');
        $status = ORDER_NEW;
        switch ($category)
        {
            case 'new':
                $status = ORDER_NEW;
                break;
            case 'processing':
                $status = ORDER_PROCESSING;
                break;
            case 'completed':
                $status = ORDER_COMPLETED;
                break;
            case 'refused':
                $status = ORDER_REFUSED;
                break;
        }
        $data = template_base_tags() + array(
            'forms' => $forms->where('status', $status)->include_related('group')->get_paged($page, $this->config->item('per_page')),
            'status' => $category,
            'paginator' => $visual->paginator(base_url('cms/forms/' . $category . '/'), $forms->where('status', $status)->include_related('group')->count(), 4, $this->config->item('per_page'))
        );
        $this->parser->parse($this->config->item('tplpath') . 'cms/forms', $data);
    }
    
    function index_brillanza($category = 'new', $page = 1)
    {
        $visual = new Visual_elements();
        $forms = new Form_bril();
        $forms->order_by('created, name, id');
        $data = template_base_tags() + array(
            'forms' => $forms->get_paged($page, $this->config->item('per_page')),
            'status' => $category,
            'paginator' => $visual->paginator(base_url('cms/forms/' . $category . '/'), $forms->count(), 4, $this->config->item('per_page'))
        );
        $this->parser->parse($this->config->item('tplpath') . 'cms/forms_bril', $data);
    }
    
    
    function edit_bril($id = FALSE)
    {
         $row = new Form_bril($id);

        // Сохранение
        if ($this->input->post('eid'))
        {
            $row->get_by_id($id);
            $row->status = (int) $this->input->post('status', TRUE);
            $success = $row->skip_validation()->save();
            if (!$success)
            {
                $error = 'Ошибка сохранения.';
                if (!($row->valid))
                {
                    $error = $row->error->string;
                }
              
                $data = template_base_tags() + array(
                    'error' => $error,
                    'id' => $id,
                    'item' => $row,
                    'items' => $qitems->result(),
                    'method_path' => base_url('cms/forms/edit/' . $id)
                );
                $this->parser->parse($this->config->item('tplpath') . 'cms/forms_entry_bril', $data);
            }
            else
                redirect('cms/forms/edit/' . $id);
        } else
        {
            // Редактируем заказ.
      
     
           //$this->output->enable_profiler(TRUE);
           
            $data = template_base_tags() + array(
                'error' => '',
                'id' => $id,
                'item' => $row,
               
                'method_path' => base_url('cms/forms/edit/' . $id)
            );

            $this->parser->parse($this->config->item('tplpath') . 'cms/forms_entry', $data);
        }
    }

    /**
     * Просмотр конкретного заказа.
     * @param integer $id
     */
    function edit($id = FALSE)
    {
        $row = new Form();

        // Сохранение
        if ($this->input->post('eid'))
        {
            $row->get_by_id($id);
            $row->status = (int) $this->input->post('status', TRUE);
            $success = $row->skip_validation()->save();
            if (!$success)
            {
                $error = 'Ошибка сохранения.';
                if (!($row->valid))
                {
                    $error = $row->error->string;
                }
              
                $data = template_base_tags() + array(
                    'error' => $error,
                    'id' => $id,
                    'item' => $row,
                    'items' => $qitems->result(),
                    'method_path' => base_url('cms/forms/edit/' . $id)
                );
                $this->parser->parse($this->config->item('tplpath') . 'cms/forms_entry', $data);
            }
            else
                redirect('cms/forms/edit/' . $id);
        } else
        {
            // Редактируем заказ.
            $row->include_related('group');
            $row->get_by_id($id);
           //$this->output->enable_profiler(TRUE);
           
            $data = template_base_tags() + array(
                'error' => '',
                'id' => $id,
                'item' => $row,
               
                'method_path' => base_url('cms/forms/edit/' . $id)
            );

            $this->parser->parse($this->config->item('tplpath') . 'cms/forms_entry', $data);
        }
    }

    /**
     * Удалить заказ.
     */
    function delete()
    {
        if ($this->input->post('check'))
        {
            $check = $_POST['check'];
            if ($check)
            {
                foreach ($check as $c)
                {
                    $s = new Form();
                    $s->get_by_id($c);
                    $s->delete();
                }
                redirect('cms/forms');
            }
        }
        else
            redirect('cms/forms');
    }

}
