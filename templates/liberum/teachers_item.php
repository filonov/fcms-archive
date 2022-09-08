<?
require_once 'inc_header.php';
require_once 'inc_menu.php';
?>

<div class="content">
    <div class="container">
        <div class="row">
            <div class="span12">

                <div class="resume">
                    <div class="row">
                        <div class="span12">
                            <h2><?= $item->title ?> <span class="rsmall"><span class="color">@</span> Преподаватель</span></h2>
                            <hr />

                            <div class="row">
                                <div class="span12">

                                    <!-- About -->
                                    <div class="rblock">
                                        <div class="row">
                                            <div class="span3">
                                                <h4>Информация</h4>
                                                <img src="{url_for_uploads}teachers/<?= $item->photo ?>" style="max-height: 300px; max-width: 220px; margin-top: 10px" alt="<?= $item->title ?>"/>
                                            </div>
                                            <div class="span9">
                                                <div class="rinfo">
                                                    <h5><?= $item->title ?></h5>
                                                    <div class="rmeta">Преподаватель</div>
                                                    <?= $item->description ?>
                                                    <? /*
                                                      <div class="social">
                                                      <a href="#"><i class="icon-facebook"></i></a>
                                                      <a href="#"><i class="icon-twitter"></i></a>
                                                      <a href="#"><i class="icon-linkedin"></i></a>
                                                      <a href="#"><i class="icon-google-plus"></i></a>
                                                      <a href="#"><i class="icon-pinterest"></i></a>
                                                      </div>

                                                     */ ?>

                                                    <? foreach ($gallery as $pic): ?>
                                                        <a data-toggle="lightbox" href="#demoLightbox-<?= $pic->id ?>"> 
                                                            <img class="img-rounded" style="max-height: 110px; margin-bottom: 2px" src="{url_for_uploads}gallery/<?= $pic->category_id ?>/s/<?= $pic->filename ?>"/>
                                                        </a>
                                                        <div id="demoLightbox-<?= $pic->id ?>" class="lightbox hide fade"  tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class='lightbox-header'>
                                                                <button type="button" class="close" data-dismiss="lightbox" aria-hidden="true">&times;</button>
                                                            </div>
                                                            <div class='lightbox-content'>
                                                                <img src="{url_for_uploads}gallery/<?= $pic->category_id ?>/b/<?= $pic->filename ?>">

                                                            </div>
                                                        </div>
                                                    <? endforeach; ?>


                                                </div>
                                            </div>
                                        </div>

                                        <!-- Education -->
                                        <div class="rblock">
                                            <div class="row">
                                                <div class="span3">
                                                    <h4>Группы</h4>                            
                                                </div>
                                                <div class="span9">
                                                    <div class="rinfo">
                                                        
                                                        <ul>
                                                            <?
                                                            foreach ($groups as $group)
                                                            {
                                                                $outstr = '<li>'
                                                                        . anchor(base_url('courses/group/' . $group->id), $group->level . nbs() .
                                                                                $group->days . nbs() . $group->time . '&#8211;' 
                                                                                . $group->status_text . nbs() . dateToRus($group->date))
                                                                        . '</li>';
                                                                echo $outstr;
                                                            }
                                                            ?>
                                                            <hr>
                                                            <h6>Авторские курсы</h6>
                                                            <ul>
                                                                <?
                                                                foreach ($groups_s as $gr)
                                                                {
                                                                    echo '<li>' . anchor(base_url('courses/group/' . $gr->id), $gr->title.  br().  $gr->days . nbs() . $gr->time .nbs().  $gr->status_text . nbs() . dateToRus($gr->date)) . '</li>';
                                                                };
                                                                ?>
                                                            </ul>
                                                        </ul>
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
            </div>
        </div>
    </div>   


    <? require_once 'inc_footer.php'; ?>
