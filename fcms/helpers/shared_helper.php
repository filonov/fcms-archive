<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Общие функции движка
 *
 */

/**
 * Выдаёт список файлов в указанной директории.
 * @param <string> $path Директория.
 * @return <array>
 */
function get_files($path)
{
    $dirs = array();
    if ($handle = opendir($path))
    {
        while (false !== ($file = readdir($handle)))
        {
            $dname = $path . $file;
            if (($dname != ".") && ($dname != "..") && (is_dir($dname) == FALSE))
            {
                $dirs[] = $file;
            }
        }
        closedir($handle);
    }
    $bad = array(".", "..", ".DS_Store", "_notes", "Thumbs.db");
    $res = array_diff($dirs, $bad);
    return $res;
}

function delete_directory($dir)
{
    $files = array_diff(scandir($dir), array('.', '..'));
    foreach ($files as $file)
    {
        (is_dir("$dir/$file")) ? delete_directory("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
}

/**
 * Вывод отладочной информации и останов
 * @param <type> $data
 */
function debug_print($data)
{
    echo '<pre>';
    var_dump($data);
    echo '<pre>';
    exit;
}

/**
 * Пагинация.
 * @param <type> $url '/cms/orders/'
 * @param <type> $total_rows Сколько всего записей
 * @param <type> $uri_segment сколько сегментов в URI
 * @param <type> $per_page по сколько записей на страницу выводить
 * @return <type>
 */
function paginate($url, $total_rows, $uri_segment, $per_page = '10')
{
    $CI = &get_instance();
    $config['base_url'] = $url; //'/cms/orders/';
    $config['total_rows'] = $total_rows; //$nr->s;
    $config['per_page'] = $per_page; //'10';
    $config['uri_segment'] = $uri_segment;
    $config['first_link'] = '&laquo;';
    $config['last_link'] = '&raquo;';
    $config['next_link'] = 'Далее &rarr;';
    $config['prev_link'] = '&larr; Назад';
    $CI->pagination->initialize($config);
    $links = $CI->pagination->create_links();
    if (empty($links))
    {
        $CI->load->helper('url');
        return anchor($url, 'Начало');
    }
    else
        return $links;
}

function send_mime_mail($name_from, // имя отправителя
        $email_from, // email отправителя
        $name_to, // имя получателя
        $email_to, // email получателя
        $data_charset, // кодировка переданных данных
        $send_charset, // кодировка письма
        $subject, // тема письма
        $body // текст письма
)
{
    $to = mime_header_encode($name_to, $data_charset, $send_charset)
            . ' <' . $email_to . '>';
    $subject = mime_header_encode($subject, $data_charset, $send_charset);
    $from = mime_header_encode($name_from, $data_charset, $send_charset)
            . ' <' . $email_from . '>';
    if ($data_charset != $send_charset)
    {
        $body = iconv($data_charset, $send_charset, $body);
    }
    $headers = "From: $from\r\n";
    $headers .= "Content-type: text/plain; charset=$send_charset\r\n";

    return mail($to, $subject, $body, $headers);
}

function mime_header_encode($str, $data_charset, $send_charset)
{
    if ($data_charset != $send_charset)
    {
        $str = iconv($data_charset, $send_charset, $str);
    }
    return '=?' . $send_charset . '?B?' . base64_encode($str) . '?=';
}

function ShowFileExtension($filepath)
{
    preg_match('/[^?]*/', $filepath, $matches);
    $string = $matches[0];

    $pattern = preg_split('/\./', $string, -1, PREG_SPLIT_OFFSET_CAPTURE);

    # check if there is any extension
    if (count($pattern) == 1)
    {
        return '';
    }

    if (count($pattern) > 1)
    {
        $filenamepart = $pattern[count($pattern) - 1][0];
        preg_match('/[^?]*/', $filenamepart, $matches);
        return $matches[0];
    }
}

function array_to_json($array)
{

    if (!is_array($array))
    {
        return false;
    }

    $associative = count(array_diff(array_keys($array), array_keys(array_keys($array))));
    if ($associative)
    {

        $construct = array();
        foreach ($array as $key => $value)
        {

            // We first copy each key/value pair into a staging array,
            // formatting each key and value properly as we go.
            // Format the key:
            if (is_numeric($key))
            {
                $key = "key_$key";
            }
            $key = "'" . addslashes($key) . "'";

            // Format the value:
            if (is_array($value))
            {
                $value = array_to_json($value);
            } else if (!is_numeric($value) || is_string($value))
            {
                $value = "'" . addslashes($value) . "'";
            }

            // Add to staging array:
            $construct[] = "$key: $value";
        }

        // Then we collapse the staging array into the JSON form:
        $result = "{ " . implode(", ", $construct) . " }";
    } else
    { // If the array is a vector (not associative):
        $construct = array();
        foreach ($array as $value)
        {

            // Format the value:
            if (is_array($value))
            {
                $value = array_to_json($value);
            } else if (!is_numeric($value) || is_string($value))
            {
                $value = "'" . addslashes($value) . "'";
            }

            // Add to staging array:
            $construct[] = $value;
        }

        // Then we collapse the staging array into the JSON form:
        $result = "[ " . implode(", ", $construct) . " ]";
    }

    return $result;
}

/**
 * Отрезает текст после [cut]
 *
 * @param string $text
 * @return string
 */
function cut($text)
{
    $text = explode('[cut]', $text, 2);
    return empty($text[1]) ? $text[0] : $text[0] . '…';
}

/**
 * Убирает [cut] из текста
 *
 * @param string $text
 * @return string
 */
function hide_cut($text)
{
    return str_replace('[cut]', '', $text);
}

//function word_limiter($text,$limit=20)
//{
//    $explode = explode(' ',$text);
//    $string  = '';
//    $dots = '...';
//    if(count($explode) <= $limit)
//    {
//        $dots = '';
//    }
//    for($i=0;$i<$limit;$i++)
//    {
//        $string .= $explode[$i]." ";
//    }
//    if ($dots)
//    {
//        $string = substr($string, 0, strlen($string));
//    }
//    return $string.$dots;
//}

/**
 *
 */
function html_to_text($html)
{
// $document на выходе должен содержать HTML-документ.
// Необходимо удалить все HTML-теги, секции javascript,
// пробельные символы. Также необходимо заменить некоторые
// HTML-сущности на их эквивалент.

    $search = array("'<script[^>]*?>.*?</script>'si", // Вырезает javaScript
        "'<[\/\!]*?[^<>]*?>'si"/* , // Вырезает HTML-теги
              "'([\r\n])[\s]+'", // Вырезает пробельные символы
              "'&(quot|#34);'i", // Заменяет HTML-сущности
              "'&(amp|#38);'i",
              "'&(lt|#60);'i",
              "'&(gt|#62);'i",
              "'&(nbsp|#160);'i",
              "'&(iexcl|#161);'i",
              "'&(cent|#162);'i",
              "'&(pound|#163);'i",
              "'&(copy|#169);'i",
              "'&#(\d+);'e" */);                    // интерпретировать как php-код

    $replace = array("",
        "",
        "\\1",
        "\"",
        "&",
        "<",
        ">",
        " ",
        chr(161),
        chr(162),
        chr(163),
        chr(169),
        "chr(\\1)");

    $text = preg_replace($search, $replace, $html);
    return $text;
}

function html2text($html, $allowed = '')
{
    /**
     *  List of preg* regular expression patterns to search for,
     *  used in conjunction with $replace.
     *
     *  @var array $search
     *  @access public
     *  @see $replace
     */
    $search = array(
        "/\r/", // Non-legal carriage return
        "/[\n\t]+/", // Newlines and tabs
        '/[ ]{2,}/', // Runs of spaces, pre-handling
        '/<script[^>]*>.*?<\/script>/i', // <script>s -- which strip_tags supposedly has problems with
        '/<style[^>]*>.*?<\/style>/i', // <style>s -- which strip_tags supposedly has problems with
        //'/<!-- .* -->/',                         // Comments -- which strip_tags might have problem a with
        '/<h[123][^>]*>(.*?)<\/h[123]>/ie', // H1 - H3
        '/<h[456][^>]*>(.*?)<\/h[456]>/ie', // H4 - H6
        '/<p[^>]*>/i', // <P>
        '/<br[^>]*>/i', // <br>
        '/<b[^>]*>(.*?)<\/b>/ie', // <b>
        '/<strong[^>]*>(.*?)<\/strong>/ie', // <strong>
        '/<i[^>]*>(.*?)<\/i>/i', // <i>
        '/<em[^>]*>(.*?)<\/em>/i', // <em>
        '/(<ul[^>]*>|<\/ul>)/i', // <ul> and </ul>
        '/(<ol[^>]*>|<\/ol>)/i', // <ol> and </ol>
        '/<li[^>]*>(.*?)<\/li>/i', // <li> and </li>
        '/<li[^>]*>/i', // <li>
        '/<a [^>]*href="([^"]+)"[^>]*>(.*?)<\/a>/ie',
        // <a href="">
        '/<hr[^>]*>/i', // <hr>
        '/(<table[^>]*>|<\/table>)/i', // <table> and </table>
        '/(<tr[^>]*>|<\/tr>)/i', // <tr> and </tr>
        '/<td[^>]*>(.*?)<\/td>/i', // <td> and </td>
        '/<th[^>]*>(.*?)<\/th>/ie', // <th> and </th>
        '/&(nbsp|#160);/i', // Non-breaking space
        '/&(quot|rdquo|ldquo|#8220|#8221|#147|#148);/i',
        // Double quotes
        '/&(apos|rsquo|lsquo|#8216|#8217);/i', // Single quotes
        '/&gt;/i', // Greater-than
        '/&lt;/i', // Less-than
        '/&(amp|#38);/i', // Ampersand
        '/&(copy|#169);/i', // Copyright
        '/&(trade|#8482|#153);/i', // Trademark
        '/&(reg|#174);/i', // Registered
        '/&(mdash|#151|#8212);/i', // mdash
        '/&(ndash|minus|#8211|#8722);/i', // ndash
        '/&(bull|#149|#8226);/i', // Bullet
        '/&(pound|#163);/i', // Pound sign
        '/&(euro|#8364);/i', // Euro sign
        '/&[^&;]+;/i', // Unknown/unhandled entities
        '/[ ]{2,}/'                              // Runs of spaces, post-handling
    );
    /**
     *  List of pattern replacements corresponding to patterns searched.
     *
     *  @var array $replace
     *  @access public
     *  @see $search
     */
    $replace = array(
        '', // Non-legal carriage return
        ' ', // Newlines and tabs
        ' ', // Runs of spaces, pre-handling
        '', // <script>s -- which strip_tags supposedly has problems with
        '', // <style>s -- which strip_tags supposedly has problems with
        //'',                                     // Comments -- which strip_tags might have problem a with
        "strtoupper(\"\n\n\\1\n\n\")", // H1 - H3
        "ucwords(\"\n\n\\1\n\n\")", // H4 - H6
        "\n\n\t", // <P>
        "\n", // <br>
        'strtoupper("\\1")', // <b>
        'strtoupper("\\1")', // <strong>
        '\\1', // <i>
        '\\1', // <em>
        "\n\n", // <ul> and </ul>
        "\n\n", // <ol> and </ol>
        "\t* \\1\n", // <li> and </li>
        "\n\t* ", // <li>
        '$this->_build_link_list("\\1", "\\2")',
        // <a href="">
        "\n-------------------------\n", // <hr>
        "\n\n", // <table> and </table>
        "\n", // <tr> and </tr>
        "\t\t\\1\n", // <td> and </td>
        "strtoupper(\"\t\t\\1\n\")", // <th> and </th>
        ' ', // Non-breaking space
        '"', // Double quotes
        "'", // Single quotes
        '>',
        '<',
        '&',
        '(c)',
        '(tm)',
        '(R)',
        '--',
        '-',
        '*',
        '£',
        'EUR', // Euro sign. € ?
        '', // Unknown/unhandled entities
        ' '                                     // Runs of spaces, post-handling
    );

    /**
     *  Contains a list of HTML tags to allow in the resulting text.
     *
     *  @var string $allowed_tags
     *  @access public
     *  @see set_allowed_tags()
     */
    $allowed_tags = $allowed;

    // Variables used for building the link list
    $_link_count = 0;
    $_link_list = '';

    $text = trim(stripslashes($html));

    // Run our defined search-and-replace
    $text = preg_replace($search, $replace, $text);

    // Strip any other HTML tags
    $text = strip_tags($text, $allowed_tags);

    // Bring down number of empty lines to 2 max
    $text = preg_replace("/\n\s+\n/", "\n\n", $text);
    $text = preg_replace("/[\n]{3,}/", "\n\n", $text);
    return $text;
}

function force_balance_tags($text)
{
    $tagstack = array();
    $stacksize = 0;
    $tagqueue = '';
    $newtext = '';
    $single_tags = array('br', 'hr', 'img', 'input'); // Known single-entity/self-closing tags
    $nestable_tags = array('blockquote', 'div', 'span'); // Tags that can be immediately nested within themselves
    // WP bug fix for comments - in case you REALLY meant to type '< !--'
    $text = str_replace('< !--', '<    !--', $text);
    // WP bug fix for LOVE <3 (and other situations with '<' before a number)
    $text = preg_replace('#<([0-9]{1})#', '&lt;$1', $text);

    while (preg_match("/<(\/?[\w:]*)\s*([^>]*)>/", $text, $regex))
    {
        $newtext .= $tagqueue;

        $i = strpos($text, $regex[0]);
        $l = strlen($regex[0]);

        // clear the shifter
        $tagqueue = '';
        // Pop or Push
        if (isset($regex[1][0]) && '/' == $regex[1][0])
        { // End Tag
            $tag = strtolower(substr($regex[1], 1));
            // if too many closing tags
            if ($stacksize <= 0)
            {
                $tag = '';
                // or close to be safe $tag = '/' . $tag;
            }
            // if stacktop value = tag close value then pop
            else if ($tagstack[$stacksize - 1] == $tag)
            { // found closing tag
                $tag = '</' . $tag . '>'; // Close Tag
                // Pop
                array_pop($tagstack);
                $stacksize--;
            } else
            { // closing tag not at top, search for it
                for ($j = $stacksize - 1; $j >= 0; $j--)
                {
                    if ($tagstack[$j] == $tag)
                    {
                        // add tag to tagqueue
                        for ($k = $stacksize - 1; $k >= $j; $k--)
                        {
                            $tagqueue .= '</' . array_pop($tagstack) . '>';
                            $stacksize--;
                        }
                        break;
                    }
                }
                $tag = '';
            }
        } else
        { // Begin Tag
            $tag = strtolower($regex[1]);

            // Tag Cleaning
            // If self-closing or '', don't do anything.
            if (substr($regex[2], -1) == '/' || $tag == '')
            {
                // do nothing
            }
            // ElseIf it's a known single-entity tag but it doesn't close itself, do so
            elseif (in_array($tag, $single_tags))
            {
                $regex[2] .= '/';
            } else
            { // Push the tag onto the stack
                // If the top of the stack is the same as the tag we want to push, close previous tag
                if ($stacksize > 0 && !in_array($tag, $nestable_tags) && $tagstack[$stacksize - 1] == $tag)
                {
                    $tagqueue = '</' . array_pop($tagstack) . '>';
                    $stacksize--;
                }
                $stacksize = array_push($tagstack, $tag);
            }

            // Attributes
            $attributes = $regex[2];
            if (!empty($attributes))
                $attributes = ' ' . $attributes;

            $tag = '<' . $tag . $attributes . '>';
            //If already queuing a close tag, then put this tag on, too
            if (!empty($tagqueue))
            {
                $tagqueue .= $tag;
                $tag = '';
            }
        }
        $newtext .= substr($text, 0, $i) . $tag;
        $text = substr($text, $i + $l);
    }

    // Clear Tag Queue
    $newtext .= $tagqueue;

    // Add Remaining text
    $newtext .= $text;

    // Empty Stack
    while ($x = array_pop($tagstack))
        $newtext .= '</' . $x . '>'; // Add remaining tags to close






        
// WP fix for the bug with HTML comments
    $newtext = str_replace("< !--", "<!--", $newtext);
    $newtext = str_replace("<    !--", "< !--", $newtext);

    return $newtext;
}

/**
 * Возвращает "Руссифицированную дату"
 * @param type $endate
 * @return string 
 */
function getrudate($endate)
{
    $aMon = array("января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря");
    list($year, $month, $day) = explode('-', $endate);
    $RUdate = $day . ' ' . $aMon[$month - 1] . ' ' . $year;
    return $RUdate;
}

/**
 * 
 * @param type $filename 
 */
function crop_and_resize($filename)
{

// File and new size
    // $filename = 'test.jpg';
    $percent = 0.5;

// Content type
    header('Content-Type: image/jpeg');

// Get new sizes
    list($width, $height) = getimagesize($filename);
    $newwidth = $width * $percent;
    $newheight = $height * $percent;

// Load
    $thumb = imagecreatetruecolor($newwidth, $newheight);
    $source = imagecreatefromjpeg($filename);

// Resize
    imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

// Output
    imagejpeg($thumb);
}

/**
 * Функция для перевода даты на русский язык
 *
 * @param number дата в unix формате
 * @param string формат выводимой даты
 * @param number сдвиг времени (часов, относительно времени на сервере)
 * 
 * %MONTH% — русское название месяца (родительный падеж)
 * %DAYWEEK% — русское название дня недели
 *
 * @example 
 * echo dateToRus( time(), '%DAYWEEK%, j %MONTH% Y, G:i' );
 * 
 * суббота, 10 декабря 2010, 12:03
 */
function dateToRus($d_mysql, $format = 'j %MONTH% Y', $offset = 0)
{
    $d = strtotime($d_mysql);
    $months = array('января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля',
        'августа', 'сентября', 'октября', 'ноября', 'декабря');

    $days = array('понедельник', 'вторник', 'среда', 'четверг',
        'пятница', 'суббота', 'воскресенье');

    $d += 3600 * $offset;

    $format = preg_replace(array(
        '/%MONTH%/i',
        '/%DAYWEEK%/i'
            ), array(
        $months[date("m", $d) - 1],
        $days[date("N", $d) - 1]
            ), $format);

    return date($format, $d);
}