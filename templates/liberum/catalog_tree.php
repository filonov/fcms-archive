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
                                    <h2>Категории</h2>
                                    <table class="table table-condensed">
                                        <? foreach ($child_categoryes as $chk): ?>
                                            <tr>
                                                <td>
                                                    <i class="icon-book"></i>&nbsp;<a href="{base}catalog/<?= $chk->alias ?>" class="editLink"><?= $chk->title ?></a>
                                                </td>
                                            </tr>
                                        <? endforeach; ?>
                                        <? /* foreach ($tree as $item): ?>
                                          <tr>
                                          <td><?= nbs($item['__level'] * 4) ?>
                                          <i class="icon-book"></i>&nbsp;<a href="{base}catalog/<?= $item['alias_path'] ?>" class="editLink"><?= $item['title'] ?></a>
                                          </td>
                                          </tr>
                                          <? endforeach; */ ?>
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