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
            <div class="tabbable">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1" data-toggle="tab">主题综述</a></li>
                    <li><a href="#tab2" data-toggle="tab">Wikipedia</a></li>
                    <li><a href="#tab3" data-toggle="tab">百度搜索</a></li>
                    <li><a href="#tab4" data-toggle="tab">互动百科</a></li>
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

                        <iframe src="<?php echo 'http://zh.wikipedia.org/wiki/' . $keywords; ?>" width="100%" height="1000"> 
                        Wikipedia搜索结果 
                        </iframe>
                    </div>
                    <div class="tab-pane" id="tab3">

                        <iframe src="<?php echo 'http://www.baidu.com/s?tn=baiduhome_pg&ie=utf-8&bs=iframe%E7%94%A8%E6%B3%95&f=8&rsv_bp=1&rsv_spt=1&wd=' . $keywords; ?>" width="100%" height="1000"> 
                        百度搜索结果 
                        </iframe>
                    </div>
                    <div class="tab-pane" id="tab4">

                        <iframe src="<?php echo 'http://www.baike.com/wiki/' . $keywords; ?>" width="100%" height="1000"> 
                        互动百科搜索结果 
                        </iframe>


                        <?php
                        /*
                          $url = "http://www.google.com/search?sclient=psy-ab&hl=en&site=&source=hp&q=$keywords";
                          $cookie_file = dirname(__FILE__) . "/temp/google.txt";

                          $ch = curl_init();

                          curl_setopt($ch, CURLOPT_URL, $url);

                          curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

                          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                          curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

                          curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);

                          $contents = curl_exec($ch);

                          curl_close($ch);
                          //echo $contents;
                          preg_match_all("/<body(.*?)body>/is", $contents, $body);
                          //echo $contents;
                          echo '<iframe   width="100%" height="1000">';

                          echo $contents;

                          // preg_match_all("/<title(.*?)</title>/is", $contents, $title);
                          //preg_match_all("/<meta(.*?)>/is", $contents, $meta);
                          //
                          //echo 'title：' . strip_tags($title[0][0]) . '<br><br>';

                          for ($i = 0; $i < count($meta[0]); $i++) {
                          if (preg_match("/keywords/i", $meta[0][$i])) {
                          preg_match_all('/content="(.*?)"/is', $meta[0][$i], $keywords);
                          }
                          if (preg_match("/description/i", $meta[0][$i])) {
                          preg_match_all('/content="(.*?)"/is', $meta[0][$i], $description);
                          }
                          }
                          echo 'keywords：' . strip_tags($keywords[1][0]) . '<br><br>';
                          echo 'description：' . strip_tags($description[1][0]) . '<br><br>';
                         * 
                         */
                        // echo 'body：' . strip_tags($body[0][0]);
                        //echo  $body[0][0];
                        ?>
                        </iframe>
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
                        <?php
                        $query = "SELECT * FROM `tcmks`.`images` WHERE name like '%$keywords%' or subject like '%$keywords%' or description like '%$keywords%'";
                        //echo $query;
                        $result = mysqli_query($dbc, $query) or die('Error querying database.');
                        $row = mysqli_fetch_array($result);
                        while ($row) {
                            echo '<ul class = "thumbnails">';

                            for ($i = 0; $i < 4; $i++) {
                                if (!$row)
                                    break;
                                echo '<li class="span2">';
                                echo '<div class = "thumbnail">';
                                echo '<img src="' . IMG_UPLOADPATH . $row['file'] . '"  alt="" /></p>';
                                echo '<div class = "caption">';
                                echo '<p><strong>' . $row['name'] . '.&nbsp;</strong></p>';
                                // echo $row['description'] . '</p>';
                                // echo '&nbsp;&nbsp';
                                echo '</div></div></li>';
                                $row = mysqli_fetch_array($result);
                            }
                            echo '</ul>';
                        }
                        ?>
                    </div>  
                  
                        <?php
                        /*
                        $baike_keywords = iconv('utf-8', 'gbk', $keywords); //将字符转换成GBK编码，若文件为GBK编码可去掉本行
                        $encode = urlencode($baike_keywords); //对字符进行URL编码
                        $url = 'http://baike.baidu.com/list-php/dispose/searchword.php?word=' . $encode . '&pic=1';
                        $get_contents = file_get_contents($url); //获取跳转页内容
                        $get_contents = iconv('gbk', 'utf-8', $get_contents); //将获取的网页转换成UTF-8编码，若文件为GBK编码可去掉本行
                        preg_match("/URL=(\S+)'>/s", $get_contents, $out); //获取跳转后URL
                        $real_link = 'http://baike.baidu.com' . $out[1];

                        //echo $real_link; //输出 http://baike.baidu.com/view/1466380.htm
                      
                        <iframe src="<?php echo $real_link; ?>" width="100%" height="1000"> 
                        互动百科搜索结果 
                        </iframe>
                         * 
                         */
                          ?>
                                  
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
