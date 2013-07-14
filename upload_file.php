<?php
include_once ("./header.php");
?>

<?php
echo '<p></p>';
require_once('appvars.php');
require_once('connectvars.php');

if (isset($_POST['submit'])) {
    if ($_FILES["file"]["error"] > 0) {
        echo "Error: " . $_FILES["file"]["error"] . "<br />";
    } else {
        $file_name = $_FILES["file"]["name"];

        if (file_exists("upload/" . $file_name)) {
            echo $_FILES["file"]["name"] . " 已经存在。 ";
        } else {
            $name = iconv('utf-8', 'gb2312', $file_name);

            //move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $_FILES["file"]["name"]);
            if (move_uploaded_file($_FILES["file"]["tmp_name"], GW_UPLOADPATH . $name)) {
                $id = $_POST['file_id'];
                $title = $_POST['title'];
                $authors = $_POST['authors'];
                $journal = $_POST['journal'];
                $pages = $_POST['pages'];
                $year = $_POST['year'];
                $publisher = $_POST['publisher'];

                $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

                // Write the data to the database
                $query = "INSERT INTO resource VALUES ('$id', '$title', '$file_name', '$authors', '$journal', '$pages', '$year', '$publisher',NULL)";
                //echo $query;
                mysqli_query($dbc, $query);
                //echo $id . "<br/>";
                echo '<div class="alert alert-success">';
                echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                echo '<h4>上传成功!</h4>';
                echo '文献信息如下：';
                echo '<dl class="dl-horizontal">';
                echo "<dt>文献题目:</dt><dd>" . $title . '</dd>';
                echo "<dt>文件名称:</dt><dd>" . $file_name . "</dd>";
                echo "<dt>文件类型:</dt><dd>" . $_FILES["file"]["type"] . "</dd>";
                echo "<dt>文件尺寸:<dt><dd>" . ($_FILES["file"]["size"] / 1024) . "Kb</dd>";
                echo '</dl></div>';
            }
            //echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
        }
    }
}
?>

<div class="row-fluid">
    <div class="span2">
    </div>  
    <div class="span8">
        <form action="upload_file.php" method="post" class="form-horizontal"
              enctype="multipart/form-data">
            <legend>请上传文献：</legend>
            <div class="control-group" >
                <label class="control-label" for="file_id">标识:</label>
                <div class="controls" >
                    <input class="span12" type="text"  id="file_id" name="file_id" placeholder="请输入标识">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="title">题目:</label>
                <div class="controls">
                    <input class="span12" type="text" id="title" name="title" placeholder="请输入文献的题目">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="authors">作者:</label>
                <div class="controls">
                    <input class="span12" type="text" id="authors" name="authors" placeholder="请输入作者">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="journal">期刊:</label>
                <div class="controls">
                    <input class="span12" type="text" id="journal" name="journal" placeholder="请输入期刊">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="year">年份:</label>
                <div class="controls controls-row">   
                    <input class="span12" type="text" id="year" name="year" placeholder="请输入年份">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="vol">卷号:</label>
                <div class="controls controls-row">   
                    <input class="span12" type="vol" id="vol" name="vol" placeholder="请输入卷号">
                </div> 
            </div>

            <div class="control-group">
                <label class="control-label" for="iss">期号:</label>
                <div class="controls controls-row">   
                    <input class="span12" type="iss" id="iss" name="iss" placeholder="请输入期号">
                </div> 
            </div>

            <div class="control-group"">
                <label class="control-label" for="pages">页码:</label>  
                <div class="controls controls-row">   
                    <input class="span12" type="text" id="pages" name="pages" placeholder="请输入页码">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="publisher">出版者:</label>
                <div class="controls">
                    <input class="span12" type="text" id="publisher" name="publisher" placeholder="请输入出版者">

                </div>
            </div>               



            <div class="control-group">
                <label class="control-label" for="abstract">摘要:</label>
                <div class="controls">
                    <textarea class="span12" id="abstract" name="abstract" placeholder="请输入摘要" rows="6"></textarea>
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
                    <a class="btn btn-success" href="index.php">返回首页</a>
                </div>
            </div>

        </form>

    </div>
</div>

<?php
include_once ("./foot.php");
?>
