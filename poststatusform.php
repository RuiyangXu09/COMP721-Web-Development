<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Status Post</title>
</head>
<body style="background-color: bisque; font-size: 15px">
<?php
//设置本地时间格式 d-m-Y ‘Y’显示年份为xxxx
$recentDateTime = date("d/m/Y");
?>
<form action="postStatusProcess.php" method="post">
    <table>
        <div>
            <h1 style="text-align: center">Status Posting System</h1><hr>

            <h2 style="text-align: center">Status Code(required):
                <label>
                    <input type="text" name="statusCode">
                </label>
            </h2>

            <h2 style="text-align: center">Status:
                <label>
                    <input type="text" name="status">
                </label>
            </h2>

            <h2 style="text-align: center">Share:
                <label>
                    <input type="radio" name="shareOption" value="Public"/>Public
                    <input type="radio" name="shareOption" value="Friends"/>Friends
                    <input type="radio" name="shareOption" value="Only me"/>Only me
                </label>
            </h2>

            <h2 style="text-align: center">Date:
                <label>
                    <input type="date" name="date">
                </label>
            </h2>

            <h2 style="text-align: center">Permission Type:
                <!-- 获取checkbox复选框的值，必须将name设置为checkbox[] php才能够以数组数据的形式读取checkbox的值-->
                <label>
                    <input type="checkbox" name="checkbox[]" value="Allow Like"/>Allow Like
                    <input type="checkbox" name="checkbox[]" value="Allow Comment"/>Allow Comment
                    <input type="checkbox" name="checkbox[]" value="Allow Share"/>Allow Share
                </label>
            </h2>

            <h2 style="text-align: center">
                <input type="submit" name="submitClick" value="Post">
                <input type="reset" name="resetClick" value="Reset">
            </h2>

            <h3 style="text-align: center">
                <a href="http://jfm7532.cmslamp14.aut.ac.nz/assign1/index.html">Return to Home Page</a>
            </h3>
        </div>
    </table>
</form>
</body>
</html>