{

	"link":									//�|ĳ��T
	{
		"meeting_info":".\/join_meeting.php?meeting=",
		"get_meeting_now_list":"back_end/meeting/get_info/get_meeting_running_list.php",		//���b�}�l���|ĳ
		"get_meeting_record_list":"back_end/meeting/get_info/get_meeting_record_list.php",		//�|ĳ�O��
		"get_meeting_list":"back_end/meeting/get_info/get_meeting_list.php",					//�Y�N�}�l���|ĳ
	}
	"form":									//�إ߷|ĳ
	{
		"form":
		{
			"build_meeting":
			{
				"func":"build_meeting",
				"addr":"back_end\/meeting\/set_info\/set_meeting_scheduler.php",
				"form":
				{
					"meeting_title":"none",
					"meeting_time":"none",
					"moderator_id":"none"
				}
			}
		}
	}
}

get_meeting_now_list
"json":					//���b�}�l���|ĳ
{
	"contents":
	{
		"obj_meeting_now_list":					
		{
			"topic":["testing_by_android"],
			"meeting_day":["2016-11-30"],
			"meeting_time":["09:00"],
			"moderator":["apple"],
			"meeting_id":["4"]
		},
	},
}


get_meeting_record_list
"json":					//�|ĳ�O��
{
	"contents":
	{
		"obj_meeting_record_list":			
		{
			"topic":["\u6e2c\u8a66\u7528\u6703\u8b70\u8a18\u93042","\u6e2c\u8a66\u7528\u6703\u8b70\u8a18\u9304"],
			"meeting_day":["2016-11-02","2016-11-01"],
			"meeting_time":["00:00","00:00"],
			"moderator":["apple","apple"],
			"meeting_id":["8","7"]
		},
	},
}


get_meeting_list
"json":					//�Y�N�}�l���|ĳ
{
	"contents":
	{
		"obj_meeting_list":					//�Y�N�}�l���|ĳ
		{
			"topic":["testing_by_android","testing_by_android2","test set meeting"],
			"meeting_day":["2016-11-30","2016-11-30","2016-12-01"],
			"meeting_time":["09:00","10:00","00:00"],
			"moderator":["apple","apple","apple"],
			"meeting_id":["4","5","16"]
		}
	},
}

		









