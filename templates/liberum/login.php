<? require_once 'inc_header.php'; ?>

<? require_once 'inc_menu.php'; ?>

<!-- Content strats -->

<div class="content">
    <div class="container">
        <div class="row">
            <div class="span12">

                <!-- Login starts -->

                <div class="logreg">
                    <div class="row">
                        <div class="span12">
                            <div class="logreg-page">
                                <h3>Войти в <span class="color">панель администратора</span></h3>                        
                                <hr />
                                <div class="form">

                                    <!-- Login form (not working)-->
                                    <form class="form-horizontal" name="login" id="login" action="<?= $base ?>login" method="POST">
                                        
                                        <!-- Password -->
                                        <div class="control-group">
                                           
                                            <div class="controls">
                                                <input type="password" name="password" class="input-large" placeholder="Пароль">
                                            </div>
                                        </div>
                                                                                                                  
                                        <!-- Buttons -->
                                        <div class="form-actions">
                                            <!-- Buttons -->
                                            <button type="submit" class="btn">Войти</button>
                                            <button type="reset" class="btn">Сброс</button>
                                        </div>
                                    </form>
                                   
                                </div>                           
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Login ends -->

            </div>
        </div>
    </div>
</div>   

<!-- Content ends --> 
<? require_once 'inc_footer.php'; ?>