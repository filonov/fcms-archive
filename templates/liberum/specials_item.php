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
                                            <?= $item->text ?>
                                            <h3>Группы</h3>
                                            <ul>
                                                <?
                                                foreach ($groups as $gr)
                                                {
                                                     echo '<li>'.anchor(base_url('courses/group/' . $gr->gid), $gr->days . nbs() . $gr->time . ' – Преподаватель: ' . $gr->title_short . '; ' . $gr->status_text . nbs() . dateToRus($gr->date)).'</li>';
                                                };
                                                ?>
                                            </ul>
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