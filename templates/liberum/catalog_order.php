<?php include_once 'inc_header.php'; ?>   
<?php include_once 'inc_menu.php'; ?> 
<div class="content">
    <div class="container">
        <div class="row">
            <div class="span12">
                <div class="review">
                    <h3>Подтверждение и оплата заказа</h3>   

                    <?
                    switch ($optionsPay)
                    {
                        case DELIVERY_CASH:
                            ?>
                            <p>Спасибо за заказ! 
                                Вы выбрали оплату наличными и самовывоз.
                                Мы отправили Вам подтверждение по электронной почте.</p><br/>


                            <?
                            break;
                        case DELIVERY_BANK:
                            ?>
                            <p>Спасибо за заказ! 
                                Вы выбрали оплпту по счёту.
                                Мы отправили Вам подтверждение по электронной почте.</p><br/>
                            <?
                            break;
                        case DELIVERY_COURIER:
                            ?>
                            <p>Спасибо за заказ! 
                                Вы выбрали оплату курьеру наличными при доставке.
                                Мы отправили Вам подтверждение по электронной почте.</p><br/>
                            <?
                            break;
                    };
                    ?>
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
                                    <?= $oitem->quantity ?>
                                </td>
                                <td>
                                    <?php
                                    $pr = $oitem->quantity * $oitem->price;
                                    $summ += $pr;
                                    echo $pr;
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    <b>Сумма заказа: <?= $summ ?></b>






                    <? /*
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
                     */ ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'inc_footer.php'; ?>
