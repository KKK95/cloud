update join_meeting_now set meeting_id = 4 WHERE meeting_id = 1
update group_meeting_topics set meeting_id = 4 WHERE meeting_id = 1
update join_meeting_member set meeting_id = 4 WHERE meeting_id = 1
update meeting_member_vote set meeting_id = 4 WHERE meeting_id = 1
update meeting_minutes set meeting_id = 4 WHERE meeting_id = 1
update meeting_questions set meeting_id = 4 WHERE meeting_id = 1
update meeting_record set meeting_id = 4 WHERE meeting_id = 1
update meeting_scheduler set meeting_id = 4 WHERE meeting_id = 1
update meeting_topic_contents set meeting_id = 4 WHERE meeting_id = 1
update meeting_vote set meeting_id = 4 WHERE meeting_id = 1
update meeting_voting_options set meeting_id = 4 WHERE meeting_id = 1


DELETE from meeting_topic_contents WHERE meeting_id =
DELETE from group_meeting_topics WHERE meeting_id =
DELETE from meeting_scheduler WHERE meeting_id =
DELETE from join_meeting_member WHERE meeting_id =



�Q��id ��ۤv�Ҧ����|ĳid�B�|ĳ�W�١B�|ĳ����B�s��id
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
			
�Q��id ��ۤv�Ҧ����ݪ��s��
$sql = "SELECT gl.group_name, gl.group_id
			FROM group_leader as gl, group_member as gm
			where gm.member_id = '".$id."' or gl.member_id = '".$id."'
			group by gl.group_id ";
			
�Q��meeting id ��s��id
$sql = "select * from meeting_scheduler where meeting_id = '".$meeting_id."'";

��id ��ۤv�Ҧ����|ĳid�B�|ĳ�W�١B�|ĳ���
select scheduler.*, member.name
from meeting_scheduler as scheduler, member, join_meeting_member as j_m_m
where scheduler.meeting_id = j_m_m.meeting_id and j_m_m.member_id = '".$id."'
and member.id = scheduler.moderator_id and scheduler.time < '".$meeting_time."'
order by scheduler.time

��id, group id ��ۤv�Ҧ����|ĳid�B�|ĳ�W�١B�|ĳ���
$sql = "select scheduler.*, member.name
				from meeting_scheduler as scheduler, member, join_meeting_member as j_m_m
				where scheduler.meeting_id = j_m_m.meeting_id and j_m_m.member_id = '".$id."'
				and member.id = scheduler.moderator_id and scheduler.over = 4 and scheduler.group_id = '".$_GET['group_id']."' 
				and record.meeting_id = scheduler.meeting_id
				order by scheduler.time desc";

select scheduler.*, member.name
				from meeting_scheduler as scheduler, member, join_meeting_member as j_m_m
				where scheduler.meeting_id not in 
						(select g_m_n.meeting_id from group_meeting_now as g_m_n where 4)
				and j_m_m.member_id = '".$id."' and scheduler.group_id = '".$_GET['group_id']."' 
				and scheduler.meeting_id = j_m_m.meeting_id and scheduler.over = 0 
				and member.id = scheduler.moderator_id 
				order by scheduler.time

select member.name, scheduler.meeting_id, scheduler.time, scheduler.title
				from group_meeting_now as g_m_n, meeting_scheduler as scheduler, member
				where g_m_n.meeting_id
				in
				(
					select scheduler.meeting_id
					from meeting_scheduler as scheduler
					where scheduler.group_id in 
					(
						select gl.group_id
						FROM group_leader as gl, group_member as gm
						where gm.member_id = '".$id."' or gl.member_id = '".$id."'
						group by gl.group_id
					)
				)
				and g_m_n.meeting_id = scheduler.meeting_id and scheduler.moderator_id = member.id
				group by scheduler.meeting_id
				order by scheduler.time desc