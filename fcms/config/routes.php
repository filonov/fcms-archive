<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  | 	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	http://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There are two reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['scaffolding_trigger'] = 'scaffolding';
  |
  | This route lets you set a "secret" word that will trigger the
  | scaffolding feature for added security. Note: Scaffolding must be
  | enabled in the controller in which you intend to use it.   The reserved
  | routes must come before any wildcard or regular expression routes.
  |
 */

$route['default_controller'] = 'index';
$route['scaffolding_trigger'] = '';
$route['404_override'] = 'error/error_404'; // Здесь 404 если не найден контроллер
// Админка категорий
$route['cms/categoryes/add'] = "cms/categoryes/add";
$route['cms/categoryes/delete'] = "cms/categoryes/delete";
$route['cms/categoryes/edit'] = "cms/categoryes/edit";
$route['cms/categoryes/move'] = "cms/categoryes/move";
$route['cms/categoryes/ajaxGetCategory'] = "cms/categoryes/ajaxGetCategory";
$route['cms/categoryes/(:num)'] = "cms/categoryes/index/$1";
$route['cms/categoryes'] = "cms/categoryes/index";

// Админка статических страниц
$route['cms/pages/edit/(:num)'] = "cms/pages/edit/$1";
$route['cms/pages/add'] = "cms/pages/add";
$route['cms/pages/delete'] = "cms/pages/delete";
$route['cms/pages'] = "cms/pages/index";

// Админка модулей
$route['cms/modules/edit/(:num)'] = "cms/modules/edit/$1";
$route['cms/modules/add'] = "cms/modules/add";
$route['cms/modules/delete'] = "cms/modules/delete";
$route['cms/modules'] = "cms/modules/index";

// Админка почтовой рассылки
$route['cms/emails/edit/(:num)'] = "cms/emails/edit/$1";
$route['cms/emails/add'] = "cms/emails/add";
$route['cms/emails/delete'] = "cms/emails/delete";
$route['cms/emails'] = "cms/emails/index";

// Админка контента (статьи, новости)
$route['cms/content/edit/(:num)'] = "cms/content/edit/$1";
$route['cms/content/add'] = "cms/content/add";
$route['cms/content/delete'] = "cms/content/delete";

$route['cms/content/(:any)/(:num)'] = "cms/content/index/$1/$2";
$route['cms/content/(:any)'] = "cms/content/index/$1";
$route['cms/content'] = "cms/content/index";

$route['cms/showcase'] = "cms/showcase/index";


// Админка каталогов (и магазинов)
//$route['cms/catalog/tmp_convert_img'] = "cms/catalog/tmp_convert_img";
$route['cms/catalog/edit/(:num)'] = "cms/catalog/edit/$1";
$route['cms/catalog/add'] = "cms/catalog/add";
$route['cms/catalog/delete'] = "cms/catalog/delete";
$route['cms/catalog/search'] = "cms/catalog/search";
$route['cms/catalog/make_tmb'] = "cms/catalog/make_tmb";
$route['cms/catalog/make_tmb/(:num)'] = "cms/catalog/make_tmb/$1";
$route['cms/catalog/(:any)/(:num)'] = "cms/catalog/index/$1/$2";
$route['cms/catalog/(:any)'] = "cms/catalog/index/$1";
$route['cms/catalog'] = "cms/catalog/index";

// Админка заказов из каталога
$route['cms/orders/edit/(:num)'] = "cms/orders/edit/$1";
$route['cms/orders/add'] = "cms/orders/add";
$route['cms/orders/delete'] = "cms/orders/delete";
$route['cms/orders/(:any)'] = "cms/orders/index/$1";
$route['cms/orders/(:any)/(:num)'] = "cms/orders/index/$1/$2";
$route['cms/orders'] = "cms/orders/index";

// Админка анкет слушателей курсов
$route['cms/forms/edit/(:num)'] = "cms/forms/edit/$1";
$route['cms/forms/add'] = "cms/forms/add";
$route['cms/forms/delete'] = "cms/forms/delete";
$route['cms/forms/(:any)'] = "cms/forms/index/$1";
$route['cms/forms/(:any)/(:num)'] = "cms/forms/index/$1/$2";
$route['cms/forms'] = "cms/forms/index";

// Админка галерей
$route['cms/galleryes/move'] = "cms/galleryes/move";
$route['cms/galleryes/delete'] = "cms/galleryes/delete";
$route['cms/galleryes/(:any)/(:num)'] = "cms/galleryes/index/$1/$2";
$route['cms/galleryes/(:any)'] = "cms/galleryes/index/$1";
$route['cms/galleryes'] = "cms/galleryes/index";

// Админка справочников для liberum-center

