<? require_once 'inc_header.php'; ?>
<? require_once 'inc_menu.php'; ?> 

<!-- Content strats -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id))
	    return;
	js = d.createElement(s);
	js.id = id;
	js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1";
	fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
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
					    <div class="fb-comments" data-href="http://liberum-center.ru" data-width="620"></div>
					    <!-- Put this div tag to the place, where the Comments block will be -->
					    <div id="vk_comments"></div>
					    <script type="text/javascript">
						VK.Widgets.Comments("vk_comments", {limit: 10, width: "620", attach: "*"});
					    </script>
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