<?php
include_once ("./header.php");
include_once ("./rights.php");
?>
<p></p>
<!-- Subhead
================================================== -->
<div class="container">
    <div class="navbar">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <a class="brand" href="#">综述编审</a>
                <div class="nav-collapse collapse navbar-responsive-collapse">
                    <ul class="nav">
                        <li><a  href="create_article.php">创建综述</a></li>



                        <li><a href="#">删除综述</a></li>
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
                        <input type="text" class="search-query span4" placeholder="请搜索综述">
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
    <?php
    if (has_article($dbc, $_SESSION['id'])) {
        ?>
        <table class="table table-hover">
            <tbody>
                <tr class="info">
                    <td>#</td>
                    <td width = "6%"><strong>创建者</strong></td>
                    <td width = "6%"><strong>作者</strong></td>                           
                    <td width = "6%"><strong>评审</strong></td>
                    <td width = "6%"><strong>发布者</strong></td>
                    <td width = "15%"><strong>题目</strong></td> 
                    <td width = "40%"><strong>摘要</strong></td>
                    <td width = "10%"><strong>创建时间</strong></td>
                    <td width = "10%"><strong>操作</strong></td>
                </tr>
                <?php

                function get_abstract($dbc, $article_id, $segment_id) {

                    $query = "SELECT content FROM segment where article_id=$article_id and id = $segment_id";
                    $result = mysqli_query($dbc, $query) or die('Error querying database3.');
                    $row = mysqli_fetch_array($result);
                    return $row['content'];
                }

                function getUsers($dbc, $article_id, $role) {
                    $query = "SELECT * FROM `tcmks`.`authorship` as t1, `tcmks`.`users` as t2 where t1.author_id = t2.id and article_id = $article_id and role = '$role'";

                    $result = mysqli_query($dbc, $query) or die('Error querying database3.');
                    $s = "";
                    while ($row = mysqli_fetch_array($result)) {
                        $s .= $row['real_name'] . "&nbsp;";
                    }
                    //echo $query.$s;
                    return $s;
                }

                function delete_article($dbc, $article_id, $abstract) {
                    $query = "DELETE FROM article WHERE id = '$article_id'";
                    mysqli_query($dbc, $query);
                    $query = "DELETE FROM authorship WHERE article_id = '$article_id'";
                    mysqli_query($dbc, $query);
                    $query = "DELETE FROM segment WHERE id = '$abstract'";
                    mysqli_query($dbc, $query);
                }

                if (isset($_GET['delete'])) {
                    delete_article($dbc, $_GET['delete'], $_GET['abstract']);
                }

                $query = "SELECT * FROM article";
                $result = mysqli_query($dbc, $query) or die('Error querying database.');
                //echo '<ul>';

                $row_num = 1;
                $color = true;
                while ($row = mysqli_fetch_array($result)) {

                    if (!has_right_to_edit($dbc, $_SESSION['id'], $row[id]))
                        continue;

                    if ($color) {
                        echo '<tr>';
                    } else {
                        echo '<tr class="info">';
                    }
                    $color = !$color;
                    echo '<td>' . $row_num++ . '</td>';
                    echo '<td>' . getUsers($dbc, $row[id], 'creator') . '</td>';
                    echo '<td>' . getUsers($dbc, $row[id], 'author') . '</td>';
                    echo '<td>' . getUsers($dbc, $row[id], 'reviewer') . '</td>';
                    echo '<td>' . getUsers($dbc, $row[id], 'publisher') . '</td>';

                    // $first_name = $row['first_name'];
                    // $last_name = $row['last_name'];
                    // $msg = "Dear $first_name $last_name,\n$text";


                    echo '<td>' . $row['title'] . '</td>';
                    //echo '<td>' . $row['abstract'] . '</td>';
                    $row['segments'];
                    $segments = explode('|', $row['segments']);

                    echo '<td>' . get_abstract($dbc, $row['id'], $segments[1]) . '</td>';
                    echo '<td>' . $row['create_time'] . '</td>';




                    echo '<td><a class="btn" href="article.php?id=' . $row['id'] . '"><i class="icon-edit"></i></a>';


                    echo '<a class="btn" href="' . $_SERVER['PHP_SELF'] . '?delete=' . $row['id'] . '&abstract=' . $segments[1] . '"><i class="icon-trash"></i></a></td></tr>';
                }

                ?>
            </tbody>
        </table>
        <?php
    } else {
        ?>  
        <div class = "alert">
            <button type = "button" class = "close" data-dismiss = "alert">&times;
            </button>
            没有可编审的综述！您可以创建新的综述。
        </div>
        <?php
    }
    ?>
</div>

