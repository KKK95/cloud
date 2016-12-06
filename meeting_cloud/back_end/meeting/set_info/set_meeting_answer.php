<?php
		//127.0.0.1:8080/meeting_cloud/back_end/meeting/set_info/set_meeting_answer.php?meeting_id=4
		
		if(!isset($_SESSION))
		{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

		require_once("../../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	//	require_once("../../../login_check.php");
		
		$datetime = date("Y-m-d H:i:s");
		
		if (isset($_SESSION["id"]))
			$id = $_SESSION['id'];
		else
			$id = "a@";
		
		if (isset($_GET['meeting_id']))					//取出meeting id
		{	$meeting_id = $_GET['meeting_id'];	}
		else
		{
			$sql = "select * from group_meeting_now where member_id = '".$id."'";
			$result=$conn->query($sql);
			$row=$result->fetch_array();
			$meeting_id = $row['meeting_id'];
		}
		
		if ( isset($_GET['topic_id']) )
			$topic_id = $_GET['topic_id'];
		else if ( isset($_POST['topic_id']) )					//取出topic id
			$topic_id = $_POST['topic_id'];
		else
			$topic_id = 0;
		
		if (isset($_POST['question_id']))
			$question_id = $_POST['question_id'];
		else if ( isset($_GET['question_id']) )
			$question_id = $_GET['question_id'];
		
		if ( isset($_GET['answer']) )
			$answer = $_GET['answer'];
		else if ( isset($_POST['answer']) )
			$answer = $_POST['answer'];
		
		
		if( isset($question_id) && isset($answer) )
		{
			$sql = "UPDATE meeting_questions SET answer = '".$answer."'  
					where topic_id = '".$topic_id."' and meeting_id = '".$meeting_id."' and question_id = '".$question_id."'";	
			if	($conn->query($sql))
				echo "SET ANSWER SUCCESS";
			else
				echo $sql ;
		}
		else 
		{
			echo $sql ;
		}
		
?>