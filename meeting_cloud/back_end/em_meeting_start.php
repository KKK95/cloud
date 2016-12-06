<?php

	header("Content-Type: text/html; charset=UTF-8");
	
	//會改
	/*
	server_running_now
	group_meeting_now
	join_meeting_member
	meeting_record
	
	group_meeting_now 只會在會議開始時才記錄, 結束時會刪掉
	*/
	
	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("../login_check.php");			
	
	$meeting_time = date("Y-m-d H:i:s");
	
	if (isset($_POST["meeting_id"]))
		$meeting_id = $_POST["meeting_id"];
	else if (isset($_GET["meeting_id"]))
		$meeting_id = $_GET["meeting_id"];
	
	if ( isset($_SESSION['id']) )
		$id = $_SESSION['id'];
	else
		$id = 'a@';
	
	// 如果id 在join_meeting_member 才可以開始會議
	$sql = "select * from join_meeting_member where meeting_id = '".$meeting_id."' and member_id = '".$id."'";
	$result = $conn->query($sql);
	$join_meeting = $result->num_rows;
	if ($join_meeting != 1)
		header("Location: ../web/employee_web/employee_center.php" );
	
	
	
	$sql = "select * from meeting_scheduler where meeting_id = '".$meeting_id."'";
	$result = $conn->query($sql);
	$row = $result->fetch_array();
	$group_id = $row['group_id'];				//取得群組id
	$moderator_id = $row['moderator_id'];
	
	if ( $moderator_id != $id )
		$action = 'none';
	else
		$action = 'per';
	
	$sql = "select meeting_id from group_meeting_now where member_id = '".$id."' and meeting_id != '".$meeting_id."'";
	$result = $conn->query($sql);	
	$num_rows = $result->num_rows;				//要知道目前這個人是否已開始了別的會議
	
	if ($num_rows == 0)
	{
		$sql = "select meeting_id from group_meeting_now where meeting_id = '".$meeting_id."'";
		$result = $conn->query($sql);	
		$num_rows = $result->num_rows;			//要知道目前有沒有人開始了會議
		if ($num_rows > 0)						//已有人開始了會議
		{
			$server_id = $row['server_id'];
			$sql = "select meeting_id from group_meeting_now where meeting_id = '".$meeting_id."' and member_id = '".$id."'";
			$result = $conn->query($sql);
			$num_rows = $result->num_rows;		//要知道自己是否已開始了會議

			if ($num_rows == 0 )				//否
			{
				$sql = "INSERT INTO group_meeting_now value('".$meeting_id."', '".$id."', '".$server_id."', 'none', '".$action."')";
				$result = $conn->query($sql);
			}
		}
		else	//還沒開始會議
		{
			$sql = "select * from server_running_now where meeting_id = 0";
			$result = $conn->query($sql);
			$row = $result->fetch_array();
			$server_id = $row['server_id'];
			
			$sql = "update server_running_now set meeting_id ='".$meeting_id."', group_id = '".$group_id."' where server_id = '".$server_id."'" ;
			$conn->query($sql);
			$sql = "INSERT INTO group_meeting_now value('".$meeting_id."', '".$id."', '".$server_id."', 'none', '".$action."')";
			$conn->query($sql);
			echo $sql;
			$sql = "INSERT INTO meeting_record value('".$meeting_id."', '".$group_id."', '".$meeting_time."')";
			$conn->query($sql);
			echo $sql;
		}

		$sql = "update join_meeting_member set joined = 1 where meeting_id = '".$meeting_id."' and member_id = '".$id."'";
		$conn->query($sql);	
		
	if ( $_SESSION['platform'] == "device" )
		echo "device/employee/meeting/meeting_running.php";
	else if ( $_SESSION['platform'] == "web" )
		header("Location: ../web/employee_web/meeting/meeting_running/em_meeting_running.php");
	}
	else
	{
		if ( $_SESSION['platform'] == "device" )
			echo "device/employee/employee_center.php";
		else if ( $_SESSION['platform'] == "web" )
			header("Location: ../web/employee_web/employee_center.php");
	}
	

	
?>