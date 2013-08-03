<div class="well sidebar-nav">
    <ul class="nav nav-list">
        <li class="nav-header">综述管理</li>
        <li <?php echo $managing_subject == 'articles'? 'class="active"' : ''; ?> ><a href="articles.php">综述编审</a></li>
        <li class="nav-header">知识资源管理</li>
        <li <?php echo $managing_subject == 'resource'? 'class="active"' : ''; ?> ><a href="resource_manager.php">文献管理</a></li>
        <li <?php echo $managing_subject == 'image'? 'class="active"' : ''; ?> ><a href="image_manager.php">图片管理</a></li>
        <li class="nav-header">个人信息管理</li>
        <li <?php echo $managing_subject == 'me'? 'class="active"' : ''; ?> ><a href="me.php">编辑个人信息</a></li>                    
    </ul>
</div><!--/.well -->
