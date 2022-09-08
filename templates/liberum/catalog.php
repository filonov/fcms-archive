<? require_once 'inc_header.php'; ?>
<? require_once 'inc_menu.php'; ?>
<div class="content">
    <div class="container">
        <div class="row">
            <div class="span12">
                <!-- Blog starts -->
                <div class="blog">
                    <div class="row">
                        <div class="span12">
                            <!-- Blog Posts -->
                            <div class="row">
                                <div class="span8">
                                    <h1>{category}</h1>
                                    <div class="row-fluid">
                                        <div class="span12 well">
                                            <strong>Подразделы: </strong>
      
                                            <? foreach ($child_categoryes as $chk): ?>

                                                <span class="label label-info"><a href="{base}catalog/<?= $chk->get_alias_path(CATEGORYES_CATALOG) ?>" style="color: white"><i class="icon-book"></i>&nbsp;<?= $chk->title ?></a></span>

                                            <? endforeach; ?>
                                        </div>

                                    </div>
                                    <div class="posts">
                                        <? foreach ($content as $item): ?>
                                            <div class="entry">
                                                <h2><a href="<?= base_url($uri) ?>/<?= $item->alias ?>"><?= $item->title ?></a></h2>
                                                <div class="meta">
                                                    <i class="icon-calendar"></i> <?= $item->created ?> <i class="icon-folder-open"></i> {category}
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="span4">
                                                        <a href="<?= base_url($uri) ?>/<?= $item->alias ?>"><img class="thumbnail" src="{url_for_uploads}catalog/items/<?= $item->id ?>/s/<?= $item->picture ?>" alt="<?= $item->title ?>"/></a>
                                                    </div>
                                                    <div class="span6">
                                                        <? if (!empty($item->descriptionv)): ?>
                                                            <?= $item->descriptionv ?>
                                                        <? else: ?>
                                                            <?= force_balance_tags(word_limiter($item->desctiption, 1000)) ?>
                                                        <? endif; ?>
                                                    </div>

                                                </div>


                                                <div class="button"><a href="<?= base_url($uri) ?>/<?= $item->alias ?>"><i class="icon-shopping-cart"></i> Подробнее</a></div>
                                            </div>
                                        <? endforeach; ?>

                                        <?= $paginator ?> 
                                        <div class="clearfix"></div>
                                    </div>
                                </div>                        
                                <div class="span4">
                                    <div class="sidebar">
                                        <? require_once 'block_cart_sidebar.php'; ?>
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