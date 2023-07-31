<?php
header("Content-Type:text/html; charset=utf-8");
session_start();
?>

<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>CCUBike</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>

<body id="wrapper">
  <div id="header">
        <h1><a href="Index.html">CCUBike</a></h1> 
        <h2>登入結果</h2>
        <ul id="navi">
            <!-- 導覽列從此開始 -->
            <li id="navi_01">
                <a href="#">用戶資料</a>
                <ul id="a1">
                    <li><a href="login.html">登入</a></li>
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
                <h1>登入</h1>
                <?php 
                    if (isset($error_message)) { 
                ?>
                <p style="color: red;">
                <?php echo $error_message; ?></p>
                <?php } 
                ?>
                <form action="http://127.0.0.1:8080/CCUBike/login.php" method="POST">
                    <label for="uid">帳號（學號）：</label>
                    <input type="text" id="uid" name="uid" required><br><br>
                    <label for="password">密碼：</label>
                    <input type="password" id="password" name="password" required><br><br>
                    <input type="submit" value="登入">
                </form>
                <?php
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);

                include "db_connect.php" ;
                $conn=sqlsrv_connect($serverName,$connectionInfo);

                $uid = $_POST['uid'];
                $password = $_POST['password'];


                if ($conn === false) {
                    echo "無法連接到資料庫。<br />";
                    die(print_r(sqlsrv_errors(), true));
                }

                // 準備查詢
                $sql = "SELECT * FROM users WHERE uID = ?";
                $params = array($uid);
                $query = sqlsrv_query($conn, $sql, $params);

                // 檢查查詢結果
                if ($query === false) {
                    die(print_r(sqlsrv_errors(), true));
                }

                if (sqlsrv_has_rows($query)) {
                    // 使用者存在，驗證密碼
                    $row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
                    /*
                    var_dump($row); // 查看從資料庫獲取的行數據
                    var_dump($password); // 查看輸入的密碼值
                    var_dump($row['password']); // 查看資料庫中儲存的密碼值
                    */
                    if ($password===$row['password']) {
                        // 登入成功，將使用者導向到其他頁面
                        header('Location: welcome.php');
                        // 登入驗證成功，將使用者資料存儲在會話中
                        $_SESSION['user'] = $row; // 將 $row 資料存儲在會話中，假設 $row 是從資料庫中取得的使用者資料
                        echo'   welcome!';
                        //header('Location: welcome.php');
                        exit;
                    } else {
                        // 密碼錯誤
                        $error_message = '密碼錯誤';
                        echo $error_message;
                        exit;
                    }
                } else {
                    // 使用者不存在
                    $error_message = '使用者帳號錯誤';
                }

                // 登入失敗，顯示錯誤訊息
                echo $error_message;
                ?>
                </div>
        </div>
    </div>
</body>
</html>
