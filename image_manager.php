<?php
include_once ("./header.php");
include_once ("./image_helper.php");
require_once('appvars.php');
require_once('connectvars.php');
$managing_subject = 'image';

function render_image($row) {
    echo '<li class="span3">';
    echo '<div class = "thumbnail">';
    echo '<div align = "right"><a href="' . $_SERVER['PHP_SELF'] . '?deleted_image_id=' . $row['id'] . '"><i class="icon-remove-sign"></i></a></div>';
    echo '<img src="' . IMG_UPLOADPATH . $row['file'] . '"  alt="" /></p>';
    echo '<div class = "caption">';
    echo '<p><strong><a href="javascript:popUpload(\'' . $row['id'] . '\');">'. $row['name']. '</a>&nbsp;</strong>';
    echo $row['description'] . '</p>';
    echo '&nbsp;&nbsp';
    /*
      echo '<a href="#"><i class="icon-plus"></i></a>';
      echo '&nbsp;&nbsp'; */
    //echo '<a href="' . $_SERVER['PHP_SELF'] . '?deleted_image_id=' . $row['id'] . '"><i class="icon-trash"></i></a>';
    echo '&nbsp;&nbsp';

    echo '</div></div></li>';
}

if (isset($_GET['deleted_image_id'])) {
    delete_image($dbc, $_GET['deleted_image_id']);
}

if (isset($_POST['submit'])) {

    $image_id = $_POST['image_id'];

    $name = $_POST['name'];

    $subject = $_POST['subject'];

    $description = $_POST['description'];

    if ($image_id = update_image($dbc, $image_id, $name, $subject, $description)) {
        echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>';
        echo '图片"' . $name . '"的信息已成功录入!</div>';
    }
}
?>
<script language="javascript" type="text/javascript">
    function popUpload(str)
    {
        if (str.length == 0)
        {
            document.getElementById("myContent").innerHTML = "没有可展示的东西！";
            document.getElementById("myContent").style.border = "0px";
            return;
        }
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById("myContent").innerHTML = xmlhttp.responseText;
                document.getElementById("myContent").style.border = "1px solid #A5ACB2";
                $('#myModal').modal('show');
            }
        }


        xmlhttp.open("GET", "image_upload_service.php?id=" + str, true);

        xmlhttp.send();
        //$('#myModal').modal('show');
    }

</script>
<p></p>
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
                        <a class="brand" href="#">图片管理</a>
                        <div class="nav-collapse collapse navbar-responsive-collapse">
                            <ul class="nav">
                                <li><a  href="javascript:popUpload('new');">上传图片</a></li>
                                <li><a href="#">删除图片</a></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">标签 <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">添加标签</a></li>
                                        <li><a href="#">修改标签</a></li>
                                        <li><a href="#">删除标签</a></li>

                                    </ul>
                                </li>


                            </ul>
                            <form class="navbar-search pull-left" action="">
                                <input type="text" class="search-query" placeholder="请搜索图片">
                                <button type="submit" class="btn-link"><i class="icon-search"></i></button>
                            </form>
                            <ul class="nav pull-right">
                                <li><a  href="#"><i class="icon-home"></i>返回首页</a></li>

                            </ul>
                        </div><!-- /.nav-collapse -->
                    </div>
                </div><!-- /navbar-inner -->
            </div><!-- /navbar -->


            <div class="row-fluid">
                <?php
                $user_id = $_SESSION[id];
                $query = "SELECT * FROM `tcmks`.`images` WHERE user_id = $user_id";

                $result = mysqli_query($dbc, $query) or die('Error querying database.');
                while ($row = mysqli_fetch_array($result)) {

                    echo '<ul class = "thumbnails">';
                    render_image($row);
                    if ($row = mysqli_fetch_array($result))
                        render_image($row);
                    if ($row = mysqli_fetch_array($result))
                        render_image($row);
                    if ($row = mysqli_fetch_array($result))
                        render_image($row);
                    echo '</ul>';
                }
                ?>
            </div>

        </div>
    </div>
</div>
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <H3 id="myModalLabel"  >图片信息录入：</H3>
    </div>
    <div id ="myContent" class="modal-body">          
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
    </div>
</div>
<?php
include_once ("./foot.php");
?>