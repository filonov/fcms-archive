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
            <form id="formdel" method="post" action="{base}cms/forms/delete">
                <div class="span12">
                    <h2>Анкеты</h2>
                    <hr/>
                    <!--div class="btn-toolbar">
                        <div class="btn-group">
                            <button class="btn" id="delbtn" type="button"><i class="icon-trash"></i> Удалить</button>
                        </div>
                    </div-->

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><i class="icon-check"></i> ID</th>
                                <th>Дата поступления</th>
                                <th>Клиент</th>
                                <th>Тип мероприятия</th>
                                <th>Количество человек</th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($forms as $order): ?>
                                <tr>
                                    <td><input type="checkbox" name="check[]" id="check-<?= $order->id ?>" value="<?= $order->id ?>"/> <?=$order->id?></td>
                                    <td><a href="{base}cms/forms/edit/<?= $order->id ?>"><?= $order->created ?></a></td>
                                    <td><a href="{base}cms/forms/edit/<?= $order->id ?>"><?= $order->name ?></a></td>
                                    <td><?= $order->field01 ?></td>    
                                    <td><?= $order->field02 ?></td>
    
                                </tr>
                            <? endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </form>
            <?= $paginator ?>

        </div>

        <? require_once 'inc.footer.php'; ?>    

