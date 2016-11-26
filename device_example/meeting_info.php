{
	"contents":
	{
		"moderator":"apple",			//主席名稱
		"date":"2016-11-30",			//會議開始日期
		"time":"09:00",					//會議開始時間
		"meeting_id":"4",				//會議id
	},
	"link":								
	{
		"meeting_start":"back_end\/meeting_start.php?meeting_id=4",		
		//會議開始
		"get_doc_list":"back_end\/upload_space\/upload.php?upload_path=group_upload_space\/3\/4\/",				
		//取得會議文件列表
		"get_topic_list":"back_end\/meeting\/get_info\/get_meeting_info.php?meeting_id=4",						
		//取得會議議題
		"get_member_list":"back_end\/meeting\/get_info\/get_meeting_member_list.php?meeting_id=4"				
		//取得與會人員名單
	},
	"form":
	{
		"get_topic_doc_list":		//取得會議議題中的附件列表
		{
			"func":"get_doc_list",
			"addr":"back_end\/upload_space\/upload.php?upload_path=group_upload_space\/3\/4\/",
			"form":
			{
				"topic_id":"none"
			}
		},
		"get_question":				//取得會議議題中的問題
		{
			"func":"get_question_list",
			"addr":"back_end\/meeting\/get_info\/get_meeting_question.php?meeting_id=4",
			"form":
			{
				"topic_id":"none"
			}
		},
		"get_answer":				//取得會議議題中的答案
		{
			"func":"get_answer_list",
			"addr":"back_end\/meeting\/get_info\/get_meeting_answer.php?meeting_id=4",
			"form":
			{
				"topic_id":"none"
			}
		},
		"get_voting_result":		//取得會議議題中的投票結果
		{
			"func":"get_voting_result",
			"addr":"back_end\/meeting\/get_info\/get_meeting_voting_result.php?meeting_id=4",
			"form":
			{
				"topic_id":"none"
			}
		},
		"get_topic_content":		//取得會議議題中的內容
		{
			"func":"get_topic_content",
			"addr":"back_end\/meeting\/get_info\/get_meeting_content.php?meeting_id=4",
			"form":
			{
				"topic_id":"none"
			},
		},

	}
}