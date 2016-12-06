<?php

	header("Content-Type: text/html; charset=UTF-8");
	
	if(!isset($_SESSION))
	{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../connMysql.php");			//引用connMysql.php 來連接資料庫
	
//	require_once("../login_check.php");

	$ip = "";
	
	if (isset($_POST['ip']))
		$ip = $_POST['ip'];
	
	if (isset($_SESSION['id']))
		$id = $_SESSION['id'];
	else
		$id = "lsaa";

	$sql = "select * from server_running_now where server_id = '".$id."'";
	$result = $conn->query($sql);
	$num_rows = $result->num_rows;
	
	if ($num_rows == 0)					//未登記
	{	$sql = "INSERT INTO server_running_now value('".$id."', 0, 0, '".$ip."')";	}
	else
	{	$sql = "update server_running_now set ip = '".$ip."' where server_id = '".$id."'";	}

	$conn->query($sql);
	
	header("Location: device/local_server/server_meeting_running.php"); 
	


?>