<?php

include_once ("./users_helper.php");
include_once ("./functions.php");

function render_tags($dbc, $c_id) {

    $query = "SELECT * FROM tags WHERE segment_id = '$c_id'";
    //echo $query;
    $result = mysqli_query($dbc, $query) or die('Error querying database.');
    $tags = array();
    while ($row = mysqli_fetch_array($result)) {
        $link = '<a href="javascript:invokePopupService(\'' . $row[tag] . '\');">' . $row[tag] . '</a>';

        array_push($tags, $link);
    }

    if (count($tags) > 0) {
        return implode(', ', $tags);
    }
}

function render_segment_summary($dbc, $row) {
    $segment_title = $row[title];
    $segment_id = $row[id];

    $segment_content = tcmks_substr($row[content]);
    echo "<h4>";
    $articles = get_articles_by_seg($dbc, $segment_id, false);

    if (count($articles) != 0) {
        echo render_articles_by_seg($dbc, $segment_id, false);
        echo "&nbsp;/&nbsp;";
        echo "<a target=\"_blank\" href = \"article.php?view&id=" . $articles[0] . "#s$segment_id\">" . $segment_title . "</a>";
    } else {
        
        echo "<a target=\"_blank\" href = \"segment.php?id=$segment_id\">" . $segment_title . "</a>";
    }
    echo "</h4>";
    render_user_action($dbc, $row[user_id], '创建于', $row[create_time]);
    echo "<p>" . $segment_content . "...</p>";
}

function get_max_segment_id($dbc) {
    $query = "SELECT MAX(id) as id FROM `tcmks`.`segment`";
    $result = mysqli_query($dbc, $query) or die('Error querying database1.');
    $row = mysqli_fetch_array($result);
    return $row['id'];
}

function copy_segment($dbc, $segment_id) {

    $query = "SELECT * FROM segment WHERE  id = '$segment_id'";
    $result = mysqli_query($dbc, $query) or die('Error querying database1.');
    $row = mysqli_fetch_array($result);

    $new_segment_id = get_max_segment_id($dbc) + 1;
    $title = $row['title'];
    $content = $row['content'];
    $rank = $row['rank'];
    $images = $row['images'];
    $is_comment = $row['is_comment'];
    $user_id = $_SESSION[id];
    $query = "INSERT INTO segment (id, title, content, rank, images, is_comment, user_id) " .
            "VALUES ('$new_segment_id','$title','$content','$rank','$images','$is_comment', '$user_id')";

    $result = mysqli_query($dbc, $query) or die('Error querying database2.');
    return $new_segment_id;
}

function init_segment($dbc, $article_id, $id, $is_comment, $rank) {

    $nid = get_max_segment_id($dbc) + 1;

    $user_id = $_SESSION[id];

    $query = "INSERT INTO segment (id, is_comment, rank, user_id) " .
            "VALUES ('$nid','$is_comment', '$rank','$user_id')";

    $result = mysqli_query($dbc, $query) or die('Error querying database2.');
    insert_segment_into_article($dbc, $article_id, $nid, $id);
    return $nid;
}

function copy_and_insert_segment($dbc, $id, $segment_id, $prev) {
    $new_segment_id = copy_segment($dbc, $segment_id);
    insert_segment_into_article($dbc, $id, $new_segment_id, $prev);
}

function insert_segment_into_article($dbc, $id, $insert, $prev) {

    $query1 = "SELECT segments FROM article WHERE id = '$id'";
    $result1 = mysqli_query($dbc, $query1) or die('Error querying database.');
    $row1 = mysqli_fetch_array($result1);

    $new_segments = str_replace('|' . $prev . '|', '|' . $prev . '|' . $insert . '|', $row1['segments']);

    $update = "update article set segments = '$new_segments' where id = '$id'";
    mysqli_query($dbc, $update) or die('Error querying database.');
}

function render_articles_by_seg($dbc, $segment_id, $get_recycle = true) {
    $articles = get_articles_by_seg($dbc, $segment_id,  $get_recycle);
    $article_links = array();
    foreach ($articles as $article_id) {
        array_push($article_links, get_article_link($dbc, $article_id));
    }
    return implode(',&nbsp;', $article_links);
}

