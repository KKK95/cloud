<?php

	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("back_end/login_check.php");

	$state = "";
	$id=$_SESSION['id'];	
	
    $sql = "SELECT gl.group_name, gl.group_id
			FROM group_leader as gl, group_member as gm
			where gm.member_id = '".$id."' or gl.member_id = '".$id."'
			group by gl.group_id ";
	
	$result=$conn->query($sql);
	
	$json = array
	(
		"link" => array(),
	);
	
	$num_rows = $result->num_rows;	
	if ($num_rows==0)
	{	$state = "目前尚未建立關於你的群組";	}
	else
	{
		$state = "目前關於你的群組";
		$json['link']['obj_group'] = array();
		$json['link']['obj_group']['head_group_name'] = array();
		$json['link']['obj_group']['查看'] = array();
		//$json['link']['obj_group']['drop_out_group'] = array();
		
		for($i=1;$i<=$num_rows;$i++) 
		{
			$row=$result->fetch_array();				//rs 在這裏, fetch_assoc 的 index 只能用字串, 而 fetch_array 能用數字和字串作 index
			array_push( $json['link']['obj_group']['head_group_name'], $row['group_name']);
			array_push( $json['link']['obj_group']['查看'], "group.php?group_id=".$row['group_id']);
		//	array_push( $json['link']['group']['del'], "group.php?group_id=".$row['id']);
			//		這裏可以加東西
		}
	}
	echo json_encode( $json );
?>
