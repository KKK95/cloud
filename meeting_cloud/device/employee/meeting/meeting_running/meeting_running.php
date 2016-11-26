<?php
	
	//http://127.0.0.1:8080/meeting_cloud/device/employee/meeting/meeting_running/meeting_running.php?meeting_id=27
	
	header("Content-Type: text/html; charset=UTF-8");
	
	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
//	require_once("../../../../login_check.php");	
	
	if ( isset($_SESSION['id']) )
		$id = $_SESSION['id'];
	else
		$id = 'a@';
	
	if (isset($_POST["meeting_id"]))
		$meeting_id = $_POST["meeting_id"];
	else if (isset($_GET["meeting_id"]))
		$meeting_id = $_GET["meeting_id"];
	
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
	$minutes_taker_id = $row['minutes_taker_id'];
	//要改囉~
	$json = array
	(
		"link" => array
		(		
			"get_topic_list" => "back_end/meeting/get_info/get_meeting_info.php?meeting_id=".$meeting_id,	//取得會議議題
			//以上優先

			"get_doc_list" => "back_end/meeting/get_info/get_meeting_doc.php?meeting_id=".$meeting_id,		//取得文件列表
			"get_meeting_member_list" => "back_end/meeting/get_info/get_meeting_member_list.php",			//取得與會者名單
			"get_persenter_id" => = "back_end/meeting/get_info/get_presenter.php";							//取得講者id
			"quit" => "back_end/meeting_end.php",
			"update_info" => "back_end/meeting/meeting_update_info.php",									//看有沒有資訊要更新
		),

		"form" => array					//form 是表單, 是讓你填資料然後送出去
		(
			"conn_to_local_server" => array
			(
				"func" => "conn_to_local_server",
				"addr" => "back_end/meeting/conn_to_local_server.php",
				"form" => array
				(
					"local_server_id" => "none",
					"member_ip" => "none",
				),
			),
			
			"get_topic_doc_list" => array																//取得會議議題中的文件列表
			(
				"func" => "get_doc_list",
				"addr" => "back_end/meeting/get_info/get_meeting_doc.php?meeting_id=".$meeting_id,
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
			
			"get_question" => array											//取得投票議題的資訊
			(
				"func" => "get_meeting_question",
				"addr" => "back_end/meeting/get_info/get_meeting_question.php",
				"form" => array
				(
					"topic_id" => "none",
				),
			),
			
			"get_answer" => array													//取得會議議題中的回答
			(
				"func" => "get_answer_list",
				"addr" => "back_end/meeting/get_info/get_meeting_question.php?meeting_id=".$meeting_id,
				"form" => array
				(
					"topic_id" => "none",											//會議議題 id
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
			
			
			
		//送出問題後能從這裏看到發起的問題 "meeting_question"=>"get_meeting_question.php"
			
			"vote" => array															//投票
			(
				"func" => "vote",
				"addr" => "back_end/meeting/set_info/set_meeting_vote.php",
				"form" => array
				(
					"topic_id" => "none",											//議題id
					"issue_id" => "none",											//投票主題id
					"option_id" => "none",											//選項id
				),
			),
			
			
			"meeting_ask" => array													//為某一個會議議題提出問題
			(
				"func" => "meeting_ask_question",
				"addr" => "back_end/meeting/set_info/set_meeting_question.php",
				"form" => array
				(
					"question" => "none",											//問題
					"topic_id" => "none",											//議題 id
				),
			),
			
			"meeting_motion" => array												//動議
			(
				"func" => "add_meeting_topic",
				"addr" => "back_end/meeting/set_info/set_meeting_topic.php",
				"form" => array
				(
					"topic" => "none",												//議題
				),
			),
		),

	);
	
	
	if ($moderator_id == $id || $minutes_taker_id == $id)
	{
		$json['form']['set_vote'] = array();
		$json['form']['set_vote']['func'] = "set_vote";										//在某個議題發起投票
		$json['form']['set_vote']['addr'] = "back_end/meeting/set_info/set_meeting_initiate_vote.php?meeting_id=".$meeting_id;
		$json['form']['set_vote']['form'] = array();
		$json['form']['set_vote']['form']['issue'] = "none";								//投票主題
		$json['form']['set_vote']['form']['topic_id'] = "none";								//議題id
		
		
		
		$json['form']['set_vote_option'] = array();											//提出投票選項
		$json['form']['set_vote_option']['func'] = "set_vote_option";						
		$json['form']['set_vote_option']['addr'] = "back_end/meeting/set_info/set_meeting_voting_option.php?meeting_id=".$meeting_id;
		$json['form']['set_vote_option']['form'] = array();
		$json['form']['set_vote_option']['form']['option'] = "none";						//選項
		$json['form']['set_vote_option']['form']['topic_id'] = "none";						//投票議題的id，得知在哪個議題發起投票
		$json['form']['set_vote_option']['form']['issue_id'] = "none";						//投票問題的id
		
		
		
		$json['form']['set_answer'] = array();												//回答
		$json['form']['set_answer']['func'] = "answer";										
		$json['form']['set_answer']['addr'] = "back_end/meeting/set_info/set_meeting_answer.php?meeting_id=".$meeting_id;
		$json['form']['set_answer']['form'] = array();
		$json['form']['set_answer']['form']['topic_id'] = "none";							//投票議題的id，得知在哪個議題發起投票
		$json['form']['set_answer']['form']['question_id'] = "none";						//問題的id
		$json['form']['set_answer']['form']['answer'] = "none";								//回答
		
		
		
		$json['form']['set_topic_content'] = array();										//在某個議題設定內容
		$json['form']['set_topic_content']['func'] = "set_content";									
		$json['form']['set_topic_content']['addr'] = "back_end/meeting/set_info/set_meeting_content.php?meeting_id=".$meeting_id;
		$json['form']['set_topic_content']['form'] = array();
		$json['form']['set_topic_content']['form']['content'] = "none";								//內容
		$json['form']['set_topic_content']['form']['topic_id'] = "none";							//議題id
		
		
		
		$json['form']['set_topic_meeting_minutes'] = array();								//在某個議題設定內容
		$json['form']['set_topic_meeting_minutes']['func'] = "set_meeting_minutes";			
		$json['form']['set_topic_meeting_minutes']['addr'] = "back_end/meeting/set_info/set_meeting_minutes.php?meeting_id=".$meeting_id;
		$json['form']['set_topic_meeting_minutes']['form'] = array();
		$json['form']['set_topic_meeting_minutes']['form']['meeting_minutes'] = "none";		//內容
		$json['form']['set_topic_meeting_minutes']['form']['topic_id'] = "none";			//議題id
		
		
		
		$json['form']['set_presenter'] = array();								//在某個議題設定內容
		$json['form']['set_presenter']['func'] = "set_presenter";			
		$json['form']['set_presenter']['addr'] = "back_end/meeting/set_info/set_presenter.php";
		$json['form']['set_presenter']['form'] = array();
		$json['form']['set_presenter']['form']['presenter_id'] = "none";			//議題id
	}
	
	echo json_encode( $json );
?>