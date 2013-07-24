<script language="javascript" type="text/javascript">

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
        } else if (type === 'resource') {
            xmlhttp.open("GET", "resource_service.php?id=" + str, true);
        } else {
            xmlhttp.open("GET", "concept_service.php?id=" + str, true);
        }
        xmlhttp.send();
    }
</script>
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