{
	"contents":
	{
		"moderator":"apple",			//�D�u�W��
		"date":"2016-11-30",			//�|ĳ�}�l���
		"time":"09:00",					//�|ĳ�}�l�ɶ�
		"meeting_id":"4",				//�|ĳid
		"obj_meeting_topic":			//�|ĳĳ�Did
		{
			"topic":["\u5168\u76db\u6642\u671f\u7684\u6797\u5927\u795e \u7684\u809a\u5b50\u5230\u5e95\u53ef\u4ee5\u88dd\u591a\u5c11\u6771\u897f?","\u5168\u76db\u6642\u671f\u7684\u6797\u5927\u795e\u5230\u5e95\u4e00\u6b21\u53ef\u4ee5\u5403\u591a\u5c11\u7897\u6c99\u8336\u62cc\u98ef?","\u4eca\u665a\u5403\u751a\u9ebc?","hihihi"],
			"topic_id":["2","1","3","4"]
		}
	},
	"link":								
	{
		"meeting_start":"back_end\/meeting_start.php?meeting_id=4",												//�|ĳ�}�l
		"get_doc_list":"back_end\/upload_space\/upload.php?upload_path=group_upload_space\/3\/4\/"				//���o�|ĳ���C��
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