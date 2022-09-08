<? require_once 'inc.header.php'; ?>

<body>
    <script type="text/javascript" src="{cms_js}tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
    <script type="text/javascript" src="{cms_js}tinymce/jscripts/tiny_mce/jquery.tinymce.js"></script>
    <script type="text/javascript" charset="utf-8">
        

        $(document).ready(function() {

            $('textarea.tinymce').tinymce({
                // Location of TinyMCE script
                script_url: '{cms_js}tinymce/jscripts/tiny_mce/tiny_mce.js',
                document_base_url: "{base}",
                convert_urls: true,
                relative_urls: false,
                // General options
                //mode: "exact",
                elements: "wysiwyg,entry,tinymce",
                theme: "advanced",
                // Skin options
                skin: "o2k7",
                skin_variant: "silver",
                language: "ru",
                plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
                // Theme options
                theme_advanced_buttons1: "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
                theme_advanced_buttons3: "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
                theme_advanced_buttons4: "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
                theme_advanced_toolbar_location: "top",
                theme_advanced_toolbar_align: "left",
                theme_advanced_statusbar_location: "bottom",
                theme_advanced_resizing: true,
                // Example content CSS (should be your site CSS)
                //content_css : "css/content.css",

                // Drop lists for link/image/media/template dialogs
                template_external_list_url: "lists/template_list.js",
                external_link_list_url: "lists/link_list.js",
                external_image_list_url: "lists/image_list.js",
                media_external_list_url: "lists/media_list.js",
                // Replace values for the template plugin
                template_replace_values: {
                    username: "root",
                    staffid: "666"
                },
                file_browser_callback: 'elFinderBrowser'
            });
        });

        function elFinderBrowser(field_name, url, type, win) {
            var elfinder_url = '{base}cms/filemanager/tinymce';    // use an absolute path!
            tinyMCE.activeEditor.windowManager.open({
                file: elfinder_url,
                title: 'Просмотр файлов',
                width: 900,
                height: 450,
                resizable: 'yes',
                inline: 'yes', // This parameter only has an effect if you use the inlinepopups plugin!
                popup_css: false, // Disable TinyMCE's default popup CSS
                close_previous: 'no'
            }, {
                window: win,
                input: field_name
            });
            return false;
        }
    </script>

    <? require_once 'inc.menu.php'; ?>

    <div class="container">

        <div class="row">           
            <div class="span12">
                <h2>Редактируем спецкурс 
                    <small>
                        <?= $content->title ?>
                    </small>
                </h2>
                <hr/>
                <? if (!empty($error)): ?>
                    <div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <h4>Ошибка сохранения!</h4>
                        <br/><?= $error ?>
                    </div>
                <? endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="span12">
                <form id="form_add" method="post" action="<?=  current_url()?>">
                    <div class="row">
                        <div class="span3">
                            <label class="control-label" >Порядок</label>
                            <input type="text" class="span2" name="order" placeholder="1" value="<?= $content->order ?>">
                            <label>Язык</label>
                            <label class="radio">
                                <input type="radio" name="language" id="optionslanguage1" value="<?= ITALIAN ?>" <?= ($content->language == ITALIAN) ? "checked" : "" ?>>
                                Итальянский
                            </label>
                            <label class="radio">
                                <input type="radio" name="language" id="optionslanguage2" value="<?= SPAIN ?>" <?= ($content->language == SPAIN) ? "checked" : "" ?>>
                                Испанский
                            </label>
                        </div>
                        <div class="span9">
                            <label class="control-label" >Название</label>
                            <input type="text" class="span9" value="<?= $content->title ?>" name="title" placeholder="Краткий курс для ложных начинающих">
                            <label class="control-label" >Алиас, он же ссылка <small>(только алиас курса, если пусто, то генерируется автоматически)</small></label>
                            <input type="text" class="span9" value="<?= $content->link ?>" name="link" placeholder="kratkij-kurs-dla-lojnih-nachinajushih">   
                        </div>
                    </div>
                    
                    <label class="control-label" >Подходит для уровня</label>
                    <? foreach ($levels as $level): ?>
                        <label class="checkbox inline">
                            <input name="specials_levels[]" type="checkbox" <?= $specials_levels[$level->id] ?> id="levels-<?= $content->id ?>" value="<?= $level->id ?>"> <?= $level->title ?>
                        </label>
                    <? endforeach; ?>
                    <hr>
                    <label class="control-label" >Краткое описание</label>
                    <input type="text" class="span12" value="<?= $content->description ?>" name="description" placeholder="Група для так называемых ложных начинающих...">
                    <label class="control-label" >Полное описание (текст страницы курса)</label>
                    <textarea style="width: 100%; height: 500px; padding: 0; margin: 0;" id="wysiwyg" name="text" class="tinymce">
                        <?= $content->text ?>
                    </textarea>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                    </div>
                </form>
            </div>
        </div>

        <? require_once 'inc.footer.php'; ?>   
