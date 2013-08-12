<?php

include_once ("./header.php");
include_once ("./users_helper.php");
if (isset($_GET['id'])) {
    $segment_id = $_GET['id'];
    $query = "SELECT * FROM segment WHERE id ='$segment_id'";

    $result = mysqli_query($dbc, $query) or die('Error querying database2.');
    while ($row = mysqli_fetch_array($result)) {
        echo '<div class="container">';

        echo '<h1><font face="微软雅黑" >' . $row[title] . '</font>&nbsp;';
        
        if (is_segment_editable($dbc, $segment_id)) {
            echo '<a class="btn btn-success" href="editor.php?act=edit&id=' . $segment_id . '"><i class="icon-edit icon-white"></i>&nbsp;编辑</a>';
        }
        echo '&nbsp;';
        echo '<a class="btn btn-warning" href="search.php"><i class="icon-home icon-white"></i>&nbsp;返回</a>';

        echo '</h1>';
        render_user_action($dbc, $row[user_id], '创建于', $row[create_time]);
        echo '<p>' . $row[content] . '</p>';
        echo '</div>';
    }
} else {
    echo '无相关信息！';
}
include_once ("./foot.php");
?>
