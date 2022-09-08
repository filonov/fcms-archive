<? require_once 'inc.header.php'; ?>

<body>
    <? require_once 'inc.menu.php'; ?>

    <div class="container">

        <div class="row">           
            <div class="span12">
                <h2>Редактируем файл конфигурации</h2>
                <div class="alert alert-error">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Внимание!</strong> Любая ошибка в данном файле может привести к полной неработоспособности 
                    сайта. Вы должны точно знать, что и зачем делаете, прежде чем редактировать конфигурацию.
                </div>
                <? if (!empty($error)): ?>
                    <div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <h4>Ошибка сохранения!</h4>
                        <br/><?= $error ?>
                    </div>
                <? endif; ?>
                <form class="form-horizontal" action="{base}cms/configuration" method="POST">
                    <label>cms.php:</label>
                    <textarea style="width: 100%; height: 500px; padding: 0; margin: 0;" id="text" name="text">{text}</textarea>
                    <br /><br />
                    <button class="btn btn-primary save" type="submit" ><i class="icon-ok"></i> Сохранить</button>
                </form>
            </div>

        </div>

       <? require_once 'inc.footer.php'; ?> 


