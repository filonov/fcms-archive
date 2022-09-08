<? require_once 'inc_header.php'; ?>
<? require_once 'inc_menu.php'; ?>

<div class="content">
    <div class="container">
        <div class="row">
            <div class="span12">
                <div class="blog">
                    <div class="row">
                        <div class="span12">
                            <!-- Blog Posts -->
                            <div class="row">
                                <div class="span8">
                                    <? // Ближайшие группы ?>
<!--noindex-->
                                    <div class="hero">
                                        <h3><span>Ближайшие группы</span></h3>
                                    </div>
                                    <div class="well">
                                        <ul>
                                            <? foreach ($groups as $group): ?>
                                                <li>
                                                    <a rel="nofollow" href="{base}courses/group/<?=$group->id?>"><?= dateToRus($group->date) ?> &mdash; <?= $group->title ?></a>
                                                </li>
                                            <? endforeach; ?>
                                        </ul>
 <!--/noindex-->                                   </div>

                                    <? /* Конец блока ближайших групп */ ?>

                                    <? // Текст главной ?>
                                    <div class="posts">
                                        <?= block_module('kursi-italyanskogo-i-ispanskogo-yazika-v-moskve', 'block_module_on_index') ?>
                                        <div class="clearfix"></div>
                                    </div>


                                </div>                        
                                <div class="span4">
                                    <div class="sidebar">
                                        <?= block_content(133, 5, 'block_content_sidebar') ?>
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

<!-- Content ends --> 

<? require 'inc_footer.php'; ?>