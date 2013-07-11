<?php
include_once ("./header.php");
$dbc = mysqli_connect('localhost', 'tcmks', 'tcmks', 'tcmks') or die('Error connecting to MySQL server.');

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
    } else {
        $query = "SELECT MAX(id) as id FROM `tcmks`.`segment`";
        $result = mysqli_query($dbc, $query) or die('Error querying database1.');
        $row = mysqli_fetch_array($result);
        $nid = $row['id'] + 1;
        $query = "INSERT INTO segment (id, article_id, prev, next) " .
                "VALUES ('$nid','$article_id','$id', '$next')";
        $result = mysqli_query($dbc, $query) or die('Error querying database2.');

        $query = "UPDATE segment SET next = '$nid' WHERE id = '$id'";
        $result = mysqli_query($dbc, $query) or die('Error querying database2.');
        $id = $nid;
    }
} else {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $article_id = $_POST['article_id'];
    $query = "UPDATE segment SET title = '$title', content = '$content' WHERE id = '$id'";
    $result = mysqli_query($dbc, $query) or die('Error querying database.');
}
mysqli_close($dbc);
?>
<p></p>
<script>
    function InsertText() {
        alert("Hellodreamdu!");    
    // Get the editor instance that we want to interact with.
	var editor = CKEDITOR.instances.content;
	var value = document.getElementById( 'title' ).value;

	// Check the active editing mode.
	if ( editor.mode == 'wysiwyg' )
	{
		// Insert as plain text.
		// http://docs.ckeditor.com/#!/api/CKEDITOR.editor-method-insertText
		editor.insertText( value );
	}
	else
		alert( 'You must be in WYSIWYG mode!' );
    }
</script>
    
<div class="container">
    <div class="row-fluid">
        <form method="post" class="form-inline" action="editor.php">

            <label  for="title">段落标题:</label>
            <div class="input-append" class="span8">
                <input  type="text" id="title"  cols="200" name="title" value ="<?php echo $title; ?>">
                <select  name="rank">
                    <option value="0">一级标题</option>
                    <option value="1">二级标题</option>
                </select>
            </div>
             <input onclick="InsertText();" type="button" value="Insert Text">
            <input class="btn btn-primary" type="submit" value="保存" name="submit" />
            <a class="btn btn-success" href="article.php?id=<?php echo $article_id; ?>">查看</a>
            <p></p>


            <textarea class="ckeditor span12" cols="200" id="content" name="content" rows="10"><?php echo $content; ?></textarea>



            <input type="hidden" name="id" value ="<?php echo $id; ?>"></input><br/>
            <input type="hidden" name="article_id" value ="<?php echo $article_id; ?>"></input><br/>


        </form>
    </div>
</div>



<?php
include_once ("./foot.php");
?>
