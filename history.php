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
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>CCUBike</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body id="wrapper">
    <div id="header">
        <h1><a href="index.html">CCUBike</a></h1>
        <p class="copy">國立中正大學資管系林欣諭設計</p>
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
    <div id= "contents"> 
        <div class="detail_box clearfix">
            <div class="link_box">
            <?php
                // 檢查使用者是否已登入
                if (!isset($_SESSION['user'])) {
                    header("Location: login.html");
                    exit;
                }
                
                // 取得登入使用者的資料
                $user = $_SESSION['user'];
                $uid = $user['uID']; // 使用者ID
                
                // 判斷表單提交的值
                if (isset($_POST['history'])) {
                    $action = $_POST['history'];
                    
                    if ($action === "login") {
                        echo "執行登入操作";
                        header("location:login.html");
                        // 執行登入操作的程式碼
                    } elseif ($action === "query") {
                        // 執行查詢操作的程式碼
                        $sql = "SELECT * FROM dbo.receipt WHERE uID = ?";
                        $params = array($uid);
                        $stmt = sqlsrv_query($conn, $sql, $params);
                        if ($stmt === false) {
                            die(print_r(sqlsrv_errors(), true));
                        }
                        echo'<br>';
                        // 輸出查詢結果
                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                            // 輸出每一列的欄位值
                            //echo "rID: " . $row['rID'] . "<br>";
                            //echo "uID: " . $row['uID'] . "<br>";
                            echo "車輛代碼:"  . $row['bID'] . "<br>";
                            echo "起始站：" . $row['rent_stName'] . "<br>" ;
                            echo "歸還站：" . $row['return_stName'] . "<br>";
                            echo "起始時間：" . $row['start_time']->format('Y-m-d H:i:s')."<br>";
                            echo "歸還時間：" . $row['return_time']->format('Y-m-d H:i:s')."<br>";
                            echo "騎乘時間：" . $row['during']."分鐘<br>";
                            echo "<br>";
                        }
                    }
                }
            
            ?>
            </div>
        </div>
    </div>

</body>

</html>