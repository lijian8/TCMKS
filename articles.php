<?php
include_once ("./header.php");

include_once ("./article_helper.php");
include_once ("./users_helper.php");
include_once ("./messages.php");
$managing_subject = 'articles';
if (isset($_GET['delete'])) {
    delete_article($dbc, $_GET['delete']);
}

if (isset($_GET['recycle'])) {
    recycle_article($dbc, $_GET['recycle']);
}

if (isset($_GET['publish'])) {
    publish_article($dbc, $_GET['publish']);
}

if (isset($_GET['revoke'])) {
    revoke_article($dbc, $_GET['revoke']);
}

if (isset($_GET['delete_segment'])){
delete_segment($dbc, $_GET['delete_segment']);
}
?>
<p></p>
<!-- Subhead
================================================== -->
<div class="container">
    <div class="row-fluid">
        <div class="span2">
            <?php include_once ("manager_sidebar.php"); ?>
        </div><!--/span-->
        <div class="span10">
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="container">
                        <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </a>

                        <div class="nav-collapse collapse navbar-responsive-collapse">
                            <a class="brand" href="#">综述编审</a>
                            <ul class="nav">
                                <li><a  href="create_article.php"><i class="icon-plus-sign"></i>创建综述</a></li>                        
                            </ul>
                            <form class="navbar-search pull-left" action="">
                                <input type="text" class="search-query" placeholder="请搜索综述">
                                <button type="submit" class="btn-link"><i class="icon-search"></i></button>
                            </form>
                            <ul class="nav pull-right">
                                <li><a href="main.php"><i class="icon-home"></i>返回首页</a></li>                          

                            </ul>
                        </div><!-- /.nav-collapse -->
                    </div>
                </div><!-- /navbar-inner -->
            </div><!-- /navbar -->
            <div class="tabbable">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1" data-toggle="tab">我创建的综述</a></li>
                    <li><a href="#tab2" data-toggle="tab">编辑中的综述</a></li>
                    <li><a href="#tab3" data-toggle="tab">审核中的综述</a></li>
                    <li><a href="#tab4" data-toggle="tab">综述发表</a></li>
                    <li><a href="#tab_segment" data-toggle="tab">综述段落管理</a></li>        
                    <li><a href="#tab6" data-toggle="tab">回收站</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                        <?php
                        $role = 'creator';
                        $recycle = false;
                        include ("./article_table.php");
                        ?>
                    </div>
                    <div class="tab-pane" id="tab2">
                        <?php
                        $role = 'author';
                        $recycle = false;
                        include ("./article_table.php");
                        ?>
                    </div>
                    <div class="tab-pane" id="tab3">
                        <?php
                        $role = 'reviewer';
                        $recycle = false;
                        include ("./article_table.php");
                        ?>
                    </div>
                    <div class="tab-pane" id="tab4">
                        <?php
                        $role = 'publisher';
                        $recycle = false;
                        include ("./article_table.php");
                        ?>
                    </div>
                    <div class="tab-pane" id="tab_segment">
                        <?php
                        include ("./segment_table.php");
                        ?>
                    </div>                    
                    <div class="tab-pane" id="tab6">
                        <?php
                        $role = 'creator';
                        $recycle = true;
                        include ("./article_table.php");
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include_once ("./foot.php");
?>
       
