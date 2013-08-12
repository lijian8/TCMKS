<?php
include_once ("./header.php");
include_once ("./article_helper.php");
include_once ("./functions.php");
require_once('appvars.php');
?>


<div class="container">
    <?php include_once ("./search_form.php"); ?>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span3">
                <div class="well sidebar-nav">
                    <div id="sidetreecontrol"><span>主题词</span></div>

                    <ul id="red" class="treeview-red">
                        <li class="open"><span>R2 中国医学</span>
                            <ul>
                                <li><span>R2-0 中国医学理论</span>
                                    <ul>
                                        <li><span>R2-03 中医现代化研究</span>
                                            <ul>
                                                <li><span>R2-031 中西医结合</span>
                                            </ul>
                                        </li>
                                        <li><span>[R2-09] 中医学史</span>
                                        </li>    

                                    </ul>
                                </li>
                                <li><span>R2-5 中医学丛书、文集、连续出版物</span>
                                    <ul>
                                        <li><span>R2-52 全书</span>                               
                                        </li>
                                        <li><span>R2-53 论文集</span>
                                        </li>                                
                                    </ul>
                                </li>

                                <li><span>R21 中医预防、卫生学</span>
                                    <ul>
                                        <li><span>R211 预防、卫生</span>                               
                                        </li>
                                        <li><span>R212 养生</span>
                                            <ul>
                                                <li><span>[R212.7] 老年保健</span>                               
                                                </li>                                                             
                                            </ul>
                                        </li> 
                                        <li><a href="?/enewsletters/index.cfm">R214 气功</a>
                                        </li>   
                                    </ul>                    
                                </li>

                                <li><span>R22 中医基础理论</span>
                                    <ul>
                                        <li><span>R221 内经</span>  
                                            <ul>
                                                <li><span>R221.1 素问</span>                               
                                                </li>
                                                <li><span>R221.2 灵枢</span>                               
                                                </li> 
                                                <li><span>R221.3 素问、灵枢分类合编</span>                               
                                                </li> 
                                                <li><span>R221.9 难经</span>                               
                                                </li> 
                                            </ul>
                                        </li>
                                        <li><span>R222 伤寒、金匮（伤寒杂病论）</span>
                                            <ul>
                                                <li><span>R222.2 伤寒论</span>                               
                                                </li>  
                                                <li><span>R222.3 金匮要略</span>                               
                                                </li>  
                                            </ul>
                                        </li>                               
                                    </ul>                    
                                </li>
                                <li><span>R24 中医临床学</span>
                                </li>
                                <li><span> R25 中医内科</span>
                                </li>
                                <li><span> R26 中医外科</span>
                                </li>
                                <li><span> R28 中药学</span>
                                </li>
                                <li><span> R29 中国少数民族医学</span>
                                </li>


                            </ul>
                        </li>            
                    </ul>
                </div>
            </div>
            <!--
            <div class="span2">
                <div class="well sidebar-nav">
                    <ul class="nav nav-list">
                        <li class="nav-header">中医药</li>
                        <li class="active"><a href="#">中医药信息学</a></li>
                        <li><a href="#">中医学</a></li>
                        <li><a href="#">中药学</a></li>
                        <li><a href="#">中西医结合</a></li>
                        <li class="nav-header">肝炎</li>
                        <li><a href="#">甲肝</a></li>
                        <li><a href="#">乙肝</a></li>
                        <li><a href="#">丙肝</a></li>
                        <li><a href="#">戊肝</a></li>
                        <li class="nav-header">五脏</li>
                        <li><a href="#">心</a></li>
                        <li><a href="#">肝</a></li>
                        <li><a href="#">脾</a></li>
                        <li><a href="#">肺</a></li>
                        <li><a href="#">肾</a></li>

                    </ul>
                </div>
            </div>
            -->

            <div class="span9">
                <?php
                $query = "SELECT * FROM segment ORDER BY create_time DESC LIMIT 0,10";
                $result = mysqli_query($dbc, $query) or die('Error querying database.');
                while ($row = mysqli_fetch_array($result)) {
                    render_segment_summary($dbc, $row);                      
                }
                ?>
                  
            </div><!--/span-->
        </div><!--/row-->
    </div>





    <footer class="footer">

        <p><a href="yutong" target="_blank">于彤</a>, <a href="yutong" target="_blank">陈矫彦</a>,<a href="yutong" target="_blank">刘娜</a>设计</p>
        <p>© 中国中医科学院中医药信息研究所</p>
        <ul class="footer-links">
            <li><a href="http://www.cintcm.ac.cn/opencms/opencms/index.html">CINTCM</a></li>
            <li class="muted">&middot;</li>
            <li><a href="http://twitter.github.io/bootstrap/">Bootstrap</a></li>
            <li class="muted">&middot;</li>
            <li><a href="https://github.com/twitter/bootstrap/blob/master/CHANGELOG.md">关于我们</a></li>
        </ul>

    </footer>
    <script src="./js/jquery.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/holder/holder.js"></script>
    <script src="./js/google-code-prettify/prettify.js"></script>

    <script src="./js/application.js"></script>

    <script src="./treeview/lib/jquery.js" type="text/javascript"></script>
    <script src="./treeview/lib/jquery.cookie.js" type="text/javascript"></script>
    <script src="./treeview/jquery.treeview.js" type="text/javascript"></script>

    <script type="text/javascript" src="./treeview/demo.js"></script>

    <script type="text/javascript">
        $(function() {
            $("#tree").treeview({
                collapsed: true,
                animated: "medium",
                control: "#sidetreecontrol",
                persist: "location"
            });
        })

    </script>


    <!-- Analytics
    ================================================== -->
    <script>
        var _gauges = _gauges || [];
        (function() {
            var t = document.createElement('script');
            t.type = 'text/javascript';
            t.async = true;
            t.id = 'gauges-tracker';
            t.setAttribute('data-site-id', '4f0dc9fef5a1f55508000013');
            t.src = '//secure.gaug.es/track.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(t, s);
        })();
    </script>

</body>
</html>

