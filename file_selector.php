
<?php

//include_once ("./header.php");
?>

<script>
        function fileSelected(str) {
        //alert(str);
        document.getElementById('fileSearchInput').value = str;
        //document.getElementById('fileSearchURI').value = uri;
        
        renderFileSearchPanel(str);

    }
    function renderFileSearchPanel(str)
    {
        //document.getElementById('fileSearchURI').value = "#" + str + "#";
       
        if (str.length == 0)
        {
            document.getElementById("fileSearchPanel").innerHTML = "";
            document.getElementById("fileSearchPanel").style.border = "0px";
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
                document.getElementById("fileSearchPanel").innerHTML = xmlhttp.responseText;
                document.getElementById("fileSearchPanel").style.border = "1px solid #A5ACB2";
            }
        }
        xmlhttp.open("GET", "file_service.php?q=" + str, true);
        xmlhttp.send();
    }
</script>


<div class="well">
    <input id="fileSearchInput" type="text"  class ="input-xxlarge" onkeyup="renderFileSearchPanel(this.value)">
    <input id="fileSearchURI" type="hidden">
    <!--
    <input id="select" class="btn btn-success" type="button"  onclick="InsertText();"><i class="icon-search icon-white"></i></input>
    -->
    <a class="btn btn-success" href="javascript:InsertText();"><i class="icon-plus  icon-white"></i>&nbsp;插入链接</a>
    

<div  id="fileSearchPanel"></div>
</div>    

<?php

//include_once ("./foot.php");
?>
