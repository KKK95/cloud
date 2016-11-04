<?php

		if(!isset($_SESSION))
		{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

		require_once("../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
		require_once("login_check.php");
		
		$rename = 1;
		
		$basic_path = $_GET['basic_path'];
		
		$new_name = $_POST['new_file_name'];
		
		$old_name = $_POST['old_file_name'];
		
		$path = '../';
		
		if ( isset($_POST['old_file_name']) && isset($_POST['new_file_name']) )
		{
			
			$path = $path . $basic_path;
			
			if ($opendir = opendir($path))	//新檔名不可以跟現有檔案的名字一樣}
			{
				while (($file = readdir($opendir)) !==FALSE)
				{	
					if ($file == $_POST['new_file_name'])
					{
						echo "file name already exists";
						$rename = 0;
						break;
					}
				}
			}
			if ($rename == 1)
			{
				$old_name = $path . "/" . $old_name;
				$new_name = $path . "/" . $new_name;
				if (rename($old_name,$new_name) )	// (rename($a,$b)   $a=原來檔名  , $b=新的檔名
					echo "rename success!";
			}
		}
		
		
		
		if ( false !== ($rst = strpos($_GET['basic_path'], "user_upload_space")) )		//在我的空間
			header("Location: my_upload_space.php?basic_path=".$_GET['basic_path']); 
		else
			header("Location: group_upload_space.php?basic_path=".$_GET['basic_path']);


?>