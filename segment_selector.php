<?php
include_once ("./header.php");
include_once ("./functions.php");
include_once ("./article_helper.php");


require_once('appvars.php');
require_once('connectvars.php');
if (isset($_POST['keywords'])) {
    $keywords = $_POST['keywords'];
}

if (isset($_GET['article_id'])) {
    $article_id = $_GET['article_id'];
    $prev = $_GET['prev'];
}
?>
<div class ="container">
    <h3>请为综述文献插入段落：</h3>
    <div class ="well">   
        <form class="form-search" action="segment_selector.php?article_id=<?php echo $article_id; ?>&prev=<?php echo $prev; ?>" method="post" class="form-horizontal"
              enctype="multipart/form-data">
            <label><font size ="4">&nbsp;&nbsp;搜索:&nbsp;&nbsp;</font></label>
            <input type="text" id ="keywords" name ="keywords" class="span10 search-query" value ="<?php if (isset($keywords)) echo $keywords; ?>">
            <button name ="submit" type="submit" class="btn btn-primary">&nbsp;&nbsp;<i class="icon-search icon-white"></i>&nbsp;&nbsp;</button>
        </form>
    </div>

    <div class="accordion" id="accordion2">

        <?php
        if (isset($keywords)) {


            $query = "SELECT * FROM segment where title like '%$keywords%' or content like '%$keywords%' ";

            $result = mysqli_query($dbc, $query) or die('Error querying database.');

            while ($row = mysqli_fetch_array($result)) {

                //$article_id = $row[article_id];
                //$article_info = get_article_info($dbc, $article_id);
                $segment_title = $row[title];
                $segment_id = $row[id];

                $segment_abstract = tcmks_substr($row[content]);
                $segment_content = $row[content];

                echo "<div class = \"accordion-group\">";
                echo "<div class = \"accordion-heading\">";
                echo "<a class = \"accordion-toggle\" data-toggle = \"collapse\" data-parent = \"#accordion2\" href = \"#$segment_id\">";
                echo $segment_title;
                echo "</a>";

                echo $segment_abstract;
                echo "</div>";
                echo "<div id = \"$segment_id\" class = \"accordion-body collapse\">";
                echo "<div class = \"accordion-inner\">";
                echo $segment_content;
                
           
              if (($_SESSION[id] == $row[user_id]) && (!is_segment_in_article($dbc, $article_id, $segment_id))) {
                    echo "<a class = \"btn btn-success\" href=\"article.php?id=$article_id&insert=$segment_id&prev=$prev\"><i class=\"icon-plus icon-white\"></i>将本段插入综述</a>";
               }
                echo '&nbsp;';
                echo "<a class = \"btn btn-success\" href=\"article.php?id=$article_id&copy=$segment_id&prev=$prev\"><i class=\"icon-plus icon-white\"></i>拷贝本段</a>";
                echo "</div></div></div>";
            }
        }
        ?>

    </div>
</div>
<?php
include_once ("./foot.php");
?>