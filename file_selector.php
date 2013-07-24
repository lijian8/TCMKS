
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


<div class="input-append" class="span8">
    <input id="fileSearchInput" type="text" size="15" onkeyup="renderFileSearchPanel(this.value)">
    <input id="fileSearchURI" type="hidden">
   
    <input id="select" class="btn btn-success" type="button" value="插入链接" onclick="InsertText();" />
    
</div>
<div class="container" id="fileSearchPanel"></div>
    

<?php

//include_once ("./foot.php");
?>
