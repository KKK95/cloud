<?php

	if(!isset($_SESSION))
	{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../connMysql.php");			//引用connMysql.php 來連接資料庫

	require_once("login_check.php");
	
	$id = $_SESSION['id'];
	
	$sql = "SELECT id,pw FROM member WHERE id='".$id."'";
	
	$result = $conn->query($sql);
	
	$row = $result->fetch_array();
	
	$old_pw = $row['pw'];
	
	if($old_pw != $_POST['old_pw'])
	{		
		if ( false !== ($rst = strpos($id, "em")) )				//id 有 em 就證明是員工
		header("Location: ../employee_web/em_update_pw.php?old_pw_fail=true");	
	}
	else
	{
		$sql = "UPDATE member SET pw='".$_POST['new_pw']."'"." WHERE id='".$id."'";
		
		if ($conn->query($sql))
		{		
			if ( false !== ($rst = strpos($id, "em")) )			//id 有 em 就證明是員工
			{	header ("Location: ../employee_web/employee_center.php?update_pw=true"); 		}
		}
		else
		{		header ("Location: ../employee_web/employee_center.php?update_pw=false"); 		}
	}
?>

		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		