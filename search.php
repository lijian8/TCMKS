<?php
include_once ("./header.php");
include_once ("./article_helper.php");
require_once('appvars.php');

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
                $query = "SELECT * FROM segment where title like '%$keywords%' or content like '%$keywords%' ";
                $result = mysqli_query($dbc, $query) or die('Error querying database.');
                while ($row = mysqli_fetch_array($result)) {

                    $segment_title = $row[title];
                    $segment_id = $row[id];
                    $segment_content = mb_substr($row[content], 0, 100, 'utf-8');

                    $articles = get_articles_by_seg($dbc, $segment_id);

                    echo "<h4>";
                    $first = true;
                    foreach ($articles as $article_id) {
                        if ($first) {
                            $first = false;
                        } else {
                            echo ',&nbsp;';
                        }
                        echo get_article_link($dbc, $article_id);
                    }

                    if (!$first) {
                        echo "&nbsp;/&nbsp;";
                        echo "<a href = \"article.php?id=$article_id#s$segment_id\">" . $segment_title . "</a>";                    
                    } else {
                        echo "<a href = \"segment.php?id=$segment_id\">" . $segment_title . "</a>";                        
                    }
                    echo "</h4>";
                    echo "<p>" . $segment_content . "...</p>";
                }
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
