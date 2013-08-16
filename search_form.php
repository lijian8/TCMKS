<div class="well">
    <form class="form-search" action="search.php" method="post" class="form-horizontal"
          enctype="multipart/form-data">
        <label><font size ="4">&nbsp;&nbsp;中医药知识搜索&nbsp;&nbsp;</font></label>
        <input placeholder ="请输入搜索词..." type="text" id ="keywords" name ="keywords" class="span8 search-query" value ="<?php if (isset($keywords)) echo $keywords; ?>">
        <button name ="submit" type="submit" class="btn  btn-primary"><i class="icon-search icon-white"></i>&nbsp;搜索</button>
    </form>
</div>
