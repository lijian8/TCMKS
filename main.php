<?php
include_once ("./header.php");
include_once ("./article_helper.php");
include_once ("./functions.php");
include_once ("./entity_helper.php");
include_once ("./image_helper.php");
include_once ("./messages.php");
require_once('appvars.php');
?>
<div class="container">

    <img width ="100%" src ="img/banner.jpg"></img>                    
    <p></p>
    <div class="row-fluid marketing">

        <div class="media">

            <div class="media-body" align ="left">
                <h4 class="media-heading">最新动态>></h4>
                <hr>
                <?php
                //echo get_content($dbc, 77);

                $query = "SELECT * FROM segment ORDER BY create_time DESC LIMIT 0,5";
                $result = mysqli_query($dbc, $query) or die('Error querying database.');
                while ($row = mysqli_fetch_array($result)) {
                    render_segment_summary($dbc, $row);
                }
                ?>

            </div>
        </div>
        <div align ="right">
            <a href='search.php'>>>查看更多</a>
        </div>    
    </div>
    <hr>
    <div class="row-fluid marketing">


        <div class="span6">
            <div class="media">
                <a class="pull-left" href="navigator.php">
                    <img class="media-object" src="img/resources.jpg" data-src="holder.js/64x64">
                </a>
                <div class="media-body"  align ="left">
                    <h4 class="media-heading"><a href="navigator.php">知识整合</a></h4>
                    <p>从知识组织系统、科学数据库、文献库和博客等知识源中搜集中医药知识资源，基于知识图谱实现知识资源的整合。</p>
                </div>
            </div>
            <div class="media">
                <a class="pull-left" href="experts.php">
                    <img class="media-object" src="img/experts.jpg" data-src="holder.js/64x64">
                </a>
                <div class="media-body" align ="left">
                    <h4 class="media-heading"><a href="experts.php">领域专家</a></h4>
                    <p>提供领域专家的各项信息以及发表的作品。</p>
                </div>
            </div>
        </div>

        <div class="span6">

            <div class="media">
                <a class="pull-left" href="articles.php">
                    <img class="media-object" src="img/review.jpg" data-src="holder.js/64x64">
                </a>
                <div class="media-body"  align ="left">
                    <h4 class="media-heading"><a  href="articles.php">综述编审</a></h4>
                    <p>支持领域专家合作进行主题综述的编辑和评审，及时、准确地反映中医药领域科研的最新进展，支持领域专家进行临床决策。</p>
                </div>
            </div>
            <div class="media">
                <a class="pull-left" href="resource_manager.php">
                    <img class="media-object" src="img/technology.jpg" data-src="holder.js/64x64">
                </a>
                <div class="media-body" align ="left">
                    <h4 class="media-heading"><a  href="resource_manager.php">资源管理</a></h4>
                    <p>对用户提供的知识资源（包括综述、文章、图片等）进行综合管理。</p>
                </div>
            </div>
        </div>
    </div>

</div>
<?php
include_once ("./foot.php");
?>
       
