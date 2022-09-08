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
            $.post("{base}cms/categoryes/ajaxGetMenu",
                    {lft: left, root: root},
            function(data) {
                $('#dbx').html(data.dropbox);
                $('#editTitle').val(data.title);
                $('#editAlias').val(data.alias);
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

    <? // Форма для перемещения пунктов меню ?>
    <div style="display: none">
        <form method="post" id="form_move" action="{base}cms/menu/move">
            <input type="hidden" name="root" id="move_root" value="{root}">
            <input type="hidden" name="lft" id="move_lft">
            <input type="hidden" name="direction" id="move_direction">
        </form>
    </div>

    <? // Диалог добавления нового пункта меню  ?>
    <div class="modal hide fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Добавить пункт</h3>
        </div>
        <div class="modal-body">
            <form action="{base}cms/menu/add" id="formadd" method="post" style="margin-top: 10px;">
                <fieldset>  
                    <div class="row-fluid">
                        <div class="span5">
                            <input type="hidden" name="root" value="{root}">  
                            <label>Название</label>
                            <input type="text" name="title" value=""/>
                        </div>
                        <div class="span5">
                            <label>Родительский пункт меню</label>     
                            {menu_dropbox}
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span5">
                            <label class="radio">
                                <input type="radio" name="content_type" id="content_type1" value="<?= CONTENT_PAGE ?>" checked>
                                Страница
                            </label>
                            {select_page}
                        </div>
                        <div class="span5">
                            <label class="radio">
                                <input type="radio" name="content_type" id="content_type2" value="<?= CONTENT_CATEGORY ?>">
                                Лента категории контента
                            </label> 
                            {category_dropbox}
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span5">
                            <label class="radio">
                                <input type="radio" name="content_type" id="content_type1" value="<?= CONTENT_CATALOG ?>" >
                                Каталог
                            </label>
                            <p class="text-info">Ссылка на главную страницу каталога.</p>
                        </div>

                        <div class="span5">
                            <label class="radio">
                                <input type="radio" name="content_type" id="content_type1" value="<?= CONTENT_CATALOG_CATEGORY ?>" >
                                Категория каталога
                            </label>
                            {category_catalog_dropbox}
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span5">
                            <label class="radio">
                                <input type="radio" name="content_type" id="content_type1" value="<?= CONTENT_GALLERY ?>" >
                                Галерея
                            </label>
                            <p class="text-info">Ссылка на главную страницу галерей.</p>
                        </div>

                        <div class="span5">
                            <label class="radio">
                                <input type="radio" name="content_type" id="content_type1" value="<?= CONTENT_GALLERY_CATEGORY ?>" >
                                Галерея
                            </label>
                            {category_gallery_dropbox}
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span5">
                            <label class="radio">
                                <input type="radio" name="content_type" id="content_type1" value="<?= CONTENT_LINK ?>" >
                                Ссылка
                            </label>
                            <input name="link" type="text" value="" placeholder="http://filonov.biz"/>
                        </div>
                        <div class="span5">    
                            <label class="radio">
                                <input type="radio" name="content_type" id="content_type1" value="<?= CONTENT_LINK_INTERNAL ?>" >
                                Внутренняя ссылка
                            </label>
                            <input name="link_internal" type="text" value="" placeholder="conrent/category1/article-about"/>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Отменить</button>
            <button id="addButton" class="btn btn-primary">Сохранить</button>
        </div>
    </div>

    <? // Диалог редактирования  ?>
    <div class="modal hide fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Редактировать пункт меню</h3>
        </div>
        <div class="modal-body">
            <form action="{base}cms/menu/edit" id="form_edit" method="post" style="margin-top: 10px;">
                <fieldset>  
                    <div class="row-fluid">
                        <div class="span5">
                            <input type="hidden" name="root" value="{root}">  
                            <label>Название</label>
                            <input type="text" name="edit_title" id="edit_title" value=""/>
                        </div>
                        <div class="span5">
                            <label>Родительский пункт меню</label>   
                            <div id="parent_menu">
                                <!--menu_dropbox-->
                            </div>

                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span5">
                            <label class="radio">
                                <input type="radio" name="content_type" id="content_type1" value="<?= CONTENT_PAGE ?>" checked>
                                Страница
                            </label>
                            {select_page}
                        </div>
                        <div class="span5">
                            <label class="radio">
                                <input type="radio" name="content_type" id="content_type2" value="<?= CONTENT_CATEGORY ?>">
                                Контент по категории
                            </label> 
                            {category_dropbox}
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span5">
                            <label class="radio">
                                <input type="radio" name="content_type" id="content_type1" value="<?= CONTENT_CATALOG ?>" >
                                Каталог
                            </label>
                            <p class="text-info">Ссылка на главную страницу каталога.</p>
                        </div>

                        <div class="span5">
                            <label class="radio">
                                <input type="radio" name="content_type" id="content_type1" value="<?= CONTENT_CATALOG_CATEGORY ?>" >
                                Категория каталога
                            </label>
                            {category_catalog_dropbox}
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span5">
                            <label class="radio">
                                <input type="radio" name="content_type" id="content_type1" value="<?= CONTENT_LINK ?>" >
                                Ссылка
                            </label>
                            <input name="link" type="text" value="" placeholder="http://google.com"/>
                        </div>
                        <div class="span5">    
                            <label class="radio">
                                <input type="radio" name="content_type" id="content_type1" value="<?= CONTENT_LINK_INTERNAL ?>" >
                                Внутренняя ссылка
                            </label>
                            <input name="link_internal" type="text" value="" placeholder="conrent/category1/article-about"/>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Отменить</button>
            <button id="addButton" class="btn btn-primary">Сохранить</button>
        </div>
    </div>

    <? // Диалог удаления  ?>
    <div class="modal hide fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="delModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="delModalLabel">Удаление пункта меню</h3>
        </div>
        <div class="modal-body">
            Вы действительно хотите удалить отмеченные пункты меню? Вложенные меню тоже будут удалены.
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Отменить</button>
            <button id="delButtonModal" class="btn btn-warning">Удалить</button>
        </div>
    </div>



    <? require_once 'inc.menu.php'; ?>

    <div class="container">
        <h2>Редактор меню: <?= $menu_title ?></h2>
        <div class="row">

            <div class="span12">

                <div class="btn-toolbar">
                    <div class="btn-group">
                        <a class="btn" href="#addModal" role="button" data-toggle="modal"><i class="icon-plus"></i> Добавить</a>
                        <a class="btn" href="#delModal" role="button" data-toggle="modal" ><i class="icon-trash"></i> Удалить отмеченные</a>
                    </div>
                </div>


                <form id="formdel" name="formdel" method="post" action="{base}cms/menu/delete">
                    <input type="hidden" name="root" value="{root}" >
                    <table class="table table-bordered table-condensed table-striped">
                        <thead>
                            <tr>
                                <th style="width: 5%"><i class="icon-check"></i> №</th>
                                <th style="width: 4%"><i class="icon-arrow-up"></i><i class="icon-arrow-down"></i></th>
                                <th>Название</th>
                                <th style="width: 15%">Тип</th>
                                <!--th style="width: 10%">Операции</th-->
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
                                <td><?= nbs($item['__level'] * 4) ?><!-- onclick="edit({root},<?= $item['lft'] ?>);" -->
                                    <?
                                    $href = '#';
                                    switch ($item['content_type'])
                                    {
                                        case CONTENT_PAGE:
                                            $href = base_url('cms/pages/edit').'/'.$item['content_id'];
                                            break;
                                        
                                    }
                                    ?>
                                    <a href='<?=$href?>' ancor="anc-<?= $item['lft'] ?>" class="editLink"  ><?= $item['title'] ?></a>
                                </td>
                                <td>
                                    <span class="label label-info">
                                        <?
                                        switch ($item['content_type'])
                                        {
                                            case CONTENT_PAGE:
                                                echo "страница";
                                                break;
                                            case CONTENT_CATEGORY:
                                                echo "контент по категории";
                                                break;
                                            case CONTENT_CATALOG:
                                                echo "каталог";
                                                break;
                                            case CONTENT_CATALOG_CATEGORY:
                                                echo "категория каталога";
                                                break;
                                            case CONTENT_GALLERY:
                                                echo "галерея";
                                                break;
                                            case CONTENT_GALLERY_CATEGORY:
                                                echo "категория галереи";
                                                break;
                                            case CONTENT_LINK:
                                                echo "ссылка";
                                                break;
                                            case CONTENT_LINK_INTERNAL:
                                                echo "внутренняя ссылка";
                                                break;
                                        }
                                        ?>
                                    </span>
                                </td>
                                <!--td>
                                    
                                    <span class="close" href="#" onClick="" title="Переименовать" rel="tooltip"><i class="icon-arrow-down"></i></span>
                                    <span class="close" href="#" onClick="" title="Переименовать" rel="tooltip"><i class="icon-arrow-up"></i></span>
                                </td-->
                            </tr>
                        <? endforeach; ?>
                    </table>
                </form>
            </div>
        </div> 
        <? require_once 'inc.footer.php'; ?>
