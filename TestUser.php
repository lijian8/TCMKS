<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        session_name('tzLogin');
        // Starting the session
        session_start();
        
        echo 'user:'.$_SESSION['usr'].'<br>';
        echo '实名:'.$_SESSION['real_name'].'<br>';
        echo 'id:'.$_SESSION['id'].'<br>';
        echo 'rememberMe:'.$_SESSION['rememberMe'].'<br>';
        ?>
    </body>
</html>
