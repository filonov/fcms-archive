<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Файлы</title>

        <script src="{cms_js}jquery-1.9.1.min.js"></script> 
        <link rel="stylesheet" type="text/css" media="screen" href="{cms_css}smoothness/jquery-ui-1.10.2.custom.min.css">
        <script type="text/javascript" src="{cms_js}jquery-ui-1.10.2.custom.min.js"></script>


        <!-- elFinder CSS (REQUIRED) -->
        <link rel="stylesheet" type="text/css" media="screen" href="{cms_js}elfinder/css/elfinder.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="{cms_js}elfinder/css/theme.css">

        <!-- elFinder JS (REQUIRED) -->
        <script type="text/javascript" src="{cms_js}elfinder/js/elfinder.min.js"></script>

        <!-- elFinder translation (OPTIONAL) -->
        <script type="text/javascript" src="{cms_js}elfinder/js/i18n/elfinder.ru.js"></script>
        <!-- elFinder initialization (REQUIRED) -->

        <script type="text/javascript" charset="utf-8">
            $().ready(function() {
                var elf = $('#elfinder').elfinder({
                    lang: 'ru',
                    requestType: 'post',
                    url: '{connector_url}',
                    commands: [
                        'open', 'reload', 'home', 'up', 'back', 'forward', 'getfile', 'quicklook',
                        'download', 'rm', 'duplicate', 'rename', 'mkdir', 'mkfile', 'upload', 'copy',
                        'cut', 'paste', 'edit', 'resize', 'extract', 'archive', 'search', 'info', 'view', 'help'
                    ],
                    height: 290


                }).elfinder('instance');
            });
        </script>

    </head>
    <body>
            <div id="elfinder"></div>
    </body>
</html>
