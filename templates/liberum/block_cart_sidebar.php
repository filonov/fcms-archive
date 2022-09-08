<div id="cart">
    <div class="widget">
        <?=  block_module('usloviya-obsluzhivaniya')?>
    </div>
    <div class="widget">
        <h4><i class="icon-shopping-cart"></i> Корзина</h4>
        <form>
            <input id="url" type="hidden" value="<?= $base ?>" />
        </form>
        <div class="inside">
            <? if ($this->cart->total_items() > 0): ?>
                <p class="text-info">В корзине товаров: <?= $this->cart->total_items() ?><br/>
                    На сумму: <?= $this->cart->format_number($this->cart->total()) ?> руб. </p>
            <? else: ?>
                <p class="text-info">Корзина пуста.</p>
            <? endif; ?>                            
        </div>

        <? $i = 1; ?>
        <table class="table table-condensed table-hover table-striped">
            <? foreach ($this->cart->contents() as $items): ?>
                <tr>
                    <td>
                        <button class="remove btn btn-link btn-mini" title="<?= $items['rowid'] ?>"><i class="icon-remove"></i></button>
                    </td>
                    <td>
                        <small><?= $items['name'] ?></small>
                    <td width="70"> 
                            <button class="add btn btn-link btn-mini" title="<?= $items['rowid'] ?>" ><i class="icon-arrow-up"></i></button> 
                            <?= $items['qty'] ?> 
                            <button class="multiply btn btn-link btn-mini" title="<?= $items['rowid'] ?>"><i class="icon-arrow-down"></i></button>
                            <form><input id="<?= $items['rowid'] ?>" value="<?= $items['qty'] ?>" type="hidden"/>
                        </form>
                    </td>
                </tr>
                <? $i++; ?>
            <? endforeach; ?>         
        </table>              
        <br/>
        <? if ($this->cart->total_items() > 0): ?>
            <a href="<?= $base ?>catalog/cart" class="btn btn-success btn-mini"><i class="icon-ok"></i> Оформить заказ</a>
        <? endif; ?>

    </div>  
    <script type="text/javascript" charset="utf-8">

        $(".remove").click(function() {
            var url = $('#url').val();
            $.post(url + "catalog/cart_update", {
                id: $(this).attr("title"), //$('#id').val(),
                qty: 0, /* $('#qty').val(),*/
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
                qty: num + 1, /* $('#qty').val(),*/
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
</div>
