<?php
include_once ("./header.php");
include_once ("./article_helper.php");
include_once ("./functions.php");
include_once ("./entity_helper.php");
include_once ("./image_helper.php");
include_once ("./messages.php");
require_once('appvars.php');

if (isset($_POST['submit'])) {
    $keywords = $_POST['keywords'];
}

if (isset($_GET['keywords'])) {
    $keywords = $_GET['keywords'];
}
?>
<div class="container">
    <?php include_once ("./search_form.php"); ?>

    <div class="row">
        <div class="span8">
            <div class="tabbable tabs-left">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1" data-toggle="tab">所有主题</a></li>
                    <li><a href="#tab2" data-toggle="tab">成人</a></li>
                    <li><a href="#tab3" data-toggle="tab">儿科</a></li>
                    <li><a href="#tab4" data-toggle="tab">患者</a></li>
                    <li><a href="#tab5" data-toggle="tab">文献</a></li>
                    <li><a href="#tab6" data-toggle="tab">图表</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                        <?php
                        $query = "SELECT * FROM segment where title like '%$keywords%' or content like '%$keywords%' ORDER BY title ASC LIMIT 0,50";
                        $result = mysqli_query($dbc, $query) or die('Error querying database.');
                        while ($row = mysqli_fetch_array($result)) {
                            render_segment_summary($dbc, $row);
                        }
                        ?>

                    </div>
                    <div class="tab-pane" id="tab2">
                        <p>成人.</p>
                    </div>
                    <div class="tab-pane" id="tab3">
                        <p>儿科.</p>
                    </div>
                    <div class="tab-pane" id="tab4">
                        <p>患者.</p>
                    </div>
                    <div class="tab-pane" id="tab5">
                        <?php
                        $url = 'http://s.wanfangdata.com.cn/sru/paper.ashx?operation=searchRetrieve&query=' . $keywords . '%20sortby%20relevance&maximumRecords=10&startRecord=1&version=1.2';

                        $xml = simplexml_load_file($url);

                        $feed = file_get_contents($url);
                        $feed = str_replace('srw_dc:dc xmlns:dc="info:srw/schema/1/dc-v1.1" xmlns:srw_dc="info:srw/schema/1/dc-v1.1"', 'srw', $feed);
                        $feed = str_replace('srw_dc:dc', 'srw', $feed);
                        $feed = str_replace('dc:', '', $feed);
                        $xml = new SimpleXmlElement($feed);
                        foreach ($xml->records->record as $r) {
                            $x = $r->recordData->srw;
                            $title = $x->title;
                            $Identifier = $x->Identifier;

                            echo '<h4><a href="http://d.wanfangdata.com.cn/' . $Identifier . '.aspx">' . $title . '</a></h4>';
                            echo '<p>' . $x->Creator . '等发表于' . $x->Date . '</p>';

                            echo "<p>" . tcmks_substr($x->Description, $word_count = 100) . "...</p>";
                        }
                        ?>
                    </div>
                    <div class="tab-pane" id="tab6">
                        <p>图表.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="span4">
            <div class ="well">
                <?php
                render_entity($dbc, $keywords);
                echo '<a class="btn btn-primary" href="entity.php?name=' . $keywords . '"><i class="icon-edit icon-white"></i>&nbsp;编辑</a>';
                ?>
            </div>
        </div>
    </div>    
</div>
</div>


<?php
include_once ("./foot.php");
?>
