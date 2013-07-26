<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>jQuery treeview</title>

        <link rel="stylesheet" href="./treeview/jquery.treeview.css" />
        <link rel="stylesheet" href="./treeview/screen.css" />

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
    </head>
    <body>

        <h4>Sample 3 - fast animations, all branches collapsed at first, red theme, cookie-based persistance</h4>
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



        <h1 id="banner"><a href="http://bassistance.de/jquery-plugins/jquery-plugin-treeview/">jQuery Treeview Plugin</a> Demo</h1>
        <div id="main"><a href=".">Main Demo</a>

            <div id="s">
                <div class="treeheader">&nbsp;</div>
                <div id="sidetreecontrol"><a href="?#">收拢全部</a> | <a href="?#">展开全部</a></div>
                <ul id="tree">
                    <li><a href="index.php"><strong>主题词</strong></a>
                        <ul>
                            <li><a href="?/enewsletters/index.cfm">Airdrie eNewsletters </a></li>
                            <li><a href="?/index.cfm">Airdrie Directories</a></li>
                            <li><a href="?/economic_development/video/index.cfm">Airdrie Life Video</a></li>
                            <li><a href="index.php"><strong>主题词</strong></a>
                                <ul>
                                    <li><a href="?/enewsletters/index.cfm">Airdrie eNewsletters </a></li>
                                    <li><a href="?/index.cfm">Airdrie Directories</a></li>
                                    <li><a href="?/economic_development/video/index.cfm">Airdrie Life Video</a></li>
                                    <li><a href="index.php"><strong>主题词</strong></a>
                                        <ul>
                                            <li><a href="?/enewsletters/index.cfm">Airdrie eNewsletters </a></li>
                                            <li><a href="?/index.cfm">Airdrie Directories</a></li>
                                            <li><a href="?/economic_development/video/index.cfm">Airdrie Life Video</a></li>

                                            <li><a href="?/index.cfm">Airdrie News</a></li>
                                            <li><a href="?/index.cfm">Airdrie Quick Links</a></li>
                                            <li><a href="?http://weather.ibegin.com/ca/ab/airdrie/">Airdrie Weather</a></li>
                                            <li><a href="?/human_resources/index.cfm">Careers</a> | <a href="?/contact_us/index.cfm">Contact Us</a> | <a href="?/site_map/index.cfm">Site Map</a> | <a href="?/links/index.cfm">Links</a></li>
                                            <li><a href="index.php"><strong>主题词</strong></a>
                                                <ul>
                                                    <li><a href="?/enewsletters/index.cfm">Airdrie eNewsletters </a></li>
                                                    <li><a href="?/index.cfm">Airdrie Directories</a></li>
                                                    <li><a href="?/economic_development/video/index.cfm">Airdrie Life Video</a></li>

                                                    <li><a href="?/index.cfm">Airdrie News</a></li>
                                                    <li><a href="?/index.cfm">Airdrie Quick Links</a></li>
                                                    <li><a href="?http://weather.ibegin.com/ca/ab/airdrie/">Airdrie Weather</a></li>
                                                    <li><a href="?/human_resources/index.cfm">Careers</a> | <a href="?/contact_us/index.cfm">Contact Us</a> | <a href="?/site_map/index.cfm">Site Map</a> | <a href="?/links/index.cfm">Links</a></li>

                                                    <li><a href="?/calendars/index.cfm">Community Calendar </a></li>
                                                    <li><a href="?/conditions_of_use/index.cfm">Conditions of Use and Privacy Statement</a></li>
                                                    <li><a href="?/index.cfm">I'd like to find out about... </a></li>
                                                    <li><a href="?/index.cfm">Opportunities</a></li>
                                                    <li><a href="?/links/index.cfm">Resource Links</a></li>
                                                    <li><a href="?/index.cfm">Special Notices</a></li>

                                                </ul>
                                            </li>
                                            <li><a href="?/calendars/index.cfm">Community Calendar </a></li>
                                            <li><a href="?/conditions_of_use/index.cfm">Conditions of Use and Privacy Statement</a></li>
                                            <li><a href="?/index.cfm">I'd like to find out about... </a></li>
                                            <li><a href="?/index.cfm">Opportunities</a></li>
                                            <li><a href="?/links/index.cfm">Resource Links</a></li>
                                            <li><a href="?/index.cfm">Special Notices</a></li>

                                        </ul>
                                    </li>
                                    <li><a href="?/index.cfm">Airdrie News</a></li>
                                    <li><a href="?/index.cfm">Airdrie Quick Links</a></li>
                                    <li><a href="?http://weather.ibegin.com/ca/ab/airdrie/">Airdrie Weather</a></li>
                                    <li><a href="?/human_resources/index.cfm">Careers</a> | <a href="?/contact_us/index.cfm">Contact Us</a> | <a href="?/site_map/index.cfm">Site Map</a> | <a href="?/links/index.cfm">Links</a></li>

                                    <li><a href="?/calendars/index.cfm">Community Calendar </a></li>
                                    <li><a href="?/conditions_of_use/index.cfm">Conditions of Use and Privacy Statement</a></li>
                                    <li><a href="?/index.cfm">I'd like to find out about... </a></li>
                                    <li><a href="?/index.cfm">Opportunities</a></li>
                                    <li><a href="?/links/index.cfm">Resource Links</a></li>
                                    <li><a href="?/index.cfm">Special Notices</a></li>

                                </ul>
                            </li>
                            <li><a href="?/index.cfm">Airdrie News</a></li>
                            <li><a href="?/index.cfm">Airdrie Quick Links</a></li>
                            <li><a href="?http://weather.ibegin.com/ca/ab/airdrie/">Airdrie Weather</a></li>
                            <li><a href="?/human_resources/index.cfm">Careers</a> | <a href="?/contact_us/index.cfm">Contact Us</a> | <a href="?/site_map/index.cfm">Site Map</a> | <a href="?/links/index.cfm">Links</a></li>

                            <li><a href="?/calendars/index.cfm">Community Calendar </a></li>
                            <li><a href="?/conditions_of_use/index.cfm">Conditions of Use and Privacy Statement</a></li>
                            <li><a href="?/index.cfm">I'd like to find out about... </a></li>
                            <li><a href="?/index.cfm">Opportunities</a></li>
                            <li><a href="?/links/index.cfm">Resource Links</a></li>
                            <li><a href="?/index.cfm">Special Notices</a></li>

                        </ul>
                    </li>
                </ul>
            </div>

        </div>

    </body>

</html>

