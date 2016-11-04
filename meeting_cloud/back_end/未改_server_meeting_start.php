<?php

	header("Content-Type: text/html; charset=UTF-8");
	
	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("login_check.php");			
	
	$no_values = NULL;
	$ip = $_POST["ip"];
	
	$sql = "INSERT INTO server_running_now (server_id, group_id, ip) 
			VALUES ('".$_SESSION["id"]."', '', '".$no_values."', '".$ip."')";		//sql 查詢語法, 查詢後會把結果返回到 $sql
		
	if($result = $conn->query($sql))
	{
		echo "vnc_start\n";
		header("Location: server_meeting_running.php");
	}
	else
	{
		echo "server running failed...\n";
		header("Location: local_server_center.php");
	}
	
?>