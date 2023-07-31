<?php
header("Content-Type:text/html; charset=utf-8");
?>

<<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>CCUBike</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body id="wrapper-02">
  <div id="header">
        <h1><a href="index.php">CCUBike</h1>
        <h2>新用戶註冊結果</h2>
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
            include"db_connect.php";
            $conn=sqlsrv_connect($serverName,$connectionInfo);

            $uid=$_POST['uid'];
            $uname=$_POST['uname'];
            $major=$_POST['major'];
            $department=$_POST['department'];
            $phone=$_POST['phone'];
            $email=$_POST['email'];
            $password=$_POST['password'];

            // 將密碼進行雜湊處理-->不用用到
            //$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql="INSERT INTO dbo.users(uID, uName, phone, email, major, department,password)
                    VALUES('$uid',N'$uname','$phone','$email',N'$major',N'$department','$password')";
            $qury=sqlsrv_query($conn,$sql)or die("sql error: ".print_r(sqlsrv_errors(),true));
            if(isset($_POST['uid'])){
                echo '<font size=3>以下是您輸入的資料:<br/><br/>';
                echo '學號:';
                echo '<font color=#66B3FF>'.$_POST['uid'].'</font>';
                echo '<br/>';
            }
            else{
                echo "用戶資料建置錯誤</br>";
            }
            
            if(isset($_POST['uname'])){
                echo '姓名:';
                echo '<font color=#66B3FF>'.$_POST['uname'].'</font>';
                echo '<br/>';
            }
            else{
                echo "要記得設名字喔</br>";
            }
            if(isset($_POST['phone'])){
                echo '電話:';
                echo '<font color=#66B3FF>'.$_POST['phone'].'</font>';
                echo '<br/>';
            }
            else{
                echo "用戶電話資料建置錯誤</br>";
            }
            if(isset($_POST['email'])){
                echo '電子信箱:';
                echo '<font color=#66B3FF>'.$_POST['email'].'</font>';
                echo '<br/>';
            }
            else{
                echo "用戶電子信箱資料建置錯誤</br>";
            }
            if(isset($_POST['major'])){
                echo '系級:';
                echo '<font color=#66B3FF>'.$_POST['major'].'</font>';
                echo '<br/>';
            }
            else{
                echo "用戶系級資料建置錯誤</br>";
            }
            if(isset($_POST['department'])){
                echo '隸屬院所:';
                echo '<font color=#66B3FF>'.$_POST['department'].'</font>';
                echo '<br/>';
            }
            else{
                echo "用戶隸屬院所資料建置錯誤</br>";
            }
            ?>
             </p>
       </div>
    </div>     
</div>
</body></html>


