<? require_once 'inc.header.php'; ?>

<body>

    <script type="text/javascript" charset="utf-8">
        function check_gr()
        {
            if ($('#optionsType1').prop('checked'))
            {
                $('#select_special').prop('disabled', true);
                $('#select_level').prop('disabled', false);

            } else
            {
                $('#select_special').prop('disabled', false);
                $('#select_level').prop('disabled', true);
            }
        }

        $(document).ready(function() {
            check_gr();

            $('input:radio[name=type]').click(function() {
                check_gr();
            });

            $('#date').pickadate({
                onOpen: function() {
                    scrollPageTo(this.$node);
                }
            });

            function scrollPageTo($node) {
                $('html, body').animate({
                    scrollTop: ~~$node.offset().top - 60
                }, 150);
            }
        });
    </script>

    <? require_once 'inc.menu.php'; ?>

    <div class="container">

        <div class="row">           
            <div class="span12">
                <h2>Редактируем группу 
                    <small>
                        <?= $content->title_for_cources ?>
                    </small>
                </h2>
                <hr/>
                <? if (!empty($error)): ?>
                    <div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <h4>Ошибка сохранения!</h4>
                        <br/><?= $error ?>
                    </div>
                <? endif; ?>
                <form id="form_add" method="post" action="{base}cms/groups/edit/<?= $content->id ?>"> 
                    <div class="row">
                        <div class="span3">
                            <label>Порядок</label>
                            <input type="text" name="order" class="span1" placeholder="14" value="<?= $content->order ?>">
                        </div>
                        <div class="span3">
                            <label>Тип группы</label>
                            <label class="radio">
                                <input type="radio" name="type" id="optionsType1" value="<?= GROUP_STANDART ?>" <?= ($content->type == GROUP_STANDART) ? "checked" : "" ?>>
                                Стандартная
                            </label>
                            <label class="radio">
                                <input type="radio" name="type" id="optionsType2" value="<?= GROUP_SPECIAL ?>" <?= ($content->type == GROUP_SPECIAL) ? "checked" : "" ?>>
                                Спецкурс
                            </label>
                        </div>
                        <div class="span3">
                            <label>Язык</label>
                            <label class="radio">
                                <input type="radio" name="language" id="optionslanguage1" value="<?= ITALIAN ?>" <?= ($content->language == ITALIAN) ? "checked" : "" ?>>
                                Итальянский
                            </label>
                            <label class="radio">
                                <input type="radio" name="language" id="optionslanguage2" value="<?= SPAIN ?>" <?= ($content->language == SPAIN) ? "checked" : "" ?>>
                                Испанский
                            </label>
                        </div>
                        <div class="span3">
                            <label for="level">Уровень группы</label>
                            <select class="span2" name="level" id="select_level">
                                <? foreach ($levels as $level): ?>
                                    <option value="<?= $level->id ?>" <?= ($content->level == $level->id) ? "selected" : "" ?>><?= $level->title ?></option>
                                <? endforeach; ?>
                            </select> 
                        </div>    
                    </div>
                    <div class="row">
                        <div class="span3">
                            <label>Вид спецкурса</label>
                            <select name="special" id="select_special">
                                <? foreach ($specials as $special): ?>
                                    <option value="<?= $special->id ?>" <?= ($content->special == $special->id) ? "selected" : "" ?>>
                                        <?= $special->title ?>
                                    </option>
                                <? endforeach; ?>
                            </select> 
                        </div>
                        <div class="span3">
                            <label>Программа курса</label>
                            <select name="program">
                                <option value="0" <?= ($content->program == 0) ? "selected" : "" ?>>Не выбрана</option>
                                <? foreach ($programs as $program): ?>
                                    <option value="<?= $program->id ?>" <?= ($content->program == $program->id) ? "selected" : "" ?>><?= $program->title ?></option>
                                <? endforeach; ?>
                            </select>  
                        </div>

                        <div class="span3">
                            <label>Дни занятий</label>
                            <input type="text" name="days" value="<?= $content->days ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="span3">
                            <label>Время занятий</label>
                            <div class="input-prepend">
                                <span class="add-on"><i class="icon-time"></i></span>
                                <input type="text" name="time" id="time" class="span2" value="<?= $content->time ?>">
                            </div>
                        </div>
                        <div class="span3">
                            <label>Дата начала занятий</label>
                            <div class="input-prepend">
                                <span class="add-on"><i class="icon-calendar"></i></span>
                                <input type="text" class="span2" name="date" id="date" value="<?= $content->date ?>">
                            </div>
                        </div>
                        <div class="span3">
                            <label>Преподаватель группы</label>
                            <select name="teacher">
                                <? foreach ($teachers as $t): ?>
                                    <option value="<?= $t->id ?>" <?= ($content->teacher == $t->id) ? "selected" : "" ?>><?= $t->title ?></option>
                                <? endforeach; ?>
                            </select>
                        </div>
                        <div class="span3">
                            <label>Статус группы</label>
                            <select name="status">
                                <? foreach ($statuses as $st): ?>
                                    <option value="<?= $st->id ?>" <?= ($content->status == $st->id) ? "selected" : "" ?>><?= $st->status_text ?></option>
                                <? endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="span3">
                            <label>Формат обучения</label>
                            <select name="format">
                                <? foreach ($formats as $f): ?>
                                    <option value="<?= $f->id ?>" <?= ($content->format == $f->id) ? "selected" : "" ?>><?= $f->title ?></option>
                                <? endforeach; ?>
                            </select>
                        </div>
                        <div class="span3">
                            <label>Продолжительность</label>
                            <select name="duration">
                                <? foreach ($durations as $d): ?>
                                    <option value="<?= $d->id ?>" <?= ($content->duration == $d->id) ? "selected" : "" ?>><?= $d->title ?></option>
                                <? endforeach; ?>
                            </select>
                        </div>
                        <div class="span3">
                            <label>Стоимость</label>
                            <select name="price">
                                <? foreach ($prices as $price): ?>
                                    <option value="<?= $price->id ?>" <?= ($content->price == $price->id) ? "selected" : "" ?>><?= $price->title ?></option>
                                <? endforeach; ?>
                            </select>
                        </div>
                        <div class="span3">
                            <label>Тест</label>
			    <select name="test">
                                <option value="0" <?= ($content->tests_id == 0) ? "selected" : "" ?>>Не выбран</option>
                                <? foreach ($tst as $test): ?>
                                    <option value="<?= $test->id ?>" <?= ($content->tests_id == $test->id) ? "selected" : "" ?>><?= $test->title ?></option>
                                <? endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="span3">
                            <label>Основные учебные пособия</label>
                            <div class="thumbnail" style="height: 200px; overflow-y: scroll;">
                                <? foreach ($textbooks as $textbook): ?>
                                    <label class="checkbox">
                                        <input type="checkbox" name="textbooks[]" value="<?= $textbook->id ?>" 
                                               <?= (isset($checked_textbook[$textbook->id])) ? "checked" : "" ?>/><?= $textbook->title ?>
                                    </label>
                                <? endforeach; ?>
                            </div>
                            
                        </div>
                        <div class="span8">
                            <label>Комментарий</label>
                            <input type="text" name="comment" class="span8" value="<?= $content->comment ?>">
                            <label>Название</label>
                            <input type="text" name="title_for_cources" readonly class="span8" value="<?=$content->title?>">
                            <label>Название в поиске курсов</label>
                            <input type="text" name="title_for_cources" readonly class="span8" value="<?=$content->title_for_cources?>">
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                    </div>
                </form>
            </div>
        </div>

        <? require_once 'inc.footer.php'; ?>   
