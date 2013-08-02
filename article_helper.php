<?php

function render_article_summary($dbc, $article_id) {
    $article_info = get_article_info($dbc, $article_id);
    echo "<h4><a href = \"article.php?id=$article_id\">" . $article_info[title] .  "</a></h4>";
    echo "$article_info[creators]创建于$article_info[create_time]";  
    echo '<p>'.get_abstract($dbc, $article_id).'</p>';
}

function get_abstract($dbc, $article_id){
    $segments = get_segments($dbc, $article_id);
    
    $abstract_id = $segments[0];
    
    $query = "SELECT content FROM segment where id = $abstract_id";
    
    $result = mysqli_query($dbc, $query) or die('Error querying database3.');
    $row = mysqli_fetch_array($result);
    return $row['content'];
    
}

function get_segments($dbc, $article_id){
    $query = "SELECT * FROM article WHERE id = '$article_id'";
    $result = mysqli_query($dbc, $query) or die('Error querying database1.');
    if ($row = mysqli_fetch_array($result)){
        $parts = explode('|', $row[segments]);
        $segments = array();
        foreach($parts as $part){
            if ('' != $part){
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
        $article_info[creators] = get_article_creator($dbc, $id);
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

function get_article_creator($dbc, $id) {
    $query = "SELECT * FROM authorship a, users u where a.author_id = u.id and a.role = 'creator' and a.article_id = '$id'";
    $result = mysqli_query($dbc, $query) or die('Error querying database.');

    $first = true;

    while ($row = mysqli_fetch_array($result)) {
        $creator = "<a href = \"user.php?id=$row[author_id]\">$row[real_name]</a>";
        if ($first) {
            $creators .= $creator;
            $first = false;
        } else {
            $creators .= ',' . $creator;
        }
    }

    return $creators;
}

?>
