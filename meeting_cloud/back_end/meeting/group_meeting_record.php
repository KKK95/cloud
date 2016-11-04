<?php
		//device/back_end
		
		if(!isset($_SESSION))
		{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

		require_once("../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
		require_once("login_check.php");
		
		$datetime = date("Y-m-d H:i:s");
		
		$msg = $_POST['msg'];
		
		$meeting_id = $_GET['meeting_id'];
		
		$member_id = $_SESSION["id"];
		
		if( isset($msg) && isset($meeting_id))
		{
			if(!empty($msg))
			{
				$sql = "INSERT INTO group_meeting_record value('$meeting_id','$member_id','$datetime','$msg')";
				
				if	($conn->query($sql))
					echo "發送成功";
				else
					echo "發送失敗";
			}
		}
		
		if (false !== ($rst = strpos($member_id, "ls"))				//server 送的就回到server 頁面
			header("Location: server_meeting_runngin.php"); 
		else
			header("Location: em_meeting_runngin.php"); 
?>