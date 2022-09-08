<? require_once 'inc.header.php'; ?>

<body>

    <? require_once 'inc.menu.php'; ?>

    <div class="container">

        <div class="row">           
            <div class="span12">
                <h2>Заказ <small><?= $id ?></small></h2>
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
                                <td>Покупатель:</td><td><?= $item->name ?></td>
                            </tr>
                            <tr>
                                <td>Оплата:</td><td>                         
                                    <?
                                    switch ($item->options)
                                    {
                                        case DELIVERY_CASH:    echo 'Самовывоз'; break;
                                        case DELIVERY_CARD:    echo 'Кредиткой онлайн'; break;
                                        case DELIVERY_COURIER: echo 'Оплата при доставке курьером'; break;
                                        case DELIVERY_BANK:    echo 'Выставить счёт'; break;
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Дата и время заказа:</td><td><?= $item->created ?></td>
                            </tr>
                            <tr>
                                <td>Адрес доставки:</td><td><?= $item->adress ?></td>
                            </tr>
                            <tr>
                                <td>Телефон:</td><td><?= $item->phone ?></td>
                            </tr>
                            <tr>
                                <td>E-mail:</td><td><?= $item->email ?></td>
                            </tr>
                            <tr>
                                <td>Комментарий:</td><td><?= $item->comment ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <h4>Содержимое заказа</h4>
                    <table class="table table-bordered table-hover table-striped">

                        <tbody>
                            <tr>
                                <th>SKU</th>
                                <th>Наименование</th>
                                <th>Стоимость</th>
                                <th>Количество</th>
                            </tr>    
                            <? foreach ($items as $p): ?>

                                <tr>
                                    <td><?= $p->SKU ?></td>
                                    <td><?= $p->title ?></td>
                                    <td><?= $p->price ?></td>
                                    <td><?= $p->quantity ?></td>
                                </tr>    
                            <? endforeach; ?>
                        </tbody>
                    </table>


                    <div class="form-actions">
                        <button class="btn btn-primary save" type="submit" ><i class="icon-ok"></i> Сохранить</button>
                    </div>
                </form>
            </div>

        </div>

       <? require_once 'inc.footer.php';?>

