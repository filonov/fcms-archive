<? require_once 'inc_header.php'; ?>
<? require_once 'inc_menu.php'; ?>
<div class="content">
    <div class="container">
        <div class="row">
            <div class="span12">
                <div class="products">
                    <div class="row">
                        <div class="span12">
                            <div class="prod">
                                <div class="row">
                                    <div class="span8">
                                        <h3><?= $test->title ?></h3>
					<div class="pdetails">
					    <?= $test->description ?>
					</div>

                                        <div class="pdetails">



                                            <a name="top"></a>
                                            <div class="logreg-page">
                                                <h3><?= $page->title ?></h3>                        
                                                <hr />
						<? if (!empty($error)): ?>
    						<div class="alert alert-warning">
    						    <button type="button" class="close" data-dismiss="alert">&times;</button>
							<?= $error ?>
    						</div>

						<? endif; ?>
                                                <div class="form">

						    <?= $text ?>
                                                </div>                           
                                            </div>


                                        </div>

                                    </div>  

                                    <div class="span4"> 
                                        <div class="sidebar">
					    <? require_once 'inc_sidebar.php'; ?>
					    <?= block_module('side-menu-group', 'block_module_sidebar') ?>
                                        </div>    
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>


                <!-- Service ends -->



            </div>
        </div>
    </div>
</div>   

<? require_once 'inc_footer.php'; ?>

