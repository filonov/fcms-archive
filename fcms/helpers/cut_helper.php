<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Отрезает текст после [cut]
 *
 * @param string $text
 * @return string
 */
function cut($text){
    $text = explode('[cut]', $text, 2);
    return empty($text[1]) ? $text[0] : $text[0].'…';
}

/**
 * Убирает [cut] из текста
 *
 * @param string $text
 * @return string
 */
function hide_cut($text){
   return str_replace('[cut]', '', $text);
}


