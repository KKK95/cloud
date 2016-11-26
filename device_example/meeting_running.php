?{
	"link":
	{
		"get_doc_list":"back_end\/upload_space\/upload.php?upload_path=group_upload_space\/10\/27\/",				//取得會議文件列表
		"get_topic_list":"back_end\/meeting\/get_info\/get_meeting_info.php?meeting_id=27",						//取得會議議題
		"get_member_list":"back_end\/meeting\/get_info\/get_meeting_member_list.php?meeting_id=27"				//取得與會人員名單
		"quit":"back_end\/meeting_end.php"
	},
	"form":
	{
		"conn_to_local_server":
		{
			"func":"conn_to_local_server",
			"addr":"back_end\/meeting\/conn_to_local_server.php",
			"form":
			{
				"local_server_id":"none",
				"member_ip":"none"
			}
		},
		"get_topic_doc_list":				//取得會議議題中的附件列表
		{
			"func":"get_doc_list",
			"addr":"back_end\/meeting\/get_info\/get_meeting_doc.php?meeting_id=27",
			"form":
			{
				"topic_id":"none"
			}
		},
		"get_voting_result":				//取得會議議題中的投票結果
		{
			"func":"get_voting_result",
			"addr":"back_end\/meeting\/get_info\/get_meeting_voting_result.php?meeting_id=27",
			"form":
			{
				"topic_id":"none",
				"issue_id":"none"
			}
		},
		"get_question":						//取得會議議題中的問題
		{
			"func":"get_meeting_question",
			"addr":"back_end\/meeting\/get_info\/get_meeting_question.php",
			"form":
			{
				"topic_id":"none"
			}
		},
		"get_answer":						//取得會議議題中的答案
		{
			"func":"get_answer_list",
			"addr":"back_end\/meeting\/get_info\/get_meeting_question.php?meeting_id=27",
			"form":
			{
				"topic_id":"none"
			}
		},
		"get_topic_content":				//取得會議議題中的內容
		{
			"func":"get_topic_content",
			"addr":"back_end\/meeting\/get_info\/get_meeting_content.php?meeting_id=27",
			"form":
			{
				"topic_id":"none"
			}
		},
<!-- ==================================================================================================================================== -->
		"meeting_ask":						//在某一個議題中提出問題
		{
			"func":"meeting_ask_question",
			"addr":"back_end\/meeting\/set_info\/set_meeting_question.php",
			"form":
			{
				"question":"none",
				"topic_id":"none"
			}
		},
		"meeting_motion":					//動議
		{
			"func":"add_meeting_topic",
			"addr":"back_end\/meeting\/set_info\/set_meeting_topic.php",
			"form":
			{
				"topic":"none"
			}
		},
		"vote":								//投票 
		{
			"func":"vote",
			"addr":"back_end\/meeting\/set_info\/set_meeting_vote.php",
			"form":
			{
				"topic_id":"none",			//議題id
				"issue_id":"none",			//投票主票id
				"option_id":"none"			//選項id
			}
		}
		
<!-- ==================================================================================================================================== -->		
		
		"set_vote":							//發起投票
		{
			"func":"set_vote",
			"addr":"back_end\/meeting\/set_info\/set_meeting_initiate_vote.php?meeting_id=27",
			"form":
			{
				"issue":"none",				//投票主題
				"topic_id":"none"			//議題id
			}
		},
		
		
		"set_vote_option":
		{
			"func":"set_vote_option",
			"addr":"back_end\/meeting\/set_info\/set_meeting_voting_option.php?meeting_id=27",
			"form":
			{
				"option":"none",			//投票選項
				"topic_id":"none",			//議題id
				"issue_id":"none"			//投票主題
			}
		},
		
		
		"set_answer":						//回答
		{
			"func":"answer",
			"addr":"back_end\/meeting\/set_info\/set_meeting_answer.php?meeting_id=27",
			"form":
			{
				"topic_id":"none",			//議題id
				"question_id":"none",		//問題id
				"answer":"none"				//回答
			}
		},
		
		
		"set_topic_content":				//設定議題內容
		{
			"func":"set_content",
			"addr":"back_end\/meeting\/set_info\/set_meeting_content.php?meeting_id=27",
			"form":
			{
				"content":"none",			//內容
				"topic_id":"none"			//議題id
			}
		},
		
		
		"set_topic_meeting_minutes":		//議題結論
		{
			"func":"set_meeting_minutes",
			"addr":"back_end\/meeting\/set_info\/set_meeting_minutes.php?meeting_id=27",
			"form":
			{
				"meeting_minutes":"none",	//結論
				"topic_id":"none"			//議題id
			}
		}
		
		
		
	}
}