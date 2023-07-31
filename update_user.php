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
    <h1><a href="index.html">首頁</a></h1>
    <h2>用戶資料修改</h2>
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
        <?php   		
            if(empty($_POST['uID']))	
            {
                echo "!!!! 請輸入帳號 !!!<br />";
            }
            else
            {        
            $uID=$_POST['uID'];
            $sql="SELECT * FROM dbo.users WHERE uID='$uID'";
            $qury=sqlsrv_query($conn,$sql) or die("sql error".sqlsrv_errors());
            $row=sqlsrv_fetch_array($qury);
            if(empty($row['uID']))
            {
                echo "!!! 無此帳號 !!!<br />";
            }
            else
            {	
        ?>
    <form name="form" action="http://127.0.0.1:8080/CCUBike/update_user_data.php" method="POST" accept-charset="UTF-8" align="center">
            <div class="detail_box clearfix">
            <div class="link_box">
            <h3>修改客戶資料</h3>

            <table>
                <tr>
                 <th>使用者帳號（學號）:</th><td><input id="uid" type="text" name="uid" size="30" required /></td>  
                    <th>姓名:</th><td><input id="uname" type="text" name="uname" size="30" /></td>
                </tr>
              
                <tr>
                    <th>科系:</th><td><input id="major" type="text" name="major" size="30" /></td>
                    <th>隸屬院所:</th><td><input id="department" type="text" name="department" size="30" /></td>
                </tr>
                <tr>
                    <th>電話號碼:</th><td><input id="phone" type="tel" name="phone" size="30" /></td>
                    <th>電子信箱:</th><td><input id="email" type="email" name="email" size="30"  /></td>
                </tr>
                <br>
                <tr>
                    <th>密碼:</th><td><input id="password" type="password" name="password" size="30" required /></td>
                    <th>確認密碼:</th><td><input id="confirm_password" type="password" name="confirm_password" size="30" required /></td>
                </tr>
                
            </table>
            </br>
                    <input type="reset" align="left" value="清除資料">
                    &nbsp;&nbsp;
                    <input type="submit" name="submit" align="right" value="送出">
        </form>
        </div>
        </div>
    <?php
	} }?>
</div>
</body>
</html>
          