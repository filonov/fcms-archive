<?
/**
 * Шаблон админки списка учителей для liberum-center.ru
 * @author Denis Filonov <denis@filonov.biz>
 * @copyright (c) 2013, Denis Filonov
 * @link http://filonov.biz Виртуальная студия Дениса Филонова.
 */
?>
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
                        });
                    }
                });
                $('#dellink').click(function(){
                    $('#formdel').submit();
                });
            });
            
            function saveorder(id)
            {               
                order = $('#order-'+id.toString()).val();  
                $.post("{base}cms/teachers/edit_order", {id: id, order: order},
                function(data){
                    $('#order-'+id.toString()).val(data.order);
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

        <div class="container">
            <div class="row">
                <div class="span12">
                    <h2>Преподаватели</h2>
                    <hr>
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
                        <a href="{base}cms/teachers/add" role="button" class="btn"><i class="icon-plus"></i> Добавить</a>
                        <button class="btn" id="delbtn" type="button"><i class="icon-trash"></i> Удалить отмеченные</button>
                    </div>
                </div>
            </div>

            <div class="row">

                <form id="formdel" method="post" action="{base}cms/teachers/delete" class="form-inline">
                    <div class="span12">

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="10%"><i class="icon-check"></i></th>
                                    <th width="20%">Порядок</th>
                                    <th>Имя</th> 
                                    <th>Имя (краткий вариант)</th> 
                                   
                                </tr>
                            </thead>
                            <tbody>
                                
                                
                                <? foreach ($content as $item): ?>
                               
                                    <tr>                                       
                                        <td><input type="checkbox" name="check[]" id="check-<?= $item->id ?>" value="<?= $item->id ?>"/></td>
                                        <td><input type="text" class="span2" id="order-<?= $item->id ?>" value="<?= $item->order ?>" onchange="saveorder(<?= $item->id ?>);"></td>  
                                        <td><a href="{base}cms/teachers/edit/<?= $item->id ?>"><?= $item->title ?></a></td> 
                                        <td><?= $item->title_short ?></td>  
                                         
                                    </tr>
                                   
                                <? endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <? require_once 'inc.footer.php'; ?>            


