<?php
include_once ("./header.php");
require_once('appvars.php');
require_once('connectvars.php');

function get_article_info($dbc, $id) {
    $query = "SELECT * FROM article where id = $id";
    $result = mysqli_query($dbc, $query) or die('Error querying database.');
    if ($row = mysqli_fetch_array($result)) {
        $article_info[title] = $row[title];
        $article_info[create_time] = $row[create_time];
        $article_info[creators] = get_article_creator($dbc, $id);
        return $article_info;
    }

    
}

function get_article_creator($dbc, $id) {
    $query = "SELECT * FROM authorship a, users u where a.author_id = u.id and a.role = 'creator' and a.article_id = '$id'";
    $result = mysqli_query($dbc, $query) or die('Error querying database.');

    $first = true;

    while ($row = mysqli_fetch_array($result)) {
        $creator = "<a href = \"user.php?id=$row[author_id]\">$row[real_name]</a>";
        if ($first) {
            $creators .= $creator;
            $first = false;
        } else {
            $creators .= ',' . $creator;
        }
    }

    return $creators;
}

if (isset($_POST['submit'])) {
    $keywords = $_POST['keywords'];
}
?>
<div class="container">
    <?php include_once ("./search_form.php"); ?>
    <div class="tabbable tabs-left">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1" data-toggle="tab">所有主题</a></li>
            <li><a href="#tab2" data-toggle="tab">成人</a></li>
            <li><a href="#tab3" data-toggle="tab">儿科</a></li>
            <li><a href="#tab4" data-toggle="tab">患者</a></li>
            <li><a href="#tab4" data-toggle="tab">文献</a></li>
            <li><a href="#tab5" data-toggle="tab">图表</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab1">
                <?php
                $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die('Error connecting to MySQL server.');

                $query = "SELECT * FROM segment where title like '%$keywords%' or content like '%$keywords%' ";
//echo $query;
                $result = mysqli_query($dbc, $query) or die('Error querying database.');



                while ($row = mysqli_fetch_array($result)) {
                    
                    $article_id = $row[article_id];
                    $article_info = get_article_info($dbc, $article_id);
                    $segment_title = $row[title];
                    $segment_id = $row[id];
                    $segment_content = mb_substr($row[content], 0, 100, 'utf-8');
                    

                    echo "<h4><a href = \"article.php?id=$article_id\">" . $article_info[title] . "</a>&nbsp;/&nbsp;<a href = \"article.php?id=$article_id#s$segment_id\">" . $segment_title . "</a></h4>";
                    echo "$article_info[creators]创建于$article_info[create_time]";
                    echo "<p>" . $segment_content . "...</p>";
                }

                mysqli_close($dbc);
                ?>

            </div>
            <div class="tab-pane" id="tab2">
                <p>成人.</p>
            </div>
            <div class="tab-pane" id="tab3">
                <p>儿科.</p>
            </div>
            <div class="tab-pane" id="tab4">
                <p>患者.</p>
            </div>
            <div class="tab-pane" id="tab5">
                <p>文献.</p>
            </div>
            <div class="tab-pane" id="tab6">
                <p>图表.</p>
            </div>
        </div>
    </div>
</div>
</div>


<?php
include_once ("./foot.php");
?>
