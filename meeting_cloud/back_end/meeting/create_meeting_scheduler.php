<?php

	header("Content-Type: text/html; charset=UTF-8");
	
	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("login_check.php");			
	
	$group_id = $_POST["group_id"];
	$today = date("Y-m-d H:i:s");
	$meeting_title = $_POST['meeting_title'];
	$create_meeting_member_id = $_POST['create_meeting_member_id'];
	$meeting_time = $_POST['meeting_time'];
	
	if ($group_id != "" && $create_meeting_member_id != "")
	{
		if (((strtotime($meeting_time) - strtotime($today))/ (60*60)) > 0)				//新增的會議必定不能在過去
		{
			$sql = "INSERT INTO meeting_scheduler value('', '".$group_id."', '".$meeting_title."', '".$create_meeting_member_id."', '".$meeting_time."')";
			$result = $conn->query($sql);
		}
	}

		header("Location: employee_center.php");
	
?>