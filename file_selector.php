<?php

include_once ("./header.php");
?>
<script>
    function clk(str) {
        //alert(str);
        document.getElementById('b').value = str;

    }
    function showResult(str)
    {
        if (str.length == 0)
        {
            document.getElementById("livesearch").innerHTML = "";
            document.getElementById("livesearch").style.border = "0px";
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
                document.getElementById("livesearch").innerHTML = xmlhttp.responseText;
                document.getElementById("livesearch").style.border = "1px solid #A5ACB2";
            }
        }
        xmlhttp.open("GET", "file_service.php?q=" + str, true);
        xmlhttp.send();
    }
</script>


<form>
    <input id="b" type="text" size="30" onkeyup="showResult(this.value)">
    <input id="A" type="button" value="A" onclick="alert('A');" />
    
    <div id="livesearch"></div>
</form>
<?php

include_once ("./foot.php");
?>
