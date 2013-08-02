<?php
require_once('appvars.php');
require_once('connectvars.php');
include_once ("./image_helper.php");
session_name('tzLogin');
session_start();
//get the q parameter from URL
$id = $_GET["id"];
$user_id = $_SESSION['id'];

//lookup all links from the xml file if length of q>0
if (strlen($id) > 0) {
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($id == 'new') {
        $image_id = init_image($dbc, $user_id);
        
    } else {
        $image_id = $id;
        
        $query = "SELECT * FROM images WHERE id= '$image_id'";
        $result = mysqli_query($dbc, $query) or die('Error querying database.');
        if ($row = mysqli_fetch_array($result)) {
            $name = $row['name'];
            $subject = $row['name'];
            $description = $row['description'];            
        }
    }
    ?>
    <form enctype="multipart/form-data" class="form-horizontal" method="post" action="image_manager.php">
        <input  type="hidden" id="image_id" name="image_id" value = "<?php if (isset($image_id)) echo $image_id; ?>" >

        <div class="control-group" >
            <label class="control-label" for="name">题目:</label>
            <div class="controls" >
                <input class="input-xlarge" type="text" placeholder="请输入图片题目" id="name" name="name" value="<?php if (isset($name)) echo $name; ?>" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="description">说明:</label>
            <div class="controls">
                <textarea class="input-xlarge" id="description" name="description" placeholder="请输入图片说明" rows="6"><?php if (isset($description)) echo $description; ?></textarea>
            </div>
        </div>
        <div class="control-group" >
            <label class="control-label" for="subject">标签:</label>
            <div class="controls" >
                <input class="input-xlarge" type="text" placeholder="请输入图片标签" id="subject" name="subject" value="<?php if (isset($subject)) echo $subject; ?>" />
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
    <?php
}
?>