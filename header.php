<?php
require_once('connectvars.php');

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die('Error connecting to MySQL server.');

session_name('tzLogin');
// Starting the session
session_start();

if (isset($_GET['logoff'])) {
    $_SESSION = array();
    session_destroy();

    header("Location: demo.php");
    exit;
}


if (!isset($_SESSION['real_name']) || !isset($_SESSION['usr']) || !isset($_SESSION['id'])) {
    header("Location: demo.php");
    exit;
}
?>
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>您好， <?php echo $_SESSION['real_name'] ? $_SESSION['real_name'] : '访客'; ?>!</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <script src="./ckeditor/ckeditor.js"></script>
        <link rel="stylesheet" href="./treeview/jquery.treeview.css" />
        <link rel="stylesheet" href="./treeview/screen.css" />
        <link rel="stylesheet" href="ckeditor/samples/sample.css">
        <!-- Le styles -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <style type="text/css">
           
            
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
            .sidebar-nav {
                padding: 9px 0;
            }

            @media (max-width: 980px) {
                /* Enable use of floated navbar text */
                .navbar-text.pull-right {
                    float: none;
                    padding-left: 5px;
                    padding-right: 5px;
                }
            }
        
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/docs.css" rel="stylesheet">
    <link href="css/prettify.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/ico/favicon.png">

    <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-146052-10']);
        _gaq.push(['_trackPageview']);
        (function() {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();
    </script>

</head>

<body style="font-family:微软雅黑">

    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <div class="nav-collapse collapse">
                    <ul class="nav">
                        <li><a class="brand" href="main.php">中医药知识服务平台</a></li>
                        <li  class="active"><a href="main.php">主页</a></li>


                        <li><a href="navigator.php">知识检索</a></li>

                        <li><a href="articles.php">综述编审</a></li>

                        <li><a href="experts.php">领域专家</a></li>


                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">管理<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="resource_manager.php">文献</a></li>
                                <li><a href="image_manager.php">图片</a></li> 
                                <li><a href="me.php">我的信息</a></li> 
                            </ul>
                        </li>
                        <li><a href="about.php">帮助</a></li>
                        <li><a href="about.php">关于我们</a></li>

                    </ul>
                    <?php
                    if ($_SESSION['real_name']) {
                        echo '您好,' . $_SESSION['real_name'];

                        echo "<p class=\"navbar-text pull-right\">您好," . $_SESSION['real_name'] . "&nbsp;|&nbsp;" . "<a href=\"?logoff\" class=\"navbar-link\">退出</a></p>";
                    } else {
                        ?>
                        <form class="navbar-form pull-right">
                            <input class="span2" type="text" placeholder="用户名">
                            <input class="span2" type="password" placeholder="密码">
                            <button type="submit" class="btn">登录</button>
                        </form>
    <?php
}
?>

                </div><!--/.nav-collapse -->
            </div>
        </div>
    </div>

