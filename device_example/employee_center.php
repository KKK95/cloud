{
	"contents":
	{
		"obj_meeting_now_list":					//���b�}�l���|ĳ
		{
			"topic":["testing_by_android"],
			"meeting_day":["2016-11-30"],
			"meeting_time":["09:00"],
			"moderator":["apple"],
			"meeting_id":["4"]
		},
		"obj_meeting_record_list":			//�|ĳ�O��
		{
			"topic":["\u6e2c\u8a66\u7528\u6703\u8b70\u8a18\u93042","\u6e2c\u8a66\u7528\u6703\u8b70\u8a18\u9304"],
			"meeting_day":["2016-11-02","2016-11-01"],
			"meeting_time":["00:00","00:00"],
			"moderator":["apple","apple"],
			"meeting_id":["8","7"]
		},
		"obj_meeting_list":					//�Y�N�}�l���|ĳ
		{
			"topic":["testing_by_android","testing_by_android2","test set meeting"],
			"meeting_day":["2016-11-30","2016-11-30","2016-12-01"],
			"meeting_time":["09:00","10:00","00:00"],
			"moderator":["apple","apple","apple"],
			"meeting_id":["4","5","16"]
		}
	},
	"link":									//�|ĳ��T
	{
		"meeting_info":".\/join_meeting.php?meeting="
	}
	"form":									//�إ߷|ĳ
	{
		"form":
		{
			"login":
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