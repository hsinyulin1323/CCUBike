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
                    <li><a href="insert_commend.html">意見回饋</a>
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
                 // 從全域變數中獲取 $rent_stName 的值

                if (isset($_POST['return_stName'])) {
                    $return_stName = $_POST['return_stName'];
                    $_SESSION['return_stName'] = $return_stName;
                } elseif (isset($_SESSION['return_stName'])) {
                    $return_stName = $_SESSION['return_stName'];
                } else {
                    $return_stName = ""; // 預設值
                }
                
                
                // 在這裡使用 $return_stName 進行相關處理或顯示相關資訊
                echo "您要還車的站名為：" . $return_stName;
                echo "<br><br>";
                

                // 檢查用戶是否有未歸還的租車記錄
                $sql_check_rental = "SELECT * FROM receipt WHERE uID = ? AND return_time IS NULL";
                $params_check_rental = array($uid);
                $query_check_rental = sqlsrv_query($conn, $sql_check_rental, $params_check_rental);
               
                if ($query_check_rental === false) {
                    die(print_r(sqlsrv_errors(), true));
                }

                if (sqlsrv_has_rows($query_check_rental)) {
                    echo'<form action="return_2.php" method="post">
                        <label for="return_stName">選擇歸還站（目前位置）：</label>
                        <select name="return_stName">
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
                        <input type ="submit" value="還車">
                        </form>';
                        echo "您要還車的站名為：" . $return_stName ;
                        echo" <br><br>";
                }else {
                    // 使用者沒有未歸還的租車記錄，顯示提示訊息
                    echo "您沒有需要歸還的車輛記錄。";
                }
                
                // 檢查表單是否已提交
                if (isset($_POST['return_stName'])) {
                    // 獲取選擇的歸還站名稱
                    $return_stName = $_POST['return_stName'];
                

                    //更新receipt資料，增加return_stName, return_time
                    $return_time = date('Y-m-d H:i:s');
                    $sql_update_receipt_return ="UPDATE receipt SET return_stName = ?,return_time= ? ,during = DATEDIFF(minute, start_time, ?) WHERE uID= ? AND return_time IS NULL ";
                    $params_update_receipt_return  = array($return_stName,$return_time,$return_time, $uid);
                    $stmt_update_receipt_return = sqlsrv_query($conn, $sql_update_receipt_return , $params_update_receipt_return );
                    
                    if ($stmt_update_receipt_return  === false) {
                        die(print_r(sqlsrv_errors(), true));
                    }

                    if (sqlsrv_has_rows($query_check_rental)) {
                        // 獲取第一行結果的 bID 值
                        $row = sqlsrv_fetch_array($query_check_rental, SQLSRV_FETCH_ASSOC);
                        $bID = $row['bID'];
                                
                        // 更新 bike 表格中的 using 欄位為 "N"
                        $sql_update_bike = "UPDATE Bike SET using = 'N' WHERE bID=? ";
                        $params_update_bike = array($row['bID']);
                        $stmt_update_bike = sqlsrv_query($conn, $sql_update_bike, $params_update_bike);
                        //$stmt_update_bike=$_SESSION[$stmt_update_bike];
                        if ($stmt_update_bike === false) {
                            die(print_r(sqlsrv_errors(), true));
                        }
                    
                        //更新車輛位置
                        $sql_update_position ="UPDATE position SET stName = ? WHERE bID = ?";
                        $params_update_position = array($return_stName,$row['bID']);
                        $stmt_update_position = sqlsrv_query($conn, $sql_update_position, $params_update_position);
                        if ($stmt_update_position ===false) {
                            die(print_r(sqlsrv_errors(),true));

                        }
                        //var_dump($return_stName, $bID);

                        // 查詢車站記錄
                        $sql_select_station = "SELECT stno, bike_num FROM station WHERE stName = ?";
                        $params_select_station = array($return_stName);
                        $stmt_select_station = sqlsrv_query($conn, $sql_select_station, $params_select_station);

                        if ($stmt_select_station === false) {
                            die(print_r(sqlsrv_errors(), true));
                        }

                        if (sqlsrv_has_rows($stmt_select_station)) {
                            // 獲取車站記錄
                            $row_station = sqlsrv_fetch_array($stmt_select_station, SQLSRV_FETCH_ASSOC);

                            // 獲取 stno 和 bike_num
                            $stno = $row_station['stno'];
                            $bike_num = $row_station['bike_num'];

                            // 增加 bike_num
                            $bike_num += 1;

                            // 更新車站記錄
                            $sql_update_station = "UPDATE station SET bike_num = ? WHERE stno = ?";
                            $params_update_station = array($bike_num, $stno);
                            $stmt_update_station = sqlsrv_query($conn, $sql_update_station, $params_update_station);

                            if ($stmt_update_station === false) {
                                die(print_r(sqlsrv_errors(), true));
                            }
                        }
                    }
                    
                    // 檢查更新結果
                    if (isset($stmt_update_receipt_return)  && isset($stmt_update_bike) && isset($stmt_update_position) ) {
                        // 提交交易
                        sqlsrv_commit($conn);
                        echo "車輛已成功歸還！";
                    } else {
                        // 回滾交易
                        sqlsrv_rollback($conn);
                        echo "還車過程中出現問題，請稍後再試。";
                    }
                    unset($_SESSION['return_stName']);
                }
            ?>

            </div>
        </div>
    </div>
<body>
</html>