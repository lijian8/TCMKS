<?php

function get_file_by_id($dbc, $id) {
    $query = "SELECT file FROM resource WHERE id = '$id'";

    $result = mysqli_query($dbc, $query) or die('Error querying database.');
    if ($row = mysqli_fetch_array($result)) {
        return $row[file];
    }
}

function get_max_resource_id($dbc) {
    $query = 'select max(id) as id from resource';
    $result = mysqli_query($dbc, $query) or die('Error querying database.');
    if ($row = mysqli_fetch_array($result)) {
        return $row[id];
    }
}

function init_resource($dbc, $type) {
    $file_id = get_max_resource_id($dbc) + 1;
    $user_id = $_SESSION['id'];

    $query = "INSERT INTO resource (id, create_time, user_id, type) VALUES ('$file_id',NOW(), '$user_id', '$type')";
    //echo $query;
    mysqli_query($dbc, $query);
    return $file_id;
}

function get_title_by_id($dbc, $id) {
    $query = "SELECT title FROM resource WHERE id = '$id'";

    $result = mysqli_query($dbc, $query) or die('Error querying database.');
    if ($row = mysqli_fetch_array($result)) {
        return $row[title] == '' ? '(题目不详）' : $row[title];
    }
}

function delete_resource($dbc, $id) {
    $file = GW_UPLOADPATH . get_file_by_id($dbc, $id);
    unlink($file);

    $query = "DELETE FROM resource WHERE id = '$id'";
    mysqli_query($dbc, $query) or die('Error querying database.');
}

function render_resource_as_item($row) {

    if ($row['identifier'] != '') {
        $link = '<a href="' . $row['identifier'] . '">' . $row['title'] . '</a>';
    }else{
        $link = $row['title'];
    }

    //$link = '<a href="javascript:invokePopupService(\'' . $row['id'] . '\',\'resource\');">' . $row['title'] . '</a>';

    echo $row['creator'] . '.' . $link . '.' . $row['source'] . '.' . $row['publisher'];
    $file_name = iconv('utf-8', 'gb2312', $row['file']);

    echo '<a class = "btn btn-success" href="javascript:invokePopupService(\'' . $row['id'] . '\',\'resource\');"><i class="icon-search icon-white"></i>&nbsp;查看</a>';
    echo '&nbsp;';
    if (is_file(GW_UPLOADPATH . $file_name)) {
        echo '<a class = "btn btn-warning" href="' . GW_UPLOADPATH . $row['file'] . '"><i class="icon-download-alt icon-white"></i>&nbsp;下载原文</a>';
    }
}

function render_resource_list($dbc, $biblio) {
    if (count($biblio) != 0) {
        echo '<ol>';
        foreach ($biblio as $ref) {
            $q3 = "SELECT * FROM resource WHERE id = '$ref'";
            $r3 = mysqli_query($dbc, $q3) or die('Error querying database2.');
            if ($row = mysqli_fetch_array($r3)) {
                echo "<li id = \"" . $row['id'] . "\">";
                render_resource_as_item($row);
                echo '</li>';
            } else {
                echo "<li id = \"" . $ref . "\">该文献信息已不存在。</li>";
            }
        }
        echo '</ol>';
    }
}

?>
 