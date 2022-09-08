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
                <h2>Редактируем статью</h2>
                <hr>
                <? if (!empty($error)): ?>
                    <div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <h4>Ошибка сохранения!</h4>
                        <br/><?= $error ?>
                    </div>
                <? endif; ?>
                <form class="form" action="{method_path}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="eid" value="{id}" />
                    <div class="row">
                        <div class="span6">
                            <label>Заголовок</label>
                            <input type="text" class="span6" placeholder="(Без имени...)" name="title" value="<?= $item->title ?>"/>
                            <label>Категория</label>
                            <?= $category ?>
                            <label class="checkbox" for="checkboxes-0">
                                <input type="checkbox" <? if($item->show_in_showcase):?>checked<? endif; ?> name="show_in_showcase" id="show_in_showcase" value="show_in_showcase">
                                Показывать в «Витрине»
                            </label>
                        </div>
                        <div class="span3">
                            <? if (!empty($item->thumbnail)): ?>
                                <img src="{url_for_uploads}thumbnails/<?= $item->thumbnail ?>" alt="<?= $item->title ?>" style="max-height: 100px; max-width: 100px" class="img-polaroid"/>
                            <? endif; ?>
                            
                        </div>
                        <div class="span3">
                            <div class="thumbnail">
                                <input class="inputf" type="file" size="5" multiple name="thumbnail"/>
                            </div>
                        </div>
                    </div>
                    <label>META-TITLE (название страницы в заголовке окна)</label>
                    <input type="text" class="span12" placeholder="Заголовок окна страницы" name="meta_title" value="<?= $item->meta_title ?>"/>
                    <label>META-KEYWORDS (ключевые слова через запятую)</label>
                    <input type="text" class="span12" placeholder="ложка, лопата, перфоратор" name="meta_keywords" value="<?= $item->meta_keywords ?>"/>
                    <label for="meta_description">META-DESCRIPTION (описание страницы)</label>
                    <input type="text" class="span12" placeholder="Страница с философским трактатом об общем между лопатой и ложками в контексте перфоратора." name="meta_description" value="<?= $item->meta_description ?>"/>
                    <label for="template">Шаблон</label>
                    <input type="text" class="span12" placeholder="" name="template" value="<?= $item->template ?>"/>

                    <label>Текст:</label>
                    <textarea style="width: 100%; height: 500px; padding: 0; margin: 0;" id="wysiwyg" name="text" class="tinymce"><?= $item->text ?></textarea>
                    <br />
                    <div class="btn-group">
                        <a href="javascript:;" onclick="$('#wysiwyg').tinymce().show();
            return false;" class="btn button_link" >Визуальный редактор</a>
                        <a href="javascript:;" onclick="$('#wysiwyg').tinymce().hide();
            return false;" class="btn button_link" >HTML редактор</a>
                    </div> 
                    <br /><br />
                    <button class="btn btn-primary save" type="submit" ><i class="icon-ok"></i> Сохранить</button>
                </form>
            </div>

        </div>

        <? require_once 'inc.footer.php'; ?> 

