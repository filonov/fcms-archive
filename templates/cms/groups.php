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
            $.post("{base}cms/groups/edit_order", {id: id, order: order},
            function(data) {
                $('#order-' + id.toString()).val(data.order);
            }, "json");
        }


        function clearInputs()
        {
            $(':input', '#filter_cources')
                    .not(':button, :submit, :reset, :hidden')
                    .removeAttr('checked');
        }

        function setInputs()
        {
            $(':input', '#filter_cources')
                    .not(':button, :submit, :reset, :hidden')
                    .attr('checked', 'checked');
            ;
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
                <h2>Группы</h2>
                <hr/>
                <div class="btn-toolbar">
                    <div class="btn-group">
                        <a href="{base}cms/groups/add" role="button" class="btn"><i class="icon-plus"></i> Новая группа</a>
                        <button class="btn" id="delbtn" type="button"><i class="icon-trash"></i> Удалить</button>
                        <button class="btn dropdown-toggle" id="catbtn" type="button" data-toggle="dropdown" onclick="$('#dd').toggle('slow');"><i class="icon-tag"></i> Фильтр</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="span12 well dd hide dropdown" id="dd">
                <form id="filter_cources" method="post" action="<?= current_url() ?>">
                    <fieldset>
                        <h5>Уровень:</h5>
                        <? foreach ($levels as $level): ?>
                            <label class="checkbox inline">
                                <input type="checkbox" id="level[<?= $level->id ?>]" name="level[<?= $level->id ?>]" value="<?= $level->id ?>" 
                                       <?= ((is_array($chk_levels) && isset($chk_levels[$level->id]))) ? 'checked' : '' ?>> <?= $level->title ?>
                            </label>
                        <? endforeach; ?>
                    </fieldset>
                    <fieldset>
                        <h5>Формат:</h5>
                        <? foreach ($formats as $format): ?>
                            <label class="checkbox inline">
                                <input type="checkbox" name="format[<?= $format->id ?>]" value="<?= $format->id ?>"
                                       <?= ((is_array($chk_formats) && isset($chk_formats[$format->id]))) ? 'checked' : '' ?>> <?= $format->title ?>
                            </label>
                        <? endforeach; ?>
                    </fieldset>
                    <hr>
                    <div class="btn-group">
                        <button type="submit" class="btn">Применить</button>
                        <button type="button" class="btn" onclick="clearInputs();">Сбросить всё</button>
                        <button type="button" class="btn" onclick="setInputs();">Выделить всё</button>
                    </div>
                </form>
                <div class="clearfix"></div>                                    
            </div>
        </div>


        <div class="row">
            <form id="formdel" method="post" action="{base}cms/groups/delete">
                <div class="span12">


                    <table class="table table-hover table-condensed">
                        <thead>
                            <tr>
                                <th><i class="icon-check"></i></th>
                                <th class="span2">Дата начала</th>
                                <th>Название группы</th>
                                <th class="span2">Опубликовано<br/>
                                    Изменено</th>      
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($groups as $group): ?>                              
                                <tr>
                                    <td><input type="checkbox" name="check[]" id="check-<?= $group->gid ?>" value="<?= $group->gid ?>"/></td>
                                    <td><?= dateToRus($group->date) ?></td>
                                    <!--td><input type="text" class="span1" id="order-<?= $group->gid ?>" value="<? // $group->order     ?>" onchange="saveorder(<?= $group->gid ?>)"></td-->
                                    <td><a href="{base}cms/groups/edit/<?= $group->gid ?>"><?= $group->gtitle ?></a></td>    
                                    <td><small><?= $group->created ?><br/>
                                            <?= $group->updated ?></small></td>
                                </tr>
                            <? endforeach; ?>
                            <? $old_gr_id = -1; ?>
                            <? foreach ($groups_s as $group): ?>   
                                <? if ($group->gid != $old_gr_id): ?>                           
                                    <tr>
                                        <td><input type="checkbox" name="check[]" id="check-<?= $group->gid ?>" value="<?= $group->gid ?>"/></td>
                                        <td><?= dateToRus($group->date) ?></td>
                                        <!--td><input type="text" class="span1" id="order-<?= $group->gid ?>" value="<? // $group->order     ?>" onchange="saveorder(<?= $group->gid ?>)"></td-->
                                        <td><a href="{base}cms/groups/edit/<?= $group->gid ?>"><?= $group->gtitle ?></a></td>    
                                        <td><small><?= $group->created ?><br/>
                                                <?= $group->updated ?></small></td>
                                    </tr>
                                    <? $old_gr_id = $group->gid; ?>
                                <? endif; ?>
                            <? endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
        <? require_once 'inc.footer.php'; ?>    

