
<?php
require_once('appvars.php');
require_once('connectvars.php');
//get the q parameter from URL
$id = $_GET["id"];
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$q3 = "SELECT * FROM images WHERE id = '$id'";
$r3 = mysqli_query($dbc, $q3) or die('Error querying database2.');
if ($row3 = mysqli_fetch_array($r3)) {
    $hint = '<div class="row-fluid">';
    $hint .= '<ul class="thumbnails">';
    $hint .= '<li class="span12">';
    $hint .= '<div class="thumbnail">';
    $hint .= '<img src="' . IMG_UPLOADPATH . $row3['file'] . '"  alt="" />';
    $hint .= '<div class="caption">';
    $hint .= '<h3>' . $row3[name] . '</h3>';
    $hint .= '<p>' . $row3[description] . '</p>';
    //echo '<p><a href="#" class="btn btn-primary">查看</a></p>';
    $hint .= '</div></div></li></ul></div>';
}

if ($hint == "") {
    $response = "无相关资源";
} else {
    $response = $hint;
}

//output the response
echo $response;
?>
   