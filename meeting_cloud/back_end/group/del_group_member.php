<?php
	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了
	
	require_once("../../connMysql.php");	
	
	require_once("login_check.php");			//login_check.php 是用來檢查用戶是否登錄了
	
	$sql = "delete
		from group_member
		where member_id = '".$_GET['member_id']."' and group_id = '".$_GET['group_id']."'";
		
	$location = "Location: group.php?group_id=".$_GET['group_id'];
	if ($conn->query($sql))
	{	
		echo "success\n";
		header ($location);	
	}
	else
	{	
		echo "failed\n";
		header ($location);	
	}

//header ("Location: get_member_list.php?asl_ac=$_GET['ask_ac']&ask_name=$_GET['ask_name']");
?>