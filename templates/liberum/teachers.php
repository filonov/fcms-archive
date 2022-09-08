<?
require_once 'inc_header.php';
require_once 'inc_menu.php';
?>

<div class="content">
    <div class="container">
        <div class="row">
            <div class="span12">
                <div class="about">
                    <div class="row">
                        <div class="span12">

                            <div class="hero">
                      
                                <h3><span>Наши преподаватели</span></h3>
                      
                                <p>Преподаватели Итальяно-испанского учебного центра «Liberum». На странице каждого преподавателя можно получить дополнительные сведения о нём и информацию о его группах.</p>
                            </div>
              

                            <div class="teams">
                                <div class="row">
                                    <h4 align="center">Итальянский язык</h4><br/>

                                    <? foreach ($items_i as $ii): ?>
                                        <div class="span4">
                                            <div class="staff">                   
                                                <? if (isset($ii->photo) && !empty($ii->photo)): ?>
                                                    <div class="pic">
                                                        <a href="{base}teachers/<?= $ii->id ?>" style="display: block; width: 300px; height: 300px;">
                                                            <img src="{url_for_uploads}teachers/<?= $ii->photo ?>" style="max-height: 300px; max-width: 300px;" alt="<?= $ii->title ?>"/>
                                                        </a>
                                                    </div>
                                                <? endif; ?>               
                                                <div class="details">
                                                    <div class="desig">
                                                        <p class="name"><a href="{base}teachers/<?= $ii->id ?>"><?= $ii->title ?></a></p>  
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <hr />
                                            </div>
                                        </div>
                                    <? endforeach; ?>

                                </div>
                                <div class="row">
                                    <h4 align="center">Испанский язык</h4><br/>
                                    <? foreach ($items_s as $i): ?>

                                        <div class="span4">
                                            <!-- Staff #1 -->

                                            <div class="staff">
                                                <!-- Picture -->
                                                <? if (isset($i->photo) && !empty($i->photo)): ?>
                                                    <div class="pic">
                                                        <a href="{base}teachers/<?= $i->id ?>">
                                                            <img src="{url_for_uploads}teachers/<?= $i->photo ?>" style="max-height: 300px; max-width: 300px;" alt="<?= $i->title ?>"/>
                                                        </a>
                                                    </div>
                                                <? endif; ?>
                                                <!-- Details -->
                                                <div class="details">
                                                    <!-- Name and designation -->
                                                    <div class="desig pull-left">
                                                        <p class="name"><a href="{base}teachers/<?= $i->id ?>"><?= $i->title ?></a></p>
                                                        <!--em>преподаватель</em-->
                                                    </div>
                                                    <!-- Social media details. Replace # with profile links 
                                                    <div class="asocial pull-right">
                                                        <a href="#"><i class="icon-facebook"></i></a>
                                                        <a href="#"><i class="icon-twitter"></i></a>
                                                        <a href="#"><i class="icon-linkedin"></i></a>
                                                    </div-->
                                                    <div class="clearfix"></div>
                                                </div>
                                                <hr />
                                            </div>
                                        </div>
                                    <? endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- About ends -->


</div>  

<? require_once 'inc_footer.php'; ?>
