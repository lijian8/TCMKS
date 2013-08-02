<?php

function get_all_segments($dbc) {
    $query = "select * from segment";
    $result = mysqli_query($dbc, $query) or die('Error querying database.');
    $segments = array();
    while ($row = mysqli_fetch_array($result)) {
        array_push($segments, $row[id]);
    }
    return $segments;
}

function get_file_by_id($dbc, $image_id) {
    $query = "SELECT file FROM images WHERE id = '$image_id'";
    $result = mysqli_query($dbc, $query) or die('Error querying database.');
    if ($row = mysqli_fetch_array($result)) {
        return $row[file];
    }
}

function delete_image($dbc, $image_id) {
    $file = IMG_UPLOADPATH . get_file_by_id($dbc, $image_id);

    unlink($file);
    $query = "DELETE FROM images WHERE id = '$image_id'";
    mysqli_query($dbc, $query) or die('Error querying database.');

    foreach (get_all_segments($dbc) as $segment_id) {
        delete_image_from_segment($dbc, $segment_id, $image_id);
    }
}

function delete_image_from_segment($dbc, $segment_id, $image_id) {

    $query = "select images from segment where id = '$segment_id'";
    //echo $query;
    $result = mysqli_query($dbc, $query) or die('Error querying database1.');
    $row = mysqli_fetch_array($result);

    $new_images = str_replace('|' . $image_id . '|', '|', $row['images']);
    //echo $new_images;
    $update = "update segment set images = '$new_images' where id = '$segment_id'";
    mysqli_query($dbc, $update) or die('Error querying database.');
}

function insert_into_segment($dbc, $segment_id, $image_id) {

    $query = "SELECT images FROM segment WHERE id = '$segment_id'";
    $result = mysqli_query($dbc, $query) or die('Error querying database.');
    $row = mysqli_fetch_array($result);
    $images = $row['images'];
    if ($images == '') {
        $images = '|' . $image_id . '|';
    } else {
        $images .= $image_id . '|';
    }

    $update = "update segment set images = '$images' where id = '$segment_id'";
    mysqli_query($dbc, $update) or die('Error querying database.');
}

function get_image_name($dbc, $image_id) {
    $query = "SELECT * FROM `tcmks`.`images` WHERE id = $image_id";

    $result = mysqli_query($dbc, $query) or die('Error querying database.');
    $row = mysqli_fetch_array($result);

    return $row[name];
}

function getMaxImageId($dbc) {
    $query = "SELECT MAX(id) AS id FROM `tcmks`.`images`";

    $result = mysqli_query($dbc, $query) or die('Error querying database.');
    $row = mysqli_fetch_array($result);
    return $row[id];
}

function init_image($dbc, $user_id) {
    $image_id = getMaxImageId($dbc) + 1;

    $query = "INSERT INTO images (id, date, user_id) VALUES ('$image_id', NOW(), '$user_id')";
    echo $query;
    mysqli_query($dbc, $query);
    return $image_id;
}

function upload_image($dbc, $name, $subject, $discription) {
    $screenshot = $_FILES['screenshot']['name'];
    $screenshot_type = $_FILES['screenshot']['type'];
    $screenshot_size = $_FILES['screenshot']['size'];
    $user_id = $_SESSION['id'];

    if (!empty($name) && !empty($subject) && !empty($screenshot)) {
        if ((($screenshot_type == 'image/gif') || ($screenshot_type == 'image/jpeg') || ($screenshot_type == 'image/pjpeg') || ($screenshot_type == 'image/png')) && ($screenshot_size > 0) && ($screenshot_size <= IMG_MAXFILESIZE)) {
            if ($_FILES['screenshot']['error'] == 0) {
                // Move the file to the target upload folder
                //$target = IMG_UPLOADPATH . $screenshot;
                $image_id = getMaxImageId($dbc) + 1;
                $new_file_name = $image_id . '.' . pathinfo($screenshot, PATHINFO_EXTENSION);
                $target = IMG_UPLOADPATH . $new_file_name;
                if (move_uploaded_file($_FILES['screenshot']['tmp_name'], $target)) {
                    // Connect to the database
                    // Write the data to the database
                    $query = "INSERT INTO images VALUES ('$image_id', '$name', '$new_file_name', '$subject', NOW(), '$discription', '1', '$user_id')";
                    echo $query;
                    mysqli_query($dbc, $query);

                    $name = "";
                    $subject = "";
                    $screenshot = "";
                } else {
                    echo '<p class="error">Sorry, there was a problem uploading your screen shot image.</p>';
                }
            }
        } else {
            echo '<p class="error">The screen shot must be a GIF, JPEG, or PNG image file no greater than ' . (GW_MAXFILESIZE / 1024) . ' KB in size.</p>';
        }

        // Try to delete the temporary screen shot image file
        @unlink($_FILES['screenshot']['tmp_name']);
    } else {
        echo '<p class="error">请录入完整的信息。</p>';
    }
    return $image_id;
}

function update_image($dbc, $image_id, $name, $subject, $description){
    $image_file = upload_image_file($image_id); 
               
    
    if ('' != $name){
        $query = "update images set name = '$name' where id = '$image_id'";
        mysqli_query($dbc, $query);
    }
    
    if ('' != $image_file){
        $query = "update images set file = '$image_file' where id = '$image_id'";
        mysqli_query($dbc, $query);
        
    }
    
    if ('' != $subject){
        $query = "update images set subject='$subject' where id = '$image_id'";
        mysqli_query($dbc, $query);
        
    }
    
    if ('' != $description){
        $query = "update images set description = '$description' where id = '$image_id'";
        mysqli_query($dbc, $query);
       
    }
    
   
    
    

    //$query = "INSERT INTO resource VALUES ('$file_id', '$title', '$file_name', '$creator', '$journal', '$pages', '$year', '$publisher',NULL)";
    
    return true;
}


function upload_image_file($image_id) {

    if (is_uploaded_file($_FILES['screenshot']['tmp_name'])) {
        $screenshot = $_FILES['screenshot']['name'];
        $screenshot_type = $_FILES['screenshot']['type'];
        $screenshot_size = $_FILES['screenshot']['size'];

        if ((($screenshot_type == 'image/gif') || ($screenshot_type == 'image/jpeg') || ($screenshot_type == 'image/pjpeg') || ($screenshot_type == 'image/png')) && ($screenshot_size > 0) && ($screenshot_size <= IMG_MAXFILESIZE)) {
            if ($_FILES['screenshot']['error'] == 0) {
                $new_file_name = $image_id . '.' . pathinfo($screenshot, PATHINFO_EXTENSION);
                $target = IMG_UPLOADPATH . $new_file_name;
                if (file_exists(GW_UPLOADPATH . $new_file_name)) {
                    unlink(GW_UPLOADPATH . $new_file_name);
                }
                if (move_uploaded_file($_FILES['screenshot']['tmp_name'], $target)) {
                    return $new_file_name;
                } else {
                    echo '<p class="error">Sorry, there was a problem uploading your screen shot image.</p>';
                }
            }
        } else {
            echo '<p class="error">The screen shot must be a GIF, JPEG, or PNG image file no greater than ' . (GW_MAXFILESIZE / 1024) . ' KB in size.</p>';
        }

        // Try to delete the temporary screen shot image file
        @unlink($_FILES['screenshot']['tmp_name']);
    }
}
?>
 