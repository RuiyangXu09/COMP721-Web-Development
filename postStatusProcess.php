<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post System</title>
</head>
<body style="background: #1b7dd2">
<div class="content">
    <?php
    if(isset($_POST['submitClick']))
    {
        require_once ('sql_Inform.php');
        //数据库链接
        $conn = new mysqli($servername,$username,$password,$myDB,3306);
        if ($conn ->connect_error)
        {
            //die() 函数输出一条消息，并退出当前脚本
            die("Connect Failed: ".$conn->connect_error);
        }else {
            //检查数据库是否存在
            $sql_check_DB = 'SELECT COUNT(*) AS `exists` FROM INFORMATION_SCHEMA.SCHEMATA 
                    WHERE SCHEMATA.SCHEMA_NAME="status1"';
            if (mysqli_query($conn,$sql_check_DB))
            {
                //判断数据表是否存在
                $sql_check_table = "SELECT TABLE_NAME FROM `INFORMATION_SCHEMA`.`TABLES` WHERE 
                        `TABLE_SCHEMA`='status' AND `TABLE_NAME`='statuslog'";
                $table_result = mysqli_query($conn, $sql_check_table);
                if (!empty($table_result))
                {
                    //设置数据库编码为utf8格式，能够顺利写入英文和中文
                    mysqli_set_charset($conn, "utf8");
                    //创建多个变量接收来自表单提交的数据post
                    $statusCode = $_POST['statusCode'];
                    $status = $_POST['status'];
                    $share = $_POST['shareOption'];
                    $date = $_POST['date'];
                    //创建一个数组，接收来自表单提交的checkbox[]的数据
                    //因已经以数组的形式获取复选框checkbox的值，所以可以使用implode函数，把数组元素组合为字符串
                    $permission_array = array();
                    $permission_array = $_POST['checkbox'];
                    //设置一个变量，将数组$permission_array中的数组元素组合为一个字符串，插入数据表
                    /*
                     * implode(separator,array)
                     *  separator 	可选。规定数组元素之间放置的内容。默认是 ""（空字符串）。
                        array 	必需。要组合为字符串的数组。
                     */
                    $permission = implode(', ', $permission_array);
                    //判断statuscode是否为空。如果不为空，执行判断输入字符长度是否为4，如果是4，执行判断是否输入字符为数字
                    if (empty($statusCode))
                    {
                        echo "<h2 style='text-align: center; background-color: goldenrod'>Status code can not be empty."."<br>"."<hr>".
                            "<a href='http://jfm7532.cmslamp14.aut.ac.nz/assign1/poststatusform.php'>Post another Status</a>"."<br>".
                            "<a href='http://jfm7532.cmslamp14.aut.ac.nz/assign1/index.html'>Return to home page</a></h2>";
                    } elseif (strlen($statusCode) == 4)
                    {
                        if (is_numeric($statusCode))
                        {
                            //判断status是否为空，不为空，执行判断输入字符串是否只包含数字字母和部分标点号
                            if (empty($status))
                            {
                                echo "<h2 style='text-align: center; background-color: goldenrod'>Status can not be empty"."<br>"."<hr>".
                                    "<a href='http://jfm7532.cmslamp14.aut.ac.nz/assign1/poststatusform.php'>Post another Status</a>"."<br>".
                                    "<a href='http://jfm7532.cmslamp14.aut.ac.nz/assign1/index.html'>Return to home page</a></h2>";
                            }else
                            {
                                //执行判断date是否为空
                                if (empty($date))
                                {
                                    echo "<h2 style='text-align: center; background-color: goldenrod'>Date can not be empty"."<br>"."<hr>".
                                        "<a href='http://jfm7532.cmslamp14.aut.ac.nz/assign1/poststatusform.php'>Post another Status</a>"."<br>".
                                        "<a href='http://jfm7532.cmslamp14.aut.ac.nz/assign1/index.html'>Return to home page</a></h2>";
                                }else
                                {
                                    if (preg_match('/[A-Za-z0-9]/', $status) || strpos($status, '!,.?'))
                                    {
                                        //设置变量，对表单statuslog中的每一个列名statusCode, status,share,date,permission插入php表单获取的数据
                                        $sql = "INSERT INTO statuslog(statusCode, status,share,date,permission) VALUES ('$statusCode','$status','$share','$date','$permission')";
                                        //mysqli_query() 函数执行某个针对数据库的查询 对数据库执行INSERT INTO 操作，成功后打印通知信息
                                        if (mysqli_query($conn, $sql))
                                        {
                                            echo "<h2 style='text-align: center; background-color: goldenrod'>Success!<br>
                                          Status code: S".$statusCode."<br>".
                                                "Status: ".$status."<br>".
                                                "Share: ".$share."<br>".
                                                "Date: ".$date."<br>".
                                                "Permission Type: ".$permission."<br><hr>
                                          <a href='http://jfm7532.cmslamp14.aut.ac.nz/assign1/poststatusform.php'>Post another Status</a>"."<br>".
                                                "<a href='http://jfm7532.cmslamp14.aut.ac.nz/assign1/index.html'>Return to home page</a></h2>";
                                            //header() 函数向客户端发送原始的 HTTP 报头
                                            //string 	必需。规定要发送的报头字符串
                                            //replace   可选。指示该报头是否替换之前的报头，或添加第二个报头
                                            //          默认是 true（替换）false（允许相同类型的多个报头）
                                            //http_response_code 	可选 把 HTTP 响应代码强制为指定的值
                                            //等待2秒后，返回home page
                                            //header("refresh:2; url = index.html");
                                        }else
                                        {
                                            echo "<h2 style='text-align: center; background-color: goldenrod'>Failed, Status Code can not be repeated"."<br>".$sql.mysqli_error($conn)."
                                          <br><a href='http://jfm7532.cmslamp14.aut.ac.nz/assign1/poststatusform.php'>Post another Status</a><br>
                                          <a href='http://jfm7532.cmslamp14.aut.ac.nz/assign1/index.html'>Return to home page</a></h2>";
                                        }
                                    }else
                                    {
                                        echo "<h2 style='text-align: center; background-color: goldenrod'>Wrong format. Status could only only contain alpha, numerical, comma, 
                              period (full stop), exclamation mark and question mark"."<br>"."<hr>".
                                            "<a href='http://jfm7532.cmslamp14.aut.ac.nz/assign1/poststatusform.php'>Post another Status</a>"."<br>".
                                            "<a href='http://jfm7532.cmslamp14.aut.ac.nz/assign1/index.html'>Return to home page</a></h2>";
                                    }
                                }
                            }
                        }else
                        {
                            echo "<h2 style='text-align: center; background-color: goldenrod'>Status code has start with an uppercase letter “S” followed by 4 digits,
                            please input 4 digits"."<br>"."<hr>".
                                "<a href='http://jfm7532.cmslamp14.aut.ac.nz/assign1/poststatusform.php'>Post another Status</a>"."<br>".
                                "<a href='http://jfm7532.cmslamp14.aut.ac.nz/assign1/index.html'>Return to home page</a></h2>";
                        }
                    } else
                    {
                        echo "<h2 style='text-align: center; background-color: goldenrod'>Status code has start with an uppercase letter “S” followed by 4 digits,
                        please input 4 digits"."<br>"."<hr>".
                            "<a href='http://jfm7532.cmslamp14.aut.ac.nz/assign1/poststatusform.php'>Post another Status</a>"."<br>".
                            "<a href='http://jfm7532.cmslamp14.aut.ac.nz/assign1/index.html'>Return to home page</a></h2>";
                    }
                }else
                {
                    //table不存在即创建table statuslog
                    echo "<h2 style='text-align: center'>Table not exist, create the table statuslog now.</h2>";
                    $sql_create_table = "CREATE TABLE statuslog(
                                         statusCode VARCHAR(100) UNIQUE NOT NULL,
                                         status VARCHAR(100) NOT NULL,
                                         share VARCHAR(100),
                                         date VARCHAR(100) NOT NULL,
                                         permission VARCHAR(100)
                                         )";
                    $conn->query($sql_create_table);

                }
            }else
            {
                echo "<h2>Error".mysqli_error($conn)."</h2>";
            }
        }
    }
    ?>
</div>
</body>
</html>

