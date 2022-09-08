<?php
/**
 * Модификация класса Парсера
 *
 * @version 1.5
 * @author Artyuh Anton
 * @copyright 2008
 * @link http://tovit.livejournal.com
 */
/**
 * v1.5 -- поиск и обработка дублирующих блоков в шаблоне. Первоначальный вариант
 *         обрабатывает только первый блок в шаблоне.
 * v1.2 -- удаление не используемых блоков в шаблоне
 *
 */
class MY_Parser extends CI_Parser
{
    function _parse_pair($variable, $data, $string)
    {
        while (false !== ($match = $this->_match_pair($string, $variable)))
        {
            if (false === ($match = $this->_match_pair($string, $variable)))
            {
                return $string;
            }
            $str = '';
            foreach ($data as $row)
            {
                if (is_array($row))
                {
                    $temp = $match['1'];
                    foreach ($row as $key => $val)
                    {
                        if (!is_array($val))
                        {
                            $temp = $this->_parse_single($key, $val, $temp);
                        } else
                        {
                            $temp = $this->_parse_pair($key, $val, $temp);
                        }
                    }
                } else
                {
                    $temp = '';
                }
                $str .= $temp;
            }
            $string = str_replace($match['0'], $str, $string);
        }
        return $string;
    }
    function _parse_single($key, $val, $string)
    {
        $m = $this->_match_pair($string, $key);
        if ($m)
        {
            return str_replace($m[0], '', $string);
        } else
        {
            return str_replace($this->l_delim . $key . $this->r_delim, $val, $string);
        }
    }
}
