<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>乙型病毒性肝炎</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le styles -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/bootstrap-responsive.css" rel="stylesheet">
        <link href="css/docs.css" rel="stylesheet">
        <link href="css/prettify.css" rel="stylesheet">

        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="assets/js/html5shiv.js"></script>
        <![endif]-->

        <!-- Le fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
        <link rel="shortcut icon" href="assets/ico/favicon.png">
        <script language="javascript" type="text/javascript">

            function test(value)
            {
                var hd = document.getElementById("xxx");
                hd.value += value + "/";

                alert(hd.value);
            }
            function test1(value)
            {
                alert(value);
                //document.getElementById("myContent").innerHTML = "good";
                invokeImageService('70');
                $('#myModal').modal('show');

            }

            function invokePopupService(str, type) {


                if (str.length == 0)
                {
                    document.getElementById("myContent").innerHTML = "没有可展示的东西！";
                    document.getElementById("myContent").style.border = "0px";
                    return;
                }
                if (window.XMLHttpRequest)
                {// code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                }
                else
                {// code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function()
                {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        document.getElementById("myContent").innerHTML = xmlhttp.responseText;
                        document.getElementById("myContent").style.border = "1px solid #A5ACB2";
                        $('#myModal').modal('show');
                    }
                }

                if (type === 'image') {
                    //alert(document.getElementById("myModalLabel").label);
                    xmlhttp.open("GET", "image_service.php?id=" + str, true);
                } else if(type === 'resource'){
                    xmlhttp.open("GET", "resource_service.php?id=" + str, true); 
                } else {
                    xmlhttp.open("GET", "concept_service.php?id=" + str, true);
                }
                xmlhttp.send();
            }
        </script>

    </head>
    <body>

        <p>濒危物种。人参为第三纪孑遗植物，属五加科，多年生草本植物，茎高约40~50cm</p>
        <input id="A" type="button" value="A" onclick="alert('您点击了A');
                $('#myModal').modal({keyboard: false});" />
        <input class="" id="b" type="button" value="b" onclick="javascript:test(1);" />
        <p>人参-百草和堂(15张)，轮生掌状复叶。<a href="javascript:invokePopupService('王飞跃等2010a','resource');">王飞跃等2010a</a>初夏开黄绿色小花，伞顶花序单个顶生，果实呈扁圆形。也是珍贵的中药材，是“东北三宝”之一，在中国药用历史悠久。长期以来，由于过度采挖，资源枯竭，人参赖以生存的森林生态环境遭到严重破坏，因此以山西五加科“上党参”为代表的中原产区即山西南部、河北南部、河南、山东西部等地的人参早已绝灭。目前东北参也处于濒临绝灭的边缘，因此，保护本种的自然资源有其重要的意义。</p>
        <p><a href="?concept=1#myModal"  data-toggle="modal">人参</a>已列为国家珍稀濒危保护植物，长白山等自然保护区已进行保护。其它分布区也应加强保护，严禁采挖，使人参资源逐渐恢复和增加。东北三省已广泛栽培，近来河北、山西、陕西、湖南、湖北、广西、四川、云南等省区均有引种。</p>
        <p><a href="javascript:invokePopupService('71');">人参</a>是五加科人参属植物，它与三七、西洋参等著名药用植物是近亲。野生人参对生长环境要求比较高，它怕热、怕旱怕晒，要求土壤疏松、肥沃、空气湿润凉爽，所以多生长在长白山海拔500～1000米的针叶、阔叶混交林里。每年七八月正是人参开花季节，紫白色的花朵结出鲜红色的浆果，十分引人喜爱。野山参在深山里生长很慢，60～100年的山参，其根往镑也只有几十克重。1989年，抚松县农民在长白山采到一棵“参王”重305克，估计已在地下生长了500年。这棵“参王”是我国目前采到的最大的山参，已作为"国宝"被国家收购保存。百草和堂</p>
        <p><a href="javascript:invokePopupService('71','image');">Hepatitis-B vaccine</a>我国自唐朝起，就已开始人工种植人参。人工栽培的园参，目前除东北有大量种植外，河北、山西、甘肃、宁夏、湖北等省区也均有栽培。在人工精心管理下，栽培的人参6年就可收获，但从药用价值或珍贵程度讲，似乎都无法与百年的老山参相比。野生人参被大量采挖已越来越少。野生人参已处于濒临绝灭的境地。这种"中药之王"、"能治百病的草"与水杉、银杉、桫椤等珍贵植物一起，已列为我国国家一级重点保护植物。</p>
        <!-- Button to trigger modal -->

        <!-- Modal -->
        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <H3 id="myModalLabel"  >查看：</H3>
            </div>
            <div id ="myContent" class="modal-body">
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
            </div>
        </div>
        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster 
        <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>-->
        <script src="./js/jquery.min.js"></script>
        <script src="./js/bootstrap.min.js"></script>
        <script src="./js/holder/holder.js"></script>
        <script src="./js/google-code-prettify/prettify.js"></script>

        <script src="./js/application.js"></script>
    </body>
</html>
