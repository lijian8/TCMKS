
<?php

include_once ("./messages.php");
include_once ("./image_helper.php");
include_once ("./entity_helper.php");
include_once ("./functions.php");

require_once('appvars.php');
require_once('connectvars.php');

$id = $_GET["id"];



$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
/*
  $query = "SELECT def FROM def WHERE name = '$id'";
  //echo $query;
  $result = mysqli_query($dbc, $query) or die('Error querying database1.');
  if ($row = mysqli_fetch_array($result)) {
  $def = $row['def'];

  $hint = "<p><strong>$id</strong>，".$def."</p>";
  }


  if ($hint == "") {
  $response = "无相关概念信息！";
  } else {
  $response = $hint;
  }

  //output the response
  echo $response;
 * 
 */
render_entity($dbc, $id, $edit = false);
echo '<a class="btn btn-success" href="search.php?keywords='. $id .'">查看详情</a>';
?>
   
