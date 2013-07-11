<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
       
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

        <form method="post" action="editor.php">
            <label for="title">标题:</label>
            <br/>
            <input type="text" size ="100" name="title" value ="<?php echo $title; ?>"></input><br/>
            
            <label for="content">内容:</label>
            <br/>
            <textarea name="content" rows="15" cols="100"><?php echo $content; ?></textarea><br/>
            <input type="submit" value="保存" name="submit" />
            
            <input type="hidden" name="id" value ="<?php echo $id; ?>"></input><br/>
            <input type="hidden" name="article_id" value ="<?php echo $article_id; ?>"></input><br/>
           
            <a href="article.php?id=<?php echo $article_id; ?>">查看</a>
        </form>
    </body>
</html>
