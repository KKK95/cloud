<?php

	header("Content-Type: text/html; charset=UTF-8");
			
	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("back_end/login_check.php");
	
	//====================================從server_running_now 中找出ip, group_id=======================================
	$sql = "select s_r_n.ip, s_r_n.group_id 
			from server_running_now as s_r_n, group_meeting_now as g_m_n 
			where 
			s_r_n.server_id = g_m_n.server_id and g_m_n.member_id = '".$_SESSION["id"]."'";

	$result = $conn->query($sql);
	$row=$result->fetch_array();
	$server_ip = $row['ip'];
	$group_id = $row['group_id'];
	//==================================================================================================================
	
	//================================================找出meeting_id=====================================================
	
			//	取得本次 meeting_id
	$sql = "select meeting_id from group_meeting_now where 
			member_id = '".$_SESSION["id"]."'";
	
	$result=$conn->query($sql);
	$row=$result->fetch_array();
	$meeting_id = $row['meeting_id'];
	
	
	//==================================================================================================================
	//json 裏面有server ip, 顯示會議記錄, 送出會議對話, 退出會議
	$em_meeting_end = array
	(
		"contents" => array
		(
			"server_ip" => $server_ip
		),
		"link" => array
		(
			"meeting_end" => "back_end/em_meeting_end.php"
		),
		"form" => array
		(
			"send_msg" => array
			(
				"func" => "發送訊息",
				"addr" => "back_end/group_meeting_record.php?meeting_id=".$meeting_id,
				"form" => array
				(	"msg" => "none"	)
			),
		),
		"state" =>array
		(
			"command" => "connect to local server"
		)
	);
	
	//==================================================================================================================
	
	//顯示會議記錄
		$json['content']['obj_meeting_record'] = array();
		$json['content']['obj_meeting_record']['0'] = array();
		$json['content']['obj_meeting_record']['time'] = array();
		$json['content']['obj_meeting_record']['msg'] = array();
		
			$get_msg = 20;				//取出幾句談話內容
			$msg_volume = 0;			//從最新的記錄開始
			
			$sql = "select record.*, member.name from group_meeting_record as record, member where 
			record_id = '".$record_id."' and record.member_id = member.id
			order by send_time
			Limit ".$msg_volume.",".$get_msg;
		
		$result=$conn->query($sql);
		$num_rows = $result->num_rows;
		
		for($i=1; $i<=$num_rows; $i++)
		{
			$row=$result->fetch_array();
			array_push( $json ['content']['obj_meeting_record']['0'], $row['name'] );
			array_push( $json ['content']['obj_meeting_record']['time'], $row['send_time'] );
			array_push( $json ['content']['obj_meeting_record']['msg'], $row['msg'] );
		}
		
		echo json_encode( $json );
?>