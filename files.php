<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <h2>Guitar Wars - High Scores</h2>
        <p>Welcome, Guitar Warrior, do you have what it takes to crack the high score list? If so, just <a href="addscore.php">add your own score</a>.</p>
        <hr />
        <?php
        require_once('appvars.php');
        require_once('connectvars.php');

        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        $query = "SELECT * FROM resource ORDER BY title ASC";
        $data = mysqli_query($dbc, $query);
        echo '<table>';
        
        while ($row = mysqli_fetch_array($data)) {
            
            echo '<tr><td>' . $row['title'] . '</td>';
            
            $file_name = iconv('utf-8','gb2312',$row['file']);
            
            if (is_file(GW_UPLOADPATH . $file_name)){ 
                echo '<td><a href="' . GW_UPLOADPATH . $row['file'] . '"  />原文</td></tr>';
            } 
            
        }
        echo '</table>';
        ?>
    </body>
</html>
