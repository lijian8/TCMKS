<?php

function renderUserList() {
    $dbc = mysqli_connect('localhost', 'tcmks', 'tcmks', 'tcmks') or die('Error connecting to MySQL server.');
    $query = "select * from users";
    $result = mysqli_query($dbc, $query) or die('Error querying database3.');

    while ($row = mysqli_fetch_array($result)) {
        echo '<option value ="' . $row['id'] . '">' . $row['real_name'] . '</option>';
    }
}

function get_id($dbc) {
    $query = "SELECT MAX(id) as id FROM article";
    $result = mysqli_query($dbc, $query) or die('Error querying database3.');
    $row = mysqli_fetch_array($result);
    return $row['id'] + 1;
}

function insert_abstract($dbc, $abstract, $article_id) {
    $query = "SELECT MAX(id) as id FROM `tcmks`.`segment`";
    $result = mysqli_query($dbc, $query) or die('Error querying database1.');
    $row = mysqli_fetch_array($result);
    $id = $row['id'] + 1;
    $query = "INSERT INTO segment (id, title, content, article_id, prev, next) " .
            "VALUES ('$id','摘要','$abstract', '$article_id','0', '0')";
    mysqli_query($dbc, $query) or die('Error querying database2.');
    return $id;
}

include_once ("./header.php");
if (isset($_POST['submit'])) {
    $dbc = mysqli_connect('localhost', 'tcmks', 'tcmks', 'tcmks') or die('Error connecting to MySQL server.');
    $title = $_POST['title'];
    $abstract = $_POST['abstract'];



    $id = get_id($dbc);

    $query = "INSERT INTO article (id, title) " .
            "VALUES ('$id','$title')";
    mysqli_query($dbc, $query) or die('Error querying database:');

    $segment_id = insert_abstract($dbc, $abstract, $id);

    $query = "UPDATE article SET segments = '|$segment_id|' where id = '$id'";
    mysqli_query($dbc, $query) or die('Error querying database5.');


    $creator = $_SESSION['id'];
    $query = "INSERT INTO authorship (article_id, author_id, role) " .
            "VALUES ('$id','$creator', 'creator')";
    //echo $query;
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
        <form method="post" class="form-horizontal" action="create_article.php">
            <legend>请填写综述文献的基本信息：</legend>
            <div class="control-group">
                <label class="control-label" for="title">标题:</label>
                <div class="controls">
                    <input class="input-block-level" type="text" id="title" name="title" placeholder="请输入综述的标题">
                </div>
            </div>         
            <div class="control-group">
                <label class="control-label" for="creator">创建者:</label>
                <div class="controls">
                    <input class="input-block-level" type="text" id="creator" name="creator" value="<?php echo $_SESSION['real_name'] ? $_SESSION['real_name'] : ''; ?>">
                </div>
            </div>
            <div class="control-group">
                <!-- Select Multiple -->
                <label class="control-label" for="authors[]">作者:</label>
                <div class="controls">
                    <select id="authors[]" name ="authors[]" class="input-block-level" multiple="multiple">
                        <?php renderUserList(); ?>                        
                    </select>
                </div>
            </div>
            <div class="control-group">
                <!-- Select Multiple -->
                <label class="control-label" for="reviewers[]">评审:</label>
                <div class="controls">
                    <select id="reviewers[]" name ="reviewers[]" class="input-block-level" multiple="multiple">
                        <?php renderUserList(); ?>                        
                    </select>
                </div>
            </div>
            <div class="control-group">
                <!-- Select Multiple -->
                <label class="control-label" for="publishers[]">发布者:</label>
                <div class="controls">
                    <select id="publishers[]" name ="publishers[]" class="input-block-level" multiple="multiple">
                        <?php renderUserList(); ?>                        
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="abstract">摘要:</label>
                <div class="controls">
                    <textarea class="input-block-level" id="abstract" name="abstract" placeholder="请输入摘要" rows="10"></textarea>                    
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <input class="btn btn-primary" type="submit" name="submit" value="创建" />    
                    <a class="btn btn-success" href="index.php">返回首页</a>
                </div>
            </div>

        </form>
    </div> 
</div> 


<?php
include_once ("./foot.php");
?>
