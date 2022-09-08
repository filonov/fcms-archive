<? require_once 'inc.header.php'; ?>

<body>

    <? require_once 'inc.menu.php'; ?>

    <div class="container">

        <div class="row">           
            <div class="span12">
                <h2>Заявка <small><?= $item->id ?></small></h2>
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
                    <table class="table table-bordered table-hover table-striped">
                        <tbody>
			    <tr>
                                <td>Тип:</td>
				<td>
				    <?
				    switch ($item->type)
				    {
					case MMA_KASKO:
					    echo 'КАСКО';
					    break;
					case MMA_OSAGO:
					    echo 'ОСАГО';
					    break;
					case MMA_DMS:
					    echo 'ДМС';
					    break;
					case MMA_OTHER:
					    echo 'Другое: ' . $item->mma_other;
					    break;
				    }
				    ?>
				</td>
                            </tr>
                            <tr>
                                <td>Контактное лицо:</td><td><?= $item->name ?> <?= $item->contact_name ?></td>
                            </tr>
                            <tr>
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
			    <? if ($item->type == MMA_KASKO): ?>
    			    <tr>
    				<td>Марка автомобиля:</td>
    				<td>
					<?= $mark->get_by_id($item->mma_mark_id)->mark ?>
    				</td>
    			    </tr>
    			    <tr>
    				<td>Модель автомобиля:</td>
    				<td>
					<?= $model->get_by_id($item->mma_model_id)->model ?>
    				</td>
    			    </tr>
    			    <tr>
    				<td>Дата выпуска:</td>
    				<td>
					<?= $item->release_date ?>
    				</td>
    			    </tr>
    			    <tr>
    				<td>Регион:</td>
    				<td>
					<?= $region->get_by_id($item->mma_region_id)->name ?>
    				</td>
    			    </tr>
    			    <tr>
    				<td>Допущены к управлению:</td>
    				<td>
					<?= $item->num_of_drivers ?>
    				</td>
    			    </tr>
    			    <tr>
    				<td>Минимальный возраст:</td>
    				<td>
					<?= $item->minimum_age ?>
    				</td>
    			    </tr>
    			    <tr>
    				<td>Максимальный стаж:</td>
    				<td>
					<?= $item->driving_experience ?>
    				</td>
    			    </tr>
			    <? endif; ?>
			    <? if ($item->type == MMA_OSAGO): ?>
    			    <tr>
    				<td>Собственник ТС:</td>
    				<td>
					<? if ($item->owner_type == 10): ?>Физическое лицо
					<? else: ?>Юридическое лицо
					<? endif; ?>
    				</td>
    			    </tr>
    			    <tr>
    				<td>Место регистрации ТС:</td>
    				<td>
					<? if ($item->reg_place_type == 10): ?>Россия<? endif; ?>
					<? if ($item->reg_place_type == 20): ?>Следует к месту регистрации<? endif; ?>
					<? if ($item->reg_place_type == 30): ?>Зарегистрировано в иностранном государстве <? endif; ?>

    				</td>
    			    </tr>
    			    <tr>
    				<td>Тип ТС:</td>
    				<td>
					<?= $tstype->get_by_id($item->mma_car_type_id)->type ?>
    				</td>
    			    </tr>
    			    <tr>
    				<td>Мощность ТС:</td>
    				<td>
					<?= $osago_power->get_by_id($item->power)->text ?>
    				</td>
    			    </tr>
    			    <tr>
    				<td>Регион:</td>
    				<td>
					<?= $osago_oblast->get_by_id($item->mma_region_id)->title ?>
    				</td>
    			    </tr>
    			    <tr>
    				<td> Населённый пункт:</td>
    				<td>
					<?= $osago_np->get_by_id($item->mma_community_id)->title ?>
    				</td>
    			    </tr>
    			    <tr>
    				<td>Количество водителей:</td>
    				<td>
					<? if ($item->number_of_users == 1): ?>Количество водителей ограничено
					<? else: ?>Количество водителей не ограничено<? endif; ?>
    				</td>
    			    </tr>
    			    <tr>
    				<td>Срок страхования:</td>
    				<td>
					<?= $item->term_insurance ?>
    				</td>
    			    </tr>
    			    <tr>
    				<td>Период использования ТС (месяцы):</td>
    				<td>
					<?= $item->period_of_use ?>
    				</td>
    			    </tr>
    			    <tr>
    				<td>Класс:</td>
    				<td>

					<?
					$osago_class->get_by_id($item->class);
					echo $osago_class->class . ' — ' . $osago_class->koeff;
					?>
    				</td>
    			    </tr>
    			    <tr>
    				<td>Страховые выплаты за год:</td>
    				<td>
					<?= $item->insurance_payments ?>

    				</td>
    			    </tr>
    			    <tr>
    				<td>Нарушения страхования:</td>
    				<td>
					<? if ($item->security_violations == 10): ?>Были<? endif; ?>
					<? if ($item->security_violations == 20): ?>Не было<? endif; ?>
    				</td>
    			    </tr>
			    <? endif; ?>
			    <? if ($item->type == MMA_DMS): ?>
    			    <tr>
    				<td>Клиент:</td>
    				<td>
					<? if ($item->owner_type == 10): ?>Физическое лицо
					<? else: ?>Юридическое лицо
					<? endif; ?>
    				</td>
    			    </tr>
    			    <tr>
    				<td>Количество человек:</td>
    				<td>
					<?= $item->number_of_users ?>
    				</td>
    			    </tr>
    			    <tr>
    				<td>Средний возраст:</td>
    				<td>
					<?= $item->age ?>
    				</td>
    			    </tr>
    			    <tr>
    				<td> Сфера деятельности:</td>
    				<td>
					<?= $item->scope ?>
    				</td>
    			    </tr>
    			    <tr>
    				<td> Пожелания по медучреждениям:</td>
    				<td>
					<?= $item->wishes ?>
    				</td>
    			    </tr>
    			    <tr>
    				<td>Опции:</td>
    				<td>
					<?= $item->mma_dms_options ?>
    				</td>
    			    </tr>
    			    <tr>
    				<td>Примечания:</td>
    				<td>
					<?= $item->comments ?>
    				</td>
    			    </tr>
			    <? endif; ?>
			    <? if ($item->type == MMA_OTHER): ?>
    			    <tr>
    				<td>Вид страхования:</td>
    				<td>
					<?= $item->mma_other ?>
    				</td>
    			    </tr>
    			    <tr>
    				<td>Комментарий:</td>
    				<td>
					<?= $item->comments ?>
    				</td>
    			    </tr>
			    <? endif; ?>
                        </tbody>
                    </table>



                    <div class="form-actions">

                    </div>
                </form>
            </div>

        </div>

	<? require_once 'inc.footer.php'; ?>
