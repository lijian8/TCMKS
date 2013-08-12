<?php
include_once ("./header.php");
include_once ("./article_helper.php");

function getTags($dbc, $segment_id) {
    $query = "SELECT * FROM tags WHERE segment_id = '$segment_id'";
    //echo $query;
    $result = mysqli_query($dbc, $query) or die('Error querying database.');
    $tags = array();
    while ($row = mysqli_fetch_array($result)) {
        array_push($tags, $row[tag]);
    }

    return implode(';', $tags);
}

function modifyTags($dbc, $segment_id, $tag_string) {

    $query = "DELETE FROM tags WHERE segment_id = '$segment_id'";
    //echo $query;
    mysqli_query($dbc, $query) or die('Error querying database.');

    /*
      $tag_string = str_replace(',', ' ', $tag_string);
      $tag_string = str_replace('，', ' ', $tag_string);
      $tag_string = str_replace('.', ' ', $tag_string);
      $tag_string = str_replace('。', ' ', $tag_string);
      $tag_string = str_replace('；', ' ', $tag_string); */
    $tag_string = str_replace('；', ';', $tag_string);

    $tags = explode(';', $tag_string);
    //$final_tags = array();
    if (count($tags) > 0) {
        foreach ($tags as $tag) {
            if (!empty($tag)) {
                //$final_tags[] = $tag;
                $query = "INSERT INTO tags VALUES('$segment_id','" . mysql_escape_string($tag) . "')";
                mysqli_query($dbc, $query) or die('Error querying database.');
            }
        }
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $article_id = isset($_GET['article_id'])?$_GET['article_id']:'';

    if ($_GET['act'] == 'edit') {
        $query = "SELECT * FROM segment WHERE id = '$id'";
        $result = mysqli_query($dbc, $query) or die('Error querying database.');
        $row = mysqli_fetch_array($result);
        $title = $row['title'];
        $content = $row['content'];
        $rank = $row['rank'];
        $is_comment = $row['is_comment'];
        $tags = getTags($dbc, $id);
    } else if ($_GET['act'] == 'insert') {
        $is_comment = isset($_GET['is_comment']) ? '1' : '0';
        $rank = $is_comment ? '0' : '1';
        $id = init_segment($dbc, $article_id, $id, $is_comment, $rank);
    }
} else {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $rank = $_POST['rank'];
    $content = $_POST['content'];
    $article_id = isset($_POST['article_id']) ? $_POST['article_id']: '';
    $tags = $_POST['tags'];
    $query = "UPDATE segment SET rank = '$rank', title = '" . mysql_escape_string($title) . "', content = '" . mysql_escape_string($content) . "' WHERE id = '$id'";

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
        <legend>段落编辑器</legend>

        <div class="navbar">
            <div class="navbar-inner">
                <div class="container">

                    <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="#">编辑器</a>

                    <!-- Be sure to leave the brand out there if you want it shown -->

                    <input class="btn btn-primary" type="submit" value="保存" name="submit" /> 
                    <?php
                    $link_for_view = ($article_id !='')? "article.php?id=$article_id#s$id" : "segment.php?id=$id";
                    ?>
                    <a class="btn btn-link" href="<?php echo $link_for_view; ?>"><i class="icon-search"></i>&nbsp;查看</a>
                    <a class="btn btn-link" href="articles.php"><i class="icon-home"></i>返回</a>
                                       
                    <div class="btn-group" >
                        <label  class="control-label" for="title">标题:</label>
                        <input  type="text" id="title" class ="input-large" name="title" value ="<?php echo $title; ?>">

                        <select  name="rank">
                            <option <?php if ($rank == 1) echo 'selected="selected"'; ?>  value="1">一级标题</option>
                            <option <?php if ($rank == 2) echo 'selected="selected"'; ?> value="2">二级标题</option>
                            <option <?php if ($rank == 3) echo 'selected="selected"'; ?> value="3">三级标题</option>
                            <option <?php if ($rank == 4) echo 'selected="selected"'; ?> value="4">四级标题</option>
                            <option <?php if ($rank == 0) echo 'selected="selected"'; ?> value="0">正文</option>
                        </select>
                                  
                        <input  type="text" id="tags" class ="input"  name="tags" value ="<?php echo $tags; ?>" placeholder ="添加标签">
       
                    </div>

                  



                    <!-- Everything you want hidden at 940px or less, place within here -->
                    <div class="nav-collapse collapse">
                        <!-- .nav, .navbar-search, .navbar-form, etc -->
                    </div>

                </div>
            </div>
        </div>

        <textarea class="ckeditor span12" cols="200" id="content" name="content" rows="10"><?php echo $content; ?></textarea>

        <div class="control-group">

<?php
include_once ("./file_selector.php");
?>
        </div>

        <input type="hidden" name="id" value ="<?php echo $id; ?>"></input><br/>
        <input type="hidden" name="article_id" value ="<?php echo $article_id; ?>"></input><br/>
    </form>


</div>







<?php
include_once ("./foot.php");
?>
