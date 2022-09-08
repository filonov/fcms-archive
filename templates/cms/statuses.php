<? require_once 'inc.header.php';?>
    <body>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#delbtn').click(function(){
                    var checked = $('#formdel input:checkbox:checked').val();
                    if (checked)
                    {          
                        $('#modal_delete').modal({
                            keyboard: false
                        })
                    }
                });
                $('#dellink').click(function(){
                    $('#formdel').submit();
                });
                $('#add_link').click(function(){
                    $('#form_add').submit();
                });
            });
            
            function savestring(id)
            {
                status_text = $('#status_text-'+id.toString()).val();
                if_late = $('#if_late-'+id.toString()).val();
                order = $('#order-'+id.toString()).val();
                critery  = $('#critery-'+id.toString()).val();
                
                $.post("{base}cms/references/edit_status", {
                    id: id, 
                    status_text: status_text, 
                    if_late: if_late,
                    order: order, 
                    critery: critery},
                function(data){
                    $('#status_text-'+id.toString()).val(data.status_text);
                    $('#if_late-'+id.toString()).val(data.if_late);
                    $('#order-'+id.toString()).val(data.order);
                    $('#critery-'+id.toString()).val(data.critery);
                }, "json");
            }
        </script>
        
        <? require_once 'inc.menu.php';?>

       
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

        <? // Диалог добавления ?>
        <div class="modal hide" id="modal_add">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>Статусы группы</h3>
            </div>
            <div class="modal-body">
                <form id="form_add" class=".form-horizontal" method="post" action="{base}cms/references/add_status"> 
                    <label class="control-label" >Порядок</label>
                    <input type="text" class="input-xlarge" name="order" placeholder="1">
                    <label class="control-label" >Статус</label>
                    <input type="text" class="input-xlarge" name="status_text" placeholder="идёт набор, старт">   
                    <label class="control-label" >Статус после начала занятий</label>
                    <input type="text" class="input-xlarge" name="if_late" placeholder="можно присоединиться, идут занятия">   
                    <label class="control-label" >Условия выбора</label> 
                    <label class="radio">
                    <input type="radio" name="critery" id="optionsRadios1" value="<?=BIGGER_OR_EQUAL_CURRENT_DAY?>" checked>
                    Дата начала занятий больше или равна сегодняшней дате
                    </label>
                    <label class="radio">
                    <input type="radio" name="critery" id="optionsRadios2" value="<?=SMALLER_CURRENT_DAY?>">
                    Дата начала занятий меньше сегодняшней даты
                    </label>
                </form>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn" data-dismiss="modal">Отмена</a>
                <a href="#" id="add_link" class="btn btn-primary">Создать</a>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="span12">
                    <h2>Статусы групп</h2>
                </div>
            </div>

            <? if (!empty($error)): ?>
                <div class="row ">    
                    <div class="span12">
                        <div class="alert alert-error">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <h4>Ошибка!</h4>
                            {error}
                        </div>
                    </div>
                </div>
            <? endif; ?>

            <div class="row">  
                <div class="span12">
                    <div class="btn-group">
                        <a href="#modal_add" role="button" class="btn" data-toggle="modal"><i class="icon-plus"></i> Добавить</a>
                        <button class="btn" id="delbtn" type="button"><i class="icon-trash"></i> Удалить отмеченные</button>
                    </div>
                </div>
            </div>

            <div class="row">

                <form id="formdel" method="post" action="{base}cms/references/delete_status" class="form-inline">
                    <div class="span12">

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="10%"><i class="icon-check"></i>ID</th>
                                    <th width="20%">Порядок</th>
                                    <th>Статус</th> 
                                    <th>Статус после начала занятий</th> 
                                    <th>Условия выбора</th>                  
                                </tr>
                            </thead>
                            <tbody>
                                <? foreach ($content as $item): ?>
                                    <tr>                                       
                                        <td><label class="checkbox"><input type="checkbox" name="check[]" id="check-<?= $item->id ?>" value="<?= $item->id ?>"/> <?= $item->id ?></label></td>
                                        <td><input type="text" class="span2" id="order-<?= $item->id ?>" value="<?= $item->order ?>" onchange="savestring(<?= $item->id ?>)"></td>  
                                        <td><input type="text" class="span3" id="status_text-<?= $item->id ?>" value="<?= $item->status_text ?>" onchange="savestring(<?= $item->id ?>)"></td> 
                                        <td><input type="text" class="span3" id="if_late-<?= $item->id ?>" value="<?= $item->if_late ?>" onchange="savestring(<?= $item->id ?>)"></td>  
                                        <td>
                                            <select id="critery-<?= $item->id ?>" onchange="savestring(<?= $item->id ?>)">
                                                <option <? if($item->critery == BIGGER_OR_EQUAL_CURRENT_DAY): ?> selected <? endif; ?> value="<?=BIGGER_OR_EQUAL_CURRENT_DAY?>">Дата начала занятий больше или равна сегодняшней дате</option>
                                                <option <? if($item->critery == SMALLER_CURRENT_DAY): ?> selected <? endif; ?> value="<?=SMALLER_CURRENT_DAY?>">Дата начала занятий меньше сегодняшней даты</option>
                                            <select>
                                        </td>  
                                    </tr>
                                <? endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <? require_once 'inc.footer.php'; ?>            


