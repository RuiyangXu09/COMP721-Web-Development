<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search System</title>
</head>
<body style="background-color: antiquewhite">
<div class="content">
    <?php
    if(isset($_GET['showResultClick']))
    {
        //require_once 语句和 require 语句完全相同, 唯一区别是 PHP 会检查该文件是否已经被包含过, 如果是则不会再次包含
        //require_once() 语句在脚本执行期间包括并运行指定文件, require_once() 为了避免重复加载文件,仅加载文件一次
        require_once ('sql_Inform.php');
        //数据库链接
        $conn = new mysqli($servername,$username,$password,$myDB,3306);
        //确认数据链接成功，否则打印错误信息
        //http://jfm7532.cmslamp14.aut.ac.nz/assign1/index.html
        if ($conn ->connect_error)
        {
            die("Connect failed.".$conn->connect_error);
        }else
        {
            //获取文本框中的值
            $search = $_GET['search'];
            //设置一个变量，接收来自sql语句查找对应号码的内容，WHERE限定条件为表格中status列中获取的文本值,
            //因为要求根据status列获取数据，而status可能有重复多个相似输入文本，所以需要使用模糊查询，依次查询可能存在的多个数据
            $result = mysqli_query($conn,"SELECT statusCode, status, share, date, permission FROM statuslog WHERE status LIKE '%$search%'");
            //如果search文本框中的值为空，打印一段语句警告
            if (empty($search))
            {
                echo "<h2 style='text-align: center'>The search string is empty. Please enter a keyword to search<br><hr>
                      <a href='http://jfm7532.cmslamp14.aut.ac.nz/assign1/searchstatus.html'>Search for another status</a>
                      </h2>";
                //等待1.5s返回搜索页面
                //header("refresh:1.5; url = searchstatus.html");
            }else
            {
                //mysqli_num_rows() 函数返回结果集中行的数量
                //mysqli_num_rows(result) result 必需 规定由 mysqli_query()、mysqli_store_result()
                //或 mysqli_use_result() 返回的结果集标识符
                //如果行数量大于0，证明表中存在数据集，否则打印信息告知没有数据存在
                echo "<h1 style='text-align: center; background-color: darkorange'>Status Information</h1>"."<br>"."<hr>";
                if (mysqli_num_rows($result) >0)
                {
                    //mysqli_fetch_array(result,resulttype) 从结果集中取得一行作为数字数组或关联数组
                    //result 必需 规定由 mysqli_query()、mysqli_store_result() 或 mysqli_use_result() 返回的结果集标识符
                    //resulttype 可选 规定应该产生哪种类型的数组。可以是以下值中的一个
                    //    MYSQLI_ASSOC
                    //    MYSQLI_NUM
                    //    MYSQLI_BOTH
                    while ($row = mysqli_fetch_array($result))
                    {
                        echo
                            "<h2 style='text-align: center; background-color: darkorange'>Status code: S".$row["statusCode"]."<br>".
                            "Status: ".$row["status"]."<br>".
                            "Share: ".$row["share"]."<br>".
                            "Date: ".$row["date"]."<br>".
                            "Permission Type: ".$row["permission"]."<br></h2>".
                            //使用hr标签分割获取的数据
                            "<hr>";
                    }
                }else
                {
                    echo "<h2 style='text-align: center; background-color: darkorange'>The status not found."."<br></h2><hr>";
                }
                //打印返回页面
                echo "<h3 style='text-align: center; background-color: darkorange'>
                      <a href='http://jfm7532.cmslamp14.aut.ac.nz/assign1/searchstatus.html' style='text-align: left'>Search for another status</a>
                      <br>
                      <a href='http://jfm7532.cmslamp14.aut.ac.nz/assign1/index.html'>Return to home page</a>
                      </h3>";
            }
        }
    }
    ?>
</div>
</body>
</html>