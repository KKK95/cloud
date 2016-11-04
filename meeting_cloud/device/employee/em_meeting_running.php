<?php
	
	header("Content-Type: text/html; charset=UTF-8");
	
	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("../../login_check.php?platform=device");	
	
	//要改囉~
	$json = array
	(
		"link"=>array
		(
			"get_meeting_voting_issue"=>"../../back_end/meeting/get_meeting_voting_issue.php",			//取得投票議題的資訊
			"get_meeting_topic"=>"../../back_end/meeting/get_meeting_topic.php",							//取得會議議題
			//以上優先

			"get_meeting_doc"=>"../../back_end/meeting/get_meeting_doc.php",						//取得會議文件
			"get_meeting_question"=>"../../back_end/meeting/meeting/get_meeting_question.php",	//看提問
			"get_meeting_member_list"=>"../../back_end/meeting/meeting/meeting_member_list.php",	//取得與會者名單
			"quit" => "../../back_end/meeting_end.php",
			"update_info"=>"../../back_end/meeting/meeting_update_info.php",					//看有沒有資訊要更新
		)	

		"form"=>array					//form 是表單, 是讓你填資料然後送出去
		(
			"vote_issue"=>array						//發起投票問題
			(
				"func"=>"vote_issue",				
				"addr"=>"../../back_end/meeting/meeting_initiate_vote.php",		
				"form"=>							//表單的欄位
				(
					"topic_id"="none"			//投票議題的id，得知在哪個議題裏面發起投票	能從"meeting_topic "=>"get_meeting_topic.php" 取得topic_id
					"issue"=>"none",				//投票的問題
				)
			)
		)		//送出問題後能從這裏看到發起的問題"meeting_voting_issue"=>"get_meeting_voting_issue.php"

		"add_voting_option"=>array					//提出投票選項
		(
			"func"=>"add_voting_option",			
			"addr"=>"../../back_end/meeting/meeting_add_voting_option.php",
			"form"=>array						//表單的欄位
			(																			//因為是先有vote_issue 才有options, 所以
				"topic_id"=>"none"			//投票議題的id，得知在哪個議題發起投票	能從"meeting_voting_issue"=>"get_meeting_voting_issue.php" 取得topic_id
				"issue_id"=>"none",			//投票的問題								能從"meeting_voting_issue"=>"get_meeting_voting_issue.php" 取得topic_id
				"option"=>"none",			//你寫的選項
			)
		)
		//以上優先


		"meeting_motion"=>array				//一份名為login 的表單
		(
			"func"=>"meeting_motion",			//動議
			"addr"=>"../../back_end/meeting/meeting_motion.php",		//這份表單送到哪裏
			"form"=>array							//表單的欄位
			(
				"topic"=>"none",			//none 就是要你填東西
			)
		)

		"meeting_answer_question"=>array					//解答問題
		(
			"func"=>"meeting_answer",			
			"addr"=>"../../back_end/meeting/meeting_answer.php",	//這份表單送到哪裏
			"form"=>array						//表單的欄位
			(
				"question_id"=>"none",		//none 就是要你填東西
				"topic_id"="none"			//投票議題的id，得知在哪個議題裏面提出問題  能從"meeting_topic "=>"get_meeting_topic.php" 取得topic_id
				"answer"=>"none"			
			)
		)
		//送出問題後能從這裏看到發起的問題 "meeting_question"=>"get_meeting_question.php"

		)

	)
?>