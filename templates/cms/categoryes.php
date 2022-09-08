<? require_once 'inc.header.php'; ?>

<body>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#addButton').click(function() {
                $('#addModal').modal('hide');
                $('#formadd').submit();
            });
            $('#delButtonModal').click(function() {
                var checked = $('#formdel input:checkbox:checked').val();
                if (checked)
                {
                    $('#delModal').modal('hide');
                    $('#formdel').submit();
                }
            });
            $('#editButton').click(function() {
                $('#editModal').modal('hide');
                $('#formedit').submit();
            });
        });

        function edit(root, left)
        {
            $.post("{base}cms/categoryes/ajaxGetCategory",
                    {lft: left, root: root},
            function(data) {
                $('#dbx').html(data.dropbox);
                $('#editTitle').val(data.title);
                $('#editAlias').val(data.alias);
                $('#editTemplate').val(data.template);
                $('#editDescription').val(data.description);
                $('#editImage').attr('src', '{url_for_uploads}thumbnails/' + data.image);
            }, "json");
            $('#editLft').val(left);
            $('#editModal').modal('show');
        }

        function move_up(lft)
        {
            $('#move_lft').val(lft);
            $('#move_direction').val('up');
            $('#form_move').submit();
            return false;
        }

        function move_down(lft)
        {
            $('#move_lft').val(lft);
            $('#move_direction').val('down');
            $('#form_move').submit();
            return false;
        }
    </script>

    <? // Форма для перемещения категорий ?>
    <div style="display: none">
        <form method="post" id="form_move" action="{base}cms/categoryes/move">
            <input type="hidden" name="root" id="move_root" value="{root}">
            <input type="hidden" name="lft" id="move_lft">
            <input type="hidden" name="direction" id="move_direction">
        </form>
    </div>


    <? // Диалог добавления нового материала ?>
    <div class="modal hide fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Добавить категорию</h3>
        </div>
        <div class="modal-body">
            <form action="{base}cms/categoryes/add" enctype="multipart/form-data" id="formadd" method="post" style="margin-top: 10px;" class="form-horizontal">
                <fieldset>   
                    <input type="hidden" name="root" value="{root}">  
                    <label >Родительская категория</label>      
                    <?=$category_dropbox?>
                    <label >Название</label>
                    <input name="title" class="span5" type="text" value=""/>
                    <label >Шаблон</label>
                    <input name="template" class="span5" type="text" value=""/>
                    <label >Описание</label>
                    <textarea name="description" class="span5"></textarea>
                    <label> Картинка</label>
                    <input type="file" name="thumbnail" id="image" accept="image/jpeg,image/png,image/gif"/>
                </fieldset>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Отменить</button>
            <button id="addButton" class="btn btn-primary">Сохранить</button>
        </div>
    </div>

    <? // Диалог редактирования ?>
    <div class="modal hide fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Редактирование категории</h3>
        </div>
        <div class="modal-body">
            <form action="{base}cms/categoryes/edit" enctype="multipart/form-data" id="formedit" method="post" style="margin-top: 10px;" class="form-horizontal">
                <fieldset>   
                    <input type="hidden" id="editRoot" name="root" value="{root}">  
                    <input type="hidden" id="editLft" name="left" value=""/>
                    <div class="row-fluid">
                        <div class="span6">
                            <label >Родительская категория</label>      
                            <div id="dbx"></div>
                        </div>
                        <div class="span6">
                            <img id="editImage" style="max-width: 50px; margin-left: 30px" class="thumbnail" src="">
			    <label class="checkbox">
				<input type="checkbox" name="delImage" value="kill"/> Удалить рисунок
			    </label>
                        </div>
                    </div>

                    <label>Название</label>
                    <input id="editTitle" name="title" type="text" value="" class="span5"/>
                    <label>Алиас</label>
                    <input id="editAlias" name="alias" type="text" value="" class="span5"/>
                    <label>Шаблон</label>
                    <input id="editTemplate" name="template" class="span5" type="text" value=""/>
                    <label >Описание</label>
                    <textarea id="editDescription" name="description" class="span5"></textarea>
                    <label> Картинка</label>
                    <input type="file" name="thumbnail"  accept="image/jpeg,image/png,image/gif"/>
                </fieldset>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Отменить</button>
            <button id="editButton" class="btn btn-primary">Сохранить</button>
        </div>
    </div>

    <? // Диалог удаления ?>
    <div class="modal hide fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="delModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="delModalLabel">Удаление категорий</h3>
        </div>
        <div class="modal-body">
            Вы действительно хотите удалить отмеченные категории? Вложенные категории тоже будут удалены.
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Отменить</button>
            <button id="delButtonModal" class="btn btn-warning">Удалить</button>
        </div>
    </div>



    <? require_once 'inc.menu.php'; ?>

    <div class="container">
        <h2>
            <?
            switch ($root)
            {
                case CATEGORYES_CONTENT: echo "Категории контента";
                    break;
                case CATEGORYES_CATALOG: echo "Категории каталога";
                    break;
                case CATEGORYES_GALLERY: echo "Галереи";
                    break;
            }
            ?></h2>
        <div class="row">

            <div class="span12">

                <div class="btn-toolbar">
                    <div class="btn-group">
                        <a class="btn" href="#addModal" role="button" data-toggle="modal"><i class="icon-plus"></i> Добавить</a>
                        <a class="btn" href="#delModal" role="button" data-toggle="modal" ><i class="icon-trash"></i> Удалить отмеченные</a>
                    </div>
                </div>
                <form id="formdel" name="formdel" method="post" action="{base}cms/categoryes/delete">
                    <input type="hidden" name="root" value="{root}" >

                    <table class="table table-bordered table-condensed table-striped">
                        <thead>
                            <tr>
                                <th style="width: 5%"><i class="icon-check"></i> №</th>
                                <th style="width: 4%"><i class="icon-arrow-up"></i><i class="icon-arrow-down"></i></th>
                                <th style="width: 50%">Название</th>
                                <th style="width: 45%">Алиас</th>
                            </tr>
                        </thead>
                        <? foreach ($tree as $item): ?>

                            <tr>
                                <td>
                                    <label class="checkbox">
                                        <input type="checkbox" value="<?= $item['lft'] ?>" name="item[<?= $item['id'] ?>]"/> <?= $item['id'] ?>
                                    </label>
                                </td>
                                <td>
                                    <a href="#" id="moveup-<?= $item['lft'] ?>" onclick="move_up(<?= $item['lft'] ?>);"><i class="icon-arrow-up"></i></a>
                                    <a href="#" id="movedown-<?= $item['lft'] ?>" onclick="move_down(<?= $item['lft'] ?>);"><i class="icon-arrow-down"></i></a>
                                </td>
                                <td><?= nbs(($item['__level']) * 4) ?>
                                    <a ancor="anc-<?= $item['lft'] ?>" class="editLink" onclick="edit(<?= $root ?>,<?= $item['lft'] ?>);"><?= $item['title'] ?></a>
                                </td>
                                <td>
                                    <?= $item['alias'] ?>
                                </td>
                            </tr>
                        <? endforeach; ?>
                    </table>

                </form>
            </div>
        </div> 
        <? require_once 'inc.footer.php'; ?>
