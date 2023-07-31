<?php
    header("Content-Type:text/html; charset=utf-8");
    date_default_timezone_set('Asia/Taipei');

    session_start();

    include"db_connect.php";
    $conn=sqlsrv_connect($serverName,$connectionInfo);
?>
<!DOCTYPE html>
<html>
<head>
    <title>CCUBike</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="style.css" rel="stylesheet" type="text/css">
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
                    <li><a href="logout.php">登出</a></li>
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
        <div id= "contents"> 
        <div class="detail_box clearfix">
            <div class="link_box">
                <?php
                if (!isset($_SESSION['user'])) {
                    header("Location: login.html");
                    exit;
                }
                // 取得登入使用者的資料
                $user = $_SESSION['user'];
                $uid = $user['uID'];
                // 驗證成功後，取得使用者的角色
                $sql_users = "SELECT role FROM users WHERE uID = ?";
                $params_users = array($uid);
                $stmt_users = sqlsrv_query($conn, $sql_users, $params_users);

                if ($stmt_users === false) {
                    die(print_r(sqlsrv_errors(), true));
                }

                if ($row = sqlsrv_fetch_array($stmt_users, SQLSRV_FETCH_ASSOC)) {
                    $role = $row['role'];

                    if ($role === 'admin') {
                        // 使用者是超級使用者，設定相關的 session 變數或其他處理
                        $_SESSION['loggedIn'] = true;
                        $_SESSION['role'] = 'admin';

                        $sql = "SELECT TOP 3 DATEPART(hour, start_time) AS hour_of_day, COUNT(*) AS receipt_count
                                FROM receipt
                                GROUP BY DATEPART(hour, start_time)
                                ORDER BY COUNT(*) DESC";
                        $stmt = sqlsrv_query($conn,$sql );
                        if( $stmt ===false){
                            die(print_r(sqlsrv_errors(),true));
                        }
                        while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                            echo"尖峰時刻：". $row['hour_of_day'] ." 點鐘 &nbsp  ";
                            echo"訂單筆數：" . $row['receipt_count']."<br>";
                        }

                    } else {
                        // 使用者不是超級使用者，顯示錯誤訊息或其他處理
                        echo '您沒有權限訪問此頁面';
                        exit();
                    }
                } else {
                    // 使用者不存在或發生其他錯誤
                    echo '登入失敗';
                    exit();
                }   
                unset($_SESSION['return_stName']);
                    
                ?>
            </div>
        </div>
    </div>
</body>
</html>

