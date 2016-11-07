


利用id 找自己所有的會議id、會議名稱、會議日期
$sql = "select scheduler.*, member.name
			from meeting_scheduler as scheduler, member
			where scheduler.group_id in 
			(select gl.group_id
				FROM group_leader as gl, group_member as gm
				where gm.member_id = 'emaa' or gl.member_id = 'emaa'
                group by gl.group_id
			)
			and member.id = scheduler.moderator_id
            order by scheduler.time desc";
			
利用id 找自己所有所屬的群組
$sql = "SELECT gl.group_name, gl.group_id
			FROM group_leader as gl, group_member as gm
			where gm.member_id = '".$id."' or gl.member_id = '".$id."'
			group by gl.group_id ";
			
利用meeting id 找群組id