if (FCMS_PROJECT == 'liberum')
{

    $route['cms/references/levels'] = "cms/references/levels";
    $route['cms/references/add_level'] = "cms/references/add_level";
    $route['cms/references/delete_level'] = "cms/references/delete_level";
    $route['cms/references/edit_level'] = "cms/references/edit_level";

    $route['cms/references/programs'] = "cms/references/programs";
    $route['cms/references/add_program'] = "cms/references/add_program";
    $route['cms/references/delete_program'] = "cms/references/delete_program";
    $route['cms/references/edit_program'] = "cms/references/edit_program";

    $route['cms/references/textbooks'] = "cms/references/textbooks";
    $route['cms/references/add_textbook'] = "cms/references/add_textbook";
    $route['cms/references/delete_textbook'] = "cms/references/delete_textbook";
    $route['cms/references/edit_textbook'] = "cms/references/edit_textbook";

    $route['cms/references/prices'] = "cms/references/prices";
    $route['cms/references/add_price'] = "cms/references/add_price";
    $route['cms/references/delete_price'] = "cms/references/delete_price";
    $route['cms/references/edit_price'] = "cms/references/edit_price";

    $route['cms/references/tests'] = "cms/references/tests";
    $route['cms/references/add_test'] = "cms/references/add_test";
    $route['cms/references/delete_test'] = "cms/references/delete_test";
    $route['cms/references/edit_test'] = "cms/references/edit_test";

    $route['cms/references/durations'] = "cms/references/durations";
    $route['cms/references/add_duration'] = "cms/references/add_duration";
    $route['cms/references/delete_duration'] = "cms/references/delete_duration";
    $route['cms/references/edit_duration'] = "cms/references/edit_duration";

    $route['cms/references/formats'] = "cms/references/formats";
    $route['cms/references/add_format'] = "cms/references/add_format";
    $route['cms/references/delete_format'] = "cms/references/delete_format";
    $route['cms/references/edit_format'] = "cms/references/edit_format";

    $route['cms/references/statuses'] = "cms/references/statuses";
    $route['cms/references/add_status'] = "cms/references/add_status";
    $route['cms/references/delete_status'] = "cms/references/delete_status";
    $route['cms/references/edit_status'] = "cms/references/edit_status";

    $route['cms/references/specials'] = "cms/references/specials";
    $route['cms/references/add_special'] = "cms/references/add_special";
    $route['cms/references/delete_special'] = "cms/references/delete_special";
    $route['cms/references/edit_special'] = "cms/references/edit_special";
    $route['cms/references/edit_specials_levels'] = "cms/references/edit_specials_levels";

// Админка групп для liberum-center.ru
    $route['cms/groups'] = "cms/groups/index";
    $route['cms/groups/italiano'] = "cms/groups/index/italiano";
    $route['cms/groups/espanol'] = "cms/groups/index/espanol";
    $route['cms/groups/add'] = "cms/groups/add";
    $route['cms/groups/delete'] = "cms/groups/delete";
    $route['cms/groups/edit/(:num)'] = "cms/groups/edit/$1";
    $route['cms/groups/edit_order'] = "cms/groups/edit_order";
    $route['cms/groups/regenerate_titles'] = "cms/groups/regenerate_titles";
    $route['cms/groups/generate_title_for_cources/(:num)'] = "cms/groups/generate_title_for_cources/$1";

//Админка спецкурсов
    $route['cms/specials'] = "cms/specials/index";
    $route['cms/specials/italiano'] = "cms/specials/index/italiano";
    $route['cms/specials/espanol'] = "cms/specials/index/espanol";
    $route['cms/specials/add'] = "cms/specials/add";
    $route['cms/specials/delete'] = "cms/specials/delete";
    $route['cms/specials/edit/(:num)'] = "cms/specials/edit/$1";


// Админка для преподавателей
    $route['cms/teachers'] = "cms/teachers/index";
    $route['cms/teachers/add'] = "cms/teachers/add";
    $route['cms/teachers/delete'] = "cms/teachers/delete";
    $route['cms/teachers/edit/(:num)'] = "cms/teachers/edit/$1";
    $route['cms/teachers/edit_order'] = "cms/teachers/edit_order";

// Админка для тестов
    $route['cms/testing'] = "cms/testing/index";
    $route['cms/testing/add'] = "cms/testing/add";
    $route['cms/testing/delete'] = "cms/testing/delete";
    $route['cms/testing/edit/(:num)'] = "cms/testing/edit/$1";
    $route['cms/testing/add_page/(:num)'] = "cms/testing/add_page/$1";
    $route['cms/testing/edit_page'] = "cms/testing/edit_page";
    $route['cms/testing/ajax_add_question'] = "cms/testing/ajax_add_question";
    $route['cms/testing/ajax_get_question'] = "cms/testing/ajax_get_question";
    $route['cms/testing/ajax_edit_question'] = "cms/testing/ajax_edit_question";
    $route['cms/testing/ajax_delete_question'] = "cms/testing/ajax_delete_question";
}

