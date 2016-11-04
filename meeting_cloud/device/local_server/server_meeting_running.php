<?php

	header("Content-Type: text/html; charset=UTF-8");
			
	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("end_back/login_check.php");
	
	
	//	查server 正在處理的群組id
	$sql = "select group_id from server_running_now as s_r_n where s_r_n.server_id = '".$_SESSION["id"]."'"; //找出server 處理的群組會議id 
	$result=$conn->query($sql);
	$row=$result->fetch_array();
	$group_id = $row['group_id'];
	

	
	if ($group_id != null)		
	{
		
		//	取得本次 record_id
	$sql = "select record.*, member.name from meeting_record as record where 
			group_id = '".$group_id."' order by send_time";
	
	$result=$conn->query($sql);
	$row=$result->fetch_array();
	$record_id = $row['record_id'];
	
		//	定好格式
	$json = array
	(
		"content" => array
		(
			
		),
		"link" => array
		(
			"會議結束" => "server_meeting_end.php"
		),
		"form" => array
		(
			"send_msg" => array
			(
				"func" => "發送訊息",
				"addr" => "back_end/group_meeting_record.php?record_id=".$_GET['group_id'],
				"form" => array
				(	"msg" => "none"	)
			),
		)
	);
	
//======================="顯示簽到成員"========================				//一邊開會一邊更新
	//	得出群組所有人數
		$sql = "select member_id  from group_leader as gl, group_member as gm where gl.group_id = '".$group_id."' and gl.group_id = gm.group_id";
		
		$result=$conn->query($sql);
		$total_number_of_group_member = $result->num_rows;
		
		
		//從group_meeting_now中, 取得出席人數, ip 和成員名稱
			$sql = "select gmn.ip, member.name from group_meeting_now as gmn, member where 		
					gmn.server_id = '".$_SESSION["id"]."' and gmn.member_id = member.id ";

		$result=$conn->query($sql);
		
		$attendance = $result->num_rows;		//已登錄會議主機人數
		
		$json['content']['obj_meeting_member_list'] = array();
		$json['content']['obj_meeting_member_list']['0'] = array();
		$json['content']['obj_meeting_member_list']['ip'] = array();
		
		$json['content']['obj_meeting_member_list']['已簽到人數'] = $attendance;
		for($i=1; $i<=$attendance; $i++)
		{
			$row=$result->fetch_array();
			array_push( $json ['content']['obj_meeting_member_list']['0'], $row['name'] );
			array_push( $json ['content']['obj_meeting_member_list']['ip'], $row['ip'] );
		}


//======================="顯示會議記錄"========================				//一邊開會一邊更新
		$json['content']['obj_meeting_record'] = array();
		$json['content']['obj_meeting_record']['0'] = array();
		$json['content']['obj_meeting_record']['time'] = array();
		$json['content']['obj_meeting_record']['msg'] = array();
		
			$get_msg = 20;
			$msg_volume = 0;
	
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
		
		//這邊要列出未登入的群組成員
	}
	else
	{
		$json = array
		(
			"content" => array
			(
				
			),
			"link" => array
			(
				"會議結束" => "server_meeting_end.php"
			),
			"state" => array
			(
				"state" => "待機中..."
			),
		);
		//state => 待機中...
	}

	
	echo json_encode( $json );
?>