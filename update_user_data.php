<?php
    header("Content-Type:text/html; charset=utf-8");
    date_default_timezone_set('Asia/Taipei');

    header("Content-Type:text/html; charset=utf-8");

    session_start();

    include"db_connect.php";
    $conn=sqlsrv_connect($serverName,$connectionInfo);
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>CCUBike</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body id="wrapper-02">
  <div id="header">
    <h1>用戶資料修改結果</h1>
    <h2> <a href="index.html">首頁</a> </h2>
    <ul id="navi">
            <!-- 導覽列從此開始 -->
            <li id="navi_01">
                <a href="#">用戶資料</a>
                <ul id="a1">
                    <li><a href="login.html">登入</a></li>
                    <li><a href="insert_new.html">新用戶註冊</a></li>
                    <li><a href="update_user.html">修改資料</a></li>
                    <li><a href="history.html">歷史行程查詢</a></li>
                </ul>
            </li>
            <li id="navi_02">
                <a href="#">即時查詢</a>
				<ul id="a2">
                    <li><a href="search_bike.html">站點單車數量</a>
                    </li>
                    <li><a href="search_parking.html">站點車位數量</a>
                    </li>
                </ul>
            </li>
            <li id="navi_03">
                <a href="#">租借GoGo</a>
				<ul id="a3">
                    <li><a href="rent.php">租車</a>
                    </li>
                    <li><a href="return_2.php">還車</a>
                    </li>
                    
                </ul>
            </li>
            <li id="navi_04">
                <a href="#">客服專區</a>
				<ul id="a4">
                    <li><a href="comments.html">意見回饋</a>
                </ul>
            </li>
            <li id="navi_05">
                <a href="#">分析報表</a>
				<ul id="a5">
                    <li><a href="search_highlight.php">高峰時刻</a>
                    </li>   
                    <li><a href="search_overview.php">業績統計分析表</a>
                    </li>
                </ul>
            </li>
            <!-- 導覽列到此為止 -->
        </ul>
  </div>
    
<div id="contents">
    <div class="detail_box clearfix">
        <div class="link_box">
            <?php   		
                $uID = $_POST['uID'];
                $uName = $_POST['uname'];
                $major = $_POST['major'];
                $department = $_POST['department'];
                $phone = $_POST['phone'];
                $email = $_POST['email'];
                $password = $_POST['password'];

                $sql="UPDATE dbo.users SET 
                    uName = N'$uName',
                    major = N'$major',
                    department = N'$department',
                    Phone = N'$phone',
                    password = N'$password' 
                    WHERE uID = N'$uID'";
                    $query = sqlsrv_query($conn,$sql) or die("sql error".sqlsrv_errors());   
                    if(sqlsrv_rows_affected($query))
                    {
                        echo "帳號:".$uID." 資料已修改完成。<br> 請點首頁回到系統管理畫面!<br/>";
                    }
            ?>
        </div>
    </div>
</div>
</body></html>