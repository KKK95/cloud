<?php

		//測試用網址
		//http://127.0.0.1:8080/meeting_cloud/back_end/meeting/get_info/get_persenter.php

		if(!isset($_SESSION))
		{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

		require_once("../../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
		require_once("../../../login_check.php");	

		if (isset($_SESSION["id"]))
			$id = $_SESSION["id"];
		else
			$id = "a@";
		
		$sql = "select * from group_meeting_now where member_id = '".$id."'";
		$result=$conn->query($sql);
		
		$num_rows = $result->num_rows;					//看是否在會議中
		if (isset($_GET['meeting_id']))					//否
		{	$meeting_id = $_GET['meeting_id'];	}
		else if ($num_rows!=0)							//是
		{
			$row=$result->fetch_array();
			$meeting_id = $row['meeting_id'];
		}
		
		$json = array
		(
			"contents" => array(),
		);
			
		$sql = "select group_meeting_now.*, member.name from group_meeting_now, member 
				where action = 'per' and member.id = group_meeting_now.member_id and meeting_id = '".$meeting_id."'";
		$result=$conn->query($sql);
		$row = $result->fetch_array();
		$num_rows = $result->num_rows;
		$member_id = $row['member_id'];
		$name = $row['name'];
		
		if ($num_rows == 0)
		{	$json ['contents']['persenter_id'] = "none";	}
		else
		{
			$json ['contents']['persenter_id'] = $member_id;
			$json ['contents']['persenter'] = $name;
		}
		

		echo json_encode( $json );
		
?>