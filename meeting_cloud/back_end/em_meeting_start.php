<?php

	header("Content-Type: text/html; charset=UTF-8");
	
	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("../login_check.php");			
	
	$meeting_time = date("Y-m-d H:i:s");
	$meeting_id = $_GET["meeting_id"];
	
	$sql = "select group_id from meeting_scheduler where meeting_id = '".$meeting_id."'";
	$row=$result->fetch_array();
	$group_id = $row['group_id'];				//取得群組id
	
	$sql = "select meeting_time from meeting_record where meeting_id = '".$meeting_id."'";
	$result->fetch_array();		//要知道目前有沒有人開始了會議
	
	$num_rows = $result->num_rows;	
	if ($num_rows==0)
	{
		$sql = "INSERT INTO group_meeting_now value('".$meeting_id."', '".$_SESSION["id"]."', 'none', 'none')";
		$result = $conn->query($sql);
	}
	else	//還沒開始會議
	{
		$sql = "INSERT INTO group_meeting_now value('".$meeting_id."', '".$_SESSION["id"]."', 'none', 'none')";
		$result = $conn->query($sql);
		$sql = "INSERT INTO meeting_record value('".$meeting_id."', '".$group_id."', '".$meeting_time."')";
		$result = $conn->query($sql);
	}
	if ($_SESSION['platform'] == "device")
		header("Location: ../device/employee/em_meeting_running.php");
	else if ($_SESSION['platform'] == "web")
		header("Location: ../web/employee/em_meeting_running.php");

	
?>