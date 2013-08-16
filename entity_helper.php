<?php

function delete_triple($dbc, $id) {
    $query = "DELETE FROM graph WHERE id = '$id'";
    mysqli_query($dbc, $query) or die('Error querying database.');
}

function render_graph($dbc, $name, $edit) {
    $query = "select * from graph where subject ='$name'";
    $result = mysqli_query($dbc, $query) or die('Error querying database2.');
    while ($row = mysqli_fetch_array($result)) {
        $property = $row[property];
        $value = $row[value];
        $id = $row[id];
        echo "<p><strong>$property</strong>:&nbsp;$value";
        if ($edit) {
            echo '<a href="' . $_SERVER['PHP_SELF'] . '?name=' . $name . '&delete_triple_id=' . $id . '"><i class="icon-remove-circle"></i></a>';
        }
        echo "</p>";
    }
}

function render_entity($dbc, $name, $edit = false) {
    $query = "select * from def where name ='$name'";
    $width = $edit ? 200 : 100;

    $result = mysqli_query($dbc, $query) or die('Error querying database2.');
    if ($row = mysqli_fetch_array($result)) {
        //$id = $row[id];
        $def = $row[def];
        $image_file = 'img/' . get_image_file_by_name($dbc, $name);

        echo '<div class="media">';
        echo '<a class="pull-right" href="search.php?keywords=' . $name . '">';
        echo '<img width="' . $width . '" class="media-object" src="' . $image_file . '" data-src="holder.js/64x64">';
        echo '</a>';
        echo '<div class="media-body"  align ="left">';
        echo '<h2>' . $name . '</h2>';
        echo '<h4>' . $def . '</h4>';
        echo '</div></div>';
        echo '<div  align ="left">';
        if (isset($name)) {
            render_graph($dbc, $name, $edit);
        }
        echo '</div>';
      
    } else {
        render_warning('暂无"' . $name . '"的相关信息！');
    }
}

?>
