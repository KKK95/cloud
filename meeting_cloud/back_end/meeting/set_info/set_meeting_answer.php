<?php
		//device/back_end
		
		if(!isset($_SESSION))
		{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

		require_once("../../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
		require_once("../../../login_check.php");
		
		$datetime = date("Y-m-d H:i:s");
		
		if (isset($_SESSION["id"]))
			$id = $_SESSION['id'];
		else
			$id = "a@";
		
		if (isset($_GET['meeting_id']))					//取出meeting id
		{
			$meeting_id = $_GET['meeting_id'];
		}
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
		
		$question_id = $_GET['question_id'];
		
		$answer = $_POST['answer'];
		
		if( isset($question_id) )
		{
			$sql = "UPDATE meeting_questions SET answer = '".$answer."'  
					where topic_id = '".$topic_id."' and meeting_id = '".$meeting_id."' and question_id = '".$question_id."'";	
			if	($conn->query($sql))
				echo "發送成功";
			else
				echo "發送失敗";
		}
		
?>