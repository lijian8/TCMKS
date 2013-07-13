<?php

function delete_segment($dbc, $id) {

    $query = "SELECT * FROM segment WHERE id = '$id'";
    $result = mysqli_query($dbc, $query) or die('Error querying database.');
    $row = mysqli_fetch_array($result);
    $prev = $row['prev'];
    $next = $row['next'];

    $query = "UPDATE segment SET next = '$next' WHERE id = '$prev'";

    $result = mysqli_query($dbc, $query) or die('Error querying database1.');

    $query = "delete from segment where id = '$id'";
    $result = mysqli_query($dbc, $query) or die('Error querying database1.');
}

function getUsers($dbc, $article_id, $role) {
    $query = "SELECT * FROM `tcmks`.`authorship` as t1, `tcmks`.`users` as t2 where t1.author_id = t2.id and article_id = $article_id and role = '$role'";

    $result = mysqli_query($dbc, $query) or die('Error querying database3.');
    $s = "";

    $first = true;
    while ($row = mysqli_fetch_array($result)) {
        if ($first) {
            $first = false;
        } else {
            $s .= ',&nbsp;&nbsp;';
        }
        $s .= $row['real_name'];
    }

    //echo $query . $s;
    return $s;
}

include_once ("./header.php");
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $dbc = mysqli_connect('localhost', 'tcmks', 'tcmks', 'tcmks') or die('Error connecting to MySQL server.');


    if (isset($_GET['deleted_segment_id'])) {
        delete_segment($dbc, $_GET['deleted_segment_id']);
    }



    $q1 = "SELECT * FROM article WHERE id = '$id'";

    $r1 = mysqli_query($dbc, $q1) or die('Error querying database1.');
    $row1 = mysqli_fetch_array($r1);
    $title = $row1['title'];
    $abstract = $row1['abstract'];
    ?>
    
    <p>
        <a class="btn btn-primary" href="article.php?id='1'&deleted_segment_id='2'"><i class="icon-th-list icon-white"></i>&nbsp;编辑元信息</a>
        <a class="btn btn-primary" href="article.php?id='1'&deleted_segment_id='2'"><i class="icon-edit icon-white"></i>&nbsp;编辑全文</a>
        <a class="btn btn-primary" href="article.php?id='1'&deleted_segment_id='2'"><i class="icon-trash icon-white"></i>&nbsp;删除本文</a> 
        <a class="btn btn-warning" href="article.php?id='1'&deleted_segment_id='2'"><i class="icon-download-alt icon-white"></i>&nbsp;下载全文</a>            
        <a class="btn btn-warning" href="article.php?id='1'&deleted_segment_id='2'"><i class="icon-home icon-white"></i>&nbsp;返回主页</a>            


    </p>
    <div  class="row">
        <p></p>
        <div class="span4"><h1><font face="微软雅黑" ><?php echo $title; ?> </font></h1> </div>
        <div class="span5" align ="left"> 
        </div>
    </div>    

    <div class="container" style="background-color:#f1f1f1;"   >
        <font size ="2">
        <p></p>
        <p>&nbsp;&nbsp;<strong>创建者:&nbsp;</strong>
            <?php echo getUsers($dbc, $id, 'creator'); ?>;&nbsp;&nbsp;
            <strong>作者:&nbsp;</strong>
            <?php echo getUsers($dbc, $id, 'author'); ?>;&nbsp;&nbsp;     
            <strong>评审:&nbsp;</strong>
            <?php echo getUsers($dbc, $id, 'reviewer'); ?>;&nbsp;&nbsp;     
            <strong>发布者:&nbsp;</strong>
            <?php echo getUsers($dbc, $id, 'publisher'); ?>.     
        <p>&nbsp;&nbsp;<strong>创建时间：</strong>06/07/2013 ;&nbsp;&nbsp; <strong>发布时间：</strong>06/07/2013</font></p>            

        </font>
    </div>
    <p></p>







    <div class="container">
        <div class="row">
            <div class="span3 bs-docs-sidebar">
                <ul class="nav nav-list bs-docs-sidenav">

                    <?php
                    $segment_id = $row1['first'];
                    $is_first_segment = true;

                    $i = 0;
                    while ($segment_id != 0) {

                        $q2 = "SELECT * FROM segment WHERE id = '$segment_id'";
                        $r2 = mysqli_query($dbc, $q2) or die('Error querying database2.');
                        $row2 = mysqli_fetch_array($r2);

                        $c_id = $row2['id'];
                        $c_title = $row2['title'];
                        //echo $c_title;
                        $c_rank = $row2['rank'];

                        if ($c_rank == 1) {
                            echo '<li><a href="#s' . $i . '"><i class="icon-chevron-right"></i><font face="微软雅黑">' . $c_title . '</font></a></li>';

                            //'<h2>' . $c_title . '</h2>';
                        } else {
                            echo '<li><a href="#s' . $i . '"><i class="icon-chevron-right"></i><font face="微软雅黑">-' . $c_title . '</font></a></li>';

                            //echo '<h3>' . $c_title . '</h3>';
                        }
                        $i++;
                        $segment_id = $row2['next'];
                    }

                    //mysqli_close($dbc);
                    ?>
                </ul>
            </div>

            <div class="span9">




                <?php
                //to do: authors
                //echo '<h2>摘要</h2>' . $abstract;
                echo '<HR color=#987cb9 size=1>';

                $segment_id = $row1['first'];
                $is_first_segment = true;
                $j = 0;
                while ($segment_id != 0) {
                    echo '<section id="s' . $j . '">';
                    $j++;
                    $q2 = "SELECT * FROM segment WHERE id = '$segment_id'";
                    $r2 = mysqli_query($dbc, $q2) or die('Error querying database2.');
                    $row2 = mysqli_fetch_array($r2);

                    $c_id = $row2['id'];
                    $c_title = $row2['title'];
                    $c_content = $row2['content'];
                    $c_rank = $row2['rank'];

                    if ($c_rank == 1) {
                        echo '<div class="page-header"><h2><font face="微软雅黑">' . $c_title . '</font></h2></div>';
                    } else {
                        echo '<div class="page-header"><h3><font face="微软雅黑">' . $c_title . '</font></h3></div>';
                    }

                    echo '<p>' . $c_content . '</p>';
                    echo '<a href="editor.php?act=edit&article_id=' . $id . '&id=' . $c_id . '"><i class="icon-edit"></i></a>';
                    echo '&nbsp;&nbsp';
                    echo '<a href="editor.php?act=insert&article_id=' . $id . '&id=' . $c_id . '"><i class="icon-plus"></i></a>';
                    echo '&nbsp;&nbsp';

                    if ($is_first_segment) {
                        $is_first_segment = false;
                    } else {
                        echo '<a href="article.php?id=' . $id . '&deleted_segment_id=' . $c_id . '"><i class="icon-trash"></i></a>';
                    }

                    echo '<HR color=#987cb9 size=1>';

                    $segment_id = $row2['next'];
                    echo '</section>';
                }

                mysqli_close($dbc);
            }
            ?>
        </div>
    </div>
    <?php
    include_once ("./foot.php");
    ?>
