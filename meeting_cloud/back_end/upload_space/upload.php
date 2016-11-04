<?php

		//device/back_end
		
		if(!isset($_SESSION))
		{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

		require_once("../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
		require_once("login_check.php");
		
		
		
		$path = '../';
		
		if (isset($_GET['upload_path']))
		{
			$path = $path.$_GET['upload_path'];
			$target_file = $path.basename($_FILES["fileToUpload"]["name"]);
			
			if ($_FILES["fileToUpload"]["size"] > 20000000) 					//不接受大於 20M 的檔案
			{
				echo "Sorry, your file is too large.";
				$uploadOk = 0;
			}
			else
			{
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
					echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
				else{
					$status= "There was an error uploading the file, please try again!";
					$status.= "filename: " .  basename( $_FILES['fileToUpload']['name']);
					echo "$status";
				}
			}
		}
		
		if ( false !== ($rst = strpos($_GET['upload_path'], "user_upload_space")) )		//在我的空間
			header("Location: my_upload_space.php?basic_path=".$_GET['upload_path']); 
		else
			header("Location: group_upload_space.php?basic_path=".$_GET['upload_path']);
		
		
		
		
?>