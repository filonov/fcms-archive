<? require_once 'inc.header.php'; ?>

    <body>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#delbtn').click(function(){
                    var checked = $('#formdel input:checkbox:checked').val();
                    if (checked)
                    {          
                        $('#myModal').modal({
                            keyboard: false
                        });
                    }
                });
                $('#dellink').click(function(){
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
                        <p>Вы действительно хотите удалить шаблоны?</p>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn" data-dismiss="modal">Отмена</a>
                        <a href="#" id="dellink" class="btn btn-primary">Удалить</a>
                    </div>
                </div>
                <form id="formdel" method="post" action="{base}cms/emails/delete">
                    <div class="span12">
                        <h2>Шаблоны почтовых сообщений</h2>
                        
                        <hr/>

                        <div class="btn-toolbar">
                            <div class="btn-group">
                                <a class="btn" href="{base}cms/emails/add"><i class="icon-file"></i> Новый шаблон</a>
                                <button class="btn" id="delbtn" type="button"><i class="icon-trash"></i> Удалить</button>
                            </div>
                        </div>

                        <table class="table table-condensed table-hover">
                            <thead>
                                <tr>
                                    <th><i class="icon-check"></i></th>
                                    <th>Название</th>
                                    <th>Алиас</th>
                                </tr>
                            </thead>
                            <tbody>
                                <? foreach ($emails as $module): ?>
                                <tr>
                                    <td><input type="checkbox" name="check[]" id="check-<?= $module->id ?>" value="<?= $module->id ?>"/></td>
                                    <td><a href="{base}cms/emails/edit/<?= $module->id ?>"><?= $module->title ?></a></td>
                                    <td><?= $module->alias ?></td>    
                                </tr>
                                <? endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
           <? require_once 'inc.footer.php'; ?>    

