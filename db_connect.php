<?php
     header("Content-Type:text/html; charset=utf-8");
     $serverName="localhost";
     $connectionInfo=array(
        "Database"=>"CCUBike",
        "UID"=>"SA",
        "PWD"=>"PassWord123@",
        "CharacterSet" => "UTF-8",
        "TrustServerCertificate"=>"yes");
     $conn=sqlsrv_connect($serverName,$connectionInfo);
         if($conn){
             echo "Success!!!<br />";
         }else{
             echo "Error!!!<br />";
             die(print_r(sqlsrv_errors(),true));
         }            
?>