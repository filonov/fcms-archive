<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
  |--------------------------------------------------------------------------
  | File and Directory Modes
  |--------------------------------------------------------------------------
  |
  | These prefs are used when checking and setting modes when working
  | with the file system.  The defaults are fine on servers with proper
  | security, but you may wish (or even need) to change the values in
  | certain environments (Apache running a separate process for each
  | user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
  | always be used to set the mode correctly.
  |
 */
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
  |--------------------------------------------------------------------------
  | File Stream Modes
  |--------------------------------------------------------------------------
  |
  | These modes are used when working with fopen()/popen()
  |
 */

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');


/*
  |--------------------------------------------------------------------------
  | Константы
  |--------------------------------------------------------------------------
  |
  | Константы CMS
  |
 */

// Определяем константы безопасности
// Админ, Сотрудник, Клиент, Гость.
define('SEC_RIGHTS_NONE', -1);
define('SEC_RIGHTS_ROOT', 1);

// Тип материала
define('CONTENT_PAGE', 10);
define('CONTENT_CATEGORY', 20);
define('CONTENT_GALLERY', 30);
define('CONTENT_GALLERY_CATEGORY', 35);
define('CONTENT_CATALOG', 40);
define('CONTENT_CATALOG_CATEGORY', 45);
define('CONTENT_LINK', 50);
define('CONTENT_LINK_INTERNAL', 55);

// Тип категорий
define('CATEGORYES_CONTENT', 10);
define('CATEGORYES_CATALOG', 20);
define('CATEGORYES_GALLERY', 30);

// Статусы заказов
define('ORDER_NEW', 0);
define('ORDER_PROCESSING', 1);
define('ORDER_COMPLETED', 2);
define('ORDER_REFUSED', 3);

// Статусы доставки и оплаты
define('DELIVERY_CASH', 10); // Наличные
define('DELIVERY_CARD', 20); // Карточка
define('DELIVERY_COURIER', 30); // Налом курьеру
define('DELIVERY_BANK', 40); // Выставить счёт

// Для либерум
define('BIGGER_OR_EQUAL_CURRENT_DAY', 10);
define('SMALLER_CURRENT_DAY', 20);

define('GROUP_STANDART', 10);
define('GROUP_SPECIAL', 20);

define('ITALIAN', 10);
define('SPAIN', 20);

define('MMA_KASKO', 10);
define('MMA_OSAGO', 20);
define('MMA_DMS', 30);
define('MMA_OTHER', 40);


/* End of file constants.php */
/* Location: ./system/application/config/constants.php */