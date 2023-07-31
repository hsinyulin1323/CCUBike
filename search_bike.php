<?php
header("Content-Type:text/html; charset=utf-8");
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
        <br><br/>
        <br><br/>
        <div class="detail_box clearfix">
            <div class="link_box">
                <?php
                if($_POST['stName']!=''){
                    $stName=$_POST['stName'];
                    $sql="SELECT bike_num FROM dbo.station WHERE stName = ? ";
                    $params = array($stName);
                    $stmt = sqlsrv_query($conn, $sql, $params);
                    if ($stmt === false) {
                        die(print_r(sqlsrv_errors(), true));
                    }
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                        $bike_num = $row['bike_num'];
                        echo"目前車輛數：  $bike_num  <br>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
