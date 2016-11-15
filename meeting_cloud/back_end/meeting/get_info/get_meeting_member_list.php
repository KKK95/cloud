<?php
	//測試用網址
	//http://127.0.0.1:8080/meeting_cloud/back_end/meeting/get_info/get_meeting_member_list.php?meeting_id=4
	
	header("Content-Type: text/html; charset=UTF-8");
	
	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
//	require_once("../../../login_check.php");	
	
	if (isset($_SESSION["id"]))
		$id = $_SESSION["id"];
	else
		$id = "a@";
	
	$meeting_running = 0;
	$num_of_meeting_member = 0;
	
	$sql = "select * from group_meeting_now where member_id = '".$id."'";
	$result=$conn->query($sql);
													
	$num_rows = $result->num_rows;					//看是否在會議中
	if (isset($_GET['meeting_id']))							//否
	{	$meeting_id = $_GET['meeting_id'];	}
	if ($num_rows!=0)										//是
	{
		if (isset($_GET['meeting_id']))
		{
			$row=$result->fetch_array();					//要知道他查詢的列表是否和他正在開會相關
			if ($meeting_id == $row['meeting_id'])
				$meeting_running = 1;
		}
		else 	
		{
			$row=$result->fetch_array();
			$meeting_id = $row['meeting_id'];
		}	
	}


	$sql = "select * from meeting_scheduler where meeting_id = '".$meeting_id."'";
	$result=$conn->query($sql);
	$row=$result->fetch_array();
	$group_id = $row['group_id'];
	
	$sql = "select scheduler.*, member.name
			from meeting_scheduler as scheduler, member
			where scheduler.meeting_id = '".$meeting_id."' and scheduler.moderator_id = member.id";
	
	$result = $conn->query($sql);
	$row = $result->fetch_array();
	$meeting_date = date("Y-m-d", strtotime($row['time']));
	$meeting_time = date("H:i", strtotime($row['time']));
	$moderator = $row['name'];
	
	//以center 的角度來看的相對路徑
	$json = array
	(
		"contents" => array(),
	);
	
	$sql = "select j_m_m.*, m.name, m.mail, m.access from join_meeting_member as j_m_m, member as m 
			where j_m_m.meeting_id = '".$_GET['meeting_id']."' and j_m_m.member_id = m.id";
	$result = $conn->query($sql);
	$num_rows = $result->num_rows;	
	
	if ($num_rows==0)
	{	$json['contents']['obj_meeting_member_list'] = "none";	}
	else
	{
		$json['contents']['obj_meeting_member_list'] = array();
		$json['contents']['obj_meeting_member_list']['name'] = array();
		$json['contents']['obj_meeting_member_list']['mail'] = array();
		$json['contents']['obj_meeting_member_list']['access'] = array();
		$json['contents']['obj_meeting_member_list']['member_id'] = array();
		$json['contents']['obj_meeting_member_list']['online'] = array();
	
		for($i=1;$i<=$num_rows;$i++) 
		{
			$row=$result->fetch_array();
			array_push ($json['contents']['obj_meeting_member_list']['name'], $row['name']);
			array_push ($json['contents']['obj_meeting_member_list']['member_id'], $row['member_id']);
			array_push ($json['contents']['obj_meeting_member_list']['mail'], $row['mail']);
			array_push ($json['contents']['obj_meeting_member_list']['access'], $row['access']);
			
			if ($meeting_running == 0)
				array_push ($json['contents']['obj_meeting_member_list']['online'], 0);
			if ($meeting_running == 1)															//如果要取得正在會議中 的與會者列表
			{
				$member_meeting_now_sql = "select * from group_meeting_now where member_id = '".$row['member_id']."'";
				$member_meeting_now_result = $conn->query($member_meeting_now_sql);
				$member_meeting_now_row = $member_meeting_now_result->fetch_array();
				
				if (isset($member_meeting_now_row['meeting_id']))								
				{
					array_push ($json['contents']['obj_meeting_member_list']['online'], 1);
					$num_of_meeting_member = $num_of_meeting_member + 1;
				}
				else
					array_push ($json['contents']['obj_meeting_member_list']['online'], 0);
			}
		}
		$json['contents']['now_meeting_member'] = $num_of_meeting_member;
	}
			
	echo json_encode( $json );

?>