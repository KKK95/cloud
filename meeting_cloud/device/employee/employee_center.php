<?php
/*
	127.0.0.1:8080/meeting_cloud/device/employee/employee_center.php
*/


	header("Content-Type: text/html; charset=UTF-8");
			
	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("../../login_check.php");
	
	if (isset($_SESSION["id"]))
		$id = $_SESSION["id"];
	else
		$id = "a@";
	
	
/*	
	$sql = "select scheduler.*, member.name
			from meeting_scheduler as scheduler, member
			where scheduler.group_id in 
			(select gl.group_id
				FROM group_leader as gl, group_member as gm
				where gm.member_id = '".$_SESSION["id"]."' or gl.member_id = '".$_SESSION["id"]."'
                group by gl.group_id
			)
			and member.id = scheduler.moderator_id
            order by scheduler.time desc";
			
	$result = $conn->query($sql);
*/	
	$json = array
	(
		"contents" => array(),
		"link" => array
		(
			"meeting_info" => "./join_meeting.php?meeting=",
			"get_meeting_now_list" => "back_end/meeting/get_info/get_meeting_running_list.php",
			"get_meeting_record_list" => "back_end/meeting/get_info/get_meeting_record_list.php",
			"get_meeting_list" => "back_end/meeting/get_info/get_meeting_list.php",
		/*
			"新增會議群組" => "./group/build_group_form.php",
			"查看會議群組列表" => "./group/group_list.php",
			"我的雲端空間" => "my_upload_space.php?basic_path=user_upload_space/".$_SESSION["id"],
			"會議群組雲端空間" => "group/group_upload_space_center.php?basic_path=group_upload_space",
			"登出系統" => "../../logout.php"
		*/
			
		),
		"form" => array
		(
			"build_meeting" => array 
			(
				"func" => "build_meeting",
				"addr" => "back_end/meeting/set_info/set_meeting_scheduler.php",
				"form" => array
				(
					"meeting_title" => "none",
					"meeting_time" => "none",
					"moderator_id" => "none",
				)
			)
		)
	);
	
	
	//==========================================================================================================================//
/*	
	$sql = "select member.name, scheduler.meeting_id, scheduler.time, scheduler.title
					from meeting_scheduler as scheduler, member, join_meeting_member as j_m_m, group_meeting_now as g_m_n
					where j_m_m.member_id = '".$id."' and j_m_m.meeting_id = g_m_n.meeting_id 
					and j_m_m.meeting_id = scheduler.meeting_id 
					and member.id = scheduler.moderator_id
					group by scheduler.meeting_id";

		$result=$conn->query($sql);
		$num_rows = $result->num_rows;					//看是否在會議中
		

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
			}
		}
		else
		{
			$json ['contents']['obj_meeting_now_list'] = "none";
		}
	
	
	$sql = "select scheduler.*, member.name
				from meeting_scheduler as scheduler, member, join_meeting_member as j_m_m
				where scheduler.meeting_id = j_m_m.meeting_id and j_m_m.member_id = '".$id."'
				and member.id = scheduler.moderator_id and scheduler.over = 1
				order by scheduler.time desc";

	
	$result=$conn->query($sql);
	$num_rows = $result->num_rows;
	
	if (isset($result))
	{
		
		$json ['contents']['obj_meeting_record_list'] = array();
		$json ['contents']['obj_meeting_record_list']['topic'] = array();
		$json ['contents']['obj_meeting_record_list']['meeting_day'] = array();
		$json ['contents']['obj_meeting_record_list']['meeting_time'] = array();
		$json ['contents']['obj_meeting_record_list']['moderator'] = array();
		$json ['contents']['obj_meeting_record_list']['meeting_id'] = array();
		for($i = 1 ; $i <= $num_rows ; $i++)
		{
			$row=$result->fetch_array();
			$meeting_date = date("Y-m-d", strtotime($row['time']));
			$meeting_time = date("H:i", strtotime($row['time']));
			array_push( $json ['contents']['obj_meeting_record_list']['meeting_id'], $row['meeting_id']);			//這裏是employee_center.php 的相對位置
			array_push( $json ['contents']['obj_meeting_record_list']['topic'], $row['title']);
			array_push( $json ['contents']['obj_meeting_record_list']['meeting_day'], $meeting_date);
			array_push( $json ['contents']['obj_meeting_record_list']['meeting_time'], $meeting_time);
			array_push( $json ['contents']['obj_meeting_record_list']['moderator'], $row['name']);
		}
	}
	else
	{
		$json ['contents']['obj_meeting_now'] = "none";
	}
	
	$sql = "select scheduler.*, member.name
				from meeting_scheduler as scheduler, member, join_meeting_member as j_m_m
				where scheduler.meeting_id = j_m_m.meeting_id and j_m_m.member_id = '".$id."'
				and member.id = scheduler.moderator_id and scheduler.over = 0 
				order by scheduler.time";
				
	$result = $conn->query($sql);
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
	}
*/	
	echo json_encode( $json );
?>