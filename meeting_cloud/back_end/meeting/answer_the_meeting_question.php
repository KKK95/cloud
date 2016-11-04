<?php
		//device/back_end
		
		if(!isset($_SESSION))
		{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

		require_once("../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
		require_once("login_check.php");
		
		$datetime = date("Y-m-d H:i:s");
		
		$meeting_id = $_GET['meeting_id'];
		
		$question_id = $_GET['question_id'];
		
		$answer = $_SESSION['answer'];
		
		if( isset($question) )
		{
				$sql = "UPDATE server_running_now SET answer = '".$answer."'  
						where server_id = '".$meeting_id."' and meeting_id = '".$meeting_id."'";	
				if	($conn->query($sql))
					echo "發送成功";
				else
					echo "發送失敗";
		}
		
		//									要改
		header("Location: group_chat_room.php?group_id=".$_GET['group_id']."&msg_volume=0"); 
?>