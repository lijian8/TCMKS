<?php
include_once ("./header.php");
include_once ("./image_helper.php");
require_once('appvars.php');
require_once('connectvars.php');

function render_image($row) {
    echo '<li class="span3">';
    echo '<div class = "thumbnail">';
    echo '<img src="' . IMG_UPLOADPATH . $row['file'] . '"  alt="" /></p>';
    echo '<div class = "caption">';
    echo '<p><strong>' . $row['name'] . '.&nbsp;</strong>';
    echo $row['description'] . '</p>';
    echo '<a href="#"><i class="icon-edit"></i></a>';
    echo '&nbsp;&nbsp';
    /*
    echo '<a href="#"><i class="icon-plus"></i></a>';
    echo '&nbsp;&nbsp';*/
    echo '<a href="'.$_SERVER['PHP_SELF'].'?deleted_image_id='.$row['id'].'"><i class="icon-trash"></i></a>';
    echo '&nbsp;&nbsp';

    echo '</div></div></li>';
}

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (isset($_GET['deleted_image_id'])){
    delete_image($dbc, $_GET['deleted_image_id']);
}

if (isset($_POST['submit'])) {

    $name = $_POST['name'];

    $score = $_POST['score'];

    $discription = $_POST['discription'];

    if ($image_id = upload_image($dbc, $name, $score, $discription)) {
        echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>';
        echo '图片"' . get_image_name($dbc, $image_id) . '"已成功插入!</div>';
    }
}
?>
<script language="javascript" type="text/javascript">
    function popUpload()
    {
        $('#myModal').modal('show');
    }

</script>

<div class="container">
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
                        <li><a  href="javascript:popUpload();">上传图片</a></li>
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
                        <input type="text" class="search-query span4" placeholder="请搜索图片">
                        <button type="submit" class="btn-link"><i class="icon-search"></i></button>
                    </form>
                    <ul class="nav pull-right">
                        <li><a  href="#">返回首页</a></li>

                    </ul>
                </div><!-- /.nav-collapse -->
            </div>
        </div><!-- /navbar-inner -->
    </div><!-- /navbar -->
</div>
<div class="container">
    <div class="row-fluid">
<?php
$query = "SELECT * FROM `tcmks`.`images`";
//echo $query;
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
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <H3 id="myModalLabel"  >请上传图片：</H3>
    </div>
    <div id ="myContent" class="modal-body">
        <form enctype="multipart/form-data" class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

            <input type="hidden" name="segment_id" value="<?php echo $segment_id; ?>" />

            <div class="control-group" >
                <label class="control-label" for="file_id">图片题目:</label>
                <div class="controls" >
                    <input class="input-xlarge" type="text" placeholder="请输入图片题目" id="name" name="name" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="discription">图片说明:</label>
                <div class="controls">
                    <textarea class="input-xlarge" id="discription" name="discription" placeholder="请输入图片说明" rows="6"></textarea>
                </div>
            </div>
            <div class="control-group" >
                <label class="control-label" for="score">标签:</label>
                <div class="controls" >
                    <input class="input-xlarge" type="text" placeholder="请输入图片标签" id="score" name="score"  />
                </div>
            </div>
            <div class="control-group" >
                <label class="control-label" for="screenshot">上传图片:</label>
                <div class="controls" >
                    <input  type="file" id="screenshot" name="screenshot" />
                </div>
            </div>
            <div class="control-group" >
                <div class="controls" >
                    <input class="btn btn-primary" type="submit" value="确定" name="submit" />
                </div>
            </div>

        </form>        
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
    </div>
</div>
<?php
include_once ("./foot.php");
?>