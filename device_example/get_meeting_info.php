{
	"contents":
	{
		"moderator":"apple",			//�D�u�W��
		"date":"2016-11-30",			//�|ĳ�}�l���
		"time":"09:00",					//�|ĳ�}�l�ɶ�
		"meeting_id":"4",				//�|ĳid
	},
	"link":								
	{
		"meeting_start":"back_end\/meeting_start.php?meeting_id=4",												//�|ĳ�}�l
		"get_doc_list":"back_end\/upload_space\/upload.php?upload_path=group_upload_space\/3\/4\/",				//���o�|ĳ���C��
		"get_topic_list":"back_end\/meeting\/get_info\/get_meeting_info.php?meeting_id=4"						//���o�|ĳĳ�D
	},
	"form":
	{
		"get_topic_doc_list":																					//���o�|ĳĳ�D����C��
		{
			"func":"get_doc_list",
			"addr":"back_end\/upload_space\/upload.php?upload_path=group_upload_space\/3\/4\/",
			"form":
			{
				"topic_id":"none"
			}
		},
		"get_guestion":																							//���o�|ĳĳ�D�������D
		{
			"func":"get_question_list",
			"addr":"back_end\/meeting\/get_info\/get_meeting_question.php?meeting_id=4",
			"form":
			{
				"topic_id":"none"
			}
		},
		"get_answer":																							//���o�|ĳĳ�D��������
		{
			"func":"get_answer_list",
			"addr":"back_end\/meeting\/get_info\/get_meeting_question.php?meeting_id=4",
			"form":
			{
				"topic_id":"none"
			}
		},
		"get_voting_result":																					//���o�|ĳĳ�D�����벼���A
		{
			"func":"get_voting_result",
			"addr":"back_end\/meeting\/get_info\/get_meeting_question.php?meeting_id=4",
			"form":
			{
				"topic_id":"none"
			}
		}
	}
}