<?php
	//測試用網址
	//http://127.0.0.1:8080/meeting_cloud/device/employee/meeting/meeting_info.php?meeting_id=4
	
	header("Content-Type: text/html; charset=UTF-8");
	
	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
//	require_once("../../../login_check.php");	
	
	if ( isset($_SESSION['id']) )
		$id = $_SESSION['id'];
	else
		$id = 'a@';
	
	$sql = "select scheduler.*, member.name
			from meeting_scheduler as scheduler, member
			where scheduler.meeting_id = '".$_GET['meeting_id']."' and scheduler.moderator_id = member.id";
	
	$result = $conn->query($sql);
	$row = $result->fetch_array();
	$meeting_id = $_GET['meeting_id'];
	$moderator = $row['name'];
	$meeting_date = date("Y-m-d", strtotime($row['time']));
	$meeting_time = date("H:i", strtotime($row['time']));
	$moderator_id = $row['moderator_id'];
	
	
	$sql = "select * from meeting_scheduler where meeting_id = '".$meeting_id."'";
	$result = $conn->query($sql);
	$row = $result->fetch_array();
	$meeting_title = $row['title'];
	$group_id = $row['group_id'];

	
	//以center 的角度來看的相對路徑
	$json = array
	(
		"contents" => array
		(
			"moderator" => $moderator,
			"date" => $meeting_date,
			"time" => $meeting_time,
			"meeting_id" => $_GET['meeting_id'],
		),
		"link" => array
		(
			"meeting_start" => "back_end/meeting_start.php?meeting_id=".$_GET['meeting_id'],							//會議開始
			"get_doc_list" => "back_end/meeting/get_info/get_meeting_doc.php?meeting_id=".$meeting_id,					//取得文件列表
			"get_topic_list" => "back_end/meeting/get_info/get_meeting_info.php?meeting_id=".$meeting_id,				//取得會議議題
			"get_member_list" => "back_end/meeting/get_info/get_meeting_member_list.php?meeting_id=".$meeting_id,		//取得與會者名單
		),
		"form" => array
		(

			"get_topic_doc_list" => array																//取得會議議題中的文件列表
			(
				"func" => "get_doc_list",
				"addr" => "back_end/meeting/get_info/get_meeting_doc.php?meeting_id=".$meeting_id,
				"form" => array
				(
					"topic_id" => "none",																//會議議題 id
				),
			),
			"get_question" => array																		//取得會議議題中的問題
			(
				"func" => "get_question_list",
				"addr" => "back_end/meeting/get_info/get_meeting_question.php?meeting_id=".$meeting_id,
				"form" => array
				(
					"topic_id" => "none",																//會議議題 id
				),
			),
			"get_answer" => array																		//取得會議議題中的回答
			(
				"func" => "get_answer_list",
				"addr" => "back_end/meeting/get_info/get_meeting_question.php?meeting_id=".$meeting_id,
				"form" => array
				(
					"topic_id" => "none",																//會議議題 id
				),
			),
			"get_voting_result" => array																		//取得議題中的投票結果
			(
				"func" => "get_voting_result",
				"addr" => "back_end/meeting/get_info/get_meeting_voting_result.php?meeting_id=".$meeting_id,
				"form" => array
				(
					"topic_id" => "none",																		//會議議題 id
					"issue_id" => "none",
				),
			),
			"get_topic_content" => array																		//取得議題中的內容
			(
				"func" => "get_topic_content",
				"addr" => "back_end/meeting/get_info/get_meeting_content.php?meeting_id=".$meeting_id,
				"form" => array
				(
					"topic_id" => "none",																		//會議議題 id
				),
			),

			
			
		),
		
	);
	
	if ($moderator_id == $id)
	{
		$json['form']['set_topic_content'] = array();
		$json['form']['set_topic_content']['func'] = "set_vote";									//在某個議題設定內容
		$json['form']['set_topic_content']['addr'] = "back_end/meeting/set_info/set_meeting_initiate_vote.php?meeting_id=".$meeting_id;
		$json['form']['set_topic_content']['form'] = array();
		$json['form']['set_topic_content']['form']['content'] = "none";								//內容
		$json['form']['set_topic_content']['form']['topic_id'] = "none";							//議題id
		
	}
	
			
	echo json_encode( $json );

?>