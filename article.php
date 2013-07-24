<?php
require_once('appvars.php');
require_once('connectvars.php');

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

function set_image_id($segment_id, $dbc) {
    $image_id = 1;
    while ($segment_id != 0) {
        $q1 = "SELECT * FROM images WHERE segment_id = '$segment_id'";
        $r1 = mysqli_query($dbc, $q1) or die('Error querying database2.');
        while ($row1 = mysqli_fetch_array($r1)) {
            if (!array_key_exists($row1[id], $images)) {
                $images[$row1[id]] = $image_id;
                $image_id++;
            }
        }

        $q2 = "SELECT * FROM segment WHERE id = '$segment_id'";
        $r2 = mysqli_query($dbc, $q2) or die('Error querying database2.');
        $row2 = mysqli_fetch_array($r2);
        $segment_id = $row2['next'];
    }

    //print_r($images);
    return $images;
}

include_once ("./header.php");
include_once ("./pop_up.php");
//include_once ("./number_sign_processing.php");
$biblio = array();




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
    //$abstract = $row1['abstract'];

    $segment_id = $row1['first'];

    $images = set_image_id($segment_id, $dbc);
    ?>
    <script type ="text/javascript">
        function jump(link){
            window.location = "#" + link;
        }
    </script>
    <div class="container">
        <div class="row">
            <div class="span3  bs-docs-sidebar">
                <ul class="nav nav-list bs-docs-sidenav">

                    <?php
                    //$segment_id = $row1['first'];
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
                            //echo '<li><a href="#s' . $i . '"><i class="icon-chevron-right"></i><font face="微软雅黑">' . $c_title . '</font></a></li>';
                            echo '<li><a href="#s' . $c_id . '"><i class="icon-chevron-right"></i><font face="微软雅黑">' . $c_title . '</font></a></li>';

                            //'<h2>' . $c_title . '</h2>';
                        } else {
                            //echo '<li><a href="#s' . $i . '"><i class="icon-chevron-right"></i><font face="微软雅黑">-' . $c_title . '</font></a></li>';
                            echo '<li><a href="#s' . $c_id . '"><i class="icon-chevron-right"></i><font face="微软雅黑">-' . $c_title . '</font></a></li>';

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
                <div class="well">
                    <h1><font face="微软雅黑" ><?php echo $title; ?> </font></h1>
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
                    <p>
                        <a class="btn btn-primary" href="article.php?id='1'&deleted_segment_id='2'"><i class="icon-th-list icon-white"></i>&nbsp;编辑元信息</a>
                        <a class="btn btn-primary" href="article.php?id='1'&deleted_segment_id='2'"><i class="icon-edit icon-white"></i>&nbsp;编辑全文</a>
                        <a class="btn btn-primary" href="article.php?id='1'&deleted_segment_id='2'"><i class="icon-trash icon-white"></i>&nbsp;删除本文</a> 
                        <a class="btn btn-warning" href="article.php?id='1'&deleted_segment_id='2'"><i class="icon-download-alt icon-white"></i>&nbsp;下载全文</a>            
                        <a class="btn btn-warning" href="article.php?id='1'&deleted_segment_id='2'"><i class="icon-home icon-white"></i>&nbsp;返回主页</a>            
                    </p>
                </div>




                <?php
                //to do: authors
                //echo '<h2>摘要</h2>' . $abstract;
                //echo '<HR color=#987cb9 size=1>';

                $segment_id = $row1['first'];
                $is_first_segment = true;
                $j = 0;
                while ($segment_id != 0) {
                    //echo '<section id="s' . $j . '">';
                    echo '<section id="s' . $segment_id . '">';
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
                        //echo '<h2><font face="微软雅黑">' . $c_title . '</font></h2>';
                    } else {
                        echo '<div class="page-header"><h3><font face="微软雅黑">' . $c_title . '</font></h3></div>';
                        //echo '<h3><font face="微软雅黑">' . $c_title . '</font></h3>';
                    }

                    //echo '<p>' . $c_content . '</p>';
                    //$c_content_processed = process_number_sign($c_content);
                    //echo '<p>' . $c_content_processed["content"] . '</p>';
                    //$results = process_number_sign($c_content);
                    //$biblio = array_merge($biblio, $results[biblio]);

                    preg_match_all('/#(.*?)#/', $c_content, $out);


                    foreach ($out[1] as $word) {

                        if (!strncmp($word, BIBLIO, strlen(BIBLIO))) {
                            $word = substr($word, strlen(BIBLIO));
                            //echo "is biblio;";
                            if (in_array($word, $biblio)) {
                                $key = array_search($word, $biblio);
                            }else{
                                $key = array_push($biblio, $word);
                            }
                           
                            //$link = '<a href="javascript:invokePopupService(\'' . $word . '\',\'resource\');">[' . $key . ']</a>';
                            //$link = "<a href=\"#$word\">[$key]</a>";
                           
                            $link = "<a href=\"javascript:jump('$word');\">[$key]</a>";
                            $c_content = str_replace("#" . BIBLIO . "$word#", $link, "$c_content");
                        } else if (!strncmp($word, FIGURE, strlen(FIGURE))) {
                            $word = substr($word, strlen(FIGURE));
                            //echo "is image;";

                            $link = '<a href="javascript:invokePopupService(\'' . $word . '\',\'image\');">' . FIGURE . $images[$word] . '</a>';
                            $c_content = str_replace("#" . FIGURE . "$word#", $link, "$c_content");
                        } else {
                            $link = '<a href="javascript:invokePopupService(\'' . $word . '\');">' . $word . '</a>';
                            $c_content = str_replace("#$word#", $link, "$c_content");
                        }
                    }

                    echo '<p>' . $c_content . '</p>';

                    $q3 = "SELECT * FROM images WHERE segment_id = '$segment_id'";
                    $r3 = mysqli_query($dbc, $q3) or die('Error querying database2.');
                    while ($row3 = mysqli_fetch_array($r3)) {
                        echo '<div class="row-fluid">';
                        echo '<ul class="thumbnails">';
                        echo '<li class="span12">';
                        echo '<div class="thumbnail">';
                        echo '<img src="' . IMG_UPLOADPATH . $row3['file'] . '"  alt="" />';
                        echo '<div class="caption">';
                        echo '<h3>' . FIGURE . $images[$row3['id']] . '.' . $row3['name'] . '</h3>';
                        echo '<p>' . $row3[description] . '</p>';
                        //echo '<p><a href="#" class="btn btn-primary">查看</a></p>';
                        echo '</div></div></li></ul></div>';
                    }


                    echo '<a href="editor.php?act=edit&article_id=' . $id . '&id=' . $c_id . '"><i class="icon-edit"></i></a>';
                    echo '&nbsp;&nbsp';
                    echo '<a href="editor.php?act=insert&article_id=' . $id . '&id=' . $c_id . '"><i class="icon-plus"></i></a>';
                    echo '&nbsp;&nbsp';
                    echo '<a href="upload_image.php?article_id='.$id.'&segment_id=' . $c_id . '"><i class="icon-picture"></i></a>';
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
                echo '<section id="biblio">';
                echo '<div class="page-header"><h2><font face="微软雅黑">参考文献</font></h2></div>';
                echo '<ol>';
                foreach ($biblio as $ref) {
                    $q3 = "SELECT * FROM resource WHERE id = '$ref'";
                    $r3 = mysqli_query($dbc, $q3) or die('Error querying database2.');
                    while ($row3 = mysqli_fetch_array($r3)) {
                        echo "<li id = \"".$row3['id']."\">";
                        //echo "<a name =\"".$row3['id']."\">";
                        $link = '<a href="javascript:invokePopupService(\'' . $row3['id'] . '\',\'resource\');">[' . $row3['id'] . ']</a>';

                        echo $link . '.' . $row3['authors'] . '.' . $row3['title'] . '.' . $row3['journal'] . $row3['year'] . ',' . $row3['pages'] . ',' . $row3['publisher'] . '.';
                        $file_name = iconv('utf-8', 'gb2312', $row3['file']);

                        if (is_file(GW_UPLOADPATH . $file_name)) {
                            echo '<a class = "btn btn-warning" href="' . GW_UPLOADPATH . $row3['file'] . '"><i class="icon-download-alt icon-white"></i>下载原文</a>';
                        }
                        
                        echo '</li>';
                    }
                }
                echo '</ol>';
                echo '</section>';
                //print_r($biblio);

                mysqli_close($dbc);
            }
            ?>
        </div>

    </div>
<?php
include_once ("./foot.php");
?>
