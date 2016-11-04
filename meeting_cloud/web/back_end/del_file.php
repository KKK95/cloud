<?php


		if(!isset($_SESSION))
		{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

		require_once("../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
		require_once("login_check.php");
		
		$path = '../';
		
		if ( isset($_GET['basic_path']) && isset($_GET['file_name']) )
		{
			$path = $path.$_GET['basic_path']."/".$_GET['file_name'];
			
			if ( strstr($_GET['file_name'], '.') )		//它是一個檔案
			{
				if(file_exists($path))
				{	unlink($path);	}	//將檔案刪除
				else
				{	echo"檔案不存在";	}
			}
			else										//否則是一個目錄
			{
				if (is_dir($path))
				{	rmdir($path);	}	//將檔案刪除
				else
				{	echo"目錄不存在";	}
			}
		}
		
		if ( false !== ($rst = strpos($_GET['basic_path'], "user_upload_space")) )		//在我的空間
			header("Location: my_upload_space.php?basic_path=".$_GET['basic_path']); 
		else
			header("Location: group_upload_space.php?basic_path=".$_GET['basic_path']);
?>