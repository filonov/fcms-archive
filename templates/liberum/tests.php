<? require_once 'inc_header.php'; ?>
<? require_once 'inc_menu.php'; ?>
<div class="content">
    <div class="container">
        <div class="row">
            <div class="span12">
                <div class="blog">
                    <div class="row">
                        <div class="span12">
                            <div class="row">
                                <div class="span8">
                                    <h2>Тесты</h2>
                                    <table class="table table-condensed">
                                        <? foreach ($content as $item): ?>
                                            <tr>
                                                <td>
                                                    <i class="icon-check"></i>&nbsp;<a href="<?=$base?>tests/<?= $item->alias ?>" class="editLink"><?= $item->title ?></a>
                                                </td>
                                            </tr>
                                        <? endforeach; ?>
                                      
                                    </table>
                                    <div class="clearfix"></div>
                                </div>                        
                                <div class="span4">
                                    <div class="sidebar">
                                        <? require_once 'inc_sidebar.php'; ?>
                                    </div>                                             
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>   
<? require_once 'inc_footer.php'; ?>