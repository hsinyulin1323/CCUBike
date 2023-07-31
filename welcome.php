<?php
header("Content-Type:text/html; charset=utf-8");
?>
<html>

<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title>CCUBike</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>


<body id="wrapper">
    <div id="header">
        <h1><a href="welcome.php">CCUBike</a></h1> 
        <p class="copy">國立中正大學資管系林欣諭設計</p>
        <ul id="navi">
            <!-- 導覽列從此開始 -->
            <li id="navi_01">
                <a href="#">用戶資料</a>
                <ul id="a1">
                    <li><a href="logout.php">登出</a></li>
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
        <div id= "contents">
            <div class="detail_box clearfix">
            <div class="link_box">
            <?php
                include "db_connect.php" ;
                $conn=sqlsrv_connect($serverName,$connectionInfo);
        
                // 在登入後的首頁 (welcome.php) 中讀取會話資料
                session_start();
                if (isset($_SESSION['user'])) {
                // 使用者已登入，讀取使用者資料並顯示
                $user = $_SESSION['user'];
                echo '歡迎，' . $user['uName'] . '！'; // 假設使用者資料中有 username 欄位
                // 顯示其他使用者資料...
                } else {
                // 使用者未登入，將其導向到登入頁面或其他處理方式
                header('Location: login.php');
                exit;
                }
            ?>
            </div>
        </div>
    </div>
</body>
</html>
