<?php
include_once ("./header.php");
?>
<div class="row-fluid">
    <?php
    require_once('appvars.php');
    require_once('connectvars.php');

    function getMaxImageId($dbc) {
        $query = "SELECT MAX(id) AS id FROM `tcmks`.`images`";
        $result = mysqli_query($dbc, $query) or die('Error querying database.');
        $row = mysqli_fetch_array($result);
        return $row[id];
    }

    function renderImage($dbc, $id) {
        $query = "SELECT * FROM `tcmks`.`images` where id = $id";
        $result = mysqli_query($dbc, $query) or die('Error querying database.');
        while ($row = mysqli_fetch_array($result)) {
            echo '<li class="span6">';
            echo '<div class = "thumbnail">';
            echo '<img src="' . IMG_UPLOADPATH . $row['file'] . '" alt="" width = "500"/></p>';
            echo '<div class = "caption">';
            echo '<h3>' . $row['name'] . '</h3>';
            echo '<p>' . $row['discription'] . '</p>';
            echo '</div></div></li>';
        }
    }

    if (isset($_POST['submit'])) {

        $name = $_POST['name'];
        $score = $_POST['score'];
        $discription = $_POST['discription'];

        $images[] = $_POST['images'];
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
                        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

                        // Write the data to the database
                        $query = "INSERT INTO images VALUES (0,  '$name', '$screenshot', '$score', NOW(),'$discription')";
                        mysqli_query($dbc, $query);
                        array_push($images, getMaxImageId($dbc));




                        // Confirm success with the user
                        /*
                          echo '<p><strong>Name:</strong> ' . $name . '<br />';
                          echo '<strong>Score:</strong> ' . $score . '<br />';
                          echo '<img src="' . IMG_UPLOADPATH . $screenshot . '" alt="Score image" /></p>';
                          echo '<p><a href="index.php">&lt;&lt; Back to high scores</a></p>';
                         */
                        // Clear the score data to clear the form
                        if (!empty($images[])) {
                            echo '<div class = "span6">';
                            echo '<legend>图片已成功上传！您可以继续上传图片，或<a>返回</a>.</legend>';

                            $left = true;
                            foreach ($images[] as $cur_image) {
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





                        echo '<ul class = "thumbnails">';
                        echo '<li >';
                        echo '<div class = "thumbnail">';
                        echo '<img src="' . IMG_UPLOADPATH . $screenshot . '" alt="" width = "500"/></p>';
                        echo '<div class = "caption">';
                        echo '<h3>' . $name . '</h3>';
                        echo '<p>' . $discription . '</p>';

                        echo '</div></div></li></ul></div >';

                        $name = "";
                        $score = "";
                        $screenshot = "";

                        mysqli_close($dbc);
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
    }
    ?>

    <div class="span3">
        <form enctype="multipart/form-data" class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <legend>请上传图片：</legend>
            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo GW_MAXFILESIZE; ?>" />

            <input type="hidden" name="XYZ[]"  value="A " />
            <input type="hidden" name="XYZ[]"  value="B " />
            <input type="hidden" name="XYZ[]"  value="C " />

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


<hr />

<div class="row-fluid span6">

    <ul class="thumbnails">
        <li class="span6">
            <div class="thumbnail">
                <img src="img/Hepatitis-B.jpg"  alt="">
                <div class="caption">
                    <p><strong>乙肝的形态:</strong>感染乙肝的肝脏与正常肝脏的对比.</p>
                </div>
            </div>
        </li>
        <li class="span6">
            <div class="thumbnail">
                <img src="img/Hepatitis-B.jpg"  alt="">
                <div class="caption">
                    <p><strong>乙肝的形态:</strong>感染乙肝的肝脏与正常肝脏的对比.</p>
                </div>
            </div>
        </li>



    </ul>
    <ul class="thumbnails">


        <li class="span6">
            <div class="thumbnail">
                <img src="img/Hepatitis-B.jpg"  alt="">
                <div class="caption">
                    <p><strong>乙肝的形态:</strong>感染乙肝的肝脏与正常肝脏的对比.</p>
                </div>
            </div>
        </li>
        <li class="span6">
            <div class="thumbnail">
                <img src="img/Hepatitis-B.jpg"  alt="">
                <div class="caption">
                    <p><strong>乙肝的形态:</strong>感染乙肝的肝脏与正常肝脏的对比.</p>
                </div>
            </div>
        </li>
    </ul>
</div>
<?php
include_once ("./foot.php");
?>

