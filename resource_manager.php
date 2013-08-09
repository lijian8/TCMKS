<?php
include_once ("./header.php");
include_once ("./resource_helper.php");
require_once('appvars.php');
$managing_subject = 'resource';
if (isset($_GET['deleted_file'])) {

    $deleted_file = get_title_by_id($dbc, $_GET['deleted_file']);

    delete_resource($dbc, $_GET['deleted_file']);

    echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>';
    echo '文献"' . $deleted_file . '"已被删除!</div>';
}
?>
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
                        <a class="brand" href="#">文献管理</a>
                        <div class="nav-collapse collapse navbar-responsive-collapse">
                            <ul class="nav">

                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">录入文献 <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="upload_file.php?action=create&type=期刊文献">录入期刊文献</a></li>
                                        <li><a href="upload_file.php?action=create&type=会议文献">录入会议文献</a></li>
                                        <li><a href="upload_file.php?action=create&type=指南">录入指南</a></li>
                                        <li><a href="upload_file.php?action=create">录入其他资源</a></li>
                                    </ul>
                                </li>

                                <li><a href="#">删除文献</a></li>
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
                                <input type="text" class="search-query" placeholder="请搜索文献">
                                <button type="submit" class="btn-link"><i class="icon-search"></i></button>
                            </form>
                            <ul class="nav pull-right">
                                <li><a  href="#"><i class="icon-home"></i>返回首页</a></li>

                            </ul>
                        </div><!-- /.nav-collapse -->
                    </div>
                </div><!-- /navbar-inner -->
            </div><!-- /navbar -->



            <table class="table table-hover">
                <tbody>
                    <tr class="info">
                        <td>#</td>
                        <td width = "8%"><strong>创建者</strong></td>
                        <td width = "8%"><strong>题名</strong></td>
                        <td width = "8%"><strong>类型</strong></td>
                        <td width = "8%"><strong>出处</strong></td>
                        <td width = "8%"><strong>主题</strong></td>
                        <td width = "15%"><strong>上传时间</strong></td> 
                        <td width = "40%"><strong>操作</strong></td>

                    </tr>

                    <?php
                    $query = "SELECT * FROM resource ORDER BY title ASC";
                    $data = mysqli_query($dbc, $query);

                    $row_num = 1;
                    $color = true;
                    while ($row = mysqli_fetch_array($data)) {
                        if ($color) {
                            echo '<tr>';
                        } else {
                            echo '<tr class="info">';
                        }
                        $color = !$color;
                        echo '<td width = "3%">' . $row_num++ . '</td>';
                        echo '<td width = "15%">' . $row['creator'] . '</td>';

                        echo '<td width = "20%">' . $row['title'] . '</td>';
                        echo '<td width = "5%">' . $row['type'] . '</td>';

                        echo '<td width = "20%">' . $row['source'] . '</td>';
                        echo '<td width = "10%">' . $row['subject'] . '</td>';

                        echo '<td width = "10%">' . $row['create_time'] . '</td>';
                        $file_name = iconv('utf-8', 'gb2312', $row['file']);
                        echo '<td width = "15%">';
                        echo '<a class="btn-link" href="upload_file.php?action=update&file_id=' . $row[id] . '"><i class="icon-edit"></i></a>';

                        if (is_file(GW_UPLOADPATH . $file_name)) {
                            echo '<a class="btn-link" href="' . GW_UPLOADPATH . $row['file'] . '"><i class="icon-download-alt"></i></a>';
                        }

                        $link_for_delete = $_SERVER['PHP_SELF'] . '?deleted_file=' . $row['id'];
                        echo '<a class="btn-link" href="' . $link_for_delete . '"><i class="icon-trash"></i></a></td></tr>';
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>
</div> 
<?php
include_once ("./foot.php");
?>