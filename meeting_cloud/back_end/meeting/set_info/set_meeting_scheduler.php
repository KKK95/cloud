<?php

	header("Content-Type: text/html; charset=UTF-8");
	
	if(!isset($_SESSION))
	{  		session_start();	}			//�� session �禡, �ݥΤ�O�_�w�g�n���F

	require_once("../../../connMysql.php");			//�ޥ�connMysql.php �ӳs����Ʈw
	
	require_once("../../../login_check.php");			
	
	
	$today = date("Y-m-d H:i:s");
	$meeting_title = $_POST['meeting_title'];
	$moderator_id = $_POST['moderator_id'];
	if (isset($_POST['meeting_time']))
		$meeting_time = $_POST['meeting_time'];
	else
		$meeting_time = $_POST['year']."-".str_pad($_POST['month'],2,'0',STR_PAD_LEFT)."-".str_pad($_POST['day'],2,'0',STR_PAD_LEFT)." ".str_pad($_POST['hour'],2,'0',STR_PAD_LEFT).":00:00";
	
	if ( isset($_POST["group_id"]) )
		$group_id = $_POST["group_id"];
	else 
		$group_id = 0;
	

	if ($moderator_id == "" || $moderator_id == "none")
		$moderator_id = $_SESSION['id'];
	
	$sql = "INSERT INTO meeting_scheduler value('', '".$group_id."', '".$meeting_title."', '".$moderator_id."', '".$meeting_time."', 0 )";
	
	if ( ((strtotime($meeting_time) - strtotime($today))/(60*60)) > 0 )				//�s�W���|ĳ���w����b�L�h
	{
		
		if ($conn->query($sql))
		{
			$sql = "select * from meeting_scheduler where group_id = '".$group_id."' and time = '".$meeting_time."'";
			$result = $conn->query($sql);
			$row=$result->fetch_array();
			$meeting_id = $row['meeting_id'];
			
			$file = "../../upload_space/group_upload_space/".$group_id."/".$row['meeting_id'];
			mkdir($file);
			
			
			$sql = "select * from group_member where group_id = '".$group_id."'";		//���ogroup ���Ҧ��H
			$result = $conn->query($sql);
			$num_rows = $result->num_rows;
			
			for ( $i = 1; $i <= $num_rows; $i++)
			{
				
				$row=$result->fetch_array();
				$invite_member_meeting_sql = "INSERT INTO join_meeting_member value('".$meeting_id."', '".$row['member_id']."')";
				if ( $conn->query($invite_member_meeting_sql) )
					echo "invite success";
			}
			echo $meeting_id;
		}
		else
		{
			echo $sql;
			echo "failed";
		}	
	}
	else
	{
		echo $sql;
		echo "failed";
	}	
//	echo "device/employee/employee_center.php";
	
	$platform = $_SESSION["platform"];
	if ( $platform == "web" )
		header("Location: ../../../web/employee_web/group/group.php?group_id=".$group_id );
	else if ( $platform == "device" )
		echo "device/employee/meeting/meeting_info.php?meeting_id=".$meeting_id;

?>