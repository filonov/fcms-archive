<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * хелпер транслита - базирован на плагине Wordpress
  Plugin Name: RusToLat
  Plugin URI: http://mywordpress.ru/plugins/rustolat/
  Description: Транслитерация русских символов URL в английские. Thanks to Alexander Shilyaev for idea. Send your suggestions and critics to <a href="mailto:skorobogatov@gmail.com">skorobogatov@gmail.com</a>.
  Author: Anton Skorobogatov <skorobogatov@gmail.com>
  Contributor: Andrey Serebryakov <saahov@gmail.com>
  Author URI: http://skorobogatov.ru/
  Version: 0.3
 */

/*function sanitize_title_with_translit($title, $ruls = 'iso')
{
    $gost = array(
        "Є" => "EH", "І" => "I", "і" => "i", "№" => "#", "є" => "eh",
        "А" => "A", "Б" => "B", "В" => "V", "Г" => "G", "Д" => "D",
        "Е" => "E", "Ё" => "JO", "Ж" => "ZH",
        "З" => "Z", "И" => "I", "Й" => "JJ", "К" => "K", "Л" => "L",
        "М" => "M", "Н" => "N", "О" => "O", "П" => "P", "Р" => "R",
        "С" => "S", "Т" => "T", "У" => "U", "Ф" => "F", "Х" => "KH",
        "Ц" => "C", "Ч" => "CH", "Ш" => "SH", "Щ" => "SHH", "Ъ" => "'",
        "Ы" => "Y", "Ь" => "", "Э" => "EH", "Ю" => "YU", "Я" => "YA",
        "а" => "a", "б" => "b", "в" => "v", "г" => "g", "д" => "d",
        "е" => "e", "ё" => "jo", "ж" => "zh",
        "з" => "z", "и" => "i", "й" => "jj", "к" => "k", "л" => "l",
        "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
        "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "kh",
        "ц" => "c", "ч" => "ch", "ш" => "sh", "щ" => "shh", "ъ" => "",
        "ы" => "y", "ь" => "", "э" => "eh", "ю" => "yu", "я" => "ya", "«" => "", "»" => "", "—" => "-", " " => "-", '"' => '', '.' => '-', '+' => '-', '?' => '', '!' => '', ',' => '-', ';' => '', ':' => '-'
    );

    $iso = array(
        "Є" => "YE", "І" => "I", "Ѓ" => "G", "і" => "i", "№" => "#", "є" => "ye", "ѓ" => "g",
        "А" => "A", "Б" => "B", "В" => "V", "Г" => "G", "Д" => "D",
        "Е" => "E", "Ё" => "YO", "Ж" => "ZH",
        "З" => "Z", "И" => "I", "Й" => "J", "К" => "K", "Л" => "L",
        "М" => "M", "Н" => "N", "О" => "O", "П" => "P", "Р" => "R",
        "С" => "S", "Т" => "T", "У" => "U", "Ф" => "F", "Х" => "X",
        "Ц" => "C", "Ч" => "CH", "Ш" => "SH", "Щ" => "SHH", "Ъ" => "'",
        "Ы" => "Y", "Ь" => "", "Э" => "E", "Ю" => "YU", "Я" => "YA",
        "а" => "a", "б" => "b", "в" => "v", "г" => "g", "д" => "d",
        "е" => "e", "ё" => "yo", "ж" => "zh",
        "з" => "z", "и" => "i", "й" => "j", "к" => "k", "л" => "l",
        "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
        "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "x",
        "ц" => "c", "ч" => "ch", "ш" => "sh", "щ" => "shh", "ъ" => "",
        "ы" => "y", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya", "«" => "", "»" => "", "—" => "-", " " => "-", '"' => '', '.' => '-', '+' => '-', '?' => '', '!' => '', ',' => '-', ';' => '-', ':' => '-'
    );
    switch ($ruls)
    {
        case 'off':
            return $title;
        case 'gost':
            return strtr($title, $gost);
        default:
            return strtr($title, $iso);
    }

    // iconv("UTF-8", "ISO-8859-1//TRANSLIT", $text)
}*/

function sanitize_title_with_translit($st, $ruls = 'iso')//makeTranslit($st)
{
    $st = mb_strtolower($st, "utf-8");
    $st = trim($st);
    $st = str_replace(array(
                ' ', '?', '!', '.', ',', ':', ';', '*', '(', ')', '{', '}', '[', ']', '%', '#', '№', '@', '$', '^', '-', '+', '/', '\\', '=', '|', '"', '\'', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ъ', 'ы', 'э', ' ', 'ж', 'ц', 'ч', 'ш', 'щ', 'ь', 'ю', 'я'), 
          array('-','-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'j', 'i', 'e', '-', 'zh', 'ts', 'ch', 'sh', 'shch', '', 'yu', 'ya'), $st);
    $st = preg_replace("/[^a-z0-9_]/", "-", $st);
    $prev_st = '';
    do
    {
        $prev_st = $st;
        $st = preg_replace("/_[a-z0-9]_/", "-", $st);
    }
    while ($st != $prev_st);

    $st = preg_replace("/_{2,}/", "-", $st);
    return $st;
}