<?php
	// 請查詢此機是local server 還是普通登錄
	if(!isset($_SESSION))
	{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了
											//用來暫存用戶的資料
	
	require_once("../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("login_check.php");	
	
	$sql = "select form server_running_now where server_id = '".$_SESSION["id"]."'";
	
	$result = $conn->query($sql);
	
	$num_rows = $result->num_rows;	
	
	if ($num_rows == 1)
	{
		$sql = "delete from server_running_now where server_id = '".$_SESSION["id"]."'";
		
		if($result = $conn->query($sql))
		{
			echo "server closing now...\n";
			header("Location: local_server_center.php");
		}
		else
		{
			echo "server closing failed...\n";
			header("Location: local_server_center.php");
		}
	}
	
	session_destroy();
	
	header("Location: ../index.php");
?>