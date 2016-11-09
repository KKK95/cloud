<?php

		if(!isset($_SESSION))
		{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

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
		
		if (isset($_POST['topic_id']))
		{	$topic_id = $_POST['topic_id'];	}
		else
		{	$topic_id = 0;	}
		
		$json = array
		(
			"contents" => array(),
		);
			
		$sql = "select * from meeting_questions where meeting_id = '".$meeting_id."' and topic_id = '".$topic_id."'";
		$result=$conn->query($sql);									
		$num_rows = $result->num_rows;
		
		if ($num_rows == 0)
		{	echo "尚未設定任何問題";	}
		else
		{
			$json ['contents']['obj_question'] = array();
			$json ['contents']['obj_question']['head_question'] = array();
			$json ['contents']['obj_question']['topic_id'] = array();
			$json ['contents']['obj_question']['question_id'] = array();
			$json ['contents']['obj_question']['answer'] = array();
			
			for ($i = 1; i <= $num_rows; i++)
			{
				$row=$result->fetch_array();
				array_push ($json ['contents']['obj_question']['head_question'], $row['question']);
				array_push ($json ['contents']['obj_question']['topic_id'], $row['topic_id']);
				array_push ($json ['contents']['obj_question']['question_id'], $row['question_id']);
				array_push ($json ['contents']['obj_question']['answer'], $row['answer']);
			}
		}
		

		echo json_encode( $json );
		
?>