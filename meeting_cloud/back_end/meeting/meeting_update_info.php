<?php

	if(!isset($_SESSION))
	(  	session_start();	)			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../../connMysql.php");			//引用connMysql.php 來連接資料庫

	require_once("../../../login_check.php?platform=device");	
	
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
	
	$json = array
	(
		"contents" => array(),
	);
	
	
	//==============================================議題數=====================================================
	$sql = "select * from meeting_topics where meeting_id = '".$meeting_id."'";
	$result=$conn->query($sql);
	$num_rows = $result->num_rows;
	$json ['contents']['meeting_topic'] = $num_rows;
	
	//==============================================問題數=====================================================
	$json ['contents']['meeting_question'] = array();
	$sql = "select * from meeting_questions where meeting_id = '".$meeting_id."'";
	$result=$conn->query($sql);
	$num_rows = $result->num_rows;
	$topic_id = -1;
	$num_of_topic = 0;
	for($i=1;$i<=$num_rows;$i++) 
	{
		$row=$result->fetch_array();
		if ($topic_id != $row['topic_id'])
		{
			if ( $topic_id != -1 )
			{	array_push ($json ['contents']['meeting_question'], $num_of_topic);	}
			$topic_id = $row['topic_id'];
			$num_of_topic = 0;
		}
		$num_of_topic = $num_of_topic + 1;
	}
	array_push ($json ['contents']['meeting_question'], $num_of_topic);
	
	//=============================================與會者數====================================================
	
	$sql = "select * from group_meeting_now where meeting_id = '".$meeting_id."'";
	$result=$conn->query($sql);
	$num_rows = $result->num_rows;
	$json ['contents']['meeting_member_list'] = $num_rows;
	
	
	
	
	
	
	
	
	
	
?>