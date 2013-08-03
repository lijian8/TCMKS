<?php
include_once ("./header.php");
include_once ("./users_helper.php");


function get_new_id($dbc) {
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


if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $abstract = $_POST['abstract'];



    $id = get_new_id($dbc);

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
                <label class="control-label" for="abstract">摘要:</label>
                <div class="controls">
                    <textarea class="input-block-level" id="abstract" name="abstract" placeholder="请输入摘要" rows="10"></textarea>                    
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
