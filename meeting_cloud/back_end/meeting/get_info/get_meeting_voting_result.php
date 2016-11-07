<?php

		header("Content-Type: text/html; charset=UTF-8");

		if(!isset($_SESSION))
		{	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

		require_once("../../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
		require_once("../../../login_check.php");	
		
		$sql = "select * from group_meeting_now where member_id = '".$_SESSION["id"]."'";
		$result=$conn->query($sql);
	
		$num_rows = $result->num_rows;					//看是否在會議中
		if ($num_rows==0)								//否
		{	$meeting_id = $_GET['meeting_id'];	}
		else											//是
		{
			$row=$result->fetch_array();
			$meeting_id = $row['meeting_id'];
		}
	//==============================================取得會議id===================================================
	
		if (isset($_POST['topic_id']) && $_POST['topic_id'] != "none")					//選擇某一議題內的投票
		{
			$topic_id = $_POST['topic_id'];
			if ( isset($_POST['issue_id']) && $_POST['issue_id'] != "none")				//某一議題內指定某一投票記錄
			{
				$issue_id = $_POST['issue_id'];
				$sql = "select * from meeting_vote 
						where meeting_id = '".$meeting_id."' and issue_id = '".$issue_id."' and topic_id = '".$topic_id."'";
				$num_rows = $result->num_rows;	
				$result=$conn->query($sql);
			}
			else										//某一議題內的所有投票記錄
			{
				$sql = "select * from meeting_vote 
						where meeting_id = '".$meeting_id."' and topic_id = '".$topic_id."'";
				$result=$conn->query($sql);
				$num_rows = $result->num_rows;	
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
		{	$state = "目前尚未發起投票";	}
		else
		{
			$state = "目前關於你的群組";
			$json['contents']['obj_voting_issue'] = array();
			$json['contents']['obj_voting_issue']['head_issue'] = array();
			$json['contents']['obj_voting_issue']['topic_id'] = array();
			$json['contents']['obj_voting_issue']['issue_id'] = array();
		
			for($i=1;$i<=$num_voting;$i++) 
			{
				$row = $result->fetch_array();
				array_push( $json['contents']['obj_voting_issue']['head_issue'], $row['issue']);
				array_push( $json['contents']['obj_voting_issue']['topic_id'], $row['topic_id']);
				array_push( $json['contents']['obj_voting_issue']['issue_id'], $row['issue_id']);
				
				$obj_issue = "obj_".$row['issue_id'];
				$find_options = "select * from meeting_voting_options 
								where issue_id = '".$row['issue_id']."' and topic_id = '".$row['topic_id']."' and issue_id = '".$row['issue_id']."'";
				
				$options_result = $conn->query($find_options);
				$num_options = $options_result->num_rows;	
				if ($num_options != 0)
				{
					$json['contents'][$obj_issue] = array('option'=>array(), 'option_id'=>array(), 'result'=>array());
	//				$json['contents'][$obj_issue] = array('option_id'=>array());
	//				$json['contents'][$obj_issue] = array('result'=>array());

					for($j=1 ; $j <= $num_options ; $j++) 
					{
						$option = $options_result->fetch_array();
/*						if (isset($option['voting_option']))
							$voting_option = "none";
						if (isset($option['option_id']))
							$option_id = "none";
*/
						array_push( $json['contents'][$obj_issue]['option'], $option['voting_option']);
						array_push( $json['contents'][$obj_issue]['option_id'], $option['option_id']);
						array_push ($json['contents'][$obj_issue]['result'], $option['votes']);
					}
					
				}
			}
		}
		if ($_SESSION['platform'] == "device")
			echo json_encode( $json );
		else
		{
			$data = json_encode( $json );
		}	echo "($data)";
?>