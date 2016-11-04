<?php

		if(!isset($_SESSION))
		(  	session_start();	)			//用 session 函式, 看用戶是否已經登錄了

		require_once("connMysql.php");			//引用connMysql.php 來連接資料庫
	
		require_once("device/back_end/login_check.php");
		
		$sql = "select * from group_meeting_now where member_id = '".$_SESSION["id"]."'";
		$result=$conn->query($sql);
		$row=$result->fetch_array();
		$meeting_id = $row['meeting_id'];			//透過member id 來查詢會議中的 meeting id
		
		$obj_issue = "obj_";
		
		$json = array
		(
			"contents"=>array(),
		);
		
		$sql = "select * from meeting_vote where meeting_id = '".$meeting_id."'";
		$result=$conn->query($sql);
		$num_rows = $result->num_rows;	
		if ($num_rows==0)
		{	$state = "目前尚未發起投票";	}
		else
		{
			$state = "目前關於你的群組";
			$json['contents']['obj_voting_issue'] = array();
			$json['contents']['obj_voting_issue']['head_issue'] = array();
			$json['contents']['obj_voting_issue']['topic_id'] = array();
			$json['contents']['obj_voting_issue']['issue_id'] = array();
		
			for($i=1;$i<=$num_rows;$i++) 
			{
				$row=$result->fetch_array();
				array_push( $json['contents']['obj_voting_issue']['head_issue'], $row['issue']);
				array_push( $json['contents']['obj_voting_issue']['topic_id'], $row['topic_id']);
				array_push( $json['contents']['obj_voting_issue']['issue_id'], $row['issue_id']);
				$obj_issue = "obj_".$row['issue'];
				$find_options = "select * from meeting_voting_options where issue_id = '".$row['issue_id']."'";
				$result=$conn->query($find_options);
				$num_rows = $result->num_rows;	
				if ($num_rows != 0)
				{
					$json['contents'][$obj_issue] = array('option'=>array());
					$json['contents'][$obj_issue] = array('option_id'=>array());

					for($j=1;$j<=$num_rows;$j++) 
					{
						$row=$result->fetch_array();
						array_push( $json['contents']['obj_voting_issue'][$obj_issue]['option'], $row['voting_option']);
						array_push( $json['contents']['obj_voting_issue'][$obj_issue]['option_id'], $row['option_id']);
					}
				}
			
		}
		echo json_encode( $json );
?>