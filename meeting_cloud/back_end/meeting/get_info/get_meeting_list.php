<?php

	
	//127.0.0.1:8080/meeting_cloud/back_end/meeting/get_info/get_meeting_list.php?meeting_id=4
	header("Content-Type: text/html; charset=UTF-8");
	
	if(!isset($_SESSION))
	{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../../connMysql.php");			//引用connMysql.php 來連接資料庫

//	require_once("../../../login_check.php");	
	
	if (isset($_SESSION["id"]))
		$id = $_SESSION["id"];
	else
		$id = "a@";
	
	$time = date("Y-m-d H:i:s");
	
	if (isset($_GET['group_id']))
	{
	/*
		$sql = "select scheduler.*, member.name
				from meeting_scheduler as scheduler, member, join_meeting_member as j_m_m, group_meeting_now as g_m_n
				where scheduler.meeting_id = j_m_m.meeting_id and j_m_m.member_id = '".$id."'
				and member.id = scheduler.moderator_id and scheduler.over = 0 and scheduler.group_id = '".$_GET['group_id']."'
				and g_m_n.meeting_id != scheduler.meeting_id 
				order by scheduler.time";
	*/			
		$sql = "select scheduler.*, member.name
				from meeting_scheduler as scheduler, member, join_meeting_member as j_m_m
				where scheduler.meeting_id not in 
						(select g_m_n.meeting_id from group_meeting_now as g_m_n where 1)
				and j_m_m.member_id = '".$id."' and scheduler.group_id = '".$_GET['group_id']."' 
				and scheduler.meeting_id = j_m_m.meeting_id and scheduler.over = 0 
				and member.id = scheduler.moderator_id 
				order by scheduler.time";
	}
	else
	{
/*		$sql = "select scheduler.*, member.name
				from meeting_scheduler as scheduler, member, join_meeting_member as j_m_m, group_meeting_now as g_m_n
				where scheduler.meeting_id = j_m_m.meeting_id and j_m_m.member_id = '".$id."'
				and member.id = scheduler.moderator_id and scheduler.over = 0 and g_m_n.meeting_id != scheduler.meeting_id 
				order by scheduler.time";
*/				
		$sql = "select scheduler.*, member.name
				from meeting_scheduler as scheduler, member, join_meeting_member as j_m_m
				where scheduler.meeting_id not in 
						(select g_m_n.meeting_id from group_meeting_now as g_m_n where 1)
				and j_m_m.member_id = '".$id."' and scheduler.meeting_id = j_m_m.meeting_id and scheduler.over = 0 
				and member.id = scheduler.moderator_id
				order by scheduler.time";
		
	}
	
	$json = array
	(	
		"contents" => array(),
		"link" => array(),
	);
	
	$result=$conn->query($sql);
	$num_rows = $result->num_rows;
	
	if (isset($result))
	{
		
		$json ['contents']['obj_meeting_list'] = array();
		$json ['contents']['obj_meeting_list']['topic'] = array();
		$json ['contents']['obj_meeting_list']['meeting_day'] = array();
		$json ['contents']['obj_meeting_list']['meeting_time'] = array();
		$json ['contents']['obj_meeting_list']['moderator'] = array();
		$json ['contents']['obj_meeting_list']['meeting_id'] = array();
		for($i = 1 ; $i <= $num_rows ; $i++)
		{
			$row=$result->fetch_array();
			$meeting_date = date("Y-m-d", strtotime($row['time']));
			$meeting_time = date("H:i", strtotime($row['time']));
			array_push( $json ['contents']['obj_meeting_list']['meeting_id'], $row['meeting_id']);			//這裏是employee_center.php 的相對位置
			array_push( $json ['contents']['obj_meeting_list']['topic'], $row['title']);
			array_push( $json ['contents']['obj_meeting_list']['meeting_day'], $meeting_date);
			array_push( $json ['contents']['obj_meeting_list']['meeting_time'], $meeting_time);
			array_push( $json ['contents']['obj_meeting_list']['moderator'], $row['name']);
		}
	}
	else
	{
		$json ['contents']['obj_meeting_now'] = "none";
		$json ['link'] = "none";
	}
	
	
	echo json_encode($json);

?>