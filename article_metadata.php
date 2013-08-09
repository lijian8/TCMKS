<?php
include_once ("./header.php");
include_once ("./users_helper.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM article WHERE id='$id'";
    //echo $query;
    $result = mysqli_query($dbc, $query) or die('Error querying database table:article');
    if ($row = mysqli_fetch_array($result)) {
        $title = $row['title'];
    }
}

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];


    $query = "update article set title = '".mysql_escape_string($title)."' where id = '$id'";
    mysqli_query($dbc, $query) or die('Error querying database:');

    $query = "delete from authorship where article_id = '$id' and role != 'creator'";
    mysqli_query($dbc, $query) or die('Error querying database:');

    $authors = $_POST['authors'];
    if (empty($authors)) {
        echo("您未指定作者！");
    } else {
        $N = count($authors);
        for ($i = 0; $i < $N; $i++) {
            $query = "INSERT INTO authorship (article_id, author_id, role) " .
                    "VALUES ('$id','$authors[$i]', 'author')";
            //echo $query;
            mysqli_query($dbc, $query) or die('Error querying database:');
        }
    }

    $reviewers = $_POST['reviewers'];
    if (empty($reviewers)) {
        echo("您未指定评审！");
    } else {
        $N = count($reviewers);
        for ($i = 0; $i < $N; $i++) {
            $query = "INSERT INTO authorship (article_id, author_id, role) " .
                    "VALUES ('$id','$reviewers[$i]', 'reviewer')";
            //echo $query;
            mysqli_query($dbc, $query) or die('Error querying database:');
        }
    }


    $publishers = $_POST['publishers'];
    if (empty($publishers)) {
        echo("您未指定评审！");
    } else {
        $N = count($publishers);
        for ($i = 0; $i < $N; $i++) {
            $query = "INSERT INTO authorship (article_id, author_id, role) " .
                    "VALUES ('$id','$publishers[$i]', 'publisher')";
            //echo $query;
            mysqli_query($dbc, $query) or die('Error querying database:');
        }
    }

    echo '<div class="alert alert-success">';
    echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
    echo '<h4>综述文献' . $title . '创建成功!</h4>';
    echo '<p>' . $abstract . '</p>';
    echo '<a href="article.php?id=' . $id . '">查看并编辑</a>';
    echo '</div>';
}
?>


<div class="row-fluid">
    <div class="span2">
    </div>  
    <div class="span8">
        <form method="post" class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <legend>请填写综述文献的基本信息：</legend>
            <div class="control-group">
                <label class="control-label" for="title">标题:</label>
                <div class="controls">
                    <input class="input-block-level" type="text" id="title" name="title" value=" <?php if (isset($title)) echo $title; ?> " placeholder="请输入综述的标题">
                </div>
            </div>         
            <input  type="hidden" id="id" name="id" value = "<?php if (isset($id)) echo $id; ?>" >

            <div class="control-group">
                <!-- Select Multiple -->
                <label class="control-label" for="authors[]">作者:</label>
                <div class="controls">
                    <select id="authors[]" name ="authors[]" class="input-block-level" multiple="multiple">
                        <?php render_author_list($dbc, $id); ?>                        
                    </select>
                </div>
            </div>
            <div class="control-group">
                <!-- Select Multiple -->
                <label class="control-label" for="reviewers[]">评审:</label>
                <div class="controls">
                    <select id="reviewers[]" name ="reviewers[]" class="input-block-level" multiple="multiple">
                        <?php render_reviewer_list($dbc, $id); ?>                        
                    </select>
                </div>
            </div>
            <div class="control-group">
                <!-- Select Multiple -->
                <label class="control-label" for="publishers[]">发布者:</label>
                <div class="controls">
                    <select id="publishers[]" name ="publishers[]" class="input-block-level" multiple="multiple">
                        <?php render_publisher_list($dbc, $id); ?>                        
                    </select>
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <input class="btn btn-primary" type="submit" name="submit" value="创建" />    
                    <a class="btn btn-success" href="articles.php">返回首页</a>
                </div>
            </div>

        </form>
    </div> 
</div> 


<?php
include_once ("./foot.php");
?>
