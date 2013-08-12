


<?php
if (has_article($dbc, $_SESSION['id'], $role, $recycle)) {
    ?>
    <table class="table table-hover">
        <tbody>
            <tr class="info">
                <td>#</td>
                <td width = "20%"><strong>题目</strong></td> 
                <td width = "20%"><strong>所在综述</strong></td>
                <td width = "30%"><strong>内容</strong></td> 
                <td width = "15%"><strong>主题</strong></td>               
                <td width = "10%"><strong>创建时间</strong></td>
                <td width = "5%"><strong>操作</strong></td>
            </tr>
            <?php
          
            $query = "SELECT * FROM segment where user_id = " . $_SESSION['id'];          
            $result = mysqli_query($dbc, $query) or die('Error querying database.');         

            $row_num = 1;
            $color = true;
            while ($row = mysqli_fetch_array($result)) {
                if ($color) {
                    echo '<tr>';
                } else {
                    echo '<tr class="info">';
                }
                $color = !$color;
                $segment_id = $row['id'];
                echo '<td>' . $row_num++ . '</td>';
                
                echo '<td>';
                
                echo "<a href=\"editor.php?act=edit&id=$segment_id\">".$row[title]."</a>";

                echo   '</td>';
                
                echo '<td>' . render_articles_by_seg($dbc, $row['id']) . '</td>';
                echo '<td>' . tcmks_substr($row['content']). '</td>';

                echo '<td>' . render_tags($dbc, $row['id']) . '</td>';
                echo '<td>' . $row[create_time] . '</td>';
                echo '<td>';
                if (!is_segment_used($dbc, $row['id'])) {
                    echo '<a   href="' . $_SERVER['PHP_SELF'] . '?delete_segment=' . $row['id'] . '"><i class="icon-trash"></i></a>';                   
                }  
                 echo '</td>';
            }
            ?>
        </tbody>
    </table>

    <?php
} else {
    render_warning('没有可显示的综述段落！您可以创建新的综述段落。');
}
?>