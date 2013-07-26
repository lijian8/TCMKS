<?php
define('INCLUDE_CHECK', true);

require 'connect.php';
require 'functions.php';
// Those two files can be included only if INCLUDE_CHECK is defined


session_name('tzLogin');
// Starting the session

session_set_cookie_params(2 * 7 * 24 * 60 * 60);
// Making the cookie live for 2 weeks

session_start();

if ($_SESSION['id'] && !isset($_COOKIE['tzRemember']) && !$_SESSION['rememberMe']) {
    // If you are logged in, but you don't have the tzRemember cookie (browser restart)
    // and you have not checked the rememberMe checkbox:

    $_SESSION = array();
    session_destroy();

    // Destroy the session
}


if (isset($_GET['logoff'])) {
    $_SESSION = array();
    session_destroy();

    header("Location: demo.php");
    exit;
}

if ($_POST['submit'] == '登录') {
    // Checking whether the Login form has been submitted

    $err = array();
    // Will hold our errors


    if (!$_POST['username'] || !$_POST['password'])
        $err[] = '请补全信息!';

    if (!count($err)) {
        $_POST['username'] = mysql_real_escape_string($_POST['username']);
        $_POST['password'] = mysql_real_escape_string($_POST['password']);
        $_POST['rememberMe'] = (int) $_POST['rememberMe'];

        // Escaping all input data

        $row = mysql_fetch_assoc(mysql_query("SELECT id,usr,real_name FROM users WHERE usr='{$_POST['username']}' AND pass='" . md5($_POST['password']) . "'"));

        if ($row['usr']) {
            // If everything is OK login

            $_SESSION['usr'] = $row['usr'];
            $_SESSION['id'] = $row['id'];
            $_SESSION['real_name'] = $row['real_name'];
            
            $_SESSION['rememberMe'] = $_POST['rememberMe'];

            // Store some data in the session

            setcookie('tzRemember', $_POST['rememberMe']);
        }
        else
            $err[] = '错误的用户名和/或密码!';
    }

    if ($err)
        $_SESSION['msg']['login-err'] = implode('<br />', $err);
    // Save the error messages in the session

    header("Location: demo.php");
    exit;
}
else if ($_POST['submit'] == '注册') {
    // If the Register form has been submitted
    echo "<script type='text/javascript'>alert(1111111);</script>";  
    $err = array();

    if (strlen($_POST['username']) < 4 || strlen($_POST['username']) > 32) {
        $err[] = '用户名必须在3到32个字符之间!';
    }

    if (preg_match('/[^a-z0-9\-\_\.]+/i', $_POST['username'])) {
        $err[] = '您的用户名含有无效字符!';
    }

    if (!count($err)) {
        // If there are no errors
        // Generate a random password

        $_POST['real_name'] = mysql_real_escape_string($_POST['real_name']);
        $_POST['username'] = mysql_real_escape_string($_POST['username']);
        $_POST['pass'] = mysql_real_escape_string($_POST['pass']);

        // Escape the input data
        echo 'registering';

        mysql_query("	INSERT INTO users(usr,pass,real_name,regIP,dt)
						VALUES(
						
							'" . $_POST['username'] . "',
							'" . md5($_POST['pass']) . "',
							'" . $_POST['real_name'] . "',
							'" . $_SERVER['REMOTE_ADDR'] . "',
							NOW()
							
						)");

        if (mysql_affected_rows($link) == 1) {
            $_SESSION['msg']['reg-success'] = '注册成功!';
        }
        else
            $err[] = '该用户名已被使用!';
    }

    if (count($err)) {
        $_SESSION['msg']['reg-err'] = implode('<br />', $err);
    }

    header("Location: demo.php");
    exit;
}

$script = '';

if ($_SESSION['msg']) {
    // The script below shows the sliding panel on page load

    $script = '
	<script type="text/javascript">
	
		$(function(){
		
			$("div#panel").show();
			$("#toggle a").toggle();
		});
	
	</script>';
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>中医药知识服务平台</title>

        <link rel="stylesheet" type="text/css" href="demo.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="login_panel/css/slide.css" media="screen" />
        <!--
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
        -->
        <script type="text/javascript" src="./js/jquery.min.js"></script>
        <!-- PNG FIX for IE6 -->
        <!-- http://24ways.org/2007/supersleight-transparent-png-in-ie6 -->
        <!--[if lte IE 6]>
            <script type="text/javascript" src="login_panel/js/pngfix/supersleight-min.js"></script>
        <![endif]-->

        <script src="login_panel/js/slide.js" type="text/javascript"></script>

        <?php echo $script; ?>
        <style type="text/css">
            .container_button{
                margin-top:20px;
                width:20%;
                background:#008de6;
                border:1px solid #E0E0E0;
                padding:15px;
                
                /* Rounded corners */
                -moz-border-radius:20px;
                -khtml-border-radius: 20px;
                -webkit-border-radius: 20px;
                border-radius:20px;
            }
        </style>




    </head>

    <body>

        <!-- Panel -->
        <div id="toppanel">
            <div id="panel">
                <div class="content clearfix">
                    <div class="left">
                        <h1>注册或登录</h1>
                        <h2>注册</h2>		
                        <p class="grey">请输入完整的注册信息!</p>
                        <h2>实名制</h2>
                        <p class="grey">请输入您的真实姓名.</p>
                    </div>


                    <?php
                    if (!$_SESSION['id']):
                        ?>

                        <div class="left">
                            <!-- Login Form -->
                            <form class="clearfix" action="" method="post">
                                <h1>登录</h1>

                                <?php
                                if ($_SESSION['msg']['login-err']) {
                                    echo '<div class="err">' . $_SESSION['msg']['login-err'] . '</div>';
                                    unset($_SESSION['msg']['login-err']);
                                }
                                ?>

                                <label class="grey" for="username">用户:</label>
                                <input class="field" type="text" name="username" id="username" value="" size="23" />
                                <label class="grey" for="password">密码:</label>
                                <input class="field" type="password" name="password" id="password" size="23" />
                                <label><input name="rememberMe" id="rememberMe" type="checkbox" checked="checked" value="1" /> &nbsp;记住我</label>
                                <div class="clear"></div>
                                <input type="submit" name="submit" value="登录" class="bt_login" />
                            </form>
                        </div>
                        <div class="left right">			
                            <!-- Register Form -->
                            <form action="" method="post">
                                <h1>还不是用户吗? 请注册!</h1>		

                                <?php
                                if ($_SESSION['msg']['reg-err']) {
                                    echo '<div class="err">' . $_SESSION['msg']['reg-err'] . '</div>';
                                    unset($_SESSION['msg']['reg-err']);
                                }

                                if ($_SESSION['msg']['reg-success']) {
                                    echo '<div class="success">' . $_SESSION['msg']['reg-success'] . '</div>';
                                    unset($_SESSION['msg']['reg-success']);
                                }
                                ?>

                                <label class="grey" for="username">用户名:</label>
                                <input class="field" type="text" name="username" id="username" value="" size="23" />
                                <label class="grey" for="password">密码:</label>
                                <input class="field" type="password" name="pass" id="pass" size="23" />	
                                <label class="grey" for="real_name">真实姓名:</label>
                                <input class="field" type="text" name="real_name" id="real_name" size="23" />	
                                <input type="submit" name="submit" value="注册" class="bt_register" />


                            </form>
                        </div>

                        <?php
                    else:
                        ?>

                        <div class="left">

                            <h1>您好， <?php echo $_SESSION['real_name'] ? $_SESSION['real_name'] : '访客'; ?>!</h1>

                            <p>您已经成功登录</p>
                            <a href="registered.php">请查看并编辑您的信息</a>
                            <p>- 或 -</p>
                            <a href="?logoff">注销</a>

                        </div>

                        <div class="left right">
                        </div>

                    <?php
                    endif;
                    ?>
                </div>
            </div> <!-- /login -->	

            <!-- The tab on top -->	
            <div class="tab">
                <ul class="login">
                    <li class="left">&nbsp;</li>
                    <li>您好， <?php echo $_SESSION['real_name'] ? $_SESSION['real_name'] : '访客'; ?>!</li>
                    <li class="sep">|</li>
                    <li id="toggle">
                        <a id="open" class="open" href="#"><?php echo $_SESSION['id'] ? '打开' : '登录 | 注册'; ?></a>
                        <a id="close" style="display: none;" class="close" href="#">关闭</a>			
                    </li>
                    <li class="right">&nbsp;</li>
                </ul> 
            </div> <!-- / top -->

        </div> <!--panel -->

        <div class="pageContent">
            <div id="main">
                <div class="container">
                    <img width ="100%" src ="img/stripe.jpg"></img>                    
                </div>

                <div class="container">

                    <p><strong>简介：</strong>目前，在我国尚未出现类似于UpToDate的知识服务平台。循证知识服务平台在中医药领域中尚处于空白状态。
                        需要借鉴UpToDate等系统的成功经验，开发面向中医药领域的循证知识服务平台。
                        该项目针对乙型肝炎，总结出10个针对临床科研人员的专业临床问题、2个针对普通大众的普通问题以及1个针对医药机构的问题，
                        进行系统全面的证据检索和的收集，撰写并发布系统综述。为此，需要进行中医药循证医学证据知识服务平台的构建，实现综述知识的发布与管理，
                        并实现综述与结构性知识的关联、综述内容检索、全文链接等功能。
                    </p>
                    <div align="center"><div class="container_button">
                        <a href="main.php"><font face="微软雅黑" color="white">进入系统</font></a>
                    </div></div>
                    
                    <div class="clear"></div>
                </div>

                <div class="container tutorial-info">
                    <p><a href="yutong" target="_blank">于彤</a>设计</p>
                    <p>© 中国中医科学院中医药信息研究所</p>
                </div>
            </div>

    </body>
</html>
