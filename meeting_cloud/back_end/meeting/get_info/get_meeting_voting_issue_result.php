<?php 

	if(!isset($_SESSION))
	(  	session_start();	)			//用 session 函式, 看用戶是否已經登錄了

	require_once("connMysql.php");			//引用connMysql.php 來連接資料庫

	require_once("device/back_end/login_check.php");
	
	$sql = "select * from group_meeting_now where member_id = '".$_SESSION["id"]."'";
	$result=$conn->query($sql);
	$row=$result->fetch_array();
	$meeting_id = $row['meeting_id'];			//透過member id 來查詢會議中的 meeting id
	
	$issue_id = $_POST['issue_id'];
	$topic_id = $_POST['topic_id'];
	
	$sql = "select * from meeting_vote
			where meeting_id = '".$meeting_id."' and issue_id = '".$issue_id."' and topic_id = '".$topic_id."'";
	$result=$conn->query($sql);
	$issue = $row['issue'];	
	
	$sql = "select * from meeting_voting_options
			where meeting_id = '".$meeting_id."' and issue_id = '".$issue_id."' and topic_id = '".$topic_id."'";
	$result=$conn->query($sql);
	$num_rows = $result->num_rows;	
	
	
	$json = array
	(
		"contents"=>array(),
	);
	
	if ($num_rows==0)
	{	$state = "目前尚未發起投票";	}
	else
	{
		$json['contents'][$issue] = array("option"=>array());
		$json['contents'][$issue] = array("result"=>array());
		
		for ($i = 1; $i <= $num_rows; $i++)
		{
			$row=$result->fetch_array();
			array_push ($json['contents'][$issue]['option'], $row['voting_option']);
			array_push ($json['contents'][$issue]['result'], $row['votes']);
		}
	}
	
	echo json_encode( $json );
	
?>