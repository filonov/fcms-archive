<? require_once 'inc.header.php'; ?>

<body>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#delbtn').click(function() {
                var checked = $('#formdel input:checkbox:checked').val();
                if (checked)
                {
                    $('#modal_delete').modal({
                        keyboard: false
                    });
                }
            });

            $('#dellink').click(function() {
                $('#formdel').submit();
            });

            $('#add_link').click(function() {
                $('#form_add').submit();
            });

        });

        function saveorder(id)
        {
            order = $('#order-' + id.toString()).val();
            $.post("{base}cms/specials/edit_order", {id: id, order: order},
            function(data) {
                $('#order-' + id.toString()).val(data.order);
            }, "json");
        }



    </script>

    <? require_once 'inc.menu.php'; ?>
    <? // Диалог удаления ?>
    <div class="modal hide" id="modal_delete">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h3>Подтвердите удаление</h3>
        </div>
        <div class="modal-body">
            <p>Вы действительно хотите удалить элементы?</p>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">Отмена</a>
            <a href="#" id="dellink" class="btn btn-primary">Удалить</a>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="span12">
                <h2>Спецкурсы</h2>
                <hr/>
                <div class="btn-toolbar">
                   <div class="btn-group">
                        <a href="{base}cms/specials/add" role="button" class="btn"><i class="icon-plus"></i> Новая группа</a>
                        <button class="btn" id="delbtn" type="button"><i class="icon-trash"></i> Удалить</button>
                   </div>
                </div>
            </div>
        </div>

        <div class="row">
            <form id="formdel" method="post" action="{base}cms/specials/delete">
                <div class="span12">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="10%"><i class="icon-check"></i></th>
                                <th width="20%">Порядок</th>
                                <th>Название</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($specials as $special): ?>                              
                                <tr>
                                    <td><input type="checkbox" name="check[]" id="check-<?= $special->id ?>" value="<?= $special->id ?>"/></td>
                                    <td><?= $special->order ?></td>
                                    <!--td><input type="text" class="span1" id="order-<?= $special->id ?>" value="<? // $special->order    ?>" onchange="saveorder(<?= $special->gid ?>)"></td-->
                                    <td><a href="{base}cms/specials/edit/<?= $special->id ?>"><?= $special->title ?></a></td>    
                                    
                                </tr>
                            <? endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
        <? require_once 'inc.footer.php'; ?>    

