<? require_once 'inc.header.php'; ?>
<body>
    <script type="text/javascript">

        function savecheck(s, l)
        {
            $.post('{base}cms/references/edit_specials_levels', {
                s: s,
                l: l
            },
            function(data) {
            }, 'json');
        }

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
            
<?/*
            $('.link_popover').click(function(event) {
                event.preventDefault();
                id = $(this).attr('id');
                $('#' + id.toString()).popover({
                    html: true,
                    title: "Уровни",
                    content: $('#div_levels-' + id.replace('for_lev-', '').toString()).html()
                });
            });
 * 
 */?>
        });

        function savestring(id)
        {
            title = $('#title-' + id.toString()).val();
            description = $('#description-' + id.toString()).val();
            order = $('#order-' + id.toString()).val();
            link = $('#link-' + id.toString()).val();

            $.post("{base}cms/references/edit_special", {
                id: id,
                title: title,
                description: description,
                order: order,
                link: link},
            function(data) {
                $('#title-' + id.toString()).val(data.title);
                $('#description-' + id.toString()).val(data.description);
                $('#order-' + id.toString()).val(data.order);
                $('#link-' + id.toString()).val(data.link);
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

    <? // Диалог добавления ?>
    <div class="modal hide" id="modal_add">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h3>Спецкурсы</h3>
        </div>
        <div class="modal-body">
            <form id="form_add" class=".form-horizontal" method="post" action="{base}cms/references/add_special"> 
                <label class="control-label" >Порядок</label>
                <input type="text" class="input-xlage" name="order" placeholder="1">
                <label class="control-label" >Название</label>
                <input type="text" class="input-xlarge" name="title" placeholder="Краткий курс для ложных начинающих">
                <label class="control-label" >Подходит для уровня</label>
                <? foreach ($levels as $level): ?>
                    <label class="checkbox inline">
                        <input type="checkbox" name="specials-levels[]" value="<?= $level->id ?>"> <?= $level->title ?>
                    </label>
                <? endforeach; ?>
                <br />
                <label class="control-label" >Ссылка</label>
                <input type="text" class="input-xlarge" name="link" placeholder="courcses/shortfofalsebeginners">   
                <label class="control-label" >Краткое описание</label>
                <input type="text" class="input-xlarge" name="description" placeholder="Група для так называемых ложных начинающих...">
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
                <h2>Спецкурсы</h2>
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

        <div class="row affix">  
            <div class="span12">
                <div class="btn-group">
                    <a href="#modal_add" role="button" class="btn" data-toggle="modal"><i class="icon-plus"></i> Добавить</a>
                    <button class="btn" id="delbtn" type="button"><i class="icon-trash"></i> Удалить отмеченные</button>
                </div>
            </div>
        </div>

        <div class="row">

            <form id="formdel" method="post" action="{base}cms/references/delete_special" class="form-inline">
                <div class="span12">

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="10%"><i class="icon-check"></i></th>
                                <th width="20%">Порядок</th>
                                <th>Название</th> 
                                <th>Подходит для уровня</th>                         
                                <th>Краткое описание</th>
                                <th>Ссылка</th>  
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($content as $item): ?>
                                <tr>                                       
                                    <td><input type="checkbox" name="check[]" id="check-<?= $item->id ?>" value="<?= $item->id ?>"/></td>
                                    <td><input type="text" class="span2" id="order-<?= $item->id ?>" value="<?= $item->order ?>" onchange="savestring(<?= $item->id ?>)"></td>  
                                    <td><input type="text" class="span3" id="title-<?= $item->id ?>" value="<?= $item->title ?>" onchange="savestring(<?= $item->id ?>)"></td> 
                                    <td>

                                        
                                        
                                        <? // Диалог  ?>
                                        <div class="modal hide" id="modal_levels-<?= $item->id ?>">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">×</button>
                                                <h3>Уровни</h3>
                                            </div>
                                            <div class="modal-body">
                                                <? foreach ($levels as $level): ?>
                                                    <label class="checkbox inline">
                                                        <input onchange="savecheck(<?= $item->id ?>,<?= $level->id ?>);" type="checkbox" <?= $specials_levels[$item->id][$level->id] ?> id="levels-<?= $item->id ?>" value="<?= $level->id ?>"> <?= $level->title ?>
                                                    </label>
                                                <? endforeach; ?>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="#" class="btn" data-dismiss="modal">OK</a>
                                            </div>
                                        </div>
                                        
                                        <button class="btn" type="button" data-toggle="modal" data-target="#modal_levels-<?= $item->id ?>">Уровни</button>
                                        




                                        <!--a class="link_popover" id="for_lev-<?= $item->id ?>" href="#">Уровни</a-->
                                    </td>
                                    <td><input type="text" class="span3" id="description-<?= $item->id ?>" value="<?= $item->description ?>" onchange="savestring(<?= $item->id ?>)"></td>  
                                    <td><input type="text" class="span3" id="link-<?= $item->id ?>" value="<?= $item->link ?>" onchange="savestring(<?= $item->id ?>)"></td>                                
                                </tr>
                            <? endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
        <? require_once 'inc.footer.php'; ?>            


