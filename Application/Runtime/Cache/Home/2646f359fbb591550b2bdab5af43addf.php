<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script type="text/javascript" src="/PASS/Public/js/jquery-1.12.0.js"></script>
    <script type="text/javascript" src="/PASS/Public/js/test.js"></script>
    <title>测试1</title>
</head>
<body>
    hello world! my test 1
    {$user}<br>
        <!--<input name="in" type="text" width="200px"><br>-->
        <!--<input type="submit" name="bt" value="submit">-->
        <button type="submit" name="test1" id="test1">测试ajax</button>
    <!--<a href="http://localhost/PASS/index.php/Home/user/1">test</a>-->
    <!--<form method="post">-->
        <button type="submit" name="test2" id="test2">测试ajax2</button>
        <?php echo ($mess); ?>
    <?php echo ($type); ?>
    <!--</form>-->
</body>
</html>