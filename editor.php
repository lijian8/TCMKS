<?php
include_once ("./header.php");

function getTags($dbc, $segment_id) {
    $query = "SELECT * FROM tags WHERE segment_id = '$segment_id'";
    //echo $query;
    $result = mysqli_query($dbc, $query) or die('Error querying database.');
    $tags = array();
    while ($row = mysqli_fetch_array($result)) {
        array_push($tags, $row[tag]);
    }

    return implode(', ', $tags);
}

function modifyTags($dbc, $segment_id, $tag_string) {

    $query = "DELETE FROM tags WHERE segment_id = '$segment_id'";
    //echo $query;
    mysqli_query($dbc, $query) or die('Error querying database.');

    $tag_string = str_replace(',', ' ', $tag_string);
    $tag_string = str_replace('，', ' ', $tag_string);
    $tag_string = str_replace('.', ' ', $tag_string);
    $tag_string = str_replace('。', ' ', $tag_string);
    $tag_string = str_replace('；', ' ', $tag_string);

    $tags = explode(' ', $tag_string);
    //$final_tags = array();
    if (count($tags) > 0) {
        foreach ($tags as $tag) {
            if (!empty($tag)) {
                //$final_tags[] = $tag;
                $query = "INSERT INTO tags VALUES('$segment_id','".mysql_escape_string($tag)."')";
                mysqli_query($dbc, $query) or die('Error querying database.');
            }
        }
    }
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $article_id = $_GET['article_id'];
    $query = "SELECT * FROM segment WHERE id = '$id'";
    $result = mysqli_query($dbc, $query) or die('Error querying database.');
    $row = mysqli_fetch_array($result);
    $next = $row['next'];

    if ($_GET['act'] == 'edit') {
        $title = $row['title'];
        $content = $row['content'];
        $rank = $row['rank'];  
        $tags = getTags($dbc, $id);
    } else {
        $query = "SELECT MAX(id) as id FROM `tcmks`.`segment`";
        $result = mysqli_query($dbc, $query) or die('Error querying database1.');
        $row = mysqli_fetch_array($result);
        $nid = $row['id'] + 1;
        $query = "INSERT INTO segment (id, article_id, prev, next) " .
                "VALUES ('$nid','$article_id','$id', '$next')";
        $result = mysqli_query($dbc, $query) or die('Error querying database2.');

        $query1 = "SELECT segments FROM article WHERE id = '$article_id'";
        $result1 = mysqli_query($dbc, $query1) or die('Error querying database.');
        $row1 = mysqli_fetch_array($result1);

        $new_segments = str_replace('|' . $id. '|', '|' . $id . '|' . $nid. '|', $row1['segments']);

        $update = "update article set segments = '$new_segments' where id = '$article_id'";
        mysqli_query($dbc, $update) or die('Error querying database.');

        //$query = "UPDATE segment SET next = '$nid' WHERE id = '$id'";
        //$result = mysqli_query($dbc, $query) or die('Error querying database2.');
        $id = $nid;
    }
} else {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $rank = $_POST['rank'];    
    $content = $_POST['content'];
    $article_id = $_POST['article_id'];
    $tags = $_POST['tags'];
    $query = "UPDATE segment SET rank = '$rank', title = '". mysql_escape_string($title)."', content = '". mysql_escape_string($content)."' WHERE id = '$id'";
    
    $result = mysqli_query($dbc, $query) or die('Error querying database.');
    modifyTags($dbc, $id, $tags);
}
mysqli_close($dbc);
?>
<p></p>
<script>
    function InsertText() {
        //alert("Hellodreamdu!");
        // Get the editor instance that we want to interact with.
        var editor = CKEDITOR.instances.content;
        var value = "#" + document.getElementById('fileSearchInput').value + "#";

        // Check the active editing mode.
        if (editor.mode == 'wysiwyg')
        {
            // Insert as plain text.
            // http://docs.ckeditor.com/#!/api/CKEDITOR.editor-method-insertText
            editor.insertText(value);
        }
        else
            alert('You must be in WYSIWYG mode!');
    }
</script>

<div class="container">

    <form method="post" class="form-horizontal" action="editor.php">
        <legend>编辑段落：</legend>
        <div class="control-group">
            <label class="control-label" for="title">段落标题:</label>
            <div class="input-append" class="span12">
                <input  type="text" id="title" class ="input-xxlarge" name="title" value ="<?php echo $title; ?>">
                <select  name="rank">
                    <option <?php if ($rank == 1) echo 'selected="selected"'; ?>  value="1">一级标题</option>
                    <option <?php if ($rank == 2) echo 'selected="selected"'; ?> value="2">二级标题</option>
                </select>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="title">标签:</label>
            <input  type="text" id="tags" class ="input-xxlarge" cols="200" name="tags" value ="<?php echo $tags; ?>">
        </div>

        <div class="control-group">
            <label class="control-label">插入链接:</label>
            <?php
            include_once ("./file_selector.php");
            ?>
        </div>




        <p></p>


        <textarea class="ckeditor span12" cols="200" id="content" name="content" rows="10"><?php echo $content; ?></textarea>
        <p></p>
        <input class="btn btn-primary" type="submit" value="保存" name="submit" />
        <a class="btn btn-success" href="article.php?id=<?php echo $article_id; ?>">查看</a>

        <input type="hidden" name="id" value ="<?php echo $id; ?>"></input><br/>
        <input type="hidden" name="article_id" value ="<?php echo $article_id; ?>"></input><br/>



    </form>


</div>







<?php
include_once ("./foot.php");
?>