// Админка для менеджера файлов
$route['cms/filemanager/connector'] = "cms/filemanager/connector";
$route['cms/filemanager/catalog/(:num)'] = "cms/filemanager/catalog/$1";
$route['cms/filemanager/connector_catalog/(:num)'] = "cms/filemanager/connector_catalog/$1";
$route['cms/filemanager/tinymce'] = "cms/filemanager/tinymce";
$route['cms/filemanager'] = "cms/filemanager/index";

// Админка для редактора меню
$route['cms/menu/add'] = "cms/menu/add";
$route['cms/menu/delete'] = "cms/menu/delete";
$route['cms/menu/move'] = "cms/menu/move";
$route['cms/menu/(:num)'] = "cms/menu/index/$1";
$route['cms/menu'] = "cms/menu/index";

if (FCMS_PROJECT == 'mma')
{
// Админка для mma
    $route['cms/mma/marks'] = "cms/mma/marks";
    $route['cms/mma/add_mark'] = "cms/mma/add_mark";
    $route['cms/mma/edit_mark'] = "cms/mma/edit_mark";
    $route['cms/mma/delete_mark'] = "cms/mma/delete_mark";

    $route['cms/mma/models/(:num)'] = "cms/mma/models/$1";
    $route['cms/mma/models'] = "cms/mma/models";
    $route['cms/mma/add_model'] = "cms/mma/add_model";
    $route['cms/mma/edit_model'] = "cms/mma/edit_model";
    $route['cms/mma/delete_model'] = "cms/mma/delete_model";

    $route['cms/mma/regions'] = "cms/mma/regions";
    $route['cms/mma/add_region'] = "cms/mma/add_region";
    $route['cms/mma/edit_region'] = "cms/mma/edit_region";
    $route['cms/mma/delete_region'] = "cms/mma/delete_region";

    $route['cms/mma/forms/(:num)/(:num)'] = "cms/mma/forms/$1/$2";
    $route['cms/mma/forms/(:num)'] = "cms/mma/forms/$1";
    $route['cms/mma/viewform/(:num)'] = "cms/mma/viewform/$1";
    $route['cms/mma/forms'] = "cms/mma/forms";
    
    $route['cms/mma/counter'] = "cms/mma/counter";
}


// Редактор конфига
$route['cms/configuration'] = "cms/configuration/index";

//Обновления
$route['cms/migrate'] = "cms/migrate/index";
$route['mcsv'] = "cms/migrate/import_csv_mma";


// Настройки CMS
$route['cms'] = "cms/index/index";

// Аутентификация
$route['login'] = "login/index";
$route['logout'] = "logout/index";

// Контент
$route['content/(:any)'] = "content/index/$1";
$route['content'] = "content/index";

// Галерея
$route['gallery/(:any)'] = "gallery/index/$1";
$route['gallery'] = "gallery/index";

// Каталог
//$route['catalog/force_create_aliases'] = "catalog/force_create_aliases";
$route['catalog/order'] = "catalog/order";
$route['catalog/cart'] = "catalog/cart";
$route['catalog/cart_add'] = "catalog/cart_add";
$route['catalog/cart_update'] = "catalog/cart_update";
$route['catalog/cart_block'] = "catalog/cart_block";
$route['catalog/add_review'] = "catalog/add_review";
$route['catalog/(:any)'] = "catalog/index/$1";
$route['catalog'] = "catalog/index";

// Поиск по каталогу
$route['search'] = "search/index";

if (FCMS_PROJECT == 'liberum')
{
// Группы
    $route['courses/group/(:num)'] = "courses/group/$1";

// Курсы
    $route['courses/(:any)'] = "courses/index/$1";

// Спецкурсы
    $route['specials'] = "specials/index";
    $route['specials/italiano/(:any)'] = "specials/italiano/$1";
    $route['specials/espanol/(:any)'] = "specials/espanol/$1";

    // Преподаватели
    $route['teachers'] = "teachers/index";
    $route['teachers/(:any)'] = "teachers/teacher/$1";

// Тестирование
    $route['tests/(:any)/(:num)'] = "tests/test/$1/$2";
    $route['tests/(:any)'] = "tests/test/$1";
    $route['tests/answer'] = "tests/answer";
    $route['tests'] = "tests/index";
}

// Капча
$route['capt'] = "capt/index";

// Анкета
$route['anketa'] = "anketa/index";



// Крон
$route['cron/groups_update'] = "cron/groups_update";
$route['cron/mma_counter'] = "cron/mma_counter";

if (FCMS_PROJECT == 'mma')
{
    // MMA
    $route['mma/kasko'] = "mma/kasko";
    $route['mma/osago'] = "mma/osago";
    $route['mma/dms'] = "mma/dms";
    $route['mma/other'] = "mma/other";
    $route['mma/models'] = "mma/models";
    $route['mma/np'] = "mma/np";
    $route['mma/ajax_osago'] = "mma/ajax_osago";
}



// Показ статических страниц
$route['(:any)'] = "index/index/$1";





/* End of file routes.php */
/* Location: ./system/application/config/routes.php */
