<? require_once 'inc.header.php'; ?>

<body>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#categoryes').affix();
            $('#delbtn').click(function() {
                var checked = $('#formdel input:checkbox:checked').val();
                if (checked)
                {
                    $('#myModal').modal({
                        keyboard: false
                    });
                }
            });
            $('#dellink').click(function() {
                $('#formdel').submit();
            });
        });
    </script>

    <? require_once 'inc.menu.php'; ?>

    <div class="container">

        <div class="row">
            <div class="modal hide" id="myModal">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>Подтвердите удаление</h3>
                </div>
                <div class="modal-body">
                    <p>Вы действительно хотите удалить страницы?</p>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn" data-dismiss="modal">Отмена</a>
                    <a href="#" id="dellink" class="btn btn-primary">Удалить</a>
                </div>
            </div>
            <form id="formdel" method="post" action="{base}cms/content/delete">
                <div class="span12">
                    <h2>Статьи</h2>
                    <hr/>
                    <div class="btn-toolbar">
                        <div class="btn-group">
                            <a class="btn" href="{base}cms/content/add"><i class="icon-file"></i> Новая страница</a>
                            <button class="btn" id="delbtn" type="button"><i class="icon-trash"></i> Удалить</button>
                            <button class="btn dropdown-toggle" id="catbtn" type="button" data-toggle="dropdown" onclick="$('#dd').toggle('slow');"><i class="icon-tag"></i> Категория <?= $category_name ?> </button>
                        </div>
                    </div>
                    <div class="row dropdown hide" id="dd">
                        <div class="well span12 " style="padding: 8px 0;">
                            <ul class="nav nav-list">
                                <li class="nav-header">
                                    Категории
                                </li>
                                <li>
                                    <a href="{base}cms/catalog">
                                        <i class="icon-tags"></i>
                                        Все категории
                                    </a>
                                </li>
                                {cattree}
                            </ul>                                        
                        </div>
                    </div>
                    <table class="table table-hover table-condensed">
                        <thead>
                            <tr>
                                <th><i class="icon-check"></i></th>
                                <th>Название</th>
                                <th>Ссылка</th>
                                <th>Шаблон</th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($pages as $page): ?>
                                <tr>
                                    <td><input type="checkbox" name="check[]" id="check-<?= $page->id ?>" value="<?= $page->id ?>"/></td>
                                    <td><a href="{base}cms/content/edit/<?= $page->id ?>"><?= $page->title ?></a></td>
                                    <td><?= $page->alias ?></td>    
                                    <td><?= $page->template ?></td>
                                </tr>
                            <? endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </form>
            <?= $paginator ?>

        </div>

        <? require_once 'inc.footer.php'; ?>    

