﻿<?php 
	
	if(!isset($_SESSION))
	{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("../../../login_check.php?platform=device");	

	$sql = "select * from group_meeting_now where member_id = '".$_SESSION["id"]."'";
	$result=$conn->query($sql);
	$row=$result->fetch_array();
	$meeting_id = $row['meeting_id'];			//透過member id 來查詢會議中的 meeting id
	$option = $_POST['option'];
	
	if (isset($_POST['topic_id']))
	{	$topic_id = $_POST['topic_id'];		}
	else
	{	$topic_id = 0;		}
	
	$sql = "select * from group_meeting_now where meeting_id = '".$meeting_id."' and topic_id = '".$topic_id."'";
	$result=$conn->query($sql);
	$issue_id = $result->num_rows + 1;	
	
	$sql = "INSERT INTO meeting_vote value('".$meeting_id."', '".$topic_id."', '".$issue_id."', '".$issue."')";
	
	if ($conn->query($sql))
		echo "add voting issue success";
	else
		echo "add voting issue failed";
	
?>