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
                $('#add_link').click(function(){
                    $('#form_add').submit();
                });
            });
            
            function savestring(id)
            {
                number = $('#number-'+id.toString()).val();    
		name = $('#name-'+id.toString()).val();  
                $.post("{base}cms/mma/edit_region", {
                    id: id, 
                    number: number,
		    name: name
		},
                function(data){
		    $('#number-'+id.toString()).val(data.number);
                    $('#name-'+id.toString()).val(data.name);
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
                <h3>Добавить регион</h3>
            </div>
            <div class="modal-body">
                <form id="form_add" class=".form-horizontal" method="post" action="<?=$base?>cms/mma/add_region"> 
                    <label class="control-label" >Номер</label>
                    <input type="text" class="input-small" name="number" placeholder="177">   
		    <label class="control-label" >Название</label>
                    <input type="text" class="input-xxlarge" name="name" placeholder="Днепроджержинск-на-Амуре">
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
                    <h2>Регионы</h2>
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

                <form id="formdel" method="post" action="{base}cms/mma/delete_region" class="form-inline">
                    <div class="span12">

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="span1"><i class="icon-check"></i>ID</th>
                                    <th class="span3">Номер</th>       
				    <th class="span8">Название</th>  
                                </tr>
                            </thead>
                            <tbody>
                                <? foreach ($content as $item): ?>
                                    <tr>                                       
                                        <td><label class="checkbox"><input type="checkbox" name="check[]" id="check-<?= $item->id ?>" value="<?= $item->id ?>"/> <?= $item->id ?></label></td>
                                        <td><input type="text" class="span3" id="number-<?= $item->id ?>" value="<?= $item->number ?>" onchange="savestring(<?= $item->id ?>);"></td> 
                                        <td><input type="text" class="span8" id="name-<?= $item->id ?>" value="<?= $item->name ?>" onchange="savestring(<?= $item->id ?>);"></td>   
                                    </tr>
                                <? endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <? require_once 'inc.footer.php'; ?>            


