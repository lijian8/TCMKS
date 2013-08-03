<?php
include_once ("./header.php");

require_once('appvars.php');
$managing_subject = 'me';

if (isset($_POST['submit'])) {
    $id = $_SESSION['id'];
    $usr = $_POST['usr'];
    $email = $_POST['email'];
    $real_name = $_POST['real_name'];
    $job = $_POST['job'];
    $profile = $_POST['profile'];
    $query = "UPDATE users SET usr = '$usr', email = '$email', real_name = '$real_name', job = '$job', profile ='$profile' WHERE id = '$id'";
    mysqli_query($dbc, $query);
    echo '<div class="alert alert-success">';
    echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
    echo '个人信息修改成功！您可以继续编辑，或返回<a href = "main.php">首页</a>';
    echo '</div>';
} else {
    $query = "SELECT * FROM users WHERE id = '$_SESSION[id]'";
    $result = mysqli_query($dbc, $query) or die('Error querying database1.');
    if ($row = mysqli_fetch_array($result)) {
        $usr = $row['usr'];
        $email = $row['email'];
        $real_name = $row['real_name'];
        $job = $row['job'];
        $profile = $row['profile'];
    }
}
?>
<p></p>
<div class="container">
    <div class="row-fluid">
        <div class="span2">
            <?php include_once ("manager_sidebar.php"); ?>
        </div><!--/span-->
        <div class="span10">

            <form action="me.php" method="post" class="form-horizontal"
                  enctype="multipart/form-data">
                <legend>请编辑您的信息：</legend>

                <div class="control-group">
                    <label class="control-label" for="usr">用户名:</label>
                    <div class="controls">
                        <input class="span12" type="text" id="usr" name="usr" value="<?php if (!empty($usr)) echo $usr; ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="email">电子邮件:</label>
                    <div class="controls">
                        <input class="span12" type="text" id="email" name="email" value="<?php if (!empty($email)) echo $email; ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="real_name">真实姓名:</label>
                    <div class="controls">
                        <input class="span12" type="text" id="real_name" name="real_name" value="<?php if (!empty($real_name)) echo $real_name; ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="profile">职务/职称:</label>
                    <div class="controls controls-row">   
                        <input class="span12" type="text" id="job" name="job" value="<?php if (!empty($job)) echo $job; ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="profile">简介:</label>
                    <div class="controls">
                        <textarea class="span12" id="profile" name="profile" rows="6"><?php if (!empty($profile)) echo $profile; ?></textarea>
                    </div>
                </div>


                <div class="control-group">
                    <div class="controls">
                        <input class="btn btn-primary" type="submit" name="submit" value="提交" />                       
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>

<?php
include_once ("./foot.php");
?>