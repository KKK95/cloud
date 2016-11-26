{

	"link":									//會議資訊
	{
		"meeting_info":".\/join_meeting.php?meeting=",
		"get_meeting_now_list":"back_end/meeting/get_info/get_meeting_running_list.php",		//正在開始的會議
		"get_meeting_record_list":"back_end/meeting/get_info/get_meeting_record_list.php",		//會議記錄
		"get_meeting_list":"back_end/meeting/get_info/get_meeting_list.php",					//即將開始的會議
	}
	"form":									//建立會議
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
"json":					//正在開始的會議
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
"json":					//會議記錄
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
"json":					//即將開始的會議
{
	"contents":
	{
		"obj_meeting_list":					//即將開始的會議
		{
			"topic":["testing_by_android","testing_by_android2","test set meeting"],
			"meeting_day":["2016-11-30","2016-11-30","2016-12-01"],
			"meeting_time":["09:00","10:00","00:00"],
			"moderator":["apple","apple","apple"],
			"meeting_id":["4","5","16"]
		}
	},
}

		









