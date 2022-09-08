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
                    })
                }
            });
            $('#dellink').click(function() {
                $('#formdel').submit();
            });
        });
    </script>

    <? require_once 'inc.menu.php'; ?>

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
            <a href="#" id="dellink" class="btn btn-primary">Удалить</a>
        </div>
    </div>

    <div class="container">

        <div class="row">
            <div class="span6">
                <h2>Каталог</h2>
            </div>
            <div class="span6">
                <br/>
                <form method="post" id="searchform" action="{base}cms/catalog/search" class="form-search">
                    <div class="input-append">
                        <input type="text" value="" name="searchstr" id="s" class="input-medium span5 search-query">
                        <button type="submit" class="btn">Искать</button>
                    </div>
                </form>
            </div>
           
        </div>
        <div class="row">
            <div class="span12">
                 <hr>
                <div class="row">
                    <div class="btn-toolbar span6">
                        <div class="btn-group">
                            <a class="btn" href="<?= $base ?>cms/catalog/add"><i class="icon-plus"></i> Новый элемент</a>
                            <button class="btn" id="delbtn" type="button"><i class="icon-trash"></i> Удалить</button>
                            <button class="btn dropdown-toggle" id="catbtn" type="button" data-toggle="dropdown" onclick="$('#dd').toggle('slow');"><i class="icon-tag"></i> Категория <?= $category_name ?> </button>
                        </div>
                    </div>
                    <div class="span6">

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

            </div>
        </div>


        <div class="row">


            <form id="formdel" method="post" action="<?= $base ?>cms/catalog/delete">
                <div class="span12">


                    <table class="table table-striped table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th><i class="icon-check"></i> #</th>
                                <th>SKU</th>
                                <th>Наименование</th>
                                <th>Цена</th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($content as $item): ?>
                                <tr>
                                    <td><input type="checkbox" name="check[]" id="check-<?= $item->id ?>" value="<?= $item->id ?>"/> <?= $item->id ?></td>
                                    <td><?= $item->SKU ?></td>
                                    <td><a href="<?= $base ?>cms/catalog/edit/<?= $item->id ?>"><?= $item->title ?></a></td>
                                    <td><?= $item->price ?></td>
                                </tr>
                            <? endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </form>
            <?= $paginator ?>
        </div>

        <? require_once 'inc.footer.php'; ?>

