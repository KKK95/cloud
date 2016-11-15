<?php

	header("Content-Type: text/html; charset=UTF-8");
	
	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("../login_check.php");			
	
	
	
	if ($_SESSION['platform'] == "device")
	{
		if ($_SESSION['access'] == "ls")
			$sql = "delete form server_running_now where server_id = '".$_SESSION["id"]."'";
		else
			$sql = "delete form group_meeting_now where member_id = '".$_SESSION["id"]."'";
		
		$result = $conn->query($sql);
		header("Location: ../device/employee/employee_center.php");
	}	
	else if ($_SESSION['platform'] == "web")
	{
		$sql = "delete form group_meeting_now where member_id = '".$_SESSION["id"]."'";
		
		$result = $conn->query($sql);
		header("Location: ../web/employee/employee_web/employee_center.php");
	}	
	
?>