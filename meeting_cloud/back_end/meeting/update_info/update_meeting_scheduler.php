<?php

	header("Content-Type: text/html; charset=UTF-8");
	
	if(!isset($_SESSION))
	{  		session_start();	}			//�� session �禡, �ݥΤ�O�_�w�g�n���F

	require_once("../../../connMysql.php");			//�ޥ�connMysql.php �ӳs����Ʈw
	
	require_once("../../../login_check.php");			
	
	if (isset($_SESSION))
		$id = $_SESSION['id'];
	
	$meeting_id = $_POST['meeting_id'];
	
	$sql = "select * from meeting_scheduler where meeting_id = '".$meeting_id."'";
	$result = $conn->query($sql);
	$row = $result->fetch_array();
	$moderator_id = $row['moderator_id'];
	$minutes_taker_id = $row['minutes_taker_id'];
	
	if ( $id == $moderator_id || $id == $minutes_taker_id)
	{
		$today = date("Y-m-d H:i:s");
		
		// ���
		
		if ( isset($_POST['meeting_time']) )
			$meeting_time = $_POST['meeting_time'];
		else
			$meeting_time = $_POST['year']."-".str_pad($_POST['month'],2,'0',STR_PAD_LEFT)."-".str_pad($_POST['day'],2,'0',STR_PAD_LEFT)." ".str_pad($_POST['hour'],2,'0',STR_PAD_LEFT).":00:00";
		
		// �|ĳ�O���H id
		
		if ( isset($_POST['minutes_taker_id']) )
			$minutes_taker_id = $_POST['minutes_taker_id'];
		else $minutes_taker_id = $_SESSION['id'];
		
		// �D�u id
		
		if ( isset($_POST["moderator_id"]) )
			$moderator_id = $_POST["moderator_id"];
		else
			$moderator_id = $_SESSION['id'];
		// �|ĳ�s�� id
		
		if ( isset($_POST["group_id"]) )
			$group_id = $_POST["group_id"];
		else 
			$group_id = 0;
		
		// �|ĳ�D�D
		
		$meeting_title = $_POST['meeting_title'];
		
		
		
		if ($moderator_id == "" || $moderator_id == "none")
			$moderator_id = $_SESSION['id'];
		
		if ($minutes_taker_id == "" || $minutes_taker_id == "none")
			$minutes_taker_id = $_SESSION['id'];
		
		$update_sql = " update meeting_scheduler 
						set title = '".$meeting_title."',
						moderator_id = '".$moderator_id."', minutes_taker_id = '".$minutes_taker_id."',
						time = '".$meeting_time."' 
						where meeting_id = '".$meeting_id."'";
		
		if ( ((strtotime($meeting_time) - strtotime($today))/(60*60)) > 0 )				//�s�W���|ĳ���w����b�L�h
		{	$conn->query($update_sql);	}
	}
	//	echo "device/employee/employee_center.php";

		$platform = $_SESSION["platform"];
		if ( $platform == "web" )
			header("Location: ../../../web/employee_web/group/group.php?group_id=".$group_id );
		else if ( $platform == "device" )
			echo "device/employee/meeting/meeting_info.php?meeting_id=".$meeting_id;
		
?>