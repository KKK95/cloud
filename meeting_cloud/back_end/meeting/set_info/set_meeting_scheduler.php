<?php

	header("Content-Type: text/html; charset=UTF-8");
	
	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("../../../login_check.php");			
	
	$group_id = $_POST["group_id"];
	$today = date("Y-m-d H:i:s");
	$meeting_title = $_POST['meeting_title'];
	$moderator_id = $_POST['moderator_id'];
	$meeting_time = $_POST['year']."-".str_pad($_POST['month'],2,'0',STR_PAD_LEFT)."-".str_pad($_POST['day'],2,'0',STR_PAD_LEFT)." ".str_pad($_POST['hour'],2,'0',STR_PAD_LEFT).":00:00";
	
	echo $meeting_time;
	if ($moderator_id == "" || $moderator_id == "none")
		$moderator_id = $_SESSION['id'];
	
	if ($group_id != "")
	{
		if (((strtotime($meeting_time) - strtotime($today))/ (60*60)) > 0)				//新增的會議必定不能在過去
		{
			$sql = "INSERT INTO meeting_scheduler value('', '".$group_id."', '".$meeting_title."', '".$moderator_id."', '".$meeting_time."', 0 )";
			$result = $conn->query($sql);
		}
	}
	
	$sql = "select * from meeting_scheduler where group_id = '".$group_id."' and time = '".$meeting_time."'";
	$result = $conn->query($sql);
	$row=$result->fetch_array();
	
	$file = "../../upload_space/group_upload_space/".$group_id."/".$row['meeting_id'];
	mkdir($file);
	$meeting_id = $row['meeting_id'];
	
	$sql = "select * from group_member where group_id = '".$group_id."'";		//取得group 內所有人
	$result = $conn->query($sql);
	$num_rows = $result->num_rows;
	
	for ( $i = 1; $i <= $num_rows; $i++)
	{
		
		$row=$result->fetch_array();
		$invite_member_meeting_sql = "INSERT INTO join_meeting_member value('".$meeting_id."', '".$row['member_id']."')";
		if ( $conn->query($invite_member_meeting_sql) )
			echo "invite success";
	}
	
	$platform = $_SESSION["platform"];
	if ($platform == "device")
		header("Location: ../../../device/employee/employee_center.php");
	else if ($platform == "web")
		header("Location: ../../../web/employee_web/group/group.php?group_id=".$group_id );
	else
		header("Location: ../../../web/employee/employee_center.php");
		
	
?>