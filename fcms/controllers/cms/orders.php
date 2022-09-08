<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Администрирование заказов
 * @author Denis Filonov <denis@filonov.biz>
 */
class Orders extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_root();
    }

    /**
     * Список заказов.
     * @param string $category 
     */
    function index($category = 'new', $page = 1)
    {
        $visual = new Visual_elements();
        $orders = new Orders_orm();
        $orders->order_by('created, name, id');
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
            'orders' => $orders->where('status', $status)->get_paged($page, $this->config->item('per_page')),
            'status' => $category,
            'paginator' => $visual->paginator(base_url('cms/orders/' . $category . '/'), $orders->where('status', $status)->count(), 4, $this->config->item('per_page'))
        );
        $this->parser->parse($this->config->item('tplpath') . 'cms/orders', $data);
    }

    /**
     * Просмотр конкретного заказа.
     * @param integer $id
     */
    function edit($id = FALSE)
    {
        $row = new Orders_orm();

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
                $this->db->select('*'/* 'catalog.title AS title, catalog.price AS price, orders_items.quantity AS quantity' */)->
                        from('items')->join('orders_items', 'orders_items.catalog_id = catalog.id')->
                        where(array('orders_items.orders_id' => $id));
                $qitems = $this->db->get();
                $data = template_base_tags() + array(
                    'error' => $error,
                    'id' => $id,
                    'item' => $row,
                    'items' => $qitems->result(),
                    'method_path' => base_url('cms/orders/edit/' . $id)
                );
                $this->parser->parse($this->config->item('tplpath') . 'cms/orders_entry', $data);
            }
            else
                redirect('cms/orders/edit/' . $id);
        } else
        {
            // Редактируем заказ.
            $row->get_by_id($id);
            $this->db->select('*'/* 'catalog.title AS title, catalog.price AS price, orders_items.quantity AS quantity' */)->
                    from('items')->join('orders_items', 'orders_items.catalog_id = items.id')->
                    where(array('orders_items.orders_id' => $id));
            $qitems = $this->db->get();

            $data = template_base_tags() + array(
                'error' => '',
                'id' => $id,
                'item' => $row,
                'items' => $qitems->result(),
                'method_path' => base_url('cms/orders/edit/' . $id)
            );

            $this->parser->parse($this->config->item('tplpath') . 'cms/orders_entry', $data);
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
                    $s = new Orders_orm();
                    $s->get_by_id($c);
                    $s->delete();
                }
                redirect('cms/orders');
            }
        }
        else
            redirect('cms/orders');
    }

}
