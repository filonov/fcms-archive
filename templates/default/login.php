<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <title>Авторизация</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le styles -->
        <link href="<?= $cms_css ?>bootstrap.min.css" rel="stylesheet">
        <link href="<?= $cms_css ?>bootstrap-responsive.min.css" rel="stylesheet">
        <style type="text/css">
            body {
                padding-top: 40px;
                padding-bottom: 40px;
                background-color: #f5f5f5;
            }

            .form-signin {
                max-width: 300px;
                padding: 19px 29px 29px;
                margin: 0 auto 20px;
                background-color: #fff;
                border: 1px solid #e5e5e5;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                border-radius: 5px;
                -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
            }
            .form-signin .form-signin-heading,
            .form-signin .checkbox {
                margin-bottom: 10px;
            }
            .form-signin input[type="text"],
            .form-signin input[type="password"] {
                font-size: 16px;
                height: auto;
                margin-bottom: 15px;
                padding: 7px 9px;
            }

        </style>

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <link rel="shortcut icon" href="../assets/ico/favicon.png">
    </head>

    <body>

        <div class="container">
           
            
            <div class="form-signin">

                <!-- Login form (not working)-->
                <form class="form-horizontal" name="login" id="login" action="<?= $base ?>login" method="POST">
                    <h2 class="form-signin-heading">Авторизация</h2>
                    <!-- Password -->
                    <div class="control-group">

                      
                            <input type="password" name="password" class="input-block-level" placeholder="Пароль">
                     
                    </div>

                    <!-- Buttons -->
                    
                        <!-- Buttons -->
                        <button type="submit" class="btn btn-large btn-primary">Войти</button>
                        <button type="reset" class="btn btn-large">Сброс</button>
              
                </form>

            </div>     

        </div> <!-- /container -->

    </body>
</html>
