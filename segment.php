<?php
include_once ("./header.php");
if (isset($_GET['id'])) {
    $segment_id = $_GET['id'];
    $query = "SELECT * FROM segment WHERE id ='$segment_id'";
    
    $result = mysqli_query($dbc, $query) or die('Error querying database2.');
    while ($row = mysqli_fetch_array($result)) {
        echo '<div class="container">';
       
        echo '<h1><font face="微软雅黑" >' . $row[title] . '</font></h1>';
       
        echo '<p>' . $row[content] . '</p>';
         echo '</div>';
    }
} else {
    echo '无相关信息！';
}
include_once ("./foot.php");
?>
