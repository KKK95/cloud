<?php
	
	header("Content-Type: text/html; charset=UTF-8");
	
	if(!isset($_SESSION))
	{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
//	require_once("../../../login_check.php");

	
	
	if (isset($_SESSION["id"]))
		$id = $_SESSION['id'];
	else
		$id = "a@";
	
	$meeting_id = $GET['meeting_id'];
	
	$sql = "select moderator_id from meeting_scheduler where moderator_id = '".$id."' and meeting_id = '".$meeting_id."'";			//找出id 正在開始的會議
	$result = $conn->query($sql);
	$meeting_now = $result->num_rows;

	if (isset($_POST['presenter_id']) && $meeting_now == 1)
	{
		$row = $result->fetch_array();
		$presenter_id = $_POST['presenter_id'];													//檢查簡報者是否正在同一個會議
		$sql = "select * from group_meeting_now where member_id = '".$presenter_id."' and meeting_id = '".$meeting_id."'";
		$result = $conn->query($sql);
		$meeting_now = $result->num_rows;	
		if ( $meeting_now == 1 )																//確認這兩個人在同一會議中
		{
			$sql = "update group_meeting_now set action = 'none' where action = 'per' and meeting_id = '".$meeting_id."'";
			$conn->query($sql);
			
			$sql = "update group_meeting_now action = 'per' where meeting_id = '".$meeting_id."' and member_id = '".$presenter_id."'";
			$conn->query($sql);
		}
	}

?>