<?php 
	if(!isset($_SESSION))
	{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("back_end/login_check.php");
	
	$get_msg = 20;
	
	$sql = "select chat_room.*, member.name from group_chat_room as chat_room, member where 
			group_id = '".$_GET['group_id']."' and chat_room.member_id = member.id
			order by send_time
			Limit ".$_GET['msg_volume'].",".$get_msg;
	
	/*
	select chat_room.*, member.name from group_chat_room as chat_room, member where 
			group_id = '2' and chat_room.member_id = member.id
			order by send_time
			Limit 0,20
			
	http://localhost:8080/meeting_cloud/device/group_chat_room.php?group_id=2&msg_volume=0
	*/
			
	$result=$conn->query($sql);
	$num_rows = $result->num_rows;	
	
	$path = 0; 
	$get_history_msg = 0;
	if ( $num_rows == ($_GET['msg_volume']+$get_msg) )		//最多取多少訊息
	{
		$get_history_msg = $_GET['msg_volume']+$get_msg;
	}
	else
	{	$get_history_msg = $_GET['msg_volume'];	}


	$json = array
	(
		"content" => array
		(
			
		),
		"link" => array
		(
			"查看歷史訊息" => "group_chat_room.php?group_id=".$_GET['group_id']."&msg_volume=".$get_history_msg,
			"上傳檔案" => "back_end/upload.php?upload_path=".$path
		),
		"form" => array
		(
			"send_msg" => array
			(
				"func" => "發送訊息",
				"addr" => "back_end/send_chat_room_msg.php?group_id=".$_GET['group_id'],
				"form" => array
				(	"msg" => "none"	)
			),
		)
	);
	
	if ($num_rows==0)
	{	$state = "";	}	
	else
	{	
		$json['content']['obj_chat_room'] = array();
		$json['content']['obj_chat_room']['0'] = array();
		$json['content']['obj_chat_room']['time'] = array();
		$json['content']['obj_chat_room']['msg'] = array();
		
//		$json['content']['obj_chat_room']['func'] = "聊天室";
		for($i=1; $i<=$num_rows; $i++)
		{
			$row=$result->fetch_array();
			array_push( $json ['content']['obj_chat_room']['0'], $row['name'] );
			array_push( $json ['content']['obj_chat_room']['time'], $row['send_time'] );
			array_push( $json ['content']['obj_chat_room']['msg'], $row['msg'] );
		}
	}
	
	echo json_encode( $json );

?>