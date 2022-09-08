<? require_once 'inc_header.php'; ?>
<? require_once 'inc_menu.php'; ?> 
<script type="text/javascript">
    $(document).ready(function() {
        $('#plusone').click(function() {
            value = parseInt($('#q').val());
            $('#q').val((value + 1).toString());
        });

        $('#minusone').click(function() {
            value = parseInt($('#q').val());
            if (value > 1)
                $('#q').val((value - 1).toString());
        });
    });
</script>


<div class="content">
    <div class="container">
        <div class="row">
            <div class="span12">
                <div class="blog">
                    <div class="row">
                        <div class="span12">
                            <div class="row">
                                <div class="span8">
                                    <div class="posts">

                                        <div class="entry">
                                            <h2><?= $item->title ?></h2>

                                            <div class="meta">
                                                <i class="icon-calendar"></i> <?= dateToRus($item->created) ?> 
                                                <span class="pull-right">
                                                    <i class="icon-folder-open"></i> <a href="{base}catalog/<?=$category->get_alias_path(CATEGORYES_CATALOG)?>"><?= $category->title ?></a> 
                                                </span>
                                            </div>
                                            <div class="row-fluid">
                                                <div class="span6">

                                                    <div class="pic thumbnail">
                                                        <img src="{url_for_uploads}catalog/items/<?=$item->id?>/b/<?= $item->picture ?>" alt="<?= $item->title ?>"/>
                                                    </div>

                                                </div>
                                                <div class="span6 well">
                                                    <dl class="dl-horizontal">
                                                        <dt>Цена</dt>
                                                        <dd><?= $item->price ?> р.</dd>
                                                        <dt>Категория</dt>
                                                        <dd><a href="{base}catalog/<?=$category->get_alias_path(CATEGORYES_CATALOG)?>"><?= $category->title ?></a></dd>
                                                    </dl>


                                                    <form method="post" class="form form-inline" action="{base}catalog/cart_add">
                                                        <input type="hidden" name="id" value="<?= $item->id ?>"/>
                                                        <input type="hidden" name="url" value="<?= base_url(uri_string()) ?>"/>
                                                        <input type="hidden" name="price" value="<?= $item->price ?>"/>
                                                        <input type="hidden" name="name" value="<?= $item->title ?>"/>
                                                        <button type="button" id="plusone" class="btn btn-link"><i class="icon-arrow-up"></i></button>
                                                        <input type="text" id="q" name="qty" class="span2" value="1" onkeyup="this.value = this.value.replace (/[^\d]/g, '1');"/>
                                                        <button  type="button" id="minusone" class="btn btn-link"><i class="icon-arrow-down"></i></button>
                                                        <button class="btn btn-primary" type="submit"><i class="icon-shopping-cart"></i> В корзину</button>
                                                    </form>
                                                </div>
                                            </div>

                                            <?= $item->description ?>
                                        </div>

                                        <div class="well">
                                            <!-- Social media icons -->
                                            <div class="social pull-left">
                                                <h5>Поделитесь в соцсетях: </h5>
                                                <script type="text/javascript" src="http://liberum-center.ru/share42/share42.js"></script>
                                                <script type="text/javascript">share42('liberum-center.ru/share42/', '', '')</script>

                                            </div>

                                            <div class="clearfix"></div>
                                        </div>
                                        <hr />
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

<!-- Content ends --> 
<? require_once 'inc_footer.php'; ?>