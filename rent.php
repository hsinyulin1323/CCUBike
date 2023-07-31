<?php
    header("Content-Type:text/html; charset=utf-8");
    date_default_timezone_set('Asia/Taipei');

    header("Content-Type:text/html; charset=utf-8");

    session_start();

    include"db_connect.php";
    $conn=sqlsrv_connect($serverName,$connectionInfo);
?>
<!DOCTYPE html>
<head>
    <title>CCUBike</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
                <a href="report.html">客服專區</a>
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
    <br>
    <br>
    <div id= "contents">     
        <div class="detail_box clearfix">
            <div class="link_box">
                <?php
                 // 檢查使用者是否已登入
                if (!isset($_SESSION['user'])) {
                    header("Location: login.html");
                    exit;
                }
                
                // 檢查 $rent_stName 是否已經設置為全域變數
                if (!isset($_SESSION['rent_stName']) && empty($_SESSION['rent_stName'])) {
                    // 如果尚未設置或為空值，則將其初始化為空值
                    $_SESSION['rent_stName'] = "";
                }
                // 在選擇起始站表單的處理程式碼中，將 $rent_stName 的值存入全域變數
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rent_stName'])) {
                    $_SESSION['rent_stName'] = $_POST['rent_stName'];
                }


                // 取得登入使用者的資料
                $user = $_SESSION['user'];
                $uid = $user['uID']; // 使用者ID
                // 從全域變數中獲取 $rent_stName 的值
                $rent_stName = $_SESSION['rent_stName'];
                // 檢查用戶是否有未歸還的租車記錄
                $sql_check_rental = "SELECT * FROM receipt WHERE uID = ? AND return_time IS NULL";
                $params_check_rental = array($uid);
                $query_check_rental = sqlsrv_query($conn, $sql_check_rental, $params_check_rental);

                if ($query_check_rental === false) {
                    die(print_r(sqlsrv_errors(), true));
                }

                if (sqlsrv_has_rows($query_check_rental)) {
                    echo "您已經有未歸還的租車記錄，請先歸還車輛後再進行租借。";
                    exit;
                }

                if (!empty($rent_stName)) {
                    // 從資料庫中獲取該站有的車輛代碼（bID）
                    $sql_1 = "SELECT bID FROM position WHERE stName = ?";
                    $params_1 = array($rent_stName);
                    $query_1 = sqlsrv_query($conn, $sql_1, $params_1);
                    if ($query_1 === false) {
                        die(print_r(sqlsrv_errors(), true));
                    }
                    //var_dump($query_1);

                }
                //var_dump($_SESSION['rent_stName']);
                // 處理選擇車輛代碼表單的提交
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bID'])) {
                    $bID = $_POST['bID'];
                    if (empty($rent_stName)) {
                        echo "起始站未選擇";
                        exit;
                    }
                    else{
                    // 檢查車輛是否可被租借
                    $sql_2_check_bike = "SELECT * FROM bike WHERE bID = ? AND using = 'N'";
                    $params_2_check_bike = array($bID);
                    $query_2_check_bike = sqlsrv_query($conn, $sql_2_check_bike, $params_2_check_bike);

                    if ($query_2_check_bike === false) {
                        die(print_r(sqlsrv_errors(), true));
                    }
                    //如果找到符合條件的車輛，則進行租借操作。將資料插入到 receipt 資料表中
                    if (sqlsrv_has_rows($query_2_check_bike)) {
                        $start_time = date('Y-m-d H:i:s');
                        $sql_3 = "INSERT INTO receipt (uID, bID, rent_stName, start_time) VALUES (?, ?, ?, ?)";
                        $params_3 = array($uid, $bID, $rent_stName, $start_time);
                        $query_3 = sqlsrv_query($conn, $sql_3, $params_3);
                        if ($query_3 === false) {
                            die(print_r(sqlsrv_errors(), true));
                        }
                        // 更新車輛的狀態為 'Y'，表示正在使用中
                        $sql_4_update_bike = "UPDATE bike SET using = 'Y' WHERE bID = ?";
                        $params_4_update_bike = array($bID);
                        $stmt_update_bike = sqlsrv_query($conn, $sql_4_update_bike, $params_4_update_bike);

                        if ($stmt_update_bike === false) {
                            die(print_r(sqlsrv_errors(), true));
                        }
                        // 顯示成功訊息或重新導向到其他頁面
                        echo "租借成功！";
                    } else {
                            echo "該車輛已被租借，無法再次租借。";
                        }
                    // 更新起始站的可用車輛數量
                    $sql_5_update_station = "UPDATE station SET bike_num = bike_num - 1 WHERE stName = ?";
                    $params_5_update_station = array($rent_stName);
                    $stmt_5_update_station = sqlsrv_query($conn, $sql_5_update_station, $params_5_update_station);

                    //var_dump($query_2);
                    // 清除全域變數
                    //$_SESSION['rent_stName'] = "";
                    }
                }
                
                ?>
                <!-- 根據起始站從資料庫中獲取車輛代碼選項 -->
                <?php
                echo" <br><br>";
                //$rent_stName = $_SESSION['rent_stName'];
                echo "您選擇的起始站為：" . $rent_stName ;
                echo" <br><br>";
                ?>
                
            <!-- 顯示起始站和車輛選項的表單 -->               
                <form action="rent.php" method="post">
                <label for="rent_stName">選擇起始站（目前位置）：</label>
                <select name="rent_stName">
                <option value="大門">大門</option>
                <option value="活動中心">活動中心</option>
                <option value="管理學院">管理學院</option>
                <option value="圖書館">圖書館</option>
                <option value="共同教學大樓">共同教學大樓</option>
                <option value="法學院">法學院</option>
                <option value="工學院">工學院</option>
                <option value="創新大樓">創新大樓</option>
                <option value="宿舍">宿舍</option>
                <option value="體育館">體育館</option>
                </select>
                <input type ="submit" value="送出">
                </form>
                <br>
                <?php
                    if (!empty($rent_stName) && isset($query_1)) {
                        echo "<form action='rent.php' method='post'>";
                        echo "<label for='bID'>選擇車輛代碼：</label>";
                        echo "<select name='bID'>";
                        while ($row = sqlsrv_fetch_array($query_1, SQLSRV_FETCH_ASSOC)) {
                            echo "<option value='" . $row['bID'] . "'>" . $row['bID'] . "</option>";
                        }
                        echo "</select>";
                        echo "<input type='submit' value='送出'>";
                        echo "</form>";
                    }
                ?>
                </form>

            </div>
        </div>
    <div>
<body>
</html>
                