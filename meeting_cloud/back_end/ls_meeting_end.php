<?php

	header("Content-Type: text/html; charset=UTF-8");
	
	if(!isset($_SESSION))
	{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../connMysql.php");			//引用connMysql.php 來連接資料庫
	
//	require_once("../login_check.php");
	
	if (isset($_SESSION['id']))
		$id = $_SESSION['id'];
	else
		$id = "lsaa";

	$sql = "delete from server_running_now server_id = '".$id."'";
	$conn->query($sql);
	
	header("Location: device/local_server/local_server_center.php"); 
	


?>