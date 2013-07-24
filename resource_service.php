
<?php
require_once('appvars.php');
require_once('connectvars.php');
//get the q parameter from URL
$id = $_GET["id"];
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$q3 = "SELECT * FROM resource WHERE id = '$id'";
$r3 = mysqli_query($dbc, $q3) or die('Error querying database2.');
if ($row3 = mysqli_fetch_array($r3)) {
    $hint .= '<h3>' . $row3['title'] . '</h3>';
    $hint .= '<p>作者：' . $row3['authors'] . '</p>';
    $hint .= '<p>文献来源：' . $row3['journal'] .','. $row3['year'] .','. $row3['pages'] . '</p>';
    $hint .= '<p>出版社：'. $row3['publisher'] . '</p>';
   
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
   