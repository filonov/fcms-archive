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
                                        <h3><?= $group->title ?></h3>
                                        <div class="pdetails">
                                            <div class="ptable">
                                                <div class="pline">
						    <? if (isset($levels->title)): ?>
    						    <i class="icon-info-sign"></i> Уровень <span class="pull-right"><?= $levels->title ?> 
							    <? if ($group->program != 0): ?>
								( <a href="{base}<?= $program->link ?>">Программа курса</a> )
							    <? endif; ?>
    						    </span>
						    <? endif; ?>
						    <? if (isset($special)): ?>
    						    <i class="icon-info-sign"></i> Спецкурс <span class="pull-right">
    							<a href="{base}specials/<?= ($special->language == ITALIAN) ? 'italiano' : 'espanol' ?>/<?= $special->link ?>"><?= $special->title ?></a>
    						    </span>
						    <? endif; ?>
                                                </div>
                                                <div class="pline"><i class="icon-time"></i> Дни и время занятий <span class="pull-right"><?= $group->days ?>&nbsp;<?= $group->time ?></span></div>
                                                <div class="pline"><i class="icon-info-sign"></i> Статус <span class="pull-right"><?= $status->status_text ?>&nbsp;<?= dateToRus($group->date) ?></span></div>
						<? if (!empty($group->comment)): ?>
    						<div class="pline"><i class="icon-info-sign"></i> Комментарий <span class="pull-right"><?= $group->comment ?></span></div>
						<? endif; ?>
                                                <div class="pline"><i class="icon-user"></i> Преподаватель <span class="pull-right"><a href="{base}teachers/<?= $teacher->id ?>"><?= $teacher->title ?></a></span></div>
                                                <div class="pline"><i class="icon-book"></i> Основные учебные пособия 
                                                    <span class="pull-right"><small>
							    <?
							    $pos = '';
							    foreach ($textbook as $t)
							    {
								$pos.= ' ' . anchor(base_url($t->link), $t->title) . ', ';
							    }
							    echo mb_substr($pos, 0, strlen($pos) - 2);
							    ?>
                                                        </small>
                                                    </span>
                                                </div>
                                                <div class="pline"><i class="icon-time"></i> Общая продолжительность <?= $duration->description ?></div>
                                                <div class="pline"><i class="icon-money"></i> Стоимость <?= $price->description ?></div>
                                                <div class="clearfix"></div>
                                            </div>
					    <? /*
					    <? if (!($test_out)): ?>
                                                <div class="button center">
						    <? if ($group->tests_id != 0): ?>
							<a href="<?= base_url('tests/' . $test->alias) ?>"><i class="icon-certificate"></i> Пройти тест</a>
						    <? endif; ?>
                                                </div>
					    <? else: ?>
					    <div class="logreg-page">
						<?=$test_out?>
					    </div>
					    
					    
					    <? endif;?>
					     
					     */ ?>
                                            <a name="top"></a>
                                            <div class="logreg-page">
                                                <h3>Записаться <span class="color">в группу</span></h3>                        
                                                <hr />
						<? if (!empty($error)): ?>
    						<div class="alert alert-warning">
    						    <button type="button" class="close" data-dismiss="alert">&times;</button>
							<?= $error ?>
    						</div>

						<? endif; ?>
                                                <div class="form">
                                                    <!-- Register form (not working)-->
                                                    <form class="form-horizontal" method="post" action="{base}courses/group/<?= $group->id ?>#top">
                                                        <!-- Name -->
                                                        <div class="control-group">
                                                            <label class="control-label" for="name">Имя</label>
                                                            <div class="controls">
                                                                <input type="text" class="input-large" name="name" placeholder="Ваше имя, фамилия и отчество" value="<?= (isset($fdata->name)) ? $fdata->name : '' ?>">
                                                            </div>
                                                        </div>   
                                                        <!-- Email -->
                                                        <div class="control-group">
                                                            <label class="control-label" for="email">Email</label>
                                                            <div class="controls">
                                                                <input type="text" class="input-large" name="email" placeholder="pochta@example.com" value="<?= (isset($fdata->email)) ? $fdata->email : '' ?>">
                                                            </div>
                                                        </div>
                                                        <!-- Phone -->
                                                        <div class="control-group">
                                                            <label class="control-label" for="phone">Телефон</label>
                                                            <div class="controls">
                                                                <input type="text" class="input-large" name="phone" placeholder="+7(495)506-65-01" value="<?= (isset($fdata->phone)) ? $fdata->phone : '' ?>">
                                                            </div>
                                                        </div>
                                                        <!-- Select box -->
                                                        <div class="control-group">
                                                            <label class="control-label" for="select">Уровень</label>
                                                            <div class="controls">                               
                                                                <select name="level">
                                                                    <option value="Нулевой (Не владею)"> Нулевой (Не владею) </option>
                                                                    <option value="&quot;Ложный&quot; начинающий"> "Ложный" начинающий </option>
                                                                    <option value="Базовый"> Базовый </option>
                                                                    <option value="Средний"> Средний </option>
                                                                    <option value="Продвинутый"> Продвинутый </option>
                                                                    <option value="Высокий"> Высокий </option>
                                                                </select>
                                                                </select>  
                                                            </div>
                                                        </div>                                           

                                                        <div class="control-group">
                                                            <label class="control-label" for="exp">Ваш опыт изучения языка</label>
                                                            <div class="controls">
                                                                <textarea name="exp" rows="8" placeholder="Краткая информация о себе, которая поможет нам точнее определить ваш уровень: где учили язык, с каким преподавателем (носитель/не носитель), в течение какого времени, по каким учебникам. Также вы можете добавить другую информацию, которую сочтете важной."><?= (isset($fdata->exp)) ? $fdata->exp : '' ?></textarea>
                                                            </div>
                                                            <div class="controls">
                                                                <br/>
                                                                <img class="thumbnail" src="{base}capt" alt="Капча." />
                                                                <br/>
                                                            </div>
                                                            <label class="control-label" for="phone">Введите текст с картинки:</label>
                                                            <div class="controls">


                                                                <input type="text" class="input-large" name="captcha" placeholder="z86kk75" value="">

                                                            </div>

                                                        </div>

                                                        <!-- Buttons -->
                                                        <div class="form-actions">
                                                            <!-- Buttons -->
                                                            <button type="submit" class="btn">Записаться</button>
                                                        </div>
                                                    </form>

                                                </div>                           
                                            </div>
                                            <div class="ptable">
                                                <div class="pline">
						    <?= block_module('tekst-pered-formoy-zapisi') ?>  
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
