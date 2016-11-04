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
	
	$sql = "select gm.group_id, gl.group_name 
			from group_member as gm, group_leader as gl, member as m
			where 
			(gm.group_id = '".$_GET['group_id']."' or gl.group_id = '".$_GET['group_id']."')
			and 
			(m.id = gl.leader_id or m.id = gm.member_id)
			group by m.id";
	
	$result=$conn->query($sql);
	
	$num_rows = $result->num_rows;	
	
	$row=$result->fetch_array();
	
	$state = "";
	
	$json = array
	(
		"content" => array
		(
			"group_id" => $_GET['group_id'],
			"group_name" => $row['group_name'],
			"group_leader" => $leader_name,
			"member" => array ()
		)
		"link" => array(),
		"form" => array
		(
			"add_member_to_group" => array 
			(
				"func" => "add_member_to_group",
				"addr" => "back_end/add_member_to_group.php",
				"form" => array
				(
					"group_name" => $row['group_name'],
					"group_id" => $row['group_id'],
					"member_id" => "";
				)
			)
		),
		"state" => array(),
	);
	
	
	
	if ($num_rows==0)
	{	$state = "現時沒有任何成員";	}
	else
	{
		$state = "有群組成員";
		for($i=1;$i<=$num_rows;$i++)
		{
			$row=$result->fetch_array();				//rs 在這裏, fetch_assoc 的 index 只能用字串, 而 fetch_array 能用數字和字串作 index

			if ( $leader_id != $row['id'])
			{
				array_push( $add_member_to_group_form ['content']['member'], array( $row['name'] => $row['id'] ));
			}
		}
		if ($leader_id == $_SESSION["id"]);
		{
			$add_member_to_group_form['link']['刪除成員'] => "back_end/del_group_member.php?member_id=&group_id=";
		}
	}
	
	echo json_encode( $json );
?>

			