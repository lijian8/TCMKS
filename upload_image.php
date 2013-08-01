<?php
include_once ("./header.php");
include_once ("./image_helper.php");
?>
<div class="row-fluid">
    <?php
    require_once('appvars.php');
    require_once('connectvars.php');

    

    

    function renderImage($dbc, $id) {
        $query = "SELECT * FROM `tcmks`.`images` where id = '$id'";
        //echo $query;
        $result = mysqli_query($dbc, $query) or die('Error querying database.');
        while ($row = mysqli_fetch_array($result)) {
            echo '<li class="span6">';
            echo '<div class = "thumbnail">';
            echo '<img src="' . IMG_UPLOADPATH . $row['file'] . '"  alt="" /></p>';
            echo '<div class = "caption">';
            echo '<p><strong>' . $row['name'] . '.&nbsp;</strong>';
            echo $row['description'] . '</p>';
            echo '</div></div></li>';
        }
    }

    if (isset($_GET['segment_id'])) {
        $segment_id = $_GET['segment_id'];
        $article_id = $_GET['article_id'];
    }
    if (isset($_POST['submit'])) {

        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        $name = $_POST['name'];
        $score = $_POST['score'];
        $discription = $_POST['discription'];
        $segment_id = $_POST['segment_id'];
        $article_id = $_POST['article_id'];

        if (isset($_POST['images'])) {
            $images = $_POST['images'];
        } else {
            $images = array();
        }
        
        $image_id = upload_image($dbc, $name, $score, $discription);
        
        insert_into_segment($dbc, $segment_id, $image_id);
        array_push($images, $image_id);

        /*
        $screenshot = $_FILES['screenshot']['name'];
        $screenshot_type = $_FILES['screenshot']['type'];
        $screenshot_size = $_FILES['screenshot']['size'];

        if (!empty($name) && !empty($score) && !empty($screenshot)) {
            if ((($screenshot_type == 'image/gif') || ($screenshot_type == 'image/jpeg') || ($screenshot_type == 'image/pjpeg') || ($screenshot_type == 'image/png')) && ($screenshot_size > 0) && ($screenshot_size <= IMG_MAXFILESIZE)) {
                if ($_FILES['screenshot']['error'] == 0) {
                    // Move the file to the target upload folder
                    $target = IMG_UPLOADPATH . $screenshot;
                    if (move_uploaded_file($_FILES['screenshot']['tmp_name'], $target)) {
                        // Connect to the database
                        // Write the data to the database
                        $query = "INSERT INTO images VALUES (0,  '$name', '$screenshot', '$score', NOW(),'$discription','$segment_id')";
                        //echo $query;
                        mysqli_query($dbc, $query);
                        $image_id = getMaxImageId($dbc);
                        insert_into_segment($dbc, $segment_id, $image_id);
                        array_push($images, $image_id);


                        $name = "";
                        $score = "";
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
            echo '<p class="error">Please enter all of the information to add your high score.</p>';
        }

        /*
          foreach ($images as $image){
          echo "Select image:". $image;
          } */

        if (!empty($images)) {
            echo '<div class = "span6">';
            echo "<legend>已上传如下图片！您可继续上传图片，或<a href = \"article.php?id=$article_id#s$segment_id\">返回</a>.</legend>";

            $left = true;
            foreach ($images as $cur_image) {
                if ($left) {
                    echo '<ul class = "thumbnails">';
                    renderImage($dbc, $cur_image);
                    $left = false;
                } else {
                    renderImage($dbc, $cur_image);
                    echo '</ul>';

                    $left = true;
                }
            }
            echo '</div >';
        }
        mysqli_close($dbc);
    }
    ?>


    <div class="span3">
        <form enctype="multipart/form-data" class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <legend>请上传图片：</legend>
            <input type="hidden" name="segment_id" value="<?php echo $segment_id; ?>" />
            <input type="hidden" name="article_id" value="<?php echo $article_id; ?>" />



            <?php
            foreach ($images as $image) {
                echo '<input type="hidden" name="images[]" id ="image" value="' . $image . '" />';
            }
            ?>


            <div class="control-group" >
                <label class="control-label" for="file_id">图片题目:</label>
                <div class="controls" >
                    <input class="input-xlarge" type="text" placeholder="请输入图片题目" id="name" name="name" value="<?php if (!empty($name)) echo $name; ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="discription">图片说明:</label>
                <div class="controls">
                    <textarea class="input-xlarge" id="discription" name="discription" placeholder="请输入图片说明" value="<?php if (!empty($discription)) echo $discription; ?>" rows="6"></textarea>
                </div>
            </div>
            <div class="control-group" >
                <label class="control-label" for="score">标签:</label>
                <div class="controls" >
                    <input class="input-xlarge" type="text" placeholder="请输入图片标签" id="score" name="score" value="<?php if (!empty($score)) echo $score; ?>" />
                </div>
            </div>
            <div class="control-group" >
                <label class="control-label" for="screenshot">上传图片:</label>
                <div class="controls" >
                    <input  type="file" id="screenshot" name="screenshot" />
                </div>
            </div>
            <div class="control-group" >
                <div class="controls" >
                    <input class="btn btn-primary" type="submit" value="确定" name="submit" />
                </div>
            </div>

        </form>        
    </div>
</div>   
<?php
include_once ("./foot.php");
?>