<? require_once 'inc.header.php'; ?>
<body>
    <? require_once 'inc.menu.php'; ?>
    <div class="container">

        <div class="row">           
            <div class="span12">
                <h2>Настройки счётчика заявок</h2>
                <hr>
                <? if (!empty($error)): ?>
                    <div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <h4>Ошибка сохранения!</h4>
                        <br/><?= $error ?>
                    </div>
                <? endif; ?>
                <form class="form" action="<?=  base_url('cms/mma/counter')?>" method="POST" enctype="multipart/form-data">
                    <label>Среднее число заявок в день</label>
		    <input type="number" name="mma_counter" class="input-madium" value="{mma_counter}">
		    <label>Случаянное отклонение</label>
		    <input type="number" name="mma_counter_rand" class="input-madium" value="{mma_counter_rand}">
                    <br /><br />
                    <button class="btn btn-primary save" type="submit" ><i class="icon-ok"></i> Сохранить</button>
                </form>
            </div>

        </div>

        <? require_once 'inc.footer.php'; ?> 

