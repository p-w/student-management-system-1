<?php
session_start();
$user=$_POST["user"];
$pass=$_POST["pass"];
$pwd = md5($pass);

require_once('./config/database.php');

$com1 = "SELECT sid FROM user_student WHERE sid=? AND pwd=?";
$com2 = "SELECT adminID FROM user_admin WHERE adminID=? AND pwd=?";

$stmt1 = mysqli_prepare($db, $com1);
mysqli_stmt_bind_param($stmt1, "ss", $user, $pwd);
mysqli_stmt_execute($stmt1);
$result1 = mysqli_stmt_get_result($stmt1);

$stmt2 = mysqli_prepare($db, $com2);
mysqli_stmt_bind_param($stmt2, "ss", $user, $pwd);
mysqli_stmt_execute($stmt2);
$result2 = mysqli_stmt_get_result($stmt2);

if($result1->num_rows>0){
    $_SESSION["login"]=true;
    $_SESSION["user"]=$user;
    header ("HTTP/1.1 302 Moved Temporatily"); 
    header ("Location: "."./user/"); 
    exit();
}
else if($result2->num_rows>0){
    $_SESSION["login"]=true;
    $_SESSION["admin"]=$user;
    header ("HTTP/1.1 302 Moved Temporatily"); 
    header ("Location: "."./admin/"); 
    exit();
}
else{
    header ("HTTP/1.1 302 Moved Temporatily"); 
    header ("Location: "."./?retry=1"); 
    exit();
}
 
?>
