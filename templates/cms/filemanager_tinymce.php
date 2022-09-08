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
        <script type="text/javascript" src="{cms_js}tinymce/jscripts/tiny_mce/tiny_mce_popup.js"></script>
        <!-- elFinder initialization (REQUIRED) -->

        <script type="text/javascript">
            var FileBrowserDialogue =
                    {
                        init: function() {
                            // Here goes your code for setting your custom things onLoad.
                        },
                        mySubmit: function(URL) {
                            var win = tinyMCEPopup.getWindowArg('window');

                            // pass selected file path to TinyMCE
                            win.document.getElementById(tinyMCEPopup.getWindowArg('input')).value = URL;

                            // are we an image browser?
                            if (typeof(win.ImageDialog) !== 'undefined') {
                                // update image dimensions
                                if (win.ImageDialog.getImageData) {
                                    win.ImageDialog.getImageData();
                                }
                                // update preview if necessary
                                if (win.ImageDialog.showPreviewImage) {
                                    win.ImageDialog.showPreviewImage(URL);
                                }
                            }

                            // close popup window
                            tinyMCEPopup.close();
                        }
                    }

            tinyMCEPopup.onInit.add(FileBrowserDialogue.init, FileBrowserDialogue);

            $().ready(function() {
                var elf = $('#elfinder').elfinder({
                    // set your elFinder options here
                    toolbar: [
                        ['back', 'forward'],
                        ['reload'],
                        ['home', 'up'],
                        ['mkdir', 'mkfile', 'upload'],
                        ['open', 'download', 'getfile'],
                        ['info'],
                        ['quicklook'],
                        ['copy', 'cut', 'paste'],
                        ['rm'],
                        ['duplicate', 'rename', 'edit', 'resize'],
                        ['extract', 'archive'],
                        ['search']
                                ['view'],
                        ['help']
                    ],
                    lang: 'ru', // language (OPTIONAL)
                    requestType: 'post',
                    url: '{base}cms/filemanager/connector', // connector URL
                    getFileCallback: function(file) { // editor callback
                        // path = url;
                        FileBrowserDialogue.mySubmit(file.url); // pass selected file path to TinyMCE 
                    }
                }).elfinder('instance');
            });
        </script>

    </head>
    <body>
            <!-- Element where elFinder will be created (REQUIRED) -->
            <div id="elfinder"></div>
    </body>
</html>
