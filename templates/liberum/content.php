<? require_once 'inc_header.php'; ?>
<? require_once 'inc_menu.php'; ?>
<!-- Content strats -->
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
                                    <div class="posts">
                                        <? foreach ($content as $item): ?>
                                            <div class="entry">
                                                <h2><a href="<?= base_url($uri) ?>/<?= $item->alias ?>"><?= $item->title ?></a></h2>
                                                <div class="meta">
                                                    <i class="icon-calendar"></i> <?= $item->created ?> <!--i class="icon-folder-open"></i> <a href="#">General</a--> 
                                                </div>
                                                
                                                <?=  force_balance_tags(word_limiter($item->text, 100)) ?>

                                                <div class="button"><a href="<?= base_url($uri) ?>/<?= $item->alias ?>">Читать</a></div>
                                            </div>
                                        <? endforeach; ?>
                                        
                                        <?= $paginator ?>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>                        
                                <div class="span4">
                                    <div class="sidebar"><? require_once 'inc_sidebar.php'; ?></div>                                             
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