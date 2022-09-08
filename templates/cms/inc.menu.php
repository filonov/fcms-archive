<div class="navbar navbar-fixed-top navbar-inverse">
    <div class="navbar-inner">
        <div class="container">
            <a class="brand" href="{base}cms">Панель администратора</a>
            <ul class="nav">
                <li><a href="{base}cms/menu">Меню</a></li>
                <li><a href="{base}cms/pages">Страницы</a></li>
                <li><a href="{base}cms/modules">Модули</a></li>
                <li><a href="{base}cms/emails">Рассылки</a></li>
                <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Контент</a>
                    <ul class="dropdown-menu">
                        <li><a href="{base}cms/categoryes">Категории</a></li>
                        <li><a href="{base}cms/content">Статьи</a></li>   
			<li><a href="{base}cms/showcase">Витрина</a></li>  
                        <li class="divider"></li> 
                        <li><a href="{base}cms/content/add">Новая статья...</a></li> 
                    </ul>
                </li>
		<? if (FCMS_PROJECT != 'mma'):?>
                <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Галереи</a>
                    <ul class="dropdown-menu">
                        <li><a href="{base}cms/categoryes/30">Категории</a></li>
                        <li><a href="{base}cms/galleryes">Изображения</a></li>                          
                    </ul>
                </li>
		<? endif; ?>
		<? if ((FCMS_PROJECT == 'liberum') || (FCMS_PROJECT == 'hygiene-at-nature') || (FCMS_PROJECT == 'garsia')):?>
                <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Магазин</a>
                    <ul class="dropdown-menu">
                        <li><a href="{base}cms/categoryes/20">Категории</a></li>
                        <li><a href="{base}cms/catalog">Каталог</a></li>  
                        <li><a href="{base}cms/orders">Заказы</a></li>
			<li class="divider"></li> 
                        <li><a href="{base}cms/catalog/add">Новый товар...</a></li> 
                    </ul>
                </li>
		<? endif; ?>
		<? if (FCMS_PROJECT == 'liberum'):?>
                <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Тестирование</a>
                    <ul class="dropdown-menu">
                        <li><a href="{base}cms/testing">Тесты</a></li>
                        <li class="divider"></li> 
                        <li><a href="{base}cms/testing/add">Новый тест...</a></li> 
                    </ul>
                </li>
		<? endif;?>
		<? if(FCMS_PROJECT == 'mma'):?>
		<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">MMA</a>
                    <ul class="dropdown-menu">
                        <li><a href="{base}cms/mma/marks">Марки</a></li>
			<li><a href="{base}cms/mma/models">Модели</a></li>
			<li><a href="{base}cms/mma/regions">Регионы</a></li>
                        <li class="divider"></li> 
			<li><a href="{base}cms/mma/forms">Заявки</a></li>
			<li class="divider"></li> 
			<li><a href="{base}cms/mma/counter">Счётчик</a></li>
                    </ul>
                </li>
		<? endif;?>
		<? if(FCMS_PROJECT == 'liberum'):?>
                <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Учебный процесс</a>
                    <ul class="dropdown-menu">
                        <li><a href="{base}cms/groups/italiano">Группы итальянского</a></li>
                        <li><a href="{base}cms/groups/espanol">Группы испанского</a></li>
                        <li><a href="{base}cms/forms">Анкеты</a></li>
                        <li class="divider"></li> 
                        <li><a href="{base}cms/specials/italiano">Спецкурсы итальянского</a></li>
                        <li><a href="{base}cms/specials/espanol">Спецкурсы испанского</a></li>
                        <li class="divider"></li> 
                        <li><a href="{base}cms/references/levels">Уровни</a></li>
                        <li><a href="{base}cms/references/programs">Программы обучения</a></li>
                        <li><a href="{base}cms/references/textbooks">Учебные пособия</a></li>
                        <li><a href="{base}cms/references/statuses">Статусы групп</a></li>
                        <li><a href="{base}cms/teachers">Преподаватели</a></li>
                        <li><a href="{base}cms/references/formats">Форматы обучения</a></li>
                        <li><a href="{base}cms/references/durations">Продолжительность обучения</a></li>
                        <?// <li><a href="{base}cms/references/tests">Тесты</a></li> ?>
                        <li><a href="{base}cms/references/prices">Стоимость обучения</a></li>    
                    </ul>    
                </li>
		<? endif; ?>
                <li><a href="{base}cms/configuration"><i class="icon-wrench icon-white"></i></a></li>
            </ul>  
        </div>
    </div>
</div>