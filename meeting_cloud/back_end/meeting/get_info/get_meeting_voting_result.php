<?php

		header("Content-Type: text/html; charset=UTF-8");

		if(!isset($_SESSION))
		{	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

		require_once("../../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
		require_once("../../../login_check.php");	
		
		if (isset($_SESSION["id"]))
			$id = $_SESSION["id"];
		else
			$id = "a@";
		
		$sql = "select * from group_meeting_now where member_id = '".$id."'";
		$result = $conn->query($sql);
														
		$num_rows = $result->num_rows;					//看是否在會議中
		if (isset($_GET['meeting_id']))							//否
		{	$meeting_id = $_GET['meeting_id'];	}
		else if ($num_rows!=0)											//是
		{
			$row = $result->fetch_array();
			$meeting_id = $row['meeting_id'];
		}
	//==============================================取得會議id===================================================
		$topic_id = "";
		$issue_id = "";
		if (isset($_POST['topic_id']) && $_POST['topic_id'] != "none")
			$topic_id = $_POST['topic_id'];
		else if (isset($_GET['topic_id']) && $_GET['topic_id'] != "none")
			$topic_id = $_GET['topic_id'];
		
		if ( isset($_POST['issue_id']) && $_POST['issue_id'] != "none")
			$issue_id = $_POST['issue_id'];
		if ( isset($_GET['issue_id']) && $_GET['issue_id'] != "none")
			$issue_id = $_GET['issue_id'];
		
		if ($topic_id != "" && $topic_id != "none")						 				//選擇某一議題內的投票
		{

			if ( $issue_id != "" && $issue_id != "none")				//某一議題內指定某一投票記錄
			{
				$issue_id = $_POST['issue_id'];
				$sql = "select * from meeting_vote 
						where meeting_id = '".$meeting_id."' and issue_id = '".$issue_id."' and topic_id = '".$topic_id."'";
				$num_voting = $result->num_rows;	
				$result=$conn->query($sql);
			}
			else										//某一議題內的所有投票記錄
			{
				$sql = "select * from meeting_vote 
						where meeting_id = '".$meeting_id."' and topic_id = '".$topic_id."'";
				$result=$conn->query($sql);
				$num_voting = $result->num_rows;	
			}
		}
		else											//取出所有投票記錄
		{
			$sql = "select * from meeting_vote where meeting_id = '".$meeting_id."'";
			$result=$conn->query($sql);
			$num_voting = $result->num_rows;	
		}
	//====================================================================================================================
	
		
		$obj_issue = "obj_";
		
		$json = array
		(
			"contents"=>array(),
		);
		
		
		if ( $num_voting == 0 )
		{	$json['contents']['obj_voting_result'] = "none";	}
		else
		{
			$votes = 0;
			$json['contents']['obj_voting_result'] = array();
			$json['contents']['obj_voting_result']['head_issue'] = array();
			$json['contents']['obj_voting_result']['topic_id'] = array();
			$json['contents']['obj_voting_result']['issue_id'] = array();
			$json['contents']['obj_voting_result']['member_vote'] = array();
		
			for($i=1;$i<=$num_voting;$i++) 
			{
				$row = $result->fetch_array();
				array_push( $json['contents']['obj_voting_result']['head_issue'], $row['issue']);
				array_push( $json['contents']['obj_voting_result']['topic_id'], $row['topic_id']);
				array_push( $json['contents']['obj_voting_result']['issue_id'], $row['issue_id']);
				
				$member_vote_sql = "select * from meeting_member_vote 
									where meeting_id = '".$meeting_id."' and issue_id = '".$row['issue_id']."' and topic_id = '".$row['topic_id']."' ".
									"and member_id = '".$id."'";
									
				/*
					select * from meeting_member_vote 
					where meeting_id = '4' and issue_id = '1' and topic_id = '1' and member_id = '@'
				*/
							
				$member_voting_result = $conn->query($member_vote_sql);
				$num_member_voting = $member_voting_result->num_rows;
				if ( $num_member_voting != 0 )
					array_push( $json['contents']['obj_voting_result']['member_vote'], 1);
				else
					array_push( $json['contents']['obj_voting_result']['member_vote'], 0);
				
				$obj_issue = "obj_".$row['issue_id'];
				$find_options = "select * from meeting_voting_options 
								where issue_id = '".$row['issue_id']."' and topic_id = '".$row['topic_id']."' 
								and meeting_id = '".$meeting_id."'";
				
				$options_result = $conn->query($find_options);
				$num_options = $options_result->num_rows;	
				if ($num_options != 0)
				{
					$json['contents'][$obj_issue] = array('option'=>array(), 'option_id'=>array(), 'result'=>array());

					for($j=1 ; $j <= $num_options ; $j++) 
					{
						$option = $options_result->fetch_array();
						if (isset($option['votes']))
							$votes = $option['votes'];
						else
							$votes = 0;

						array_push( $json['contents'][$obj_issue]['option'], $option['voting_option']);
						array_push( $json['contents'][$obj_issue]['option_id'], $option['option_id']);
						array_push ($json['contents'][$obj_issue]['result'], $votes);
					}
					
				}
			}
		}
		echo json_encode( $json );
?>