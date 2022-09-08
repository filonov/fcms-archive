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
		// theme_advanced_buttons3: "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		// theme_advanced_buttons4: "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
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
	    var elfinder_url = '{base}cms/filemanager/tinymce'; // use an absolute path!
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
    <script type="text/javascript">
	$(document).ready(function() {


	});
	function add_question(page_id)
	{
	    $('#addModal-' + page_id).modal('hide');
	    $.post("<?= base_url('cms/testing/ajax_add_question') ?>",
		    {
			page_id: page_id,
			title: $('#title-' + page_id).val(),
			number: $('#number-' + page_id).val(),
			a1: $('#a1-' + page_id).val(),
			b1: $('#b1-' + page_id).val(),
			a2: $('#a2-' + page_id).val(),
			b2: $('#b2-' + page_id).val(),
			a3: $('#a3-' + page_id).val(),
			b3: $('#b3-' + page_id).val(),
			a4: $('#a4-' + page_id).val(),
			b4: $('#b4-' + page_id).val()

		    },
	    function(data) {
		$('#ajax_questions-' + page_id).html(data);
		$('#form_add_q-' + page_id)[0].reset();
	    }, "html");
	}

	function get_q(q_id, page_id)
	{
	    $.post("{base}cms/testing/ajax_get_question",
		    {id: q_id},
	    function(data) {
		$('#question_id-' + page_id).val(data.question_id);
		$('#edit_title-' + page_id).val(data.title);
		$('#edit_number-' + page_id).val(data.number);
		$('#edit_a1-' + page_id).val(data.a1);
		$('#edit_a2-' + page_id).val(data.a2);
		$('#edit_a3-' + page_id).val(data.a3);
		$('#edit_a4-' + page_id).val(data.a4);
		$('#edit_b1-' + page_id).val(data.b1);
		$('#edit_b2-' + page_id).val(data.b2);
		$('#edit_b3-' + page_id).val(data.b3);
		$('#edit_b4-' + page_id).val(data.b4);
	    }, "json");
	    $('#editModal-' + page_id).modal('show');
	}

	function edit_question(page_id)
	{
	    $('#editModal-' + page_id).modal('hide');
	    $.post("<?= base_url('cms/testing/ajax_edit_question') ?>",
		    {
			page_id: page_id,
			question_id: $('#question_id-' + page_id).val(),
			title: $('#edit_title-' + page_id).val(),
			number: $('#edit_number-' + page_id).val(),
			a1: $('#edit_a1-' + page_id).val(),
			a2: $('#edit_a2-' + page_id).val(),
			a3: $('#edit_a3-' + page_id).val(),
			a4: $('#edit_a4-' + page_id).val(),
			b1: $('#edit_b1-' + page_id).val(),
			b2: $('#edit_b2-' + page_id).val(),
			b3: $('#edit_b3-' + page_id).val(),
			b4: $('#edit_b4-' + page_id).val()
		    },
	    function(data) {
		$('#ajax_questions-' + page_id).html(data);
	    }, "html");
	}

	function del_q(q_id, page_id)
	{
	    $.post("{base}cms/testing/ajax_delete_question",
		    {
			question_id: q_id,
			page_id: page_id
		    },
	    function(data) {
		$('#ajax_questions-' + page_id).html(data);
	    }, "html");
	}

    </script>
    <div class="container">

        <div class="row">           
            <div class="span12">
                <h2>Редактируем тест <small><?= $item->title ?></small></h2>
                <hr>
		<? if (!empty($error)): ?>
    		<div class="alert alert-error">
    		    <button type="button" class="close" data-dismiss="alert">&times;</button>
    		    <h4>Ошибка сохранения!</h4>
    		    <br/><?= $error ?>
    		</div>
		<? endif; ?>
                <form class="form" id="form_testing" method="post" action="<?= base_url('cms/testing/edit/' . $item->id) ?>">
                    <fieldset>

                        <!-- Text input-->
                        <div class="control-group">
                            <label class="control-label" for="title">Название теста</label>
                            <div class="controls">
                                <input id="title" name="title" type="text" placeholder="Тест по клингонскому языку, уровень nightmare" class="span12" value="<?= !empty($item->title) ? $item->title : '' ?>">

                            </div>
                        </div>

			<div class="row">
			    <div class="span9">
				<!-- Text input-->
				<div class="control-group">
				    <label class="control-label" for="alias">Алиас</label>
				    <div class="controls">
					<input id="alias" name="alias" type="text" placeholder="tlhIngan-Hol" value="<?= !empty($item->alias) ? $item->alias : '' ?>" class="span9">
				    </div>
				</div>
			    </div>
			    <div class="span3">
				<label>Язык</label>
				<label class="radio">
				    <input type="radio" name="language" id="optionslanguage1" value="<?= ITALIAN ?>" <?= ($item->language == ITALIAN) ? "checked" : "" ?>>
				    Итальянский
				</label>
				<label class="radio">
				    <input type="radio" name="language" id="optionslanguage2" value="<?= SPAIN ?>" <?= ($item->language == SPAIN) ? "checked" : "" ?>>
				    Испанский
				</label>
			    </div>
			</div>

                        <!-- Textarea -->
                        <div class="control-group">
                            <label class="control-label" for="description">Описание</label>
                            <div class="controls">                     
                                <textarea id="description" style="width: 100%; height: 400px; padding: 0; margin: 0;" 
                                          class="tinymce" name="description"><?= !empty($item->description) ? $item->description : '' ?></textarea>
                            </div>
                        </div>


                    </fieldset>
                    <div class="control-group">
                        <button type="submit" form="form_testing" class="btn btn-primary">Сохранить</button>
                    </div>
                </form>

            </div>
        </div>
        <div class="row">

            <div class="span12">
                <h3>Страницы теста</h3>
                <hr/>
                <a name="pages" href="#"></a>
                <div class="tabbable"> <!-- Only required for left/right tabs -->
                    <ul class="nav nav-tabs">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                Действия
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="<?= base_url('cms/testing/add_page/' . $item->id) ?>"><i class="icon-file"></i> Новая страница</a></li>
                            </ul>
                        </li>
			<? foreach ($pages as $page): ?>
    			<li><a href="#tab<?= $page->id ?>" data-toggle="tab"><?= $page->title ?></a></li>
			<? endforeach; ?>
                    </ul>
                    <div class="tab-content">
			<? foreach ($pages as $page): ?>
    			<div class="tab-pane" id="tab<?= $page->id ?>">
    			    <form class="form" id="form_page_<?= $page->id ?>" action="<?= base_url('cms/testing/edit_page/') ?>" method="post">
    				<input type="hidden" name="tests_id" value="<?= $item->id ?>">
    				<input type="hidden" name="page_id" value="<?= $page->id ?>">
    				<div class="row-fluid">
    				    <div class="span6">
    					<label for="number">Номер страницы</label>
    					<input id="number" name="number" type="text" placeholder="1" class="input-mini" value="<?= !empty($page->number) ? $page->number : '' ?>">
    					<label for="page_title">Заголовок страницы</label>
    					<input id="page_title" name="title" type="text" placeholder="Первая страница текста" value="<?= !empty($page->title) ? $page->title : '' ?>" class="span12">
    				    </div>
    				    <div class="span6">
    					<label  for="page_description">Поясняющий текст</label>
    					<textarea class="span12" rows="4" id="description" name="description"><?= !empty($page->description) ? $page->description : '' ?></textarea>
    				    </div>
    				</div>

    				<div class="row-fluid">
    				    <div class="span4">
    					<div class="well well-small">
    					    <div class="label label-success">Отлично</div><br/><br/>
    					    <label for="perfectly">Сумма баллов за «отлично»</label>
    					    <input id="perfectly" name="perfectly" type="text" value="<?= !empty($page->perfectly) ? $page->perfectly : '' ?>" placeholder="20" class="input-mini">
    					    <label for="perfectly_description">Текст для «отлично»</label>
    					    <textarea rows="5" style="width:95%" id="perfectly_description" name="perfectly_description"><?= !empty($page->perfectly_description) ? $page->perfectly_description : '' ?></textarea>
    					</div>
    				    </div>
    				    <div class="span4">
    					<div class="well well-small">
    					    <div class="label label-warning">Удовлетворительно</div><br/><br/>
    					    <label for="passably">Сумма баллов за «удовлетворительно»</label>
    					    <input id="passably" name="passably" value="<?= !empty($page->passably) ? $page->passably : '' ?>" type="text" placeholder="20" class="input-mini">
    					    <label for="passably_description">Текст для «удовлетворительно»</label>
    					    <textarea rows="5" style="width:95%" id="passably_description" name="passably_description"><?= !empty($page->passably_description) ? $page->passably_description : '' ?></textarea>
    					</div>
    				    </div>
    				    <div class="span4">
    					<div class="well well-small">
    					    <div class="label label-important">Плохо</div><br/><br/>
    					    <label for="poorly">Сумма баллов за «плохо»</label>
    					    <input id="poorly" name="poorly" value="<?= !empty($page->poorly) ? $page->poorly : '' ?>" type="text" placeholder="20" class="input-mini">
    					    <label for="poorly_description">Текст для «плохо»</label>
    					    <textarea rows="5" style="width:95%" id="poorly_description" name="poorly_description"><?= !empty($page->poorly_description) ? $page->poorly_description : '' ?></textarea>
    					</div>
    				    </div>
    				</div>
    				<button class="btn btn-primary" form="form_page_<?= $page->id ?>" type="submit">Сохранить</button>
    			    </form>

				<? // Диалог добавления  ?>
    			    <div class="modal hide fade" id="addModal-<?= $page->id ?>" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    				<div class="modal-header">
    				    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    				    <h3 id="addModal">Вопрос</h3>
    				</div>
    				<div class="modal-body">
    				    <form action="<?= base_url('cms/testing/add_question') ?>" enctype="multipart/form-data" id="form_add_q-<?= $page->id ?>" method="post" style="margin-top: 10px;" class="form-horizontal">
    					<fieldset>   
    					    <label>Вопрос</label>
    					    <input id="title-<?= $page->id ?>" name="title" type="text" value="" class="span5"/>
    					    <label>Номер вопроса</label>
    					    <input id="number-<?= $page->id ?>" name="number" type="text" value="" class="span1"/>
    					    <table>
    						<thead>
    						    <tr>
    							<th class="span4">Ответ</th>
    							<th class="span1">Баллы</th>
    						    </tr>
    						</thead>
    						<tbody>
    						    <tr>
    							<td><input id="a1-<?= $page->id ?>" type="text" class="span4"></td>
    							<td><input id="b1-<?= $page->id ?>" type="text" class="span1"></td>
    						    </tr>
    						    <tr>
    							<td><input id="a2-<?= $page->id ?>" type="text" class="span4"></td>
    							<td><input id="b2-<?= $page->id ?>" type="text" class="span1"></td>
    						    </tr>
    						    <tr>
    							<td><input id="a3-<?= $page->id ?>" type="text" class="span4"></td>
    							<td><input id="b3-<?= $page->id ?>" type="text" class="span1"></td>
    						    </tr>
    						    <tr>
    							<td><input id="a4-<?= $page->id ?>" type="text" class="span4"></td>
    							<td><input id="b4-<?= $page->id ?>" type="text" class="span1"></td>
    						    </tr>
    						</tbody>
    					    </table>
    					</fieldset>
    				    </form>
    				</div>
    				<div class="modal-footer">
    				    <button class="btn" data-dismiss="modal" aria-hidden="true">Отменить</button>
    				    <button id="addButton" onclick="add_question(<?= $page->id ?>);" class="btn btn-primary">Сохранить</button>
    				</div>
    			    </div>

				<? // Диалог редактирования  ?>
    			    <div class="modal hide fade" id="editModal-<?= $page->id ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    				<div class="modal-header">
    				    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    				    <h3 id="editModal">Редактировать вопрос</h3>
    				</div>
    				<div class="modal-body">
    				    <form action="<?= base_url('cms/testing/add_question') ?>" enctype="multipart/form-data" id="form_add_q" method="post" style="margin-top: 10px;" class="form-horizontal">
    					<fieldset>   
    					    <input type="hidden" name="" id="question_id-<?= $page->id ?>" value="">
    					    <label>Вопрос</label>
    					    <input id="edit_title-<?= $page->id ?>" name="edit_title" type="text" value="" class="span5"/>
    					    <label>Номер вопроса</label>
    					    <input id="edit_number-<?= $page->id ?>" name="edit_number" type="text" value="" class="span1"/>
    					    <table>
    						<thead>
    						    <tr>
    							<th class="span4">Ответ</th>
    							<th class="span1">Баллы</th>
    						    </tr>
    						</thead>
    						<tbody>
    						    <tr>
    							<td><input id="edit_a1-<?= $page->id ?>" type="text" class="span4"></td>
    							<td><input id="edit_b1-<?= $page->id ?>" type="text" class="span1"></td>
    						    </tr>
    						    <tr>
    							<td><input id="edit_a2-<?= $page->id ?>" type="text" class="span4"></td>
    							<td><input id="edit_b2-<?= $page->id ?>" type="text" class="span1"></td>
    						    </tr>
    						    <tr>
    							<td><input id="edit_a3-<?= $page->id ?>" type="text" class="span4"></td>
    							<td><input id="edit_b3-<?= $page->id ?>" type="text" class="span1"></td>
    						    </tr>
    						    <tr>
    							<td><input id="edit_a4-<?= $page->id ?>" type="text" class="span4"></td>
    							<td><input id="edit_b4-<?= $page->id ?>" type="text" class="span1"></td>
    						    </tr>
    						</tbody>
    					    </table>
    					</fieldset>
    				    </form>
    				</div>
    				<div class="modal-footer">
    				    <button class="btn" data-dismiss="modal" aria-hidden="true">Отменить</button>
    				    <button id="editButton" onclick="edit_question(<?= $page->id ?>);" class="btn btn-primary">Сохранить</button>
    				</div>
    			    </div>

    			    <div class="btn-toolbar">
    				<div class="btn-group">
    				    <a href="#addModal-<?= $page->id ?>" role="button" data-toggle="modal" class="btn"  href="#"><i class="icon-file"></i> Новый вопрос</a>

    				</div>
    			    </div>
    			    <a name="questions" href="#"></a>
    			    <div id="ajax_questions-<?= $page->id ?>">
    				<table class="table table-hover table-condensed">
    				    <thead>
    					<tr>
    					    <th class="span1">#</th>
    					    <th class="span2">Номер</th>
    					    <th class="span7">Вопрос</th>
    					    <th class="span1">Операции</th>
    					</tr>
    				    </thead>
    				    <tbody>
					    <? $questions->get_by_tests_pages_id($page->id); ?>
					    <? $page_id = $page->id; ?>
					    <? foreach ($questions as $question): ?>
						<tr>
						    <td><?= $question->id ?></td>
						    <td><a class="q_edit" href="#" onclick="get_q(<?= $question->id ?>,<?= $page_id ?>);"><?= $question->number ?></a></td>
						    <td><a class="q_edit" href="#" onclick="get_q(<?= $question->id ?>,<?= $page_id ?>);"><?= $question->title ?></a></td>
						    <td><a class="q_del btn btn-mini" href="#" onclick="del_q(<?= $question->id ?>,<?= $page_id ?>);"><i class="icon-trash"></i> Удалить</a></td>
						</tr>
					    <? endforeach; ?>
    				    </tbody>
    				</table>
    			    </div>

    			</div><? // tabs                                    ?>
			<? endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
	<? require_once 'inc.footer.php'; ?>    

