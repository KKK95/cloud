<?php

		if(!isset($_SESSION))
		{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

		require_once("../../connMysql.php");			//引用connMysql.php 來連接資料庫
		
		require_once("login_check.php");
		
		$path = '../';
		
		if ( isset($_POST['name']) && isset($_GET['basic_path']) )			//無論如何一定會有 basic_path
		{
			$path = $path . $_GET['basic_path']."/".$_POST['name'];
			mkdir($path);
		}	
		else
		{
			echo "nothing value";
		}
		
		echo "$path";
		
		if ( false !== ($rst = strpos($_GET['basic_path'], "user_upload_space")) )		//在我的空間
			header("Location: my_upload_space.php?basic_path=".$_GET['basic_path']); 
		else
			header("Location: group_upload_space.php?basic_path=".$_GET['basic_path']);
?>