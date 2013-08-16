<?php
require_once('appvars.php');
include_once ("./header.php");
include_once ("./messages.php");
include_once ("./image_helper.php");
include_once ("./entity_helper.php");

if  (isset($_GET['delete_triple_id'])) {
    delete_triple($dbc, $_GET['delete_triple_id']); 
}

if (isset($_GET['id'])) {

    $id = $_GET['id'];
    $query = "select * from def where id ='$id'";
    $result = mysqli_query($dbc, $query) or die('Error querying database1.');
    if ($row = mysqli_fetch_array($result)) {
        $name = $row[name];
        //$def = $row[def];
    }
} else if (isset($_GET['name'])) {
    $name = $_GET['name'];
    /*
      $query = "select * from def where name ='$name'";

      $result = mysqli_query($dbc, $query) or die('Error querying database2.');

      if ($row = mysqli_fetch_array($result)) {
      $id = $row[id];
      $def = $row[def];
      } */
} else if (isset($_POST['name'])) {
    //$id = $_POST['id'];
    $name = $_POST['name'];
    $property = $_POST['property'];
    $value = $_POST['value'];
    $description = $_POST['description'];

    //$query = "select * from def where id ='$id'";
    //$result = mysqli_query($dbc, $query) or die('Error querying database3.');



    if (($name != '') && ($property != '') && ($value != '')) {
        $user_id = $_SESSION[id];
        $property_escape = mysql_escape_string($property);
        $value_escape = mysql_escape_string($value);
        $description_escape = mysql_escape_string($description);

        $query = "insert into graph (subject, property, value, description, user_id, date) values ('$name','$property_escape','$value_escape', '$description_escape', '$user_id', NOW()) ";
        mysqli_query($dbc, $query) or die('Error querying database.');
        render_warning('实体信息添加成功！');
    } else {
        render_warning('请补全实体信息！');
    }
} else {
    render_warning('无相关实体信息！');
}

if (isset($name) && $name != '') {
    ?>
    <div class="container">

        <div class ="well">
            <?php render_entity($dbc, $name, true); ?>
        </div>
        <div class ="well">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal"
                  enctype="multipart/form-data">
                <legend>请添加实体信息：</legend>
                <input  type="hidden" id="name" name="name" value = "<?php echo $name; ?>" >

                <div class="control-group">
                    <label class="control-label" for="property">实体属性:</label>
                    <div class="controls">
                        <input class="span9" type="text" id="property" name="property" value = "<?php if (isset($property)) echo $property; ?>" placeholder="请输入实体的属性名称">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="value">实体取值:</label>
                    <div class="controls">
                        <textarea class="span9"  id="value" name="value" row="6" placeholder="请输入实体的属性取值"><?php if (isset($value)) echo $value; ?></textarea>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="description">注释:</label>
                    <div class="controls">
                        <textarea class="span9" id="description" name="description"  placeholder="请输入注释" rows="6"><?php if (isset($description)) echo $description; ?></textarea>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <input class="btn btn-large btn-primary" type="submit" name="submit" value="提交" />    
                        <a class="btn btn-large btn-success" href="search.php?keywords=<?php echo $name; ?>">返回首页</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
    <?php
}
include_once ("./foot.php");
?>
