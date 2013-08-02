<?php
include_once ("./header.php");
include_once ("./resource_helper.php");
echo '<p></p>';
require_once('appvars.php');
//require_once('connectvars.php');

function getMaxImageId($dbc) {
    $query = "SELECT MAX(id) AS id FROM resource";

    $result = mysqli_query($dbc, $query) or die('Error querying database.');
    $row = mysqli_fetch_array($result);
    return $row[id];
}

function upload_file($file_id) {
    if ($_FILES["file"]["error"] > 0) {
        echo "Error: " . $_FILES["file"]["error"] . "<br />";
    } else {
        $file_name = $file_id . '.' . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        if (file_exists(GW_UPLOADPATH . $file_name)) {
            unlink(GW_UPLOADPATH . $file_name);
        }

        $name = iconv('utf-8', 'gb2312', $file_name);
//move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $_FILES["file"]["name"]);
        if (move_uploaded_file($_FILES["file"]["tmp_name"], GW_UPLOADPATH . $name)) {
            return $file_name;
        }
    }
}

//$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'create') {
        //echo 'create new resource!';
        $type = $_GET['type'];
        $file_id = init_resource($dbc, $type);
    } elseif ($_GET['action'] == 'update') {
        $file_id = $_GET['file_id'];
        $query = "SELECT * FROM resource WHERE id = '$file_id'";
        $result = mysqli_query($dbc, $query) or die('Error querying database.');
        if ($row = mysqli_fetch_array($result)) {
            $title = $row['title'];
            $creator = $row['creator'];
            $publisher = $row['publisher'];
            $description = $row['description'];
            $type = $row['type'];
            $subject = $row['subject'];
            
        }
    }
} elseif (isset($_POST['submit'])) {
    $file_id = $_POST['file_id'];
    echo $file_id;
    if (is_uploaded_file($_FILES['file']['tmp_name'])) {
        $file_name = upload_file($file_id);
    }else{
        echo '您没有上传原文！';
    }
    echo $file_name;
    $title = $_POST['title'];
    $creator = $_POST['creator'];
    $publisher = $_POST['publisher'];
    $description = $_POST['description'];
    $type = $_POST['type'];
    $subject = $_POST['subject'];
            
    $query = "update resource set ";
    if ('' != $title){
        $query .= "title = '$title',"; 
    }
    
    if ('' != $file_name){
        $query .= "file = '$file_name',"; 
    }
    
    if ('' != $creator){
        $query .= "creator='$creator',"; 
    }
    
    if ('' != $description){
        $query .= "description = '$description',"; 
    }
    
    if ('' != $publisher){
        $query .= "publisher = '$publisher', "; 
    }
    
    if ('' != $subject){
        $query .= "subject = '$subject' "; 
    }
    
    $query .= " where id = '$file_id'";
    echo $query;

    //$query = "INSERT INTO resource VALUES ('$file_id', '$title', '$file_name', '$creator', '$journal', '$pages', '$year', '$publisher',NULL)";
    mysqli_query($dbc, $query);

    echo '<div class="alert alert-success">';
    echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
    echo '<h4>文献录入成功!</h4>';
    echo '文献信息如下：';
    echo '<dl class="dl-horizontal">';
    echo "<dt>文献题目:</dt><dd>" . $title . '</dd>';
    echo "<dt>文献类型:</dt><dd>" . $type . '</dd>';    
    echo "<dt>文件名称:</dt><dd>" . $file_name . "</dd>";
    echo "<dt>文件类型:</dt><dd>" . $_FILES["file"]["type"] . "</dd>";
    echo "<dt>文件尺寸:<dt><dd>" . ($_FILES["file"]["size"] / 1024) . "Kb</dd>";
    echo '</dl></div>';
}
//echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
?>

<div class="row-fluid">
    <div class="span2">
    </div>  
    <div class="span8">
        <form action="upload_file.php" method="post" class="form-horizontal"
              enctype="multipart/form-data">
            <legend>请录入<?php  echo isset($type) ? $type : '文献'; ?>的信息：</legend>
            <input  type="hidden" id="file_id" name="file_id" value = "<?php if (isset($file_id)) echo $file_id; ?>" >
            <input  type="hidden" id="type" name="type" value = "<?php if (isset($type)) echo $type; ?>" >

            <div class="control-group">
                <label class="control-label" for="title">题名:</label>
                <div class="controls">
                    <input class="span12" type="text" id="title" name="title" value = "<?php if (isset($title)) echo $title; ?>" placeholder="请输入文献的题目">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="creator">创建者:</label>
                <div class="controls">
                    <input class="span12" type="text" id="creator" name="creator" value = "<?php if (isset($creator)) echo $creator; ?>" placeholder="请输入作者">
                </div>
            </div>
                    

            <div class="control-group">
                <label class="control-label" for="publisher">出版者:</label>
                <div class="controls">
                    <input class="span12" type="text" id="publisher" name="publisher" value = "<?php if (isset($publisher)) echo $publisher; ?>" placeholder="请输入出版者">

                </div>
            </div>               
            
            <div class="control-group">
                <label class="control-label" for="subject">主题:</label>
                <div class="controls">
                    <input class="span12" type="text" id="subject" name="subject" value = "<?php if (isset($subject)) echo $subject; ?>" placeholder="请输入主题">

                </div>
            </div>               


            <div class="control-group">
                <label class="control-label" for="description">描述:</label>
                <div class="controls">
                    <textarea class="span12" id="description" name="description"  placeholder="请输入描述" rows="6"><?php if (isset($description)) echo $description; ?></textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="file">上传原文:</label>
                <div class="controls">
                    <input class="span12" type="file" name="file" id="file" />                
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <input class="btn btn-primary" type="submit" name="submit" value="提交" />    
                    <a class="btn btn-success" href="resource_manager.php">返回首页</a>
                </div>
            </div>

        </form>

    </div>
</div>

<?php
mysqli_close($dbc);
include_once ("./foot.php");
?>
