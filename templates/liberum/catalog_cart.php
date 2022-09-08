<? require_once 'inc_header.php'; ?>  
<? require_once 'inc_menu.php'; ?>  

<script type="text/javascript">
    function checkdigits(input) {
        input.value = input.value.replace(/[^\d]/g, '');
    }
    ;
</script>

<div class="content">
    <div class="container">
        <div class="row">
            <div class="span12">
                <div class="review">
                    <h3>Оформление заказа</h3>   
                    <? if ($this->cart->total_items() > 0): ?>
                        <? if (!empty($error)): ?>
                            <div class="alert alert-error">
                                <?= $error ?>                     
                            </div>
                        <? endif; ?>


                        <form method="post" action="{base}catalog/cart">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>Количество</th>
                                    <th>Наименование</th>
                                    <th style="text-align:right">Цена за шт.</th>
                                    <th style="text-align:right">Сумма</th>
                                </tr>
                                <? $i = 1; ?>
                                <? foreach ($this->cart->contents() as $items): ?>
                                    <? echo form_hidden($i . '[rowid]', $items['rowid']); ?>
                                    <tr>
                                        <td>
                                            <!--button class="remove btn btn-link btn-mini" title="<?= $items['rowid'] ?>"><i class="icon-remove"></i></button>
                                            <button class="add btn btn-link" title="<?= $items['rowid'] ?>" ><i class="icon-arrow-up"></i></button--> 
                                            <input type="text" readonly name="<?= $i ?>[qty]" value="<?= $items['qty'] ?>" style="width: 50px" onkeyup="return checkdigits(this);" onchange="return checkdigits(this);"/>
                                            <!--button class="multiply btn btn-link" title="<?= $items['rowid'] ?>"><i class="icon-arrow-down"></i></button-->
                                        </td>
                                        <td>
                                            <input type="hidden" name="<?= $i ?>[id]" value="<? echo $items['id'] ?>" />
                                            <? echo $items['name']; ?>
                                            <? if ($this->cart->has_options($items['rowid']) == TRUE): ?>
                                                <p>
                                                    <? foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?>
                                                        <strong><? echo $option_name; ?>:</strong> <? echo $option_value; ?><br />
                                                    <? endforeach; ?>
                                                </p>
                                            <? endif; ?>
                                        </td>
                                        <td style="text-align:right"><? echo $this->cart->format_number($items['price']); ?></td>
                                        <td style="text-align:right"><? echo $this->cart->format_number($items['subtotal']); ?></td>
                                    </tr>
                                    <? $i++; ?>
                                <? endforeach; ?>
                                <tr>
                                    <td colspan="2"> </td>
                                    <td class="right"><strong>Всего:</strong></td>
                                    <td class="right"><? echo $this->cart->format_number($this->cart->total()); ?></td>
                                </tr>
                            </table>

                            <input type="hidden" id="total" name="total" value="<? echo $this->cart->format_number($this->cart->total()); ?>"/>
                            <label>Ваше имя:</label>
                            <input type="text" class="input-xxlarge" name="fio" id="fio" value="<?= $order->name ?>" placeholder="Введите ваше имя..."/>
                            <label>e-mail:</label>
                            <input type="text" class="input-xxlarge" name="email" id="email" value="<?= $order->email ?>" placeholder="info@liberum-center.ru"/>
                            <label>Адрес:</label>
                            <input type="text" class="input-xxlarge" name="adress" id="adress" value="<?= $order->adress ?>" placeholder="Введите адрес доставки..."/>
                            <label>Телефон для связи: </label>
                            <input type="text" class="input-xxlarge" name="phone" id="phone" value="<?= $order->phone ?>" placeholder="+7 (495) 506-65-19"/>
                            <label>Комментарий:</label>
                            <input type="text" class="input-xxlarge" name="comment" id="comment" value="<?= $order->comment ?>" placeholder="Введите ваш комментарий..."/>
                            <label class="checkbox">
                                <input type="checkbox" name="agree">Я согласен/согласна с <a href="{base}usloviya-obsluzhivaniya-v-magazine">условиями обслуживания</a>
                            </label>

                            <div class="control-group">
                                <label class="control-label">Оплата и доставка</label>
                                <div class="controls">
                                    <label class="radio">
                                        <input type="radio" name="optionsPay" id="optionsPay1" value="<?= DELIVERY_CASH ?>" checked >
                                        Самовывоз.
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="optionsPay" id="optionsPay2" value="<?= DELIVERY_COURIER ?>">
                                        Наличными. Доставка курьером.
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="optionsPay" id="optionsPay3" value="<?= DELIVERY_BANK ?>">
                                        Выставить счёт на оплату.
                                    </label>
                                    <!--label class="radio disabled">
                                        <input type="radio" name="optionsPay" id="optionsPay4" value="card" disabled class="disabled">
                                        Кредитной картой online (извините, сейчас недоступно).
                                    </label-->
                                </div>
                            </div>

                            <div class="form-actions">
                                <p><? echo form_submit('add', 'Оформить заказ', 'class="btn btn-primary"'); ?>&nbsp;<? echo form_submit('reset', 'Очистить корзину', 'class="btn btn-inverse"'); ?></p>
                            </div>
                        </form>

                    <? else: ?>
                        <p>Корзина пуста.<?= br(20) ?></p>
                    <? endif; ?>

                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" charset="utf-8">

    $(".remove").click(function() {
        var url = $('#url').val();
        $.post(url + "catalog/cart_update", {
            id: $(this).attr("title"), //$('#id').val(),
            qty: 0,
            price: $('#price').val(),
            name: $('#name').val()
        },
        function(data) {
            $('#cart').html(data);
        },
                "html");
    });

    $(".add").click(function() {
        var url = $('#url').val();
        var rowid = $(this).attr("title");
        var num = parseInt($('#' + rowid).val());
        $.post(url + "catalog/cart_update", {
            id: rowid,
            qty: num + 1,
            price: $('#price').val(),
            name: $('#name').val()
        },
        function(data) {
            $('#cart').html(data);
        },
                "html");
    });

    $(".multiply").click(function() {
        var url = $('#url').val();
        var rowid = $(this).attr("title");
        var num = parseInt($('#' + rowid).val());
        $.post(url + "catalog/cart_update", {
            id: rowid,
            qty: num - 1,
            price: $('#price').val(),
            name: $('#name').val()
        },
        function(data) {
            $('#cart').html(data);
        },
                "html");
    });
    </script>
    <? require_once 'inc_footer.php'; ?>
