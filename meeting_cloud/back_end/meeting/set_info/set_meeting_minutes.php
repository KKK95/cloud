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
	
	$sql = "select * from group_meeting_now where member_id = '".$id."'";
	$result=$conn->query($sql);
													//看是否在會議中
	$num_rows = $result->num_rows;	
	if (isset($_GET['meeting_id']))							//否
	{	$meeting_id = $_GET['meeting_id'];	}
	else if ($num_rows != 0)								//是
	{
		$row=$result->fetch_array();
		$meeting_id = $row['meeting_id'];
	}
	
	if (isset($_POST['topic_id']))							//否
	{	$topic_id = $_POST['topic_id'];	}
	else if (isset($_GET['topic_id']))						//否
	{	$topic_id = $_GET['topic_id'];	}
	
	
	$sql = "select * from meeting_minutes
			where	meeting_id = '".$meeting_id."' and topic_id = '".$topic_id."'";
	$result = $conn->query($sql);
	$meeting_minutes_id = $result->num_rows + 1;	
	
	if (isset($_POST['meeting_minutes']))
	{
		$meeting_minutes = $_POST['meeting_minutes'];
		$sql = "INSERT INTO meeting_minutes value('".$meeting_id."', '".$topic_id."', '".$meeting_minutes_id."', '".$meeting_minutes."')";
		$result = $conn->query($sql);
	}
	
?>