function render_article_summary($dbc, $article_id, $word_count = 0) {
    $article_info = get_article_info($dbc, $article_id);
    echo "<h4><a href = \"article.php?id=$article_id\">" . $article_info[title] . "</a></h4>";
    echo "$article_info[creators]创建于$article_info[create_time]";
    $abstract = get_abstract($dbc, $article_id);
    if ($word_count != 0) {
        $abstract = tcmks_substr($abstract);
    }
    echo '<p>' . $abstract . '</p>';
}

function has_right_to_edit($dbc, $author_id, $article_id) {
    $query = "SELECT * FROM authorship where author_id = $author_id and article_id = $article_id";
    $result = mysqli_query($dbc, $query) or die('Error querying has right to edit.');
    if ($row = mysqli_fetch_array($result)) {
        return true;
    } else {
        return false;
    }
}

function is_deleted($dbc, $id) {
    $query = "SELECT deleted FROM article where id = '$id'";
    $result = mysqli_query($dbc, $query) or die('Error querying database.');

    if ($row = mysqli_fetch_array($result)) {
        return $row[deleted] == 1;
    }
}

function is_published($dbc, $id) {
    $query = "SELECT published FROM article where id = '$id'";
    $result = mysqli_query($dbc, $query) or die('Error querying database.');

    if ($row = mysqli_fetch_array($result)) {
        return $row[published] == 1;
    }
}

function has_article($dbc, $author_id, $role, $recycle) {


    $query = "SELECT * FROM authorship where author_id = $author_id and role = '$role'";
    $result = mysqli_query($dbc, $query) or die('Error querying database3.');
    while ($row = mysqli_fetch_array($result)) {
        if ($recycle && (is_deleted($dbc, $row[article_id])))
            return true;
        if ((!$recycle) && (!is_deleted($dbc, $row[article_id])))
            return true;
    }
    return false;
}

function get_abstract_id($dbc, $article_id) {
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

function get_content($dbc, $segment_id) {

    $query = "SELECT content FROM segment where id = $segment_id";
    $result = mysqli_query($dbc, $query) or die('Error querying database3.');
    $row = mysqli_fetch_array($result);
    return $row['content'];
}

function is_segment_in_article($dbc, $article_id, $segment_id) {
    $query = "SELECT * FROM article WHERE id = '$article_id' and segments like '%|$segment_id|%'";

    $result = mysqli_query($dbc, $query) or die('Error querying database1.');
    return ($row = mysqli_fetch_array($result)) ? true : false;
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
    return "<a  target=\"_blank\" href = \"article.php?view&id=$id\">$title</a>";
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
        $article_info[deleted] = $row[deleted];
        $article_info[publish_time] = $row[publish_time] == '' ? '尚未发布' : $row[publish_time];


        $article_info[creators] = render_authors($dbc, $id, 'creator');
        return $article_info;
    }
}

function get_articles_by_seg($dbc, $segment_id, $get_recycle = true) {
    $query = "SELECT id FROM article where segments like '%|$segment_id|%'";
    if (!$get_recycle) $query .= " and deleted='0'";
    
    $result = mysqli_query($dbc, $query) or die('Error querying database.');
    $articles = array();
    while ($row = mysqli_fetch_array($result)) {
        array_push($articles, $row[id]);
    }
    return $articles;
}

function recycle_article($dbc, $article_id) {
    $deleted = is_deleted($dbc, $article_id) ? 0 : 1;
    $query = "update article set deleted = '" . $deleted . "' where id = '$article_id'";
    mysqli_query($dbc, $query) or die('Error querying database:');
}

function publish_article($dbc, $article_id) {
    $query = "update article set published = '1', publish_time = NOW() where id = '$article_id'";
    mysqli_query($dbc, $query) or die('Error querying database:');
}

function revoke_article($dbc, $article_id) {
    $query = "update article set published = '0', publish_time = null where id = '$article_id'";
    mysqli_query($dbc, $query) or die('Error querying database:');
}

function delete_segment($dbc, $id) {
    $query = "DELETE FROM segment WHERE id = '$id'";
    mysqli_query($dbc, $query);
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

function is_segment_used($dbc, $segment_id) {
    $articles = get_articles_by_seg($dbc, $segment_id);
    return (count($articles) != 0);
}

?>
