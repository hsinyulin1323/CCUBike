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
    <?php
        if(empty($_POST['uID'])||empty($_POST['comment'])){
            echo "你有資料未輸入";
            exit();
            }
            else{
        
                if(isset($_POST['uID'])){
                        echo '<h2>'.$_POST['uID'].'您好!您已傳送一則訊息給客服，我們將會盡快幫你服務<br/></h2>';
                        echo '<br/>';
                }
        }
        $uID = $_POST['uID'];
        $comment = $_POST['comment'];
    
        echo '你的留言內容:';
        echo '</br>';
        echo '<font color=#66B3FF>'.$_POST['comment'].'</font>';
        
        $c_time = date('Y-m-d H:i:s');
        $sql="INSERT INTO dbo.comment(uID,ctime, comments) VALUES('$uID', '$c_time' , '$comment' )";
        $query = sqlsrv_query($conn,$sql) ;   
        if ($query === false) {
            die("SQL error: " . print_r(sqlsrv_errors(), true));
        } else {
            echo "留言成功";
        }
        
    ?>
    </div>
</body>
</html>
