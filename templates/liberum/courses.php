<? require_once 'inc_header.php'; ?>
<? require_once 'inc_menu.php'; ?>
<script>
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
<div class="content">
    <div class="container">
        <div class="row">
            <div class="span8">
                <div class="support-page">
                    <h4><?= $language ?></h4>
                    <? if ($lng_id == ITALIAN):?>
                    <?=  block_module('teskt-stranitsi-poiska-grupp-italyanskiy')?>
                    <? else: ?>
                    <?=  block_module('teskt-stranitsi-poiska-grupp-ispanskiy')?>
                    <? endif; ?>
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
			<br/>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-mini">Применить</button>
                            <button type="button" class="btn btn-mini" onclick="clearInputs();">Сбросить всё</button>
                            <button type="button" class="btn btn-mini" onclick="setInputs();">Выделить всё</button>
                        </div>
                    </form>
                    <hr />
                    <div class="clearfix"></div>

                    <?
                    foreach ($levels as $level)
                    {
                        $have_groups = FALSE;
                        $hdr = '<h5 align="center">' . $level->title . '</h5>' . '<ul>';
                        $outstr = '';
                        
                        // Группы

                        foreach ($groups as $group)
                        {
                            if ($group->level == $level->id)
                            {
                                $outstr .= '<li>'. anchor(base_url('courses/group/' . $group->gid), $group->title_for_cources). '</li>';
                                $have_groups = TRUE;
                            }
                        }
                        $outstr .= '</ul><hr>';
                        
                        // Спецкурсы 
                        
                        $old_stitle = '';
                        $old_gr_id = -1;
                        foreach ($groups_s as $gr)
                        {
                            if ($gr->glevel == $level->id)
                            {
                                if ($gr->stitle != $old_stitle)
                                    $outstr .='<p><strong>' . $gr->stitle . '</strong> ' .  $gr->sdescription.'<br/>' ;
                                if ($gr->gid != $old_gr_id)
                                    $outstr .=anchor(base_url('courses/group/' . $gr->gid), $gr->title_for_cources);
				
                                $have_groups = TRUE;
                                $old_stitle = $gr->stitle;
                                $old_gr_id = $gr->gid;
                            }
                        }


                        if ($have_groups == TRUE)
                        {

                            echo $hdr . $outstr .'<hr>';
                        }
                    }
                    ?>

                </div>
            </div>
            <div class="span4">
                <div class="sidebar">
                    <? require_once 'inc_sidebar.php'; ?>
                    <?= block_module('dopolnitelno', 'block_module_sidebar') ?>
                </div>                                             
            </div>
        </div>
    </div>
</div> 
<? require_once 'inc_footer.php'; ?>