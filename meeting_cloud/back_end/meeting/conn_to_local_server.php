<?php

	header("Content-Type: text/html; charset=UTF-8");
	
	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("../../login_check.php");			
	
	$local_server_id = $_POST["local_server_id"];
	$member_ip = $_POST["member_ip"];
	$meeting_time = date("Y-m-d H:i:s");
	
	$sql = "select group_id from meeting_scheduler where meeting_id = '".$meeting_id."'";
	$row=$result->fetch_array();
	$group_id = $row['group_id'];					//取得群組id
	
	$sql = "select * from group_meeting_now where member_id = '".$_SESSION["id"]."'";
	$result=$conn->query($sql);
	$num_rows = $result->num_rows;					//看是否在會議中
	if ($num_rows==0)								//否
	{	
		echo "你目前不在會議中，無法連線到local server";
		header("Location: employee_center.php");
	}
	else											//是
	{
		$row=$result->fetch_array();
		$meeting_id = $row['meeting_id'];			//取得meeting_id
	}
	
													//正在運行的主機會在server_running_now資料表中填上自己的id, 當主機關閉時會在資料表中刪除自己的id
	$sql = "select group_id, ip from server_running_now where server_id = '".$local_server_id."'";			//查看lsid(會議主機id) 是否有在運行和空閒
	
	$result = $conn->query($sql);

	$row=$result->fetch_array();
	
	if ($row['group_id'] == $group_id || $row['group_id'] == "none")
	{
		if ($row['group_id'] == "none")				//如果所屬群組尚未在主機中登錄
		{
			$sql = "UPDATE server_running_now SET group_id = '".$group_id."', meeting_id = '".$meeting_id."'  where server_id = '".$local_server_id."'";	
			$result = $conn->query($sql);
			//會議主機已經寫入資料庫, 現在把group id填上去
			$sql = "UPDATE group_meeting_now SET server_id = '".$local_server_id."', member_ip = '".$member_ip."' where meeting_id = '".$meeting_id."'";
			$result = $conn->query($sql);
			
			//插一個登入時間
		}
		else 										//所屬群組已登錄該主機
		{
			$sql = "UPDATE group_meeting_now SET server_id = '".$local_server_id."', member_ip = '".$member_ip."' where meeting_id = '".$meeting_id."'";
			$result = $conn->query($sql);
		}
		
		$sql = "select * from server_running_now where meeting_id = '".$meeting_id."'";
		$result = $conn->query($sql);
		$row=$result->fetch_array();
		
		$json = array
		(
			"contents"=>array
			(
				"server_ip" => $row['server_ip'],
			),
		);
	}
	else
	{
		$json = array
		(
			"contents"=>array
			(
				"server_ip" => "會議主機正被使用中",
			),
		);
	}
	
?>