<?php
        session_name('tzLogin');
        // Starting the session
        session_start();
 
       
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
        <link rel="stylesheet" href="ckeditor/samples/sample.css">
        <!-- Le styles -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <style type="text/css">
            body {
                padding-top: 60px;
                padding-bottom: 40px;
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

    <body>

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
                            <li><a class="brand" href="#">中医药知识服务平台</a></li>
                            <li><a href="#about">查看</a></li>
                            <li class="active"><a href="#contact">编审</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">管理 <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">用户管理</a></li>
                                    <li><a href="#">主题分类</a></li>                                    
                                </ul>
                            </li>
                            <li><a href="#contact">帮助</a></li>
                            <li><a href="#contact">关于我们</a></li>

                        </ul>
                        <form class="navbar-form pull-right">
                            <input class="span2" type="text" placeholder="用户名">
                            <input class="span2" type="password" placeholder="密码">
                            <button type="submit" class="btn">登录</button>
                        </form>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>

