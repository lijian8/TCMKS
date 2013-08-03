<?php

include_once ("./users_helper.php");
include_once ("./functions.php");
function render_article_summary($dbc, $article_id, $word_count = 0) {
    $article_info = get_article_info($dbc, $article_id);
    echo "<h4><a href = \"article.php?id=$article_id\">" . $article_info[title] . "</a></h4>";
    echo "$article_info[creators]创建于$article_info[create_time]";
    $abstract = get_abstract($dbc, $article_id);
    if ($word_count != 0){
        $abstract = tcmks_substr($abstract);
    }
    echo '<p>' . $abstract . '</p>';
}

    

function get_abstract_id($dbc, $article_id){
    $segments = get_segments($dbc, $article_id);

    return $segments[0];
    
}

function get_abstract($dbc, $article_id) {
    
    $abstract_id = get_abstract_id($dbc, $article_id);
    $query = "SELECT content FROM segment where id = $abstract_id";

    $result = mysqli_query($dbc, $query) or die('Error querying database3.');
    $row = mysqli_fetch_array($result);
    return $row['content'];
}

function get_content($dbc, $article_id, $segment_id) {

    $query = "SELECT content FROM segment where article_id=$article_id and id = $segment_id";
    $result = mysqli_query($dbc, $query) or die('Error querying database3.');
    $row = mysqli_fetch_array($result);
    return $row['content'];
}

function get_segments($dbc, $article_id) {
    $query = "SELECT * FROM article WHERE id = '$article_id'";
    $result = mysqli_query($dbc, $query) or die('Error querying database1.');
    if ($row = mysqli_fetch_array($result)) {
        $parts = explode('|', $row[segments]);
        $segments = array();
        foreach ($parts as $part) {
            if ('' != $part) {
                array_push($segments, $part);
            }
        }
        return $segments;
    }
}

function get_article_link($dbc, $id) {
    $title = get_article_title($dbc, $id);
    return "<a href = \"article.php?id=$id\">$title</a>";
}

function get_article_title($dbc, $id) {
    $query = "SELECT * FROM article where id = '$id'";
    $result = mysqli_query($dbc, $query) or die('Error querying database.');
    if ($row = mysqli_fetch_array($result)) {
        return $row[title];
    }
}

function get_article_info($dbc, $id) {
    $query = "SELECT * FROM article where id = $id";
    $result = mysqli_query($dbc, $query) or die('Error querying database.');
    if ($row = mysqli_fetch_array($result)) {
        $article_info[title] = $row[title];
        $article_info[create_time] = $row[create_time];
        $article_info[creators] = render_authors($dbc, $id, 'creator');
        return $article_info;
    }
}

function get_articles_by_seg($dbc, $segment_id) {
    $query = "SELECT id FROM article where segments like '%|$segment_id|%'";
    $result = mysqli_query($dbc, $query) or die('Error querying database.');
    $articles = array();
    while ($row = mysqli_fetch_array($result)) {
        array_push($articles, $row[id]);
    }
    return $articles;
}



function delete_article($dbc, $article_id) {
    $query = "DELETE FROM article WHERE id = '$article_id'";
    mysqli_query($dbc, $query);
    $query = "DELETE FROM authorship WHERE article_id = '$article_id'";
    mysqli_query($dbc, $query);
    
    $abstract = get_abstract_id($dbc, $article_id);
    $query = "DELETE FROM segment WHERE id = '$abstract'";
    mysqli_query($dbc, $query);
}

function list_articles($dbc, $user_id) {
    $query = "SELECT distinct id, title, create_time FROM authorship au,article ar where au.article_id = ar.id and author_id = $user_id";
    
    $result = mysqli_query($dbc, $query) or die('Error querying database3.');

    while ($row = mysqli_fetch_array($result)) {
        render_article_summary($dbc, $row[id], $word_count = 0);       
    }
}
?>
