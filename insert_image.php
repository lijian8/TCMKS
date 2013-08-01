<?php
include_once ("./header.php");
include_once ("./image_helper.php");

require_once('appvars.php');
require_once('connectvars.php');

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (isset($_GET[article_id]) && isset($_GET[segment_id])) {
    $article_id = $_GET[article_id];
    $segment_id = $_GET[segment_id];
}

if (isset($_GET[keywords])) {
    $keywords = $_GET[keywords];
}

if (isset($_GET[insert_image_id])) {
    insert_into_segment($dbc, $segment_id, $_GET[insert_image_id]);
    echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>';
    echo '图片"'.get_image_name($dbc, $_GET[insert_image_id]).'"已成功插入!</div>';
}


?>


<div class="container">
    <div class="navbar">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <a class="brand" href="#">搜索并插入图片</a>
                <div class="nav-collapse collapse navbar-responsive-collapse">
                    <form class="navbar-search pull-left" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input id="article_id" name="article_id" type="hidden" value="<?php if (isset($article_id)) echo $article_id; ?>" placeholder="请搜索图片">
                        <input id="segment_id" name="segment_id" type="hidden" value="<?php if (isset($segment_id)) echo $segment_id; ?>" placeholder="请搜索图片">

                        <input id="keywords" name="keywords" type="text" class="search-query input-xxlarge" value="<?php if (isset($keywords)) echo $keywords; ?>" placeholder="请搜索图片">
                        <button type="submit" class="btn-link"><i class="icon-search"></i></button>
                    </form>
                    <ul class="nav pull-right">
                        <li><a  href="<?php echo "article.php?id=$article_id#s$segment_id"; ?>">返回</a></li>
                    </ul>
                </div><!-- /.nav-collapse -->
            </div>
        </div><!-- /navbar-inner -->
    </div><!-- /navbar -->
</div>
<div class="container">
    <div class="row-fluid">
        <?php
        $query = "SELECT * FROM `tcmks`.`images` WHERE name like '%$keywords%' or score like '%$keywords%' or description like '%$keywords%'";
        //echo $query;
        $result = mysqli_query($dbc, $query) or die('Error querying database.');
        $row = mysqli_fetch_array($result);
        while ($row) {
            echo '<ul class = "thumbnails">';

            for ($i = 0; $i < 4; $i++) {
                if (!$row)
                    break;
                echo '<li class="span3">';
                echo '<div class = "thumbnail">';
                echo '<img src="' . IMG_UPLOADPATH . $row['file'] . '"  alt="" /></p>';
                echo '<div class = "caption">';
                echo '<p><strong>' . $row['name'] . '.&nbsp;</strong>';
                echo $row['description'] . '</p>';

                $link_for_inserting_image = $_SERVER['PHP_SELF'] . '?' . 'article_id=' . $article_id . '&segment_id=' . $segment_id . '&insert_image_id=' . $row['id'];

                echo '<a class="btn" href="' . $link_for_inserting_image . '"><i class="icon-plus"></i>&nbsp;插入图片</a>';
                echo '&nbsp;&nbsp';

                echo '</div></div></li>';
                $row = mysqli_fetch_array($result);
            }
            echo '</ul>';
        }
        ?>
    </div>
</div>

<?php
include_once ("./foot.php");
?>
