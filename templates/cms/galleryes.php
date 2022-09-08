<? require_once 'inc.header.php'; ?>

<body>
    <script type="text/javascript">
        $(document).ready(function() {

            $('#delbtn').click(function() {
                var checked = $('#formdel input:checkbox:checked').val();
                if (checked)
                {
                    $('#myModal').modal({
                        keyboard: false
                    });
                }
            });

            $('#del_link').click(function() {
                $('#formdel').submit();
            });

            $('#movebtn').click(function() {
                var checked = $('#formdel input[type="checkbox"]:checked').val();
                if (checked)
                {
                    $('#formdel input[type="checkbox"]:checked').each(function() {

                        $('#form_move input[type="checkbox"]').eq($(this).parentsUntil('li.span2').parent().index()).prop('checked', true);
                    });
                    $('#modal_move').modal({
                        keyboard: false
                    });
                }
            });
        });
    </script>

    <? require_once 'inc.menu.php'; ?>

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
            <form class="form" action="<?= current_url() ?>" method="POST" enctype="multipart/form-data">
                <label>Выберите файлы:</label>

                <div class="thumbnail">
                    <input class="inputf" type="file" size="5" multiple name="pictures[]"/>
                </div>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">Отмена</a>
            <button type="submit" class="btn btn-primary">Добавить</button></form>
        </div>
    </div>

    <? // Диалог перемещения?>
    <div class="modal hide" id="modal_move">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h3>Переместить в другую галерею</h3>
        </div>
        <div class="modal-body">
            <form method="post" action="{base}cms/galleryes/move" id="form_move" name="form_move">
                {cat_drop} 
                <fieldset> 
                    <? foreach ($content as $item): ?>
                        <label class="checkbox inline">
                            <input type="checkbox" name="check[]" id="check-<?= $item->id ?>" value="<?= $item->id ?>"/><?= $item->filename ?>
                        </label><br/>
                    <? endforeach; ?>
                </fieldset>         
        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">Отмена</a>
            <button type="submit" class="btn btn-primary">Добавить</button></form>
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

    <div class="container">

        <div class="row">
            <div class="span12">
                <h2>Изображения <small><?= $category_name ?></small></h2>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="span12">
                <div class="row">
                    <div class="btn-toolbar span12">
                        <div class="btn-group">
                            <a href="#modal_add" role="button" class="btn" data-toggle="modal"><i class="icon-plus"></i> Добавить</a>
                            <button class="btn" id="movebtn" type="button"><i class="icon-move"></i> Переместить</button>
                            <button class="btn" id="delbtn" type="button"><i class="icon-trash"></i> Удалить</button>
                            <button class="btn dropdown-toggle" id="catbtn" type="button" data-toggle="dropdown" onclick="$('#dd').toggle('slow');"><i class="icon-tag"></i> Категории (фильтр)</button>
                        </div>
                    </div>
                </div>

                <div class="row dropdown hide" id="dd">
                    <div class="well span12 " style="padding: 8px 0;">
                        <ul class="nav nav-list">
                            <li class="nav-header">
                                Галереи
                            </li>
                            <li>
                                <a href="{base}cms/galleryes">
                                    <i class="icon-tags"></i>
                                    Все галереи
                                </a>
                            </li>
                            {cattree}
                        </ul>                                        
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <form id="formdel" method="post" action="<?= $base ?>cms/galleryes/delete">
                <div class="span12">
                    <table class="table table-hover table-condensed">
                        <thead>
                            <tr>
                                <th class="span3" style="overflow: hidden"><i class="icon-check"></i> Файл</th>
                                <th class="span2" style="overflow: hidden"><i class="icon-picture"></i></th>
                                <th>Описание</th>
                                <th class="span1"><i class="icon-hdd"></i></th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($content as $item): ?>
                                <tr>
                                    <td>
                                        <label class="checkbox inline">
                                            <input type="checkbox" name="check[]" id="check-<?= $item->id ?>" value="<?= $item->id ?>"/><small><?= $item->filename ?></small>
                                        </label>
                                    </td>
                                    <td align="center">
                                        <img class="img-rounded" src="{url_for_uploads}gallery/<?= $item->category_id ?>/s/<?= $item->filename ?>" alt="<?= $item->alt ?>" title="<?= $item->title ?>" style="max-height: 100px"/>
                                    </td>
                                    <td>
                                        <textarea name="desc[<?= $item->id ?>]" id="desc-<?= $item->id ?>" style="width: 98%; height: 100%"><?=$item->description?></textarea>
                                    </td>
                                    <td>
                                        <button class="btn" type="submit">Сохранить</button>
                                    </td>
                                </tr>
                            <? endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </form>
            <?= $paginator ?>
        </div>

        <? require_once 'inc.footer.php'; ?>

