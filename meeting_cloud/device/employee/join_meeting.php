<?php

	//127.0.0.1:8080/meeting_cloud/device/employee\join_meeting.php?meeting_id=4

	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
//	require_once("../../login_check.php");	
	
	if (isset($_POST['meeting_id']))
		$meeting_id = $_POST['meeting_id'];
	else if (isset($_GET['meeting_id']))
		$meeting_id = $_GET['meeting_id'];
	//$meeting_id = 10;
	
	$sql = "select * from meeting_scheduler where meeting_id = '".$meeting_id."'";
	$result = $conn->query($sql);
	$num_rows = $result->num_rows;
	
	
	if($num_rows==0) echo("Invalid meeting id");
	else
		echo "#device/employee/meeting/meeting_info.php?meeting_id=".$meeting_id;
?>