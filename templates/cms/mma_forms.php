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
                    <h2>Анкеты</h2>
                    <hr/>
                    <!--div class="btn-toolbar">
                        <div class="btn-group">
                            <button class="btn" id="delbtn" type="button"><i class="icon-trash"></i> Удалить</button>
                        </div>
                    </div-->

                    <ul class="nav nav-tabs">
                        <li <?= ($type == MMA_KASKO) ? 'class="active"' : ''; ?>>
                            <a href="<?=  base_url('cms/mma/forms/10') ?>">КАСКО</a>
                        </li>
                        <li <?= ($type == MMA_OSAGO) ? 'class="active"' : ''; ?>>
                            <a href="<?=  base_url('cms/mma/forms/20') ?>">ОСАГО</a></li>
                        
                        <li <?= ($type == MMA_DMS) ? 'class="active"' : ''; ?>>
                            <a href="<?=  base_url('cms/mma/forms/30') ?>">ДМС</a></li>
                        
                        <li <?= ($type == MMA_OTHER) ? 'class="active"' : ''; ?>>
                            <a href="<?=  base_url('cms/mma/forms/40') ?>">Прочие</a></li>
                    </ul>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Дата заполнения</th>
				<th>Имя</th>
				<th>E-mail</th>
				<th>Телефон</th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($content as $item): ?>
                                <tr>
                                    <td><a href="<?= base_url('cms/mma/viewform/'.$item->id)?>"><?=$item->id?></a></td>
                                    <td><a href="<?= base_url('cms/mma/viewform/'.$item->id)?>"><?= $item->created ?></a></td>
                                    <td><?= $item->name ?></td>
                                    <td><?= $item->phone ?></td>    
                                    <td><?= $item->email ?></td>
                                </tr>
                            <? endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </form>
            <?= $paginator ?>

        </div>

        <? require_once 'inc.footer.php'; ?>    