<!--
<div class="container"> 
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1" data-toggle="tab">综述文章</a></li>
            <li><a href="#tab2" data-toggle="tab">文献资源</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="tab1">                        
                <a class="btn btn-primary" href="create_article.php">创建综述</a>
                <p></p>
                <table class="table table-hover">
                    <tbody>
                        <tr class="info">
                            <td>#</td>
                            <td width = "6%"><strong>创建者</strong></td>
                            <td width = "6%"><strong>作者</strong></td>                           
                            <td width = "6%"><strong>评审</strong></td>
                            <td width = "6%"><strong>发布者</strong></td>
                            <td width = "15%"><strong>题目</strong></td> 
                            <td width = "40%"><strong>摘要</strong></td>
                            <td width = "10%"><strong>创建时间</strong></td>
                            <td width = "10%"><strong>操作</strong></td>
                        </tr>
                        

                        function get_abstract($dbc, $article_id, $segment_id) {

                            $query = "SELECT content FROM segment where article_id=$article_id and id = $segment_id";
                            $result = mysqli_query($dbc, $query) or die('Error querying database3.');
                            $row = mysqli_fetch_array($result);
                            return $row['content'];
                        }

                        function getUsers($dbc, $article_id, $role) {
                            $query = "SELECT * FROM `tcmks`.`authorship` as t1, `tcmks`.`users` as t2 where t1.author_id = t2.id and article_id = $article_id and role = '$role'";

                            $result = mysqli_query($dbc, $query) or die('Error querying database3.');
                            $s = "";
                            while ($row = mysqli_fetch_array($result)) {
                                $s .= $row['real_name'] . "&nbsp;";
                            }
                            //echo $query.$s;
                            return $s;
                        }

                        $dbc = mysqli_connect('localhost', 'tcmks', 'tcmks', 'tcmks') or die('Error connecting to MySQL server.');

                        $query = "SELECT * FROM article";
                        $result = mysqli_query($dbc, $query) or die('Error querying database.');
                        //echo '<ul>';

                        $row_num = 1;
                        $color = true;
                        while ($row = mysqli_fetch_array($result)) {
                            if ($color) {
                                echo '<tr>';
                            } else {
                                echo '<tr class = "info">';
                            }
                            $color = !$color;
                            echo '<td>' . $row_num++ . '</td>';
                            echo '<td>' . getUsers($dbc, $row[id], 'creator') . '</td>';
                            echo '<td>' . getUsers($dbc, $row[id], 'author') . '</td>';
                            echo '<td>' . getUsers($dbc, $row[id], 'reviewer') . '</td>';
                            echo '<td>' . getUsers($dbc, $row[id], 'publisher') . '</td>';

                            // $first_name = $row['first_name'];
                            // $last_name = $row['last_name'];
                            // $msg = "Dear $first_name $last_name,\n$text";


                            echo '<td>' . $row['title'] . '</td>';
                            //echo '<td>' . $row['abstract'] . '</td>';
                            echo '<td>' . get_abstract($dbc, $row['id'], $row['first']) . '</td>';
                            echo '<td>' . $row['create_time'] . '</td>';




                            echo '<td><a class = "btn" href = "article.php?id=' . $row['id'] . '"><i class = "icon-edit"></i></a>';
                            echo '<a class = "btn" href = "create_article.html"><i class = "icon-trash"></i></a></td></tr>';
                        }

                        mysqli_close($dbc);
                        ?>
                    </tbody>
                </table>

            </div>

            <div class="tab-pane" id="tab2">
                <a class="btn btn-primary" href="upload_file.php">录入文献</a>
                <p>

                <table class="table table-hover">
                    <tbody>
                        <tr class="info">
                            <td>#</td>
                            <td width = "8%"><strong>作者</strong></td>
                            <td width = "8%"><strong>题目</strong></td>
                            <td width = "8%"><strong>出处</strong></td>
                            <td width = "15%"><strong>上传时间</strong></td> 
                            <td width = "40%"><strong>操作</strong></td>

                        </tr>

                        
                        require_once('appvars.php');
                        require_once('connectvars.php');

                        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

                        $query = "SELECT * FROM resource ORDER BY title ASC";
                        $data = mysqli_query($dbc, $query);

                        $row_num = 1;
                        $color = true;
                        while ($row = mysqli_fetch_array($data)) {
                            if ($color) {
                                echo '<tr>';
                            } else {
                                echo '<tr class = "info">';
                            }
                            $color = !$color;
                            echo '<td width = "3%">' . $row_num++ . '</td>';
                            echo '<td width = "15%">' . $row['authors'] . '</td>';

                            echo '<td width = "30%">' . $row['title'] . '</td>';
                            echo '<td width = "25%">' . $row['journal'] . $row['year'] . ', ' . $row['pages'] . ', ' . $row['publisher'] . '</td>';
                            echo '<td width = "10%">' . $row['create_time'] . '</td>';
                            $file_name = iconv('utf-8', 'gb2312', $row['file']);
                            echo '<td width = "15%">';
                            echo '<a class = "btn" href = "upload_file.php"><i class = "icon-edit"></i></a>';

                            if (is_file(GW_UPLOADPATH . $file_name)) {
                                echo '<a class = "btn" href = "' . GW_UPLOADPATH . $row['file'] . '"><i class = "icon-download-alt"></i></a>';
                            }

                            echo '<a class = "btn" href = "create_article.html"><i class = "icon-trash"></i></a></td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>  
-->
<?php
include_once ("./foot.php");
?>
       
