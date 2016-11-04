<?php 
	
	if(!isset($_SESSION))
	{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("device/back_end/login_check.php");

	$sql = "select * from group_meeting_now where member_id = '".$_SESSION["id"]."'";
	$result=$conn->query($sql);
	$row=$result->fetch_array();
	$meeting_id = $row['meeting_id'];			//透過member id 來查詢會議中的 meeting id
	
	$option = $_POST['option'];
	$issue_id = $_POST['issue_id'];
	$topic_id = $_POST['topic_id'];
	
	$sql = "INSERT INTO meeting_voting_options value('".$meeting_id."', '".$topic_id."', '".$issue_id."', '".$option."', 0)";
	
	if ($conn->query($sql))
		echo "add voting option success";
	else
		echo "add voting option failed";
	
?>