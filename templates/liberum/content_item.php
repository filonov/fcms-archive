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
                                        <div class="entry">
                                            <h2><?= $item->title ?></h2>

                                            <!-- Meta details -->
                                            <div class="meta">
                                                <i class="icon-calendar"></i> <?= $item->created ?> <!--i class="icon-user"></i> Admin <i class="icon-folder-open"></i> <a href="#">General</a> <span class="pull-right"><i class="icon-comment"></i> <a href="#">2 Comments</a--></span>
                                            </div>

                                            <?= $item->text ?>
                                        </div>

                                        <div class="well">
                                            <!-- Social media icons -->
                                            <div class="social pull-left">
                                                <h5>Поделитесь в соцсетях: </h5>
                                                <script type="text/javascript" src="http://liberum-center.ru/share42/share42.js"></script>
                                                <script type="text/javascript">share42('liberum-center.ru/share42/', '', '')</script>

                                                <!--a href="#"><i class="icon-facebook facebook"></i></a>
                                                <a href="#"><i class="icon-twitter twitter"></i></a>
                                                <a href="#"><i class="icon-linkedin linkedin"></i></a>
                                                <a href="#"><i class="icon-pinterest pinterest"></i></a>
                                                <a href="#"><i class="icon-google-plus google-plus"></i></a-->
                                            </div>

                                            <div class="clearfix"></div>
                                        </div>
                                        <hr />
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