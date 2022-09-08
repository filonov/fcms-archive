<? require_once 'inc.header.php'; ?>

<body>
    <script type="text/javascript" src="{cms_js}tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
    <script type="text/javascript" src="{cms_js}tinymce/jscripts/tiny_mce/jquery.tinymce.js"></script>
    <script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
	    $('textarea.tinymce').tinymce({
		// Location of TinyMCE script
		script_url: '<?= $cms_js ?>tinymce/jscripts/tiny_mce/tiny_mce.js',
		document_base_url: "<?= $base ?>",
		convert_urls: true,
		relative_urls: false,
		// General options
		//mode: "exact",
		elements: "wysiwyg",
		theme: "advanced",
		// Skin options
		skin: "o2k7",
		skin_variant: "silver",
		language: "ru",
		plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
		// Theme options save,newdocument,|,
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
<? if ($id > 0): ?>
    	    $('#finder').on('hidden', function() {
    		$.post("{base}cms/catalog/make_tmb", {id: <?= $id ?>},
    		function(data) {

    		}, "html");
    	    });
<? endif; ?>
	});

	function elFinderBrowser(field_name, url, type, win) {
	    var elfinder_url = '<?= $base ?>cms/filemanager/tinymce';    // use an absolute path!
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

                <h2><?= ($id > 0) ? "Редактирование" : "Создание" ?> элемента</h2>
                <hr>
		<? if (!empty($error)): ?>
    		<div class="alert alert-error">
    		    <button type="button" class="close" data-dismiss="alert">&times;</button>
    		    <h4>Ошибка сохранения!</h4>
    		    <br/><?= $error ?>
    		</div>
		<? endif; ?>
                <form class="form" action="{method_path}" method="POST" enctype="multipart/form-data">
                    <div class="tabbable"> <!-- Only required for left/right tabs -->
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1" data-toggle="tab">Свойства</a></li>
                            <li><a href="#tab2" data-toggle="tab">Описание</a></li>
			    <li><a href="#tab3" data-toggle="tab">Отзывы</a></li>
			    <li><a href="#tab4" data-toggle="tab">Значки</a></li>
			    <li><a href="#tab5" data-toggle="tab">Аксессуары, «С этим товаром покупают»</a></li>
			    <li><a href="#tab6" data-toggle="tab">Цвета</a></li>
			    <li><a href="#tab7" data-toggle="tab">Галерея</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <input type="hidden" name="eid" value="<?= $id ?>" />
                                <div class="row">
                                    <div class="span3">
                                        <label>Порядок</label>
                                        <input type="number" class="span2" placeholder="1" name="order" value="<?= $item->order ?>"/>
                                        <label>SKU (артикул)</label>
                                        <input type="text" class="span2" placeholder="00123456" name="SKU" value="<?= $item->SKU ?>"/>
                                        <label>Цена</label>
                                        <input type="number" class="span2" placeholder="234" name="price" value="<?= $item->price ?>"/>
                                    </div>
                                    <div class="span3">
					<?
					if ($id > 0)
					{
					    ?>
					    <?
					    if (!empty($item->picture))
					    {
						?>
						<img class="thumbnail" src="{url_for_uploads}catalog/items/<?= $item->id ?>/s/<?= $item->picture ?>">
						<?
					    } else
					    {
						?>
						<img class="thumbnail" src="{cms_img}150x150.gif">
					    <? } ?>
					    <?
					} else
					{
					    ?>
    					<img class="thumbnail" src="{cms_img}150x150.gif">
					<? } ?>
					<hr>         
					<label>Файл JPEG, PNG или GIF</label>
					<input type="file" name="picture" id="picture" accept="image/jpeg,image/png,image/gif"/>
                                    </div>
                                    <div class="span6">
                                        <label>Категории</label>
                                        <div class="thumbnail" style="height: 200px; overflow-y: scroll;">
					    <?= $category ?>
                                        </div>
                                    </div>
                                </div>
				<div class="row">
				    <div class="span6">
					<label>Название</label>
					<input type="text" class="span6" placeholder="(Без имени...)" name="title" value="<?= $item->title ?>"/>
				    </div>
				    <div class="span6">
					<label>Алиас</label>
					<input type="text" class="span6" placeholder="no-name" name="alias" value="<?= $item->alias ?>"/>
				    </div>
				</div>

				<label>META-TITLE (название страницы в заголовке окна)</label>
				<input type="text" class="span12" placeholder="Товар" name="meta_title" value="<?= $item->meta_title ?>"/>

				<label>META-KEYWORDS (ключевые слова через запятую)</label>
                                <input type="text" class="span12" placeholder="ложка, лопата, эскаватор" name="meta_keywords" value="<?= $item->meta_keywords ?>"/>
                                <label for="meta_description">META-DESCRIPTION (описание страницы)</label>
                                <input type="text" class="span12" placeholder="Страница с философским трактатом об общем между лопатой и ложками." name="meta_description" value="<?= $item->meta_description ?>"/>
				<? if (FCMS_PROJECT == 'hygiene-at-nature'): ?>
    				<div class="row">
    				    <div class="span6">
    					<label>ph</label>
    					<input type="text" class="small" name="ph" placeholder="1.5" value="<?= $item->ph ?>"/>
    				    </div>
    				    <div class="span6">
    					<label>Объём</label>
    					<input type="text" class="small" name="volume" placeholder="0,5 л." value="<?= $item->volume ?>"/>
    				    </div>
    				</div>
				<? endif; ?>
                            </div>
                            <div class="tab-pane" id="tab2">
                                <label>Текст:</label>
                                <textarea style="width: 100%; height: 500px; padding: 0; margin: 0;" id="wysiwyg" name="description" class="tinymce"><?= $item->description ?></textarea>
                                <br />
                            </div>
			    <div class="tab-pane" id="tab3">
				<table class="table table-hover table-condensed">
				    <thead>
					<tr>
					    <th class="span1" style="overflow: hidden"><i class="icon-check"></i> Отображать</th>
					    <th class="span1" style="overflow: hidden">Оценка</th>
					    <th class="span2" style="overflow: hidden"><i class="icon-user"></i> Имя</th>
					    <th>Текст</th>
					</tr>
				    </thead>
				    <tbody>
					<? foreach ($reviews as $r): ?>
    					<tr>

    					    <td>
    						<label class="checkbox inline">
    						    <input type="checkbox" name="show[<?= $r->id ?>]" id="check-<?= $r->id ?>" <? if ($r->show == TRUE): ?>checked<? endif; ?> value="<?= $r->id ?>"/>
    						</label>
    					    </td>
    					    <td>
    						<input name="rate[<?= $r->id ?>]" type="number" value="<?= $r->rate ?>" class="input-small" />
    					    </td>
    					    <td>
    						<input type="text" name="name[<?= $r->id ?>]" value="<?= $r->name ?>" />
    					    </td>
    					    <td>
    						<textarea name="text[<?= $r->id ?>]" id="text-<?= $r->id ?>" style="width: 98%; height: 100%"><?= $r->text ?></textarea>
    					    </td>
    					</tr>
					<? endforeach; ?>
				    </tbody>
				</table>
			    </div>
			    <div class="tab-pane" id="tab4">

				<ul class="thumbnails">
				    <? foreach ($icons as $ic): ?>

    				    <li class="thumbnail"><img  src="<?= $url_for_uploads ?>catalog/icons/<?= $ic ?>" alt="" />
    					<label class="checkbox">
    					    <input type="checkbox" name="icon[]" value="<?= $ic ?>" <? if (in_array($ic, $icons_chk)): ?>checked<? endif; ?> /> Показать
    					</label>
    				    </li>

				    <? endforeach; ?>
				</ul>
			    </div>
			    <div class="tab-pane" id="tab5">
				<div class="row">
				    <div class="span6">
					<label>Аксессуары</label>
					<div class="thumbnail" style="height: 300px; overflow-y: scroll;">
					    <?= $acc ?>
                                        </div>
				    </div>
				    <div class="span6">
					<label>С этим товаром покупают:</label>
					<div class="thumbnail" style="height: 300px; overflow-y: scroll;">
					    <?= $also ?>
                                        </div>

				    </div>
				</div>
			    </div>
			    <div class="tab-pane" id="tab6">
				<? // Цвета ?>
				<ul class="thumbnails">

				    <? foreach ($colors as $color): ?>
    				    <li class="thumbnail">
    					<div style="width: 100px; height: 100px; background-color: <?= $color->number ?>;">
    					</div>
    					<label class="checkbox">

    					    <input type="checkbox" name="color[]" value="<?= $color->id ?>" <? if (in_array($color->id, $colors_chk)): ?>checked<? endif; ?> /> <?= $color->name ?>
    					</label>
    				    </li>
				    <? endforeach; ?>
				</ul>
			    </div>
			    <div class="tab-pane" id="tab7">
				<? // Галерея ?>
				<? // Диалог добавления ?>
				<div class="modal hide" id="modal_add">
				    <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>Добавить изображения</h3>
				    </div>

				    <div class="modal-body">
					<div class="alert">
					    <small>
						<strong>Настройки сервера</strong><br/>
						Максимальный размер для загрузки данных: <?= ini_get('post_max_size') ?><br/>
						Максимальный размер файла для загрузки: <?= ini_get('upload_max_filesize') ?><br/>
						Учитывайте при выборе файлов.
					    </small>
					</div>

					<label>Выберите файлы:</label>

					<div class="thumbnail">
					    <input class="inputf" type="file" size="5" multiple name="pictures[]"/>
					</div>
				    </div>
				    <div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">Отмена</a>
					<button type="submit" class="btn btn-primary">Добавить</button>
				    </div>
				</div>

				<? // Диалог удаления ?>
				<div class="modal hide" id="myModal">
				    <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>Подтвердите удаление</h3>
				    </div>
				    <div class="modal-body">
					<p>Вы действительно хотите удалить отмеченные элементы?</p>
				    </div>
				    <div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">Отмена</a>
					<a href="#" id="del_link" class="btn btn-primary">Удалить</a>
				    </div>
				</div>

				<div class="row">
				    <div class="btn-toolbar span12">
					<div class="btn-group">
					    <a href="#modal_add" role="button" class="btn" data-toggle="modal"><i class="icon-plus"></i> Добавить</a>
					    <button class="btn" id="delbtn" type="button"><i class="icon-trash"></i> Удалить</button>				    
					</div>
				    </div>
				</div>

				<? // Вывод галереи ?>
				<div class="row">		 
				    <div class="span12">
					<table class="table table-hover table-condensed">
					    <thead>
						<tr>
						    <th class="span3" style="overflow: hidden"><i class="icon-trash"></i> Файл</th>
						    <th>Цвет</th>
						    <th class="span1"><i class="icon-hdd"></i></th>
						</tr>
					    </thead>
					    <tbody>
						<? foreach ($gallery as $image): ?>
    						<tr>
    						    <td>
    							<img class="img-rounded" src="{url_for_uploads}catalog/gallery/<?= $image->item_id ?>/s/<?= $image->filename ?>" alt="<?= $image->alt ?>" title="<?= $image->title ?>" style="max-height: 100px"/>
    							<label class="checkbox inline">
    							    <input type="checkbox" name="check[]" id="check-<?= $image->id ?>" value="<?= $image->id ?>"/><small><?= $image->filename ?></small>
    							</label>
    						    </td>
    						    <td>
							    <? foreach ($colors as $color): ?>
								<label class="radio">
								    <input type="radio" name="piccolor[<?= $image->id ?>]" value="<?= $color->id ?>" 
									   <? if ($image->color == $color->id): ?> checked="checked" <? endif; ?>/> 
								    <span style="color: <?= $color->number ?>"><?= $color->name ?></span>
								</label>
							    <? endforeach; ?>
    						    </td>
    						    <td>
    							<button class="btn" type="submit">Сохранить</button>
    						    </td>
    						</tr>
						<? endforeach; ?>
					    </tbody>
					</table>
				    </div>			    
				</div>
			    </div>
                        </div>
                    </div><? // Tabs                            ?>
                    <div class="form-actions">
                        <button class="btn btn-primary save" type="submit" ><i class="icon-ok"></i> Сохранить</button>
                    </div>
                </form>
            </div>

        </div>
	<? require_once 'inc.footer.php';

