<? require_once 'inc.header.php'; ?>

<body>

    <? require_once 'inc.menu.php'; ?>

    <div class="container">

        <div class="row">           
            <div class="span12">
                <h2>Анкета <small><?= $id ?></small></h2>
                <hr>
		<? if (!empty($error)): ?>
    		<div class="alert alert-error">
    		    <button type="button" class="close" data-dismiss="alert">&times;</button>
    		    <h4>Ошибка сохранения!</h4>
    		    <br/><?= $error ?>
    		</div>
		<? endif; ?>


                <form class="form" action="{method_path}" method="POST">
                    <input type="hidden" name="eid" value="{id}" />
                    <label><h4>Статус</h4></label>
                    <label class="radio">
                        <input type="radio" name="status" id="stat1" value="<?= ORDER_NEW ?>" 
			       <?= ($item->status == ORDER_NEW) ? 'checked' : '' ?>>
                        Новый
                    </label>
                    <label class="radio">
                        <input type="radio" name="status" id="stat2" value="<?= ORDER_PROCESSING ?>" 
			       <?= ($item->status == ORDER_PROCESSING) ? 'checked' : '' ?>>
                        В обработке
                    </label>
                    <label class="radio">
                        <input type="radio" name="status" id="stat3" value="<?= ORDER_COMPLETED ?>" 
			       <?= ($item->status == ORDER_COMPLETED) ? 'checked' : '' ?>>
                        Выполнен
                    </label>
                    <label class="radio">
                        <input type="radio" name="status" id="stat4" value="<?= ORDER_REFUSED ?>" 
			       <?= ($item->status == ORDER_REFUSED) ? 'checked' : '' ?>>
                        Отказ
                    </label>
                    <h4>Данные покупателя</h4>
                    <table class="table table-bordered table-hover table-striped">
                        <tbody>
                            <tr>
                                <td>Имя:</td><td><?= $item->name ?></td>
                            </tr>
                            <tr>
                                <td>Дата и время заполнения:</td><td><?= $item->created ?></td>
                            </tr>

                            <tr>
                                <td>Телефон:</td><td><?= $item->phone ?></td>
                            </tr>
                            <tr>
                                <td>E-mail:</td><td><?= $item->email ?></td>
                            </tr>
                            <tr>
                                <td>Группа:</td><td><?
				    if ($item->group_id > 0):
					echo anchor(base_url('courses/group/' . $item->group_id, 'target="_blank"'), $item->group_title);
				    else:
					echo 'Пользователь не со страницы группы';
				    endif;
				    ?></td>
                            </tr>
                            <tr>
                                <td>Уровень знания:</td><td><?= $item->level ?></td>
                            </tr>
                            <tr>
                                <td>Комментарий:</td><td><?= $item->exp ?></td>
                            </tr>
                        </tbody>
                    </table>



                    <div class="form-actions">
                        <button class="btn btn-primary save" type="submit" ><i class="icon-ok"></i> Сохранить</button>
                    </div>
                </form>
            </div>

        </div>

	<? require_once 'inc.footer.php'; ?>

