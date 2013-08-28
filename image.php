<?php

require_once('appvars.php');
include_once ("./header.php");
include_once ("./pop_up.php");
include_once ("./image_helper.php");
include_once ("./article_helper.php");
include_once ("./messages.php");
include_once ("./resource_helper.php");
include_once ("./users_helper.php");
echo '<div class="container">';
echo '<p/>';

if (isset($_GET['id'])) {
    $image_id = $_GET['id'];
    $query = "SELECT * FROM images WHERE id = '$image_id'";
    $result = mysqli_query($dbc, $query) or die('Error querying database1.');
    if ($row = mysqli_fetch_array($result)) {
        //$image_id = $row3['id'];
        $image_file = $row['file'];
        echo '<h3>' . FIGURE . $row['id']. '.' . $row['name'] . '</h3>';
        
         echo '<p>' . $row[description];
        echo '<div class="row-fluid">';
        echo '<ul class="thumbnails">';
        echo '<li class="span12">';

        echo '<div class="thumbnail">';
        echo '<img src="' . IMG_UPLOADPATH . $image_file . '"  alt="" />';
        echo '<div class="caption">';

       
        echo '</div></div></li></ul></div>';
    }
} else {
    render_warning('无相关信息！');
}
$query = "select * from segment where images like '%|$image_id|%'";
$result = mysqli_query($dbc, $query) or die('Error querying database.');
$segments = array();
$first = true;
while ($row = mysqli_fetch_array($result)) {
    if ($first) {
        echo '<h3>该图表出现于如下的文献中：</h3>';
        echo '<hr>';
    }
    render_segment_summary($dbc, $row);
}
echo '</div>';



include_once ("./foot.php");
?>
