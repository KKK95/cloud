<?php
		//device/back_end
		
		if(!isset($_SESSION))
		{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

		require_once("../../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
		require_once("../../../login_check.php");	
		
		$datetime = date("Y-m-d H:i:s");
		
		if (isset($_GET['meeting_id'])
		{
			$meeting_id = $_GET['meeting_id'];
		}
		else
		{
			$sql = "select * from group_meeting_now where member_id = '".$_SESSION["id"]."'";
			$result=$conn->query($sql);
			$row=$result->fetch_array();
			$meeting_id = $row['meeting_id'];
		}
		
		$topic_id = $_POST['topic_id'];
		
		$question = $_POST['question'];
		
		$sql = "select * from meeting_questions as m_q where meeting_id = '".$meeting_id."' and topic_id = '".$topic_id."'";
		$result = $conn->query($sql);
		$num_rows = $result->num_rows;	
		$question_id = $num_rows + 1;
		
		if( isset($question) )
		{
			$sql = "INSERT INTO meeting_questions value('$meeting_id', '$topic_id', '$question_id', '$question', '', '$datetime')";
			
			if	($conn->query($sql))
				echo "發送成功";
			else
				echo "發送失敗";
		}
		
?>