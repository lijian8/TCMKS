<?php
function get_file_by_id($dbc, $id) {
    $query = "SELECT file FROM resource WHERE id = '$id'";
   
    $result = mysqli_query($dbc, $query) or die('Error querying database.');
    if ($row = mysqli_fetch_array($result)) {
        return $row[file];
    }
}

function init_resource($dbc, $type){ 
    $file_id = getMaxImageId($dbc) + 1;
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
 