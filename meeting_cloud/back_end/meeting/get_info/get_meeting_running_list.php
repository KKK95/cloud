<?php
	
		//127.0.0.1:8080/meeting_cloud/back_end/meeting/get_info/get_meeting_running_info.php
		header("Content-Type: text/html; charset=UTF-8");
		
		if(!isset($_SESSION))
		{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

		require_once("../../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	//	require_once("../../../login_check.php");	
		
		if (isset($_SESSION["id"]))
			$id = $_SESSION["id"];
		else
			$id = "a@";
		
		if (isset($_GET['group_id']))
		{
			$sql = "select member.name, scheduler.meeting_id, scheduler.time, scheduler.title
					from meeting_scheduler as scheduler, member, join_meeting_member as j_m_m, group_meeting_now as g_m_n
					where j_m_m.member_id = '".$id."' and j_m_m.meeting_id = g_m_n.meeting_id 
					and j_m_m.meeting_id = scheduler.meeting_id 
					and member.id = scheduler.moderator_id and scheduler.group_id = '".$_GET['group_id']."' 
					and scheduler.over != 1 
					group by scheduler.meeting_id";
		}
		else
		{
			$sql = "select member.name, scheduler.meeting_id, scheduler.time, scheduler.title
					from meeting_scheduler as scheduler, member, join_meeting_member as j_m_m, group_meeting_now as g_m_n
					where j_m_m.member_id = '".$id."' and j_m_m.meeting_id = g_m_n.meeting_id 
					and j_m_m.meeting_id = scheduler.meeting_id 
					and member.id = scheduler.moderator_id 
					and scheduler.over != 1 
					group by scheduler.meeting_id";
		}
		$result=$conn->query($sql);
		$num_rows = $result->num_rows;					//看是否在會議中
		
		$json = array
		(	
			"contents" => array(),
			"link" => array(),
		);
		if (isset($result))
		{
			
			$json ['contents']['obj_meeting_now_list'] = array();
			$json ['contents']['obj_meeting_now_list']['topic'] = array();
			$json ['contents']['obj_meeting_now_list']['meeting_day'] = array();
			$json ['contents']['obj_meeting_now_list']['meeting_time'] = array();
			$json ['contents']['obj_meeting_now_list']['moderator'] = array();
			$json ['contents']['obj_meeting_now_list']['meeting_id'] = array();
			for($i = 1 ; $i <= $num_rows ; $i++)
			{
				$row=$result->fetch_array();
				$meeting_date = date("Y-m-d", strtotime($row['time']));
				$meeting_time = date("H:i", strtotime($row['time']));
				array_push( $json ['contents']['obj_meeting_now_list']['meeting_id'], $row['meeting_id']);			//這裏是employee_center.php 的相對位置
				array_push( $json ['contents']['obj_meeting_now_list']['topic'], $row['title']);
				array_push( $json ['contents']['obj_meeting_now_list']['meeting_day'], $meeting_date);
				array_push( $json ['contents']['obj_meeting_now_list']['meeting_time'], $meeting_time);
				array_push( $json ['contents']['obj_meeting_now_list']['moderator'], $row['name']);
				$json ['link'][$row['meeting_id']] = "./meeting/em_meeting_info.php?meeting_id=".$row['meeting_id'];
			}
		}
		else
		{
			$json ['contents']['obj_meeting_now_list'] = "none";
			$json ['link'] = "none";
		}


	echo json_encode($json);
?>