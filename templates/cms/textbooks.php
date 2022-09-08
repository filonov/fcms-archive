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
                title = $('#title-'+id.toString()).val();
                order = $('#order-'+id.toString()).val();
                link  = $('#link-'+id.toString()).val();
                
                $.post("{base}cms/references/edit_textbook", {id: id, title: title, order: order, link: link},
                function(data){
                    $('#title-'+id.toString()).val(data.title);
                    $('#order-'+id.toString()).val(data.order);
                    $('#link-'+id.toString()).val(data.link);
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
                <h3>Новый элемент</h3>
            </div>
            <div class="modal-body">
                <form id="form_add" class=".form-horizontal" method="post" action="{base}cms/references/add_textbook"> 
                    <label class="control-label" >Порядок</label>
                    <input type="text" class="input-xlarge" name="order" placeholder="14">
                    <label class="control-label" >Название</label>
                    <input type="text" class="input-xlarge" name="title" placeholder="Affresco Italiano A1">   
                    <label class="control-label" >Ссылка на товар в магазине</label>
                    <input type="text" class="input-xlarge" name="link" placeholder="/italiano/textbookma-po-italianskomu-yazuku#a1"> 
                </form>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn" data-dismiss="modal">Отмена</a>
                <a href="#" id="add_link" class="btn btn-primary">Создать</a>
            </div>
        </div>

        <div class="container">
            <div class="row">
                
                <div class="span10 offset1">
                    <h2>Учебные пособия</h2>
                </div>
            </div>

            <? if (!empty($error)): ?>
                <div class="row ">    
                    
                    <div class="span10 offset1">
                        <div class="alert alert-error">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <h4>Ошибка!</h4>
                            {error}
                        </div>
                    </div>
                </div>
            <? endif; ?>

            <div class="row ">  
                
                <div class="span10 offset1">
                    <div class="btn-group">
                        <a href="#modal_add" role="button" class="btn" data-toggle="modal"><i class="icon-plus"></i> Добавить</a>
                        <button class="btn" id="delbtn" type="button"><i class="icon-trash"></i> Удалить отмеченные</button>
                    </div>
                </div>
            </div>

            <div class="row">

                <form id="formdel" method="post" action="{base}cms/references/delete_textbook" class="form-inline">
                    
                    <div class="span10 offset1">

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="20%"><i class="icon-check"></i></th>
                                    <th width="20%">Порядок</th>
                                    <th width="50%">Название</th>  
                                    <th width="50%">Ссылка</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <? foreach ($content as $item): ?>
                                    <tr>                                       
                                        <td><input type="checkbox" name="check[]" id="check-<?= $item->id ?>" value="<?= $item->id ?>"/></td>
                                        <td><input type="text" class="span2" id="order-<?= $item->id ?>" value="<?= $item->order ?>" onchange="savestring(<?= $item->id ?>)"></td>  
                                        <td><input type="text" class="span4" id="title-<?= $item->id ?>" value="<?= $item->title ?>" onchange="savestring(<?= $item->id ?>)"></td>  
                                        <td><input type="text" class="span4" id="link-<?= $item->id ?>" value="<?= $item->link ?>" onchange="savestring(<?= $item->id ?>)"></td>  
                                    </tr>
                                <? endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </form>

            </div>
            <? require_once 'inc.footer.php'; ?>            


