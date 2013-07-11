<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>基于循证的中医药知识服务平台</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
            }
        </style>
        <link href="css/bootstrap-responsive.min.css" rel="stylesheet">

    </head>
    <body data-spy="scroll" data-target=".bs-docs-sidebar">
        <h1>基于循证的中医药知识服务平台</h1>
        <div class="container"> 
            <div class="tabbable">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1" data-toggle="tab">综述文章</a></li>
                    <li><a href="#tab2" data-toggle="tab">文献资源</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">                        
                        <a class="btn btn-primary" href="create_article.html">创建综述</a>
                        <p></p>
                        <table class="table table-hover">
                            <tbody>
                                <tr class="info">
                                    <td>#</td>
                                    <td width = "8%"><strong>创建者</strong></td>
                                    <td width = "8%"><strong>审核者</strong></td>
                                    <td width = "8%"><strong>发布者</strong></td>
                                    <td width = "15%"><strong>题目</strong></td> 
                                    <td width = "40%"><strong>摘要</strong></td>
                                    <td width = "10%"><strong>创建时间</strong></td>
                                    <td width = "10%"><strong>操作</strong></td>
                                </tr>
                                <?php
                                $dbc = mysqli_connect('localhost', 'tcmks', 'tcmks', 'tcmks') or die('Error connecting to MySQL server.');

                                $query = "SELECT * FROM article";
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
                                    echo '<td>欧蔚妮</td>';
                                    echo '<td>段英</td>';
                                    echo '<td>邢卉春</td>';

                                    // $first_name = $row['first_name'];
                                    // $last_name = $row['last_name'];
                                    // $msg = "Dear $first_name $last_name,\n$text";
                                    echo '<td>' . $row['title'] . '</td>';
                                    echo '<td>' . $row['abstract'] . '</td>';
                                    echo '<td>' . $row['create_time'] . '</td>';

                                    echo '<td><a class="btn" href="article.php?id=' . $row['id'] . '"><i class="icon-edit"></i></a>';
                                    echo '<a class="btn" href="create_article.html"><i class="icon-trash"></i></a></td></tr>';
                                }

                                mysqli_close($dbc);
                                ?>
                            </tbody>
                        </table>

                    </div>
                    <div class="tab-pane" id="tab2">
                        <a class="btn btn-primary" href="upload_file.php">录入文献</a>
                        <p>

                        <table class="table table-hover">
                            <tbody>
                                <tr class="info">
                                    <td>#</td>
                                    <td width = "8%"><strong>作者</strong></td>
                                    <td width = "8%"><strong>题目</strong></td>
                                    <td width = "8%"><strong>出处</strong></td>
                                    <td width = "15%"><strong>上传时间</strong></td> 
                                    <td width = "40%"><strong>操作</strong></td>

                                </tr>

                                <?php
                                require_once('appvars.php');
                                require_once('connectvars.php');

                                $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

                                $query = "SELECT * FROM resource ORDER BY title ASC";
                                $data = mysqli_query($dbc, $query);

                                $row_num = 1;
                                $color = true;
                                while ($row = mysqli_fetch_array($data)) {
                                    if ($color) {
                                        echo '<tr>';
                                    } else {
                                        echo '<tr class="info">';
                                    }
                                    $color = !$color;
                                    echo '<td width = "3%">' . $row_num++ . '</td>';
                                    echo '<td width = "15%">' . $row['authors'] . '</td>';

                                    echo '<td width = "30%">' . $row['title'] . '</td>';
                                    echo '<td width = "25%">' . $row['journal'] . $row['year'] . ',' . $row['pages'] . ',' . $row['publisher'] . '</td>';
                                    echo '<td width = "10%">' . $row['create_time'] . '</td>';
                                    $file_name = iconv('utf-8', 'gb2312', $row['file']);
                                    echo '<td width = "15%">';
                                    echo '<a class="btn" href="create_article.html"><i class="icon-edit"></i></a>';

                                    if (is_file(GW_UPLOADPATH . $file_name)) {
                                        echo '<a class="btn" href="' . GW_UPLOADPATH . $row['file'] . '"><i class="icon-download-alt"></i></a>';
                                    }

                                    echo '<a class="btn" href="create_article.html"><i class="icon-trash"></i></a></td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>  
        <?php
        //include_once ("./foot.php");
        ?>
        <footer class="footer">
            <div class="container">
                <p><a href="yutong" target="_blank">于彤</a>设计</p>
                <p>© 中国中医科学院中医药信息研究所</p>
                <ul class="footer-links">
                    <li><a href="http://blog.getbootstrap.com">Blog</a></li>
                    <li class="muted">&middot;</li>
                    <li><a href="https://github.com/twitter/bootstrap/issues?state=open">Issues</a></li>
                    <li class="muted">&middot;</li>
                    <li><a href="https://github.com/twitter/bootstrap/blob/master/CHANGELOG.md">Changelog</a></li>
                </ul>
            </div>
        </footer>
        <script src="./js/jquery.min.js"></script>
        <script src="./js/bootstrap.min.js"></script>

    </body>
</html>
