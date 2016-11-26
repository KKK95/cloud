?{
	"link":
	{
		"get_doc_list":"back_end\/upload_space\/upload.php?upload_path=group_upload_space\/10\/27\/",				//���o�|ĳ���C��
		"get_topic_list":"back_end\/meeting\/get_info\/get_meeting_info.php?meeting_id=27",						//���o�|ĳĳ�D
		"get_member_list":"back_end\/meeting\/get_info\/get_meeting_member_list.php?meeting_id=27"				//���o�P�|�H���W��
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
		"get_topic_doc_list":				//���o�|ĳĳ�D��������C��
		{
			"func":"get_doc_list",
			"addr":"back_end\/meeting\/get_info\/get_meeting_doc.php?meeting_id=27",
			"form":
			{
				"topic_id":"none"
			}
		},
		"get_voting_result":				//���o�|ĳĳ�D�����벼���G
		{
			"func":"get_voting_result",
			"addr":"back_end\/meeting\/get_info\/get_meeting_voting_result.php?meeting_id=27",
			"form":
			{
				"topic_id":"none",
				"issue_id":"none"
			}
		},
		"get_question":						//���o�|ĳĳ�D�������D
		{
			"func":"get_meeting_question",
			"addr":"back_end\/meeting\/get_info\/get_meeting_question.php",
			"form":
			{
				"topic_id":"none"
			}
		},
		"get_answer":						//���o�|ĳĳ�D��������
		{
			"func":"get_answer_list",
			"addr":"back_end\/meeting\/get_info\/get_meeting_question.php?meeting_id=27",
			"form":
			{
				"topic_id":"none"
			}
		},
		"get_topic_content":				//���o�|ĳĳ�D�������e
		{
			"func":"get_topic_content",
			"addr":"back_end\/meeting\/get_info\/get_meeting_content.php?meeting_id=27",
			"form":
			{
				"topic_id":"none"
			}
		},
<!-- ==================================================================================================================================== -->
		"meeting_ask":						//�b�Y�@��ĳ�D�����X���D
		{
			"func":"meeting_ask_question",
			"addr":"back_end\/meeting\/set_info\/set_meeting_question.php",
			"form":
			{
				"question":"none",
				"topic_id":"none"
			}
		},
		"meeting_motion":					//��ĳ
		{
			"func":"add_meeting_topic",
			"addr":"back_end\/meeting\/set_info\/set_meeting_topic.php",
			"form":
			{
				"topic":"none"
			}
		},
		"vote":								//�벼 
		{
			"func":"vote",
			"addr":"back_end\/meeting\/set_info\/set_meeting_vote.php",
			"form":
			{
				"topic_id":"none",			//ĳ�Did
				"issue_id":"none",			//�벼�D��id
				"option_id":"none"			//�ﶵid
			}
		}
		
<!-- ==================================================================================================================================== -->		
		
		"set_vote":							//�o�_�벼
		{
			"func":"set_vote",
			"addr":"back_end\/meeting\/set_info\/set_meeting_initiate_vote.php?meeting_id=27",
			"form":
			{
				"issue":"none",				//�벼�D�D
				"topic_id":"none"			//ĳ�Did
			}
		},
		
		
		"set_vote_option":
		{
			"func":"set_vote_option",
			"addr":"back_end\/meeting\/set_info\/set_meeting_voting_option.php?meeting_id=27",
			"form":
			{
				"option":"none",			//�벼�ﶵ
				"topic_id":"none",			//ĳ�Did
				"issue_id":"none"			//�벼�D�D
			}
		},
		
		
		"set_answer":						//�^��
		{
			"func":"answer",
			"addr":"back_end\/meeting\/set_info\/set_meeting_answer.php?meeting_id=27",
			"form":
			{
				"topic_id":"none",			//ĳ�Did
				"question_id":"none",		//���Did
				"answer":"none"				//�^��
			}
		},
		
		
		"set_topic_content":				//�]�wĳ�D���e
		{
			"func":"set_content",
			"addr":"back_end\/meeting\/set_info\/set_meeting_content.php?meeting_id=27",
			"form":
			{
				"content":"none",			//���e
				"topic_id":"none"			//ĳ�Did
			}
		},
		
		
		"set_topic_meeting_minutes":		//ĳ�D����
		{
			"func":"set_meeting_minutes",
			"addr":"back_end\/meeting\/set_info\/set_meeting_minutes.php?meeting_id=27",
			"form":
			{
				"meeting_minutes":"none",	//����
				"topic_id":"none"			//ĳ�Did
			}
		}
		
		
		
	}
}