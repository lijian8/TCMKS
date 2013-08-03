<?php
include_once ("./header.php");
include_once ("./pop_up.php");
include_once ("./rights.php");
include_once ("./image_helper.php");
include_once ("./article_helper.php");
require_once('appvars.php');

function render_images($dbc, $id, $segment_id, $all_images) {

    $images = get_images_of_segment($dbc, $segment_id);
    //print_r($images);
    foreach ($images as $image_id) {
        $query = "SELECT * FROM images WHERE id = '$image_id'";
        $result = mysqli_query($dbc, $query) or die('Error querying database1.');
        if ($row = mysqli_fetch_array($result)) {
            //$image_id = $row3['id'];
            $image_file = $row['file'];
            echo '<div class="row-fluid">';
            echo '<ul class="thumbnails">';
            echo '<li class="span12">';

            echo '<div class="thumbnail">';
            echo "<div align = \"right\"><a href=\"?id=$id&segment_id=$segment_id&delete_image=$image_id&delete_image_file=$image_file \" ><i class=\"icon-remove-sign\"></i></a></div>";

            echo '<img src="' . IMG_UPLOADPATH . $image_file . '"  alt="" />';
            echo '<div class="caption">';
            echo '<h4>' . FIGURE . $all_images[$row['id']] . '.' . $row['name'] . '</h4>';
            echo '<p>' . $row[description];
            echo '</p>';
            echo '</div></div></li></ul></div>';
        }
    }
}

function get_images_of_segment($dbc, $segment_id) {
    $query = "SELECT images FROM segment WHERE id = '$segment_id'";

    $result = mysqli_query($dbc, $query) or die('Error querying database2.');
    $images = array();
    if ($row = mysqli_fetch_array($result)) {

        $parts = explode('|', $row["images"]);

        foreach ($parts as $part) {
            if ('' != $part) {
                array_push($images, $part);
            }
        }
    }


    return $images;
}

function renderTags($dbc, $c_id) {
    $query = "SELECT * FROM tags WHERE segment_id = '$c_id'";
    //echo $query;
    $result = mysqli_query($dbc, $query) or die('Error querying database.');
    $tags = array();
    while ($row = mysqli_fetch_array($result)) {
        $link = '<a href="javascript:invokePopupService(\'' . $row[tag] . '\');">' . $row[tag] . '</a>';

        array_push($tags, $link);
    }

    if (count($tags) > 0) {
        echo '标签：' . implode(', ', $tags);
    }
}

function delete_segment($dbc, $id, $segment_id) {

    $query = "SELECT segments FROM article WHERE id = '$id'";
    $result = mysqli_query($dbc, $query) or die('Error querying database.');
    $row = mysqli_fetch_array($result);

    $new_segments = str_replace('|' . $segment_id . '|', '|', $row['segments']);

    $update = "update article set segments = '$new_segments' where id = '$id'";
    mysqli_query($dbc, $update) or die('Error querying database.');
}



function set_image_no($dbc, $segments) {
    $image_no = 1;

    foreach ($segments as $segment_id) {
        $images = get_images_of_segment($dbc, $segment_id);

        foreach ($images as $image_id) {

            if (!array_key_exists($image_id, $images_nos)) {

                $images_nos[$image_id] = $image_no;
                $image_no++;
            }
        }
    }


    return $images_nos;
}

function insert_segment($dbc, $id, $insert, $prev) {

    $query1 = "SELECT segments FROM article WHERE id = '$id'";
    $result1 = mysqli_query($dbc, $query1) or die('Error querying database.');
    $row1 = mysqli_fetch_array($result1);

    $new_segments = str_replace('|' . $prev . '|', '|' . $prev . '|' . $insert . '|', $row1['segments']);

    $update = "update article set segments = '$new_segments' where id = '$id'";
    mysqli_query($dbc, $update) or die('Error querying database.');
}




//include_once ("./number_sign_processing.php");
$biblio = array();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
   
    $has_right_to_edit = has_right_to_edit($dbc, $_SESSION['id'], $id);

    if (isset($_GET['delete_image'])) {
        delete_image_from_segment($dbc, $_GET['segment_id'], $_GET['delete_image']);
    }

    if (isset($_GET['deleted_segment_id'])) {
        delete_segment($dbc, $id, $_GET['deleted_segment_id']);
    }

    if (isset($_GET['insert'])) {
        insert_segment($dbc, $id, $_GET['insert'], $_GET['prev']);
    }


    
    $article_info = get_article_info($dbc, $id);
    $segments = get_segments($dbc, $id);
    $images = set_image_no($dbc, $segments);
    ?>
    <script type ="text/javascript">
        function jump(link) {
            window.location = "#" + link;
        }
    </script>
    <div class="container">
        <div class="row">
            <div class="span3  bs-docs-sidebar">
                <ul class="nav nav-list bs-docs-sidenav">

                    <?php
                    $is_first_segment = true;
                    //print_r($segments);
                    //$i = 0;
                    //while ($segment_id != 0) {
                    foreach ($segments as $segment_id) {

                        if ('' != $segment_id) {
                            // echo 'echo:'.$segment_id;

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
                            //$i++;
                            //$segment_id = $row2['next'];
                        }
                    }

                    //mysqli_close($dbc);
                    ?>
                </ul>
            </div>

            <div class="span9">
                <div class="well">
                    <h1><font face="微软雅黑" ><?php echo $article_info[title]; ?> </font></h1>
                    <font size ="2">
                    <p></p>
                    <p>&nbsp;&nbsp;<strong>创建者:&nbsp;</strong>
                        <?php echo render_authors($dbc, $id, 'creator', ',&nbsp;&nbsp;'); ?>;&nbsp;&nbsp;
                        <strong>作者:&nbsp;</strong>
                        <?php echo render_authors($dbc, $id, 'author', ',&nbsp;&nbsp;'); ?>;&nbsp;&nbsp;     
                        <strong>评审:&nbsp;</strong>
                        <?php echo render_authors($dbc, $id, 'reviewer', ',&nbsp;&nbsp;'); ?>;&nbsp;&nbsp;     
                        <strong>发布者:&nbsp;</strong>
                        <?php echo render_authors($dbc, $id, 'publisher', ',&nbsp;&nbsp;'); ?>.     
                    <p>&nbsp;&nbsp;<strong>创建时间：</strong><?php echo $article_info[create_time]; ?> ;&nbsp;&nbsp; <strong>发布时间：</strong>06/07/2013</font></p>            

                    </font>
                    <p>
                        <?php
                        if ($has_right_to_edit) {
                            echo '<a class="btn btn-primary" href="article_metadata.php?id=' . $id . '"><i class="icon-th-list icon-white"></i>&nbsp;编辑元信息</a>';
                            ?>        
                            <a class="btn btn-primary" href="#"><i class="icon-edit icon-white"></i>&nbsp;编辑全文</a>
                            <a class="btn btn-primary" href="#"><i class="icon-trash icon-white"></i>&nbsp;删除本文</a> 
        <?php
    }
    ?>
                        <a class="btn btn-warning" href="#"><i class="icon-download-alt icon-white"></i>&nbsp;下载全文</a>            
                        <a class="btn btn-warning" href="#"><i class="icon-home icon-white"></i>&nbsp;返回主页</a>            
                    </p>
                </div>




    <?php
    $is_first_segment = true;
    $j = 0;
    //while ($segment_id != 0) {
    foreach ($segments as $segment_id) {
        if ('' != $segment_id) {
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
                //echo '<div class="page-header"><h2><font face="微软雅黑">' . $c_title . '</font></h2></div>';
                echo '<h3><font face="微软雅黑">' . $c_title . '</font></h3>';
            } else {
                //echo '<div class="page-header"><h3><font face="微软雅黑">' . $c_title . '</font></h3></div>';
                echo '<h4><font face="微软雅黑">' . $c_title . '</font></h4>';
            }


            renderTags($dbc, $c_id);
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
                    } else {
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

            render_images($dbc, $id, $segment_id, $images);

            if ($has_right_to_edit) {

                echo "<ul class=\"nav nav-pills\">";

                echo "<li class=\"active\"><a href=\"editor.php?act=edit&article_id=$id&id=$c_id\"><i data-toggle=\"tooltip\" title=\"编辑本段\" class=\"icon-edit\"></i>&nbsp;&nbsp;编辑本段</a></li>";

                if ($is_first_segment) {
                    $is_first_segment = false;
                } else {
                    //echo '<li class=\"active\"><a href="article.php?id=' . $id . '&deleted_segment_id=' . $c_id . '"><i data-toggle="tooltip" title="删除本段" class="icon-trash"></i>&nbsp;&nbsp;删除本段</a></li>';
                    echo "<li class=\"active\"><a href=\"article.php?id=$id&deleted_segment_id=$c_id\"><i data-toggle=\"tooltip\" title=\"删除本段\" class=\"icon-trash\"></i>&nbsp;&nbsp;删除本段</a></li>";
                }

                echo "<li class=\"dropdown\">";
                echo "<a class=\"dropdown-toggle\" id=\"drop4\" role=\"button\" data-toggle=\"dropdown\" href=\"#\">在下方插入段落<b class=\"caret\"></b></a>";
                echo "<ul id=\"menu1\" class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"drop4\">";
                echo "<li role=\"presentation\"><a role=\"menuitem\" tabindex=\"-1\" href=\"editor.php?act=insert&article_id=$id&id=$c_id\">创建新的段落</a></li>";
                echo "<li role=\"presentation\"><a role=\"menuitem\" tabindex=\"-1\" href=\"segment_selector.php?article_id=$id&prev=$c_id\">插入已有段落</a></li>";
                echo "<li role=\"presentation\"><a role=\"menuitem\" tabindex=\"-1\" href=\"#\">拷贝已有段落</a></li>";

                echo "</ul></li>";
//echo '<a href="editor.php?act=edit&article_id=' . $id . '&id=' . $c_id . '"><i data-toggle="tooltip" title="编辑本段" class="icon-edit"></i></a>';
                echo "<li class=\"dropdown\">";
                echo "<a class=\"dropdown-toggle\" id=\"drop4\" role=\"button\" data-toggle=\"dropdown\" href=\"#\">插入图片<b class=\"caret\"></b></a>";
                echo "<ul id=\"menu1\" class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"drop4\">";
                echo "<li role=\"presentation\"><a role=\"menuitem\" tabindex=\"-1\" href=\"upload_image.php?article_id=$id&segment_id=$c_id\">上传新图片</a></li>";
                echo "<li role=\"presentation\"><a role=\"menuitem\" tabindex=\"-1\" href=\"insert_image.php?article_id=$id&segment_id=$c_id\">插入已有图片</a></li>";

                echo "</ul></li></ul>";
                /*

                  echo '<a href="editor.php?act=insert&article_id=' . $id . '&id=' . $c_id . '"><i data-toggle="tooltip" title="插入已有段落" class="icon-plus"></i></a>';
                  echo '&nbsp;&nbsp';

                  echo '<a href="editor.php?act=insert&article_id=' . $id . '&id=' . $c_id . '"><i data-toggle="tooltip" title="创建新的段落" class="icon-plus"></i></a>';
                  echo '&nbsp;&nbsp';
                  echo '<a href="upload_image.php?article_id=' . $id . '&segment_id=' . $c_id . '"><i data-toggle="tooltip" title="上传并插入图片" class="icon-picture"></i></a>';
                  echo '&nbsp;&nbsp';
                 * 
                 */
            }




            echo '<HR color=#987cb9 size=1>';

            //$segment_id = $row2['next'];
            echo '</section>';
        }
    }

    if (count($biblio) != 0) {
        echo '<section id="biblio">';
        echo '<div class="page-header"><h2><font face="微软雅黑">参考文献</font></h2></div>';
        echo '<ol>';
        foreach ($biblio as $ref) {
            $q3 = "SELECT * FROM resource WHERE id = '$ref'";
            $r3 = mysqli_query($dbc, $q3) or die('Error querying database2.');
            if ($row = mysqli_fetch_array($r3)) {
                echo "<li id = \"" . $row['id'] . "\">";
                //echo "<a name =\"".$row3['id']."\">";
                //$link = '<a href="javascript:invokePopupService(\'' . $row['id'] . '\',\'resource\');">[' . $row['id'] . ']</a>';
                $link = '<a href="javascript:invokePopupService(\'' . $row['id'] . '\',\'resource\');">' . $row['title'] . '</a>';

                echo $row['creator'] . '.' . $link . '.' . $row['source'] . '.' . $row['publisher'];
                $file_name = iconv('utf-8', 'gb2312', $row['file']);

                if (is_file(GW_UPLOADPATH . $file_name)) {
                    echo '<a class = "btn btn-warning" href="' . GW_UPLOADPATH . $row['file'] . '"><i class="icon-download-alt icon-white"></i>下载原文</a>';
                }

                echo '</li>';
            }else{
                echo "<li id = \"" . $ref . "\">该文献信息已不存在。</li>";
            }
        }
        echo '</ol>';
        echo '</section>';
    }
   
}
?>
        </div>

    </div>
            <?php
            include_once ("./foot.php");
            ?>
