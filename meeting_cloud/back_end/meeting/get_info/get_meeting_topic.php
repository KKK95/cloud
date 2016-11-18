<?php

	header("Content-Type: text/html; charset=UTF-8");
	
	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("../../../login_check.php");
	
	$sql = "select * from group_meeting_now where member_id = '".$_SESSION["id"]."'";
	$result=$conn->query($sql);
	
													
	$num_rows = $result->num_rows;					//看是否在會議中
	if (isset($_GET['meeting_id']))							//否
	{	$meeting_id = $_GET['meeting_id'];	}
	else if ($num_rows!=0)											//是
	{
		$row=$result->fetch_array();
		$meeting_id = $row['meeting_id'];
	}
	
	$sql = "select * from group_meeting_topics where meeting_id = '".$meeting_id."'";
	$result=$conn->query($sql);
	$num_rows = $result->num_rows;	
	
	$json = array
	(
		"contents" => array(),
	);
	if ($num_rows==0)
	{	$state = "會議還沒有設下議題";	}
	else
	{
		$json['contents']['obj_meeting_topic'] = array();
		$json['contents']['obj_meeting_topic']['topic'] = array();
		$json['contents']['obj_meeting_topic']['topic_id'] = array();
	
		for($i=1;$i<=$num_rows;$i++) 
		{
			$row=$result->fetch_array();
			array_push ($json['contents']['obj_meeting_topic']['topic'], $row['topic']);
			array_push ($json['contents']['obj_meeting_topic']['topic_id'], $row['topic_id']);
		}
	}
			
	echo json_encode( $json );
?>