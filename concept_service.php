
<?php

require_once('appvars.php');
require_once('connectvars.php');
//get the q parameter from URL
/*
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
 */
$id = $_GET["id"];
$hint = "<p><strong>人参</strong>，多年生草本植物，喜阴凉、湿润的气候，多生长于昼夜温差小的海拔500～1100米山地缓坡或斜坡地的针阔混交林或杂木林中。由于根部肥大，形若纺锤，常有分叉，全貌颇似人的头、手、足和四肢，故而称为人参。古代人参的雅称为黄精、地精、神草。人参被人们称为“百草之王”，是闻名遐迩的“东北三宝”（人参、貂皮、鹿茸）之一，是驰名中外、老幼皆知的名贵药材。</p>";

if ($hint == "") {
    $response = "无相关资源";
} else {
    $response = $hint;
}

//output the response
echo $response;
?>
   
