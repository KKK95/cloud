<?php
	header("Content-Type: text/html; charset=UTF-8");
	
	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	
	require_once("../../../login_check.php?platform=device");	
	
	$topic = $_POST['topic'];
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
	
	$sql = "INSERT INTO group_meeting_topics value('".$meeting_id."', 0, '".$topic."')";
	
	
	
	
	
	
	
?>