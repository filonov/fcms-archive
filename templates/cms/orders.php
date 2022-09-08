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
                    })
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
            <!--div class="modal hide" id="myModal">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>Подтвердите удаление</h3>
                </div>
                <div class="modal-body">
                    <p>Вы действительно хотите удалить заказы?</p>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn" data-dismiss="modal">Отмена</a>
                    <a href="#" id="dellink" class="btn btn-primary">Удалить</a>
                </div>
            </div-->
            <form id="formdel" method="post" action="{base}cms/orders/delete">
                <div class="span12">
                    <h2>Заказы</h2>
                    <hr/>
                    <!--div class="btn-toolbar">
                        <div class="btn-group">
                            <button class="btn" id="delbtn" type="button"><i class="icon-trash"></i> Удалить</button>
                        </div>
                    </div-->

                    <ul class="nav nav-tabs">
                        <li <?= ($status == 'new') ? 'class="active"' : ''; ?>>
                            <a href="{base}cms/orders/new">Новые</a>
                        </li>
                        <li <?= ($status == 'processing') ? 'class="active"' : ''; ?>>
                            <a href="{base}cms/orders/processing">В обработке</a></li>
                        
                        <li <?= ($status == 'completed') ? 'class="active"' : ''; ?>>
                            <a href="{base}cms/orders/completed">Выполнены</a></li>
                        
                        <li <?= ($status == 'refused') ? 'class="active"' : ''; ?>>
                            <a href="{base}cms/orders/refused">Отказ</a></li>
                    </ul>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><i class="icon-check"></i> ID</th>
                                <th>Дата</th>
                                <th>Клиент</th>
                                <th>Телефон</th>
                                <th>E-mail</th>
                                <th>Сумма</th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($orders as $order): ?>
                                <tr>
                                    <td><input type="checkbox" name="check[]" id="check-<?= $order->id ?>" value="<?= $order->id ?>"/> <?=$order->id?></td>
                                    <td><?= $order->created ?></td>
                                    <td><a href="{base}cms/orders/edit/<?= $order->id ?>"><?= $order->name ?></a></td>
                                    <td><?= $order->phone ?></td>    
                                    <td><?= $order->email ?></td>
                                    <td><?= $order->total ?></td>
                                </tr>
                            <? endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </form>
            <?= $paginator ?>

        </div>

        <? require_once 'inc.footer.php'; ?>    

