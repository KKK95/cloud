<?php

	header("Content-Type: text/html; charset=UTF-8");
	
	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("../login_check.php");			
	
	$id = $_SESSION['id'];
	
	$sql = "select group_meeting_now.* from group_meeting_now, meeting_scheduler as scheduler 
			where group_meeting_now.member_id = '".$id."' and scheduler.moderator_id = group_meeting_now.member_id 
			group by member_id";
	$result = $conn->query($sql);
	$moderator = $result->num_rows;
	
	if ($moderator == 1)
	{
		$row = $result->fetch_array();
		$meeting_id = $row['meeting_id'];
		$sql = "update meeting_scheduler set over = 1 where meeting_id = '".$meeting_id."'";
		$conn->query($sql);
	}
	
	$sql = "delete from group_meeting_now where meeting_id = '".$meeting_id."' and member_id = '".$id."'";
	$conn->query($sql);
	
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
		header("Location: ../web/employee_web/employee_center.php");
	}	
	
?>