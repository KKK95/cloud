<?php

	header("Content-Type: text/html; charset=UTF-8");
	
	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("login_check.php");			
	
	$no_values = NULL;
	$local_server_id = $_POST["local_server_id"];
	$member_ip = $_POST["member_ip"];
	$meeting_time = date("Y-m-d H:i:s");
	$meeting_id = $_POST["member_id"];
	
	$meeting_title = $_POST['meeting_title'];
													//正在運行的主機會在server_running_now資料表中填上自己的id, 當主機關閉時會在資料表中刪除自己的id
	$sql = "select group_id, ip from server_running_now where server_id = '".$local_server_id."'";			//查看lsid(會議主機id) 是否有在運行和空閒
	
	$result = $conn->query($sql);

	$row=$result->fetch_array();
	
	if ($row['group_id'] == $gid || $row['group_id'] == NULL)
	{
		if ($row['group_id'] == NULL)				//如果所屬群組尚未在主機中登錄
		{
			$sql = "UPDATE server_running_now SET group_id = '".$group_id."', meeting_id = '".$meeting_id."'  where server_id = '".$local_server_id."'";	
			$result = $conn->query($sql);
			//會議主機已經寫入資料庫, 現在把group id填上去
			$sql = "INSERT INTO group_meeting_now value('".$meeting_id."', '".$_SESSION["id"]."', '".$local_server_id."', '".$member_ip."')";
			$result = $conn->query($sql);
			$sql = "INSERT INTO meeting_record value('".$meeting_id."', '".$meeting_time."', '".$group_id."')";
			$result = $conn->query($sql);
			
			//插一個登入時間
		}
		else										//所屬群組已登錄該主機
		{
			$sql = "INSERT INTO group_meeting_now value('".$meeting_id."', '".$_SESSION["id"]."', '".$local_server_id."', '".$member_ip."')";
			$result = $conn->query($sql);
		}
		
		header("Location: em_meeting_running.php");
	}
	else
	{
		header("Location: employee_center.php");
	}
	
?>