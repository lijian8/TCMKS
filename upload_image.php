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
        $subject = $_POST['subject'];
        $discription = $_POST['discription'];
        $segment_id = $_POST['segment_id'];
        $article_id = $_POST['article_id'];

        if (isset($_POST['images'])) {
            $images = $_POST['images'];
        } else {
            $images = array();
        }
        
        $image_id = upload_image($dbc, $name, $subject, $discription);
        
        insert_into_segment($dbc, $segment_id, $image_id);
        array_push($images, $image_id);

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
                <label class="control-label" for="subject">标签:</label>
                <div class="controls" >
                    <input class="input-xlarge" type="text" placeholder="请输入图片标签" id="subject" name="subject" value="<?php if (!empty($subject)) echo $subject; ?>" />
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