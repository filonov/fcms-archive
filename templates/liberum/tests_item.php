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
                                                    <form class="form" method="post" action="<?= base_url('tests/answer') ?>">




							<? // Началась форма персональных данных ?>
							<? if (($page->number == 1) && !($this->session->userdata('form_id'))): ?>
    							<!-- Name -->
    							<div class="control-group">
    							    <label class="control-label" for="name">Имя</label>
    							    <div class="controls">
								<input type="text" required="required" class="span5" name="name" placeholder="Ваше имя, фамилия и отчество" value="<?= (isset($fdata->name)) ? $fdata->name : '' ?>">
    							    </div>
    							</div>   
    							<!-- Email -->
    							<div class="control-group">
    							    <label class="control-label" for="email">Email</label>
    							    <div class="controls">
    								<input type="text" required="required" class="span5" name="email" placeholder="pochta@example.com" value="<?= (isset($fdata->email)) ? $fdata->email : '' ?>">
    							    </div>
    							</div>
    							<!-- Phone -->
    							<div class="control-group">
    							    <label class="control-label" for="phone">Телефон</label>
    							    <div class="controls">
    								<input type="text" required="required" class="span5" name="phone" placeholder="+7(495)506-65-01" value="<?= (isset($fdata->phone)) ? $fdata->phone : '' ?>">
    							    </div>
    							</div>
							<? endif; ?>
							<? // Закончилась форма персональных данных?>





							<fieldset>
							    <input type="hidden" name="test_id" value="<?= $test->id ?>">
							    <input type="hidden" name="page_id" value="<?= $page->id ?>">
							    <p><?= $page->description ?></p>
							    <? foreach ($questions as $question): ?>
    							    <div class="control-group">
    								<label class="control-label" for="question"><?= $question->number ?>. <?= $question->title ?></label>
    								<div class="controls">
									<? foreach ($answers as $a): ?>
									    <? if ($a->tests_questions_id == $question->id): ?>
	    								    <label class="radio">
	    									<input type="radio" name="answer-<?= $question->id ?>[]" value="<?= $a->id ?>">
										    <?= $a->title ?>
	    								    </label>
									    <? endif; ?>
									<? endforeach; ?>
    								</div>
    							    </div>
							    <? endforeach; ?>
							</fieldset>
							<div class="form-actions">
							    <button type="submit" class="btn btn-primary">Проверить</button>
							</div>
                                                    </form>
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
