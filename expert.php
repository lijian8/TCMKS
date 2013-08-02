<?php

require_once('appvars.php');
//require_once('connectvars.php');
include_once ("./header.php");
include_once ("./article_helper.php");

function getUsers($dbc, $article_id, $role) {
    $query = "SELECT * FROM `tcmks`.`authorship` as t1, `tcmks`.`users` as t2 where t1.author_id = t2.id and article_id = $article_id and role = '$role'";

    $result = mysqli_query($dbc, $query) or die('Error querying database3.');
    $s = "";
    while ($row = mysqli_fetch_array($result)) {
        $s .= $row['real_name'] . "&nbsp;";
    }
    //echo $query.$s;
    return $s;
}

function list_articles($dbc, $user_id) {
    $query = "SELECT distinct id, title, create_time FROM authorship au,article ar where au.article_id = ar.id and author_id = $user_id";
    $result = mysqli_query($dbc, $query) or die('Error querying database3.');

    while ($row = mysqli_fetch_array($result)) {

        $creators = getUsers($dbc, $row[id], 'creator');
        echo "<h4><a href = \"article.php?id=$row[id]\">" . $row[title] . "</a></h4>";
        echo "$creators 创建于$row[create_time]";
        //$abstract = get_abstract($dbc, $row['id'], $row['first']);
        $abstract = get_abstract($dbc, $row[id]);
        $abstract = mb_substr($abstract, 0, 100, 'utf-8');
        echo "<p>" . $abstract . "...</p>";
    }
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    //$dbc = mysqli_connect('localhost', 'tcmks', 'tcmks', 'tcmks') or die('Error connecting to MySQL server.');
    $query = "SELECT * FROM users WHERE id = $user_id";

    $result = mysqli_query($dbc, $query) or die('Error querying database1.');
    if ($row = mysqli_fetch_array($result)) {
        //echo $row[id]. $row[real_name]. $row[job].$row[profile].$row[icon];
        echo '<div class="container">';
        echo '<div class="hero-unit">';
        echo '<div class="media">';
        echo '<a class="pull-left" href="navigator.php">';
        echo "<img  class=\"media-object\" src=\"img/Person_icon.png\" data-src=\"holder.js/64x64\">";
        echo "</a><div class=\"media-body\"  align =\"left\">";
        echo "<h4 class=\"media-heading\">$row[real_name]</h4>";
        echo "<p>$row[job]. $row[profile]</p>";
        echo "</div></div>";
        echo '</div>';

       
       
        echo '<div class="tabbable">'; 
        echo '<ul class="nav nav-tabs">';
        echo '<li class="active"><a href="#tab1" data-toggle="tab">编审的综述</a></li>';
        echo '<li><a href="#tab2" data-toggle="tab">共享的文献</a></li>';
        echo '</ul>';
  
        echo '<div class="tab-content">';
        echo '<div class="tab-pane active" id="tab1">';
        echo '<p>'. list_articles($dbc, $user_id) .'</p>';
        echo '</div>';
        
        echo '<div class="tab-pane" id="tab2">';
        echo '<p>未完成</p>';
        echo '</div>';
        echo '</div>'; 
        echo '</div>'; 
        echo '</div>'; 
       
    }

}
 include_once ("./foot.php");
?>