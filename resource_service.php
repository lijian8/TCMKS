
<?php
require_once('appvars.php');
require_once('connectvars.php');
//get the q parameter from URL
$id = $_GET["id"];
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$q3 = "SELECT * FROM resource WHERE id = '$id'";
$r3 = mysqli_query($dbc, $q3) or die('Error querying database2.');
if ($row3 = mysqli_fetch_array($r3)) {
    $hint .= '<h4>' . $row3['title'] . '</h4>';
    $hint .= '<p>作者：' . $row3['creator'] . '</p>';
    $hint .= '<p>类型：' . $row3['type'] . '</p>';
    
    $hint .= '<p>出处：' . $row3['source']  . '</p>';
    $hint .= '<p>出版者：'. $row3['publisher'] . '</p>';
    $hint .= '<p>描述：'. $row3['description'] . '</p>';
   
    $hint .= '<a href="' . GW_UPLOADPATH . $row3['file'] . '">下载原文</>';
    
}

if ($hint == "") {
    $response = "无相关资源";
} else {
    $response = $hint;
}

//output the response
echo $response;
?>
   