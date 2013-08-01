<?php

function has_right_to_edit($dbc, $author_id, $article_id) {
    $query = "SELECT * FROM authorship where author_id = $author_id and article_id = $article_id";

    $result = mysqli_query($dbc, $query) or die('Error querying database3.');
    if ($row = mysqli_fetch_array($result)) {
        return true;
    } else {
        return false;
    }
}

function has_article($dbc, $author_id) {
    $query = "SELECT * FROM authorship where author_id = $author_id";
    $result = mysqli_query($dbc, $query) or die('Error querying database3.');
    if ($row = mysqli_fetch_array($result)) {
        return true;
    } else {
        return false;
    }
}
?>

