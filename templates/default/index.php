<? require_once 'inc_header.php'; ?>
<? /**
 *  Это шаблон главной страницы. Контроллер не выводит сюда ничего, всё выводится 
 *  исключительно хелпером блоков с собственными шаблонами. Обычно на главной текст из модуля и виджеты.
 */ ?>

<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="hero-unit">
                <h1>
                    <?=$site_title?>
                </h1>
                <p>
                    <?=  block_module('primer' /*, $template*/)?>
                    <?// В блоке задаётся алиас модуля из админки и шаблон, по умолчанию одноимённый ?>
                </p>
              
            </div>
            <div class="row-fluid">
                <div class="span8">
                    <?= block_page_content(2)?>
                    <?// В блоке задаётся id статической страницы из админки и шаблон, по умолчанию одноимённый ?>
                </div>
                <div class="span4">
                    <b>Меню</b>
                    <?= block_menu()?>
                    <b>Виджет контента</b>
                </div>
            </div>
        </div>
    </div>
</div>

<? require_once 'inc_footer.php'; ?>