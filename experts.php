<?php
require_once('appvars.php');
require_once('connectvars.php');
include_once ("./header.php");
$dbc = mysqli_connect('localhost', 'tcmks', 'tcmks', 'tcmks') or die('Error connecting to MySQL server.');


echo "<h1>专家列表：</h1><hr><div class =\"container\"><div class=\"row-fluid marketing\">";

$query = "SELECT * FROM users";

$result = mysqli_query($dbc, $query) or die('Error querying database1.');
while ($row = mysqli_fetch_array($result)) {
    //echo $row[id]. $row[real_name]. $row[job].$row[profile].$row[icon];
    
    echo '<div class="media">';
    echo '<a class="pull-left" href="expert.php?id='.$row[id].'">';
    echo "<img  class=\"media-object\" src=\"img/Person_icon.png\" data-src=\"holder.js/64x64\">";
    echo "</a><div class=\"media-body\"  align =\"left\">";
    echo "<h4 class=\"media-heading\"><a href=\"expert.php?id=$row[id]\">$row[real_name]</a></h4>";
    echo "<p>$row[job]. $row[profile]</p>";
    echo "</div></div>";
    
}

echo "</div></div>";
echo '<hr>';

mysqli_close($dbc);
include_once ("./foot.php");
?>
