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

                                        <!-- Each posts should be enclosed inside "entry" class" -->
                                        <!-- Post one -->

                                        <h2><?= $searchstr ?></h2> <hr />
                                        <ul>
                                            <? foreach ($items as $item): ?>
                                          
                                            <li><span class="label label-info"><i class="icon-book"></i>&nbsp;<? $cat->get_by_id($item->cat_id); echo $cat->title;  ?></span>
                                            <a href="{base}catalog/<?=$cat->get_tree_full_path($item->cat_id, CATEGORYES_CATALOG)?>/<?=$item->alias?>"><?= $item->title ?></a>
                                                
                                                
                                                
                                              </li>

                                            <? endforeach; ?>
                                        </ul>



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

<!-- Content ends --> 
<? require_once 'inc_footer.php'; ?>