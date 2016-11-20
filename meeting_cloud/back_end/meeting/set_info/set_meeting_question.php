<?php
		//device/back_end
		
		if(!isset($_SESSION))
		{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

		require_once("../../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	//	require_once("../../../login_check.php");	
	
		if (isset($_SESSION["id"]))
			$id = $_SESSION['id'];
		else
			$id = "a@";
		
		$datetime = date("Y-m-d H:i:s");
		
		if (isset($_GET['meeting_id']))
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
		
		if (isset($_GET['topic_id']))
		{	$topic_id = $_GET['topic_id'];	}
		else
		{	$topic_id = 0;	}
		
		$question = $_POST['question'];
		
		$sql = "select * from meeting_questions where meeting_id = '".$meeting_id."' and topic_id = '".$topic_id."'";
		$result = $conn->query($sql);
		$num_rows = $result->num_rows;	
		$question_id = $num_rows + 1;
		
		if( isset($question) )
		{
			$sql = "INSERT INTO meeting_questions value('".$meeting_id."', '".$topic_id."', '".$question_id."', '".$question."', '', '".$datetime."')";
			
			if	($conn->query($sql))
			{	echo "發送成功";	}
			else
			{
				echo $sql;
			}
		}
		
		//大神出產 UI 的平均速度是?
?>