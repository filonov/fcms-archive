<?php include_once 'header.inc.php'; ?>               
<div id="content">
    <div id="left">
        <div class="inside block_style">
            <h2>Новости</h2>
            <?= block_blog(2, 5) ?>                            
            <div  class="arc"><a href="<?= $base ?>blog/novosti" class="arc">архив новостей</a></div>
        </div>
    </div>
    <div id="center">
        <div >                                                    
            <h3>Подтверждение и оплата заказа</h3>   
            <div id="item_i_2">
                <? if ($optionsPay == 'cash'): ?>
                    <p>Спасибо за заказ! 
                        Вы выбрали оплату наличными курьеру при доставке.
                        Мы отправили Вам подтврждение по электронной почте.</p><br/>
                    <label>Содержимое заказа:</label>
                    <table width="100%" class="table table-striped table-bordered table-condensed">
                        <th>Название</th>
                        <th>Количество</th>
                        <th>Стоимость</th>

                        <?php
                        $summ = 0;
                        foreach ($orderentryes as $oitem):
                            ?>
                            <tr>
                                <td>
                                    <?= $oitem->title ?>
                                </td>
                                <td>
                                    <?= $oitem->qty ?>
                                </td>
                                <td>
                                    <?php
                                    $pr = $oitem->qty * $oitem->price;
                                    $summ += $pr;
                                    echo $pr;
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    <b>Сумма заказа: <?= $summ ?></b>
                <? else: ?>
                    <p>Спасибо! Вы выбрали оплату онлайн. Ещё раз проверьте содержимое заказа и перейдите к оплате:</p>
                    <table width="100%" class="table table-striped table-bordered table-condensed">
                        <th>Название</th>
                        <th>Количество</th>
                        <th>Стоимость</th>

                        <?php
                        $summ = 0;
                        foreach ($orderentryes as $oitem):
                            ?>
                            <tr>
                                <td>
                                    <?= $oitem->title ?>
                                </td>
                                <td>
                                    <?= $oitem->qty ?>
                                </td>
                                <td>
                                    <?php
                                    $pr = $oitem->qty * $oitem->price;
                                    $summ += $pr;
                                    echo $pr;
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    <b>Сумма заказа: <?= $summ ?></b>
                    <form class="well form-inline" action=" https://rbkmoney.ru/acceptpurchase.aspx " name="pay" method="POST">
                        <label for="bankCard" style="vertical-align:top;"><input type="radio" checked id="bankCard" value="bankCard" name="preference" />Банковская карта Visa/MasterCard</label><br />
                        <label for="inner"><input type="radio" id="inner" value="inner" name="preference" />Оплата с кошелька RBK Money</label><br />
                        <label for="exchangers"> <input type="radio" id="exchangers" value="exchangers" name="preference" />Электронные платежные системы</label><br />
                        <label for="prepaidcard"> <input type="radio" id="prepaidcard" value="prepaidcard" name="preference" />Предоплаченная карта RBK Money</label><br />
                        <label for="transfers"> <input type="radio" id="transfers" value="transfers" name="preference" />Системы денежных переводов</label><br />
                        <label for="terminals"> <input type="radio" id="terminals" value="terminals" name="preference" />Платёжные терминалы</label><br />
                        <label for="iFree"> <input type="radio" id="iFree" value="iFree" name="preference" />SMS</label><br />
                        <label for="bank"> <input type="radio" id="bank" value="bank" name="preference" />Банковский платёж</label><br />
                        <label for="postRus"> <input type="radio" id="postRus" value="postRus" name="preference" />Почта России</label><br />
                        <label for="atm"> <input type="radio" id="atm" value="atm" name="preference" />Банкоматы</label><br />
                        <label for="yandex"> <input type="radio" id="yandex" value="yandex" name="preference" />Яндекс</label><br />
                        <label for="ibank"> <input type="radio" id="ibank" value="ibank" name="preference" />Интернет банкинг</label><br />
                        <label for="euroset"> <input type="radio" id="euroset" value="euroset" name="preference" />Евросеть</label>
                        <input type="hidden" name="eshopId" value="2014727" />
                        <input type="hidden" name="orderId" value="<?= $id ?>" />
                        <input type="hidden" name="serviceName" value="Заказ <?= $id ?> на сайте Lindhausdom.ru" />
                        <input type="hidden" name="recipientAmount" value="<?= $summ ?>" />
                        <input type="hidden" name="recipientCurrency" value="RUR" />
                        <input type="hidden" name="user_email" value="<?= $email ?>" />
                        <input type="hidden" name="successUrl" value="<?= $base ?>shop/success" />
                        <input type="hidden" name="failUrl" value="<?= $base ?>shop/fail" />
                        <fieldset class="control-group">
                            <input type="submit" name="button" value="Оплатить" class="btn btn-success"/>
                        </fieldset>
                    </form>
                    <table border="0" align="center">
                        <tbody>
                            <tr>
                                <td><a href="http://www.rbkmoney.ru"><img src="/files/uploads/logo_light.jpeg" alt="" width="193" height="114" /></a></td>
                                <td><img src="/files/uploads/visa.png" alt="" width="57" height="33" /></td>
                                <td><img src="/files/uploads/master.png" alt="" width="113" height="33" /></td>
                            </tr>
                        </tbody>
                    </table>
                <? endif; ?>
            </div>
        </div>
    </div>
    <div id="right">
        <div class="inside block_style">
            <h2>Статьи</h2>
            <?= block_blog(3, 5) ?>                
            <div  class="arc"><a href="<?= $base ?>blog/stati">архив статей</a></div>
        </div>
    </div>
</div>
</div>
</div>
<?php require_once 'footer.inc.php'; ?>
