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
                    <h1>Авторские курсы</h1>
                    <hr />
                    <div class="clearfix"></div>
                    <div class="row-fluid">
                        <div class="span6">
                            <h3>Итальянские</h3>
                            <ul>
                                <? foreach ($specials_i as $i): ?>
                                    <li><a href="{base}specials/italiano/<?=$i->link?>"><?= $i->title ?></a></li>
                                <? endforeach; ?>
                            </ul>
                        </div>
                        <div class="span6">
                            <h3>Испанские</h3>
                            <ul>
                                <? foreach ($specials_e as $e): ?>
                                    <li><a href="{base}specials/espanol/<?=$e->link?>"><?= $e->title ?></a></li>
                                <? endforeach; ?>
                            </ul>
                        </div>
                    </div>
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