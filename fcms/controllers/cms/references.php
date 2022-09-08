<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Контроллер админки справочников для liberum-center.ru
 * @author Denis Filonov <denis@filonov.biz>
 * @copyright (c) 2013, Denis Filonov
 * @link http://filonov.biz
 */

class References extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_root();
    }

    /**
     * Уровни
     */
    function levels()
    {
        $levels = new Levels_orm();
        $levels->order_by('order, title');
        $data = template_base_tags() + array(
            'content' => $levels->get(),
        );

        $this->parser->parse($this->config->item('tplpath') . 'cms/levels', $data);
    }

    /**
     * Добавить уровень
     */
    function add_level()
    {
        $level = new Levels_orm();
        if ($this->input->post())
        {
            $level->title = $this->input->post('title', TRUE);
            $level->order = (int) $this->input->post('order', TRUE);
            $success = $level->save();
            if (!$success)
            {
                $error = 'Ошибка сохранения.';
                if (!($level->valid))
                {
                    $error = $level->error->string;
                } else
                {
                    $error = 'Неизвестная ошибка валидации.';
                }

                $data = template_base_tags() + array(
                    'content' => $level->get(), 'error' => $error
                );
                $this->parser->parse($this->config->item('tplpath') . 'cms/levels', $data);
            } else
            {
                redirect('cms/references/levels');
            }
        } else
        {
            redirect('cms/references/levels');
        }
    }

    function delete_level()
    {
        if ($this->input->post('check'))
        {
            $check = $_POST['check'];
            if ($check)
            {
                foreach ($check as $c)
                {
                    $l = new Levels_orm();
                    $l->get_by_id($c);
                    $l->delete();
                }
                redirect('cms/references/levels');
            }
        } else
            redirect('cms/references/levels');
    }

    function edit_level()
    {
        $data = array();
        if ($this->input->post())
        {
            $id = $this->input->post('id', TRUE);
            $title = $this->input->post('title', TRUE);
            $order = (int) $this->input->post('order', TRUE);
            $level = new Levels_orm();
            $level->get_by_id($id);
            $level->title = $title;
            $level->order = $order;
            $level->save();
            $data += array(
                'order' => $level->order,
                'title' => $level->title
            );
        }
        echo json_encode($data);
    }

    /**
     * Программы
     */
    function programs()
    {

        $programs = new Programs_orm();
        $programs->order_by('order, title');
        $data = template_base_tags() + array(
            'content' => $programs->get()
        );

        $this->parser->parse($this->config->item('tplpath') . 'cms/programs', $data);
    }

    function add_program()
    {
        $program = new Programs_orm();
        if ($this->input->post())
        {
            $program->title = $this->input->post('title', TRUE);
            $program->order = (int) $this->input->post('order', TRUE);
            $program->link = $this->input->post('link', TRUE);
            $success = $program->save();
            if (!$success)
            {
                $error = 'Ошибка сохранения.';
                if (!($program->valid))
                {
                    $error = $program->error->string;
                } else
                {
                    $error = 'Неизвестная ошибка валидации.';
                }

                $data = template_base_tags() + array(
                    'content' => $program->get(), 'error' => $error
                );
                $this->parser->parse($this->config->item('tplpath') . 'cms/programs', $data);
            } else
            {
                redirect('cms/references/programs');
            }
        } else
        {
            redirect('cms/references/programs');
        }
    }

    function delete_program()
    {
        if ($this->input->post('check'))
        {
            $check = $_POST['check'];
            if ($check)
            {
                foreach ($check as $c)
                {
                    $l = new Programs_orm();
                    $l->get_by_id($c);
                    $l->delete();
                }
                redirect('cms/references/programs');
            }
        } else
            redirect('cms/references/programs');
    }

    function edit_program()
    {
        $data = array();
        if ($this->input->post())
        {
            $id = $this->input->post('id', TRUE);
            $title = $this->input->post('title', TRUE);
            $order = (int) $this->input->post('order', TRUE);
            $link = $this->input->post('link', TRUE);
            $program = new Programs_orm();
            $program->get_by_id($id);
            $program->title = $title;
            $program->order = $order;
            $program->link = $link;
            $program->save();
            $data += array(
                'order' => $program->order,
                'title' => $program->title,
                'link' => $program->link
            );
        }
        echo json_encode($data);
    }

    /**
     * Учебники
     */
    function textbooks()
    {

        $textbooks = new Textbook();
        $textbooks->order_by('order, title');
        $data = template_base_tags() + array(
            'content' => $textbooks->get()
        );

        $this->parser->parse($this->config->item('tplpath') . 'cms/textbooks', $data);
    }

    function add_textbook()
    {
        $textbook = new Textbook();
        if ($this->input->post())
        {
            $textbook->title = $this->input->post('title', TRUE);
            $textbook->order = (int) $this->input->post('order', TRUE);
            $textbook->link = $this->input->post('link', TRUE);
            $success = $textbook->save();
            if (!$success)
            {
                $error = 'Ошибка сохранения.';
                if (!($textbook->valid))
                {
                    $error = $textbook->error->string;
                } else
                {
                    $error = 'Неизвестная ошибка валидации.';
                }

                $data = template_base_tags() + array(
                    'content' => $textbook->get(), 'error' => $error
                );
                $this->parser->parse($this->config->item('tplpath') . 'cms/textbooks', $data);
            } else
            {
                redirect('cms/references/textbooks');
            }
        } else
        {
            redirect('cms/references/textbooks');
        }
    }

    function delete_textbook()
    {
        if ($this->input->post('check'))
        {
            $check = $_POST['check'];
            if ($check)
            {
                foreach ($check as $c)
                {
                    $l = new Textbook();
                    $l->get_by_id($c);
                    $l->delete();
                }
                redirect('cms/references/textbooks');
            }
        } else
            redirect('cms/references/textbooks');
    }

    function edit_textbook()
    {
        $data = array();
        if ($this->input->post())
        {
            $id = $this->input->post('id', TRUE);
            $title = $this->input->post('title', TRUE);
            $order = (int) $this->input->post('order', TRUE);
            $link = $this->input->post('link', TRUE);
            $textbook = new Textbook();
            $textbook->get_by_id($id);
            $textbook->title = $title;
            $textbook->order = $order;
            $textbook->link = $link;
            $textbook->save();
            $data += array(
                'order' => $textbook->order,
                'title' => $textbook->title,
                'link' => $textbook->link
            );
        }
        echo json_encode($data);
    }

    /**
     *  Стоимость обучения
     */
    function prices()
    {

        $prices = new Prices_orm();
        $prices->order_by('order, title');
        $data = template_base_tags() + array(
            'content' => $prices->get()
        );

        $this->parser->parse($this->config->item('tplpath') . 'cms/prices', $data);
    }

    function add_price()
    {
        $price = new Prices_orm();
        if ($this->input->post())
        {
            $price->title = $this->input->post('title', TRUE);
            $price->order = (int) $this->input->post('order', TRUE);
            $price->description = $this->input->post('description', TRUE);
            $success = $price->save();
            if (!$success)
            {
                $error = 'Ошибка сохранения.';
                if (!($price->valid))
                {
                    $error = $price->error->string;
                } else
                {
                    $error = 'Неизвестная ошибка валидации.';
                }

                $data = template_base_tags() + array(
                    'content' => $price->get(), 'error' => $error
                );
                $this->parser->parse($this->config->item('tplpath') . 'cms/prices', $data);
            } else
            {
                redirect('cms/references/prices');
            }
        } else
        {
            redirect('cms/references/prices');
        }
    }

    function delete_price()
    {
        if ($this->input->post('check'))
        {
            $check = $_POST['check'];
            if ($check)
            {
                foreach ($check as $c)
                {
                    $l = new Prices_orm();
                    $l->get_by_id($c);
                    $l->delete();
                }
                redirect('cms/references/prices');
            }
        } else
            redirect('cms/references/prices');
    }

    function edit_price()
    {
        $data = array();
        if ($this->input->post())
        {
            $id = $this->input->post('id', TRUE);
            $title = $this->input->post('title', TRUE);
            $order = (int) $this->input->post('order', TRUE);
            $description = $this->input->post('description', TRUE);
            $price = new Prices_orm();
            $price->get_by_id($id);
            $price->title = $title;
            $price->order = $order;
            $price->description = $description;
            $price->save();
            $data += array(
                'order' => $price->order,
                'title' => $price->title,
                'description' => $price->description
            );
        }
        echo json_encode($data);
    }

    /**
     * Программы
     */
    function tests()
    {

        $tests = new Tests_orm();
        $tests->order_by('order, title');
        $data = template_base_tags() + array(
            'content' => $tests->get()
        );

        $this->parser->parse($this->config->item('tplpath') . 'cms/tests', $data);
    }

    function add_test()
    {
        $test = new Tests_orm();
        if ($this->input->post())
        {
            $test->title = $this->input->post('title', TRUE);
            $test->order = (int) $this->input->post('order', TRUE);
            $test->link = $this->input->post('link', TRUE);
            $success = $test->save();
            if (!$success)
            {
                $error = 'Ошибка сохранения.';
                if (!($test->valid))
                {
                    $error = $test->error->string;
                } else
                {
                    $error = 'Неизвестная ошибка валидации.';
                }

                $data = template_base_tags() + array(
                    'content' => $test->get(), 'error' => $error
                );
                $this->parser->parse($this->config->item('tplpath') . 'cms/tests', $data);
            } else
            {
                redirect('cms/references/tests');
            }
        } else
        {
            redirect('cms/references/tests');
        }
    }

    function delete_test()
    {
        if ($this->input->post('check'))
        {
            $check = $_POST['check'];
            if ($check)
            {
                foreach ($check as $c)
                {
                    $l = new Tests_orm();
                    $l->get_by_id($c);
                    $l->delete();
                }
                redirect('cms/references/tests');
            }
        } else
            redirect('cms/references/tests');
    }

    function edit_test()
    {
        $data = array();
        if ($this->input->post())
        {
            $id = $this->input->post('id', TRUE);
            $title = $this->input->post('title', TRUE);
            $order = (int) $this->input->post('order', TRUE);
            $link = $this->input->post('link', TRUE);
            $test = new Tests_orm();
            $test->get_by_id($id);
            $test->title = $title;
            $test->order = $order;
            $test->link = $link;
            $test->save();
            $data += array(
                'order' => $test->order,
                'title' => $test->title,
                'link' => $test->link
            );
        }
        echo json_encode($data);
    }

    /**
     *  Продолжительность обучения
     */
    function durations()
    {

        $durations = new Durations_orm();
        $durations->order_by('order, title');
        $data = template_base_tags() + array(
            'content' => $durations->get()
        );

        $this->parser->parse($this->config->item('tplpath') . 'cms/durations', $data);
    }

    function add_duration()
    {
        $duration = new Durations_orm();
        if ($this->input->post())
        {
            $duration->title = $this->input->post('title', TRUE);
            $duration->order = (int) $this->input->post('order', TRUE);
            $duration->description = $this->input->post('description', TRUE);
            $success = $duration->save();
            if (!$success)
            {
                $error = 'Ошибка сохранения.';
                if (!($duration->valid))
                {
                    $error = $duration->error->string;
                } else
                {
                    $error = 'Неизвестная ошибка валидации.';
                }

                $data = template_base_tags() + array(
                    'content' => $duration->get(), 'error' => $error
                );
                $this->parser->parse($this->config->item('tplpath') . 'cms/durations', $data);
            } else
            {
                redirect('cms/references/durations');
            }
        } else
        {
            redirect('cms/references/durations');
        }
    }

    function delete_duration()
    {
        if ($this->input->post('check'))
        {
            $check = $_POST['check'];
            if ($check)
            {
                foreach ($check as $c)
                {
                    $l = new Durations_orm();
                    $l->get_by_id($c);
                    $l->delete();
                }
                redirect('cms/references/durations');
            }
        } else
            redirect('cms/references/durations');
    }

    function edit_duration()
    {
        $data = array();
        if ($this->input->post())
        {
            $id = $this->input->post('id', TRUE);
            $title = $this->input->post('title', TRUE);
            $order = (int) $this->input->post('order', TRUE);
            $description = $this->input->post('description', TRUE);
            $duration = new Durations_orm();
            $duration->get_by_id($id);
            $duration->title = $title;
            $duration->order = $order;
            $duration->description = $description;
            $duration->save();
            $data += array(
                'order' => $duration->order,
                'title' => $duration->title,
                'description' => $duration->description
            );
        }
        echo json_encode($data);
    }

    /**
     * Уровни
     * 
     */
    function formats()
    {
        $formats = new Formats_orm();
        $formats->order_by('order, title');
        $data = template_base_tags() + array(
            'content' => $formats->get()
        );

        $this->parser->parse($this->config->item('tplpath') . 'cms/formats', $data);
    }

    function add_format()
    {
        $format = new Formats_orm();
        if ($this->input->post())
        {
            $format->title = $this->input->post('title', TRUE);
            $format->order = (int) $this->input->post('order', TRUE);
            $success = $format->save();
            if (!$success)
            {
                $error = 'Ошибка сохранения.';
                if (!($format->valid))
                {
                    $error = $format->error->string;
                } else
                {
                    $error = 'Неизвестная ошибка валидации.';
                }

                $data = template_base_tags() + array(
                    'content' => $format->get(), 'error' => $error
                );
                $this->parser->parse($this->config->item('tplpath') . 'cms/formats', $data);
            } else
            {
                redirect('cms/references/formats');
            }
        } else
        {
            redirect('cms/references/formats');
        }
    }

    function delete_format()
    {
        if ($this->input->post('check'))
        {
            $check = $_POST['check'];
            if ($check)
            {
                foreach ($check as $c)
                {
                    $l = new Formats_orm();
                    $l->get_by_id($c);
                    $l->delete();
                }
                redirect('cms/references/formats');
            }
        } else
            redirect('cms/references/formats');
    }

    function edit_format()
    {
        $data = array();
        if ($this->input->post())
        {
            $id = $this->input->post('id', TRUE);
            $title = $this->input->post('title', TRUE);
            $order = (int) $this->input->post('order', TRUE);
            $format = new Formats_orm();
            $format->get_by_id($id);
            $format->title = $title;
            $format->order = $order;
            $format->save();
            $data += array(
                'order' => $format->order,
                'title' => $format->title
            );
        }
        echo json_encode($data);
    }

    /**
     * Статусы групп
     */
    function statuses()
    {
        $statuses = new Statuses_orm();
        $statuses->order_by('order, status_text');
        $data = template_base_tags() + array(
            'content' => $statuses->get()
        );
        $this->parser->parse($this->config->item('tplpath') . 'cms/statuses', $data);
    }

    function add_status()
    {
        $status = new Statuses_orm();
        if ($this->input->post())
        {
            $status->status_text = $this->input->post('status_text', TRUE);
            $status->if_late = $this->input->post('if_late', TRUE);
            $status->order = (int) $this->input->post('order', TRUE);
            $status->critery = (int) $this->input->post('critery', TRUE);
            $success = $status->save();
            if (!$success)
            {
                $error = 'Ошибка сохранения.';
                if (!($status->valid))
                {
                    $error = $status->error->string;
                } else
                {
                    $error = 'Неизвестная ошибка валидации.';
                }

                $data = template_base_tags() + array(
                    'content' => $status->get(), 'error' => $error
                );
                $this->parser->parse($this->config->item('tplpath') . 'cms/statuses', $data);
            } else
            {
                redirect('cms/references/statuses');
            }
        } else
        {
            redirect('cms/references/statuses');
        }
    }

    function delete_status()
    {
        if ($this->input->post('check'))
        {
            $check = $_POST['check'];
            if ($check)
            {
                foreach ($check as $c)
                {
                    $l = new Statuses_orm();
                    $l->get_by_id($c);
                    $l->delete();
                }
                redirect('cms/references/statuses');
            }
        } else
            redirect('cms/references/statuses');
    }

    function edit_status()
    {
        $data = array();
        if ($this->input->post())
        {
            $id = $this->input->post('id', TRUE);
            $status_text = $this->input->post('status_text', TRUE);
            $if_late = $this->input->post('if_late', TRUE);
            $order = (int) $this->input->post('order', TRUE);
            $critery = (int) $this->input->post('critery', TRUE);
            $status = new Statuses_orm();
            $status->get_by_id($id);
            $status->status_text = $status_text;
            $status->if_late = $if_late;
            $status->order = $order;
            $status->critery = $critery;
            $status->save();
            $data += array(
                'order' => $status->order,
                'critery' => $status->critery,
                'status_text' => $status->status_text,
                'if_late' => $status->if_late,
            );
        }
        echo json_encode($data);
    }

    /**
     * Спецкурсы
     */
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

    function specials()
    {
        $specials = new Specials_orm();
        $specials->order_by('order, title');
        $levels = new Levels_orm();
        $levels->order_by('order, title');
        $sl = array();

        foreach ($specials->get() as $s)
        {
            foreach ($levels->get() as $l)
            {
                $sl[$s->id][$l->id] = $this->sl($s->id, $l->id);
            }
        }
        $data = template_base_tags() + array(
            'content' => $specials->get(),
            'levels' => $levels->get(),
            'specials_levels' => $sl
        );
        $this->parser->parse($this->config->item('tplpath') . 'cms/specials', $data);
    }

    function add_special()
    {
        $special = new Specials_orm();
        $s_l = new Specials_levels_orm();
        if ($this->input->post())
        {
            $special->title = $this->input->post('title', TRUE);
            $special->description = $this->input->post('description', TRUE);
            $special->order = $this->input->post('order', TRUE);
            $special->link = $this->input->post('link', TRUE);
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

                $data = template_base_tags() + array(
                    'content' => $special->get(), 'error' => $error
                );
                $this->parser->parse($this->config->item('tplpath') . 'cms/specials', $data);
            } else
            {
                $for_lev = $this->input->post('specials-levels', TRUE);
                // Просто добавить, так как до этого не было таких записей
                foreach ($for_lev as $value)
                {
                    $s_l->id_specials = $special->id;
                    $s_l->id_levels = $value;
                    $s_l->skip_validation()->save_as_new();
                }
                redirect('cms/references/specials');
            }
        } else
        {
            redirect('cms/references/specials');
        }
    }

    function delete_special()
    {
        if ($this->input->post('check'))
        {
            $check = $_POST['check'];
            if ($check)
            {
                foreach ($check as $c)
                {
                    $l = new Specials_orm();
                    $l->get_by_id($c);
                    $l->delete();
                }
                redirect('cms/references/specials');
            }
        } else
            redirect('cms/references/specials');
    }

    function edit_special()
    {
        $data = array();
        if ($this->input->post())
        {
            $id = $this->input->post('id', TRUE);
            $title = $this->input->post('title', TRUE);
            $description = $this->input->post('description', TRUE);
            $order = $this->input->post('order', TRUE);
            $link = $this->input->post('link', TRUE);
            $special = new Specials_orm();
            $special->get_by_id($id);
            $special->title = $title;
            $special->description = $description;
            $special->order = $order;
            $special->link = $link;
            $special->save();
            $data += array(
                'order' => $special->order,
                'link' => $special->link,
                'title' => $special->title,
                'description' => $special->description,
            );
        }
        echo json_encode($data);
    }

    function edit_specials_levels()
    {
        $data = array();
        if ($this->input->post())
        {
            $s = $this->input->post('s', TRUE);
            $l = $this->input->post('l', TRUE);
            $sl = new Specials_levels_orm();
            $sl->get_where(array('id_specials' => $s, 'id_levels' => $l));
            if ($sl->exists())
                $sl->delete();
            else
            {
                $sl->id_specials = $s;
                $sl->id_levels = $l;
                $sl->skip_validation()->save();
            }
        }
        echo json_encode($data);
    }

}
