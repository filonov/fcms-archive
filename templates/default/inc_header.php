<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <title><?=$site_title.' | '.$meta_title // Название сайта из конфига и мета-название страницы ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?=$meta_description?>">
        <meta name="keywords" content="<?=$meta_keywords?>">
        <meta name="author" content="">

        <!-- Le styles -->
        <link href="<?=$cms_css?>bootstrap.min.css" rel="stylesheet">
        <style type="text/css">
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
        </style>
        <link href="<?=$cms_css?>bootstrap-responsive.min.css" rel="stylesheet">
        <link href="<?=$cms_js?>themes/pickadate.01.default.css" rel="stylesheet">
        

        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <script src="<?=$cms_js?>jquery-1.9.1.min.js"></script>
        <script src="<?=$cms_js?>bootstrap.min.js"></script>
        <script src="<?=$cms_js?>pickadate.min.js"></script>
        <script src="<?=$cms_js?>pickadate.ru_RU.js"></script>
    </head>
<?/*
 *  Возможные значения — пути к файлам шаблонов. С префиксом cms_ 
 * 'base',
        'url_for_uploads',
        'path_for_uploads',
        'version',
        'cms_html',
        'cms_css',
        'cms_js',
        'cms_images',
        'cms_img',
        'cms_swf',
        'skin',
        'skin_html',
        'skin_css',
        'skin_js',
        'skin_img',
        'skin_images',
        'skin_swf',
        'site_title'
 * 
 * 
 */