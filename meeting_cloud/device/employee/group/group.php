<?php 
	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("back_end/login_check.php");
	
	$sql = "select gl.leader_id, m.name
			from group_leader as gl, member as m
			where 
			gl.group_id = '".$_GET['group_id']."' and m.id = gl.leader_id";
			
	$result=$conn->query($sql);
	$row=$result->fetch_array();
	
	$leader_id = $row['leader_id'];
	$leader_name = $row['name'];					//先抓出群組中的隊長
	
	$sql = "select m.id, m.name 
			from group_member as gm, member as m, group_leader as gl
			where 
			gm.group_id = '".$_GET['group_id']."'
			and (gm.member_id = m.id or gl.leader_id = m.id)
			and gl.group_id = gm.group_id
			group by m.id";

	$result=$conn->query($sql);						//再抓出群組中的成員
	
	$state = "";
	
	$json = array
	(

		"link" => array
		(	
			"我的雲端空間" => "my_upload_space.php?basic_path=user_upload_space/".$_SESSION["id"],
			"會議群組雲端空間" => "group_upload_space.php?basic_path=group_upload_space&path=".$_GET['group_id'],
			"會議群組聊天室" => "group_chat_room.php?group_id=".$_GET['group_id']."&msg_volume=0",
			"obj_group_manager" => array()
		),
		"form" => array
		(
			"新增成員" => array 
			(
				"func" => "新增會員到此群組",
				"addr" => "back_end/add_member_to_group.php",
				"form" => array
				(
					"group_id" => $_GET['group_id'],
					"member_id" => "none"
				)
			),
		),	

	);
	$num_rows = $result->num_rows;	
	if ($num_rows==1)
	{	$state = "";	}	
	else
	{	

		$json['link']['obj_group_manager']['member'] = array();
		$json['link']['obj_group_manager']['member_id'] = array();
		if ($leader_id == $_SESSION["id"])
		{
			$json['link']['obj_group_manager']['del_member'] = array();
		}
		$state = "有群組成員";
		for($i=1;$i<=$num_rows;$i++)
		{
			$row=$result->fetch_array();				//rs 在這裏, fetch_assoc 的 index 只能用字串, 而 fetch_array 能用數字和字串作 index

			array_push( $json ['link']['obj_group_manager']['member'], $row['name']);
			array_push( $json ['link']['obj_group_manager']['member_id'], $row['id'] );
			
			
			if ($leader_id == $_SESSION["id"] && $leader_id != $row['id'])			//如果是leader, 就會擁有刪除成員的link
			{
				array_push( $json['link']['obj_group_manager']['del_member'], "back_end/del_group_member.php?member_id=".$row['id']."&group_id=".$_GET['group_id'] );
			}
			
		}
		
		//創立會議
		$json['form']['set_meeting_scheduler'] = array();
		$json['form']['set_meeting_scheduler']['func'] => "創立會議",
		$json['form']['set_meeting_scheduler']['addr'] => "../../../back_end/meeting/set_info/set_meeting_scheduler.php",
		$json['form']['set_meeting_scheduler']['form'] = array
		(
			"group_id" => $_GET['group_id'],
			"meeting_time" => "none",
			"join_meeting_member_id" => "none",
			"meeting_title" => "none"
		);
		
			//找出群組最近要開的會議
		$sql = "select m_s.meeting_id, m_s.time, m_s.title		
				from meeting_schedular as m_s
				where 
				m_s.group_id = '".$_GET['group_id']."'
				order by m_s.time";
				
		$result=$conn->query($sql);
		$today = date("Y-m-d H:i:s");
		
		if (((strtotime($meeting_time) - strtotime($today))/ (60*60)) == 0)			//今天有會議要開才有會議開始讓你按
		{
			$json['link']['obj_time_to_meeting'] = array();
		
			for($i=1 ; $i<=$num_rows ; $i++) 
			{
				$row=$result->fetch_array();
				$meeting_date = date("Y-m-d", strtotime($row['time']));
				$meeting_time = date("H:i", strtotime($row['time']));

				if ((strtotime($today) - strtotime($meeting_date)) > 0)		//昨天的事
				{	$end_meeting = $i;	break;	}
				$title = $row['title'];
				$meeting_id = $row['meeting_id'];
				
				array_push( $json['link']['obj_time_to_meeting']['remark_meeting_topic'], $title);
				array_push( $json['link']['obj_time_to_meeting']['meeting_info'], "../../../back_end/meeting/get_info/get_meeting_info?meeting_id=".$meeting_id);

			}
		}
	}
	
	
	echo json_encode( $json );

?>

