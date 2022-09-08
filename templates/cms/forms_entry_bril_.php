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
                                <td>Тип мероприятия:</td><td><?= $item->field01?></td>
                            </tr>
                            <tr>
                                <td>Описание:</td><td><?= $item->field03 ?></td>
                            </tr>
                            <tr>
                                <td>Количество человек:</td><td><?= $item->field02 ?></td>
                            </tr>
                            <tr>
                                <td>Комментарий:</td><td><?= $item->exp ?></td>
                            </tr>
                        </tbody>
                    </table>

            </div>

        </div>

      <? require_once 'inc.footer.php';?>

