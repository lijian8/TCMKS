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

    // $last_name = $row['last_name'];
    // $msg = "Dear $first_name $last_name,\n$text";
    echo '<div class="hero-unit">';
    echo '<h1><font face="黑体">' . $title . '</font></h1>';
    echo '<font size="2">创建者：欧蔚妮（副主任医师） &nbsp;&nbsp; 审核者：段英 （主治医师） &nbsp;&nbsp; 发布者：邢卉春 （主任医师）</font><br>';
    echo '<font size="2">创建时间：06/07/2013 &nbsp; 发布时间：06/07/2013</font>';
    echo '</div>';
    ?>

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
                            echo '<li><a href="#s' . $i . '"><i class="icon-chevron-right"></i><font face="黑体">' . $c_title . '</font></a></li>';

                            //'<h2>' . $c_title . '</h2>';
                        } else {
                            echo '<li><a href="#s' . $i . '"><i class="icon-chevron-right"></i><font face="黑体">-' . $c_title . '</font></a></li>';

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
                        echo '<div class="page-header"><h2><font face="黑体">' . $c_title . '</font></h2></div>';
                    } else {
                        echo '<div class="page-header"><h3><font face="黑体">' . $c_title . '</font></h3></div>';
                    }

                    echo '<p>' . $c_content . '</p>';
                    echo '<a href="editor.php?act=edit&article_id=' . $id . '&id=' . $c_id . '">编辑本段</a>';
                    echo '&nbsp;&nbsp';
                    echo '<a href="editor.php?act=insert&article_id=' . $id . '&id=' . $c_id . '">插入段落</a>';
                    echo '&nbsp;&nbsp';

                    if ($is_first_segment) {
                        $is_first_segment = false;
                    } else {
                        echo '<a href="article.php?id=' . $id . '&deleted_segment_id=' . $c_id . '">删除段落</a>';
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
