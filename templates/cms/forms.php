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

                    <ul class="nav nav-tabs">
                        <li <?= ($status == 'new') ? 'class="active"' : ''; ?>>
                            <a href="{base}cms/forms/new">Новые</a>
                        </li>
                        <li <?= ($status == 'processing') ? 'class="active"' : ''; ?>>
                            <a href="{base}cms/forms/processing">В обработке</a></li>
                        
                        <li <?= ($status == 'completed') ? 'class="active"' : ''; ?>>
                            <a href="{base}cms/forms/completed">Выполнены</a></li>
                        
                        <li <?= ($status == 'refused') ? 'class="active"' : ''; ?>>
                            <a href="{base}cms/forms/refused">Отказ</a></li>
                    </ul>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><i class="icon-check"></i> ID</th>
                                <th>Дата</th>
                                <th>Клиент</th>
                                <th>Телефон</th>
                                <th>E-mail</th>
                                <th>Уровень</th>
                                <th>Группа</th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($forms as $order): ?>
                                <tr>
                                    <td><input type="checkbox" name="check[]" id="check-<?= $order->id ?>" value="<?= $order->id ?>"/> <?=$order->id?></td>
                                    <td><?= $order->created ?></td>
                                    <td><a href="{base}cms/forms/edit/<?= $order->id ?>"><?= $order->name ?></a></td>
                                    <td><?= $order->phone ?></td>    
                                    <td><?= $order->email ?></td>
                                    <td><?= $order->level ?></td>
                                    <td><? 
				    if($order->group_id > 0): 
					echo anchor(base_url('cms/groups/edit/'.$order->group_id), $order->group_title); 
				    else: 
					echo 'Пользователь не со страницы группы';
				    endif;
				    ?></td>
                                </tr>
                            <? endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </form>
            <?= $paginator ?>

        </div>

        <? require_once 'inc.footer.php'; ?>    

