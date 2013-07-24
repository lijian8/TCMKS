

<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="well">
                <form class="form-search" action="search.php" method="post" class="form-horizontal"
                      enctype="multipart/form-data">
                    <label><font size ="4">&nbsp;&nbsp;知识搜索:&nbsp;&nbsp;</font></label>
                    <input type="text" id ="keywords" name ="keywords" class="span10 search-query" value ="<?php if (isset($keywords)) echo $keywords; ?>">
                    <button name ="submit" type="submit" class="btn btn-primary">&nbsp;&nbsp;<i class="icon-search icon-white"></i>&nbsp;&nbsp;</button>
                </form>
            </div>
        </div>
    </div>
</div>