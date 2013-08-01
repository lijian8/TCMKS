<?php
function get_file_by_id($dbc, $id) {
    $query = "SELECT file FROM resource WHERE id = '$id'";
   
    $result = mysqli_query($dbc, $query) or die('Error querying database.');
    if ($row = mysqli_fetch_array($result)) {
        return $row[file];
    }
}

function init_resource($dbc){
    $file_id = getMaxImageId($dbc) + 1;
    $query = "INSERT INTO resource (id, create_time) VALUES ('$file_id',NOW())";     
    echo $query;
    mysqli_query($dbc, $query);  
    return $file_id;
}

function get_title_by_id($dbc, $id) {
    $query = "SELECT title FROM resource WHERE id = '$id'";
    
    $result = mysqli_query($dbc, $query) or die('Error querying database.');
    if ($row = mysqli_fetch_array($result)) {
        return $row[title];
    }
}

function delete_resource($dbc, $id) {
    $file = GW_UPLOADPATH . get_file_by_id($dbc, $id);
    unlink($file);
    
    $query = "DELETE FROM resource WHERE id = '$id'";
    mysqli_query($dbc, $query) or die('Error querying database.');

}
?>
 