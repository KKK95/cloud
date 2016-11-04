<?php

	header("Content-Type: text/html; charset=UTF-8");
	
	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("login_check.php");			
	
	$sql = "delete from server_running_now where server_id = '".$_SESSION["id"]."'";
		
	if($result = $conn->query($sql))
	{
		echo "server closing now...\n";
		header("Location: local_server_center.php");
	}
	else
	{
		echo "server closing failed...\n";
		header("Location: local_server_center.php");
	}
	
?>