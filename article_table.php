


<?php
if (has_article($dbc, $_SESSION['id'], $role)) {
    ?>
    <table class="table table-hover">
        <tbody>
            <tr class="info">
                <td>#</td>
                <td width = "6%"><strong>创建者</strong></td>
                <td width = "6%"><strong>作者</strong></td>                           
                <td width = "6%"><strong>评审</strong></td>
                <td width = "6%"><strong>发布者</strong></td>
                <td width = "15%"><strong>题目</strong></td> 
                <td width = "45%"><strong>摘要</strong></td>
                <td width = "10%"><strong>创建时间</strong></td>
                <td width = "5%"><strong>删除</strong></td>
            </tr>
            <?php
            //$query = "SELECT * FROM article";
            $query = "SELECT distinct * FROM authorship, article where id=article_id and role = '$role' and author_id = " . $_SESSION['id'];

            $result = mysqli_query($dbc, $query) or die('Error querying database.');
            //echo '<ul>';

            $row_num = 1;
            $color = true;
            while ($row = mysqli_fetch_array($result)) {



                if ($color) {
                    echo '<tr>';
                } else {
                    echo '<tr class="info">';
                }
                $color = !$color;
                echo '<td>' . $row_num++ . '</td>';
                echo '<td>' . render_authors($dbc, $row[id], 'creator') . '</td>';
                echo '<td>' . render_authors($dbc, $row[id], 'author') . '</td>';
                echo '<td>' . render_authors($dbc, $row[id], 'reviewer') . '</td>';
                echo '<td>' . render_authors($dbc, $row[id], 'publisher') . '</td>';
                echo '<td><a  href="article.php?id=' . $row['id'] . '">' . $row['title'] . '</a></td>';
                echo '<td>' . get_abstract($dbc, $row['id']) . '</td>';
                echo '<td>' . $row['create_time'] . '</td>';
                //echo '<a class="btn" href="article.php?id=' . $row['id'] . '"><i class="icon-edit"></i></a>';
                echo '<td><a  href="' . $_SERVER['PHP_SELF'] . '?delete=' . $row['id'] . '"><i class="icon-trash"></i></a></td></tr>';
            }
            ?>
        </tbody>
    </table>

    <?php
} else {
    render_warning('没有可显示的综述！您可以创建新的综述。');
}
?>