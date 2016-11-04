<?php
	
		if(!isset($_SESSION))
		{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

		require_once("../connMysql.php");			//引用connMysql.php 來連接資料庫
		
		require_once("back_end/login_check.php");
		
		//這裏要取出自己所屬的group id
		

		
		
		$path = "";
		$first_dir = 0;
		$first_file = 0;
		
		if ( isset($_GET['path']) )			//無論如何一定會有 basic_path 和 path
			$path = $_GET['basic_path']."/".$_GET['path'];
		else
			$path = $_GET['basic_path'];
		
		//open directory
		
		$json = array
		(
			"link" => array
			(	
				"我的雲端空間" => "user_upload_space.php?basic_path=user_upload_space/".$_SESSION["id"],
				"群組雲端空間" => "group_upload_space_center.php?basic_path=group_upload_space/",
				"上傳檔案" => "back_end/upload.php?upload_path=".$path
			),
			"form" => array
			(
				"make_dir" => array
				(
					"func" => "建立目錄",
					"addr" => "back_end/make_dir.php?basic_path=".$path,
					"form" => array
					(	"name" => "none"	)
				),
				"file_rename" => array
				(
					"func" => "重新命名檔案",
					"addr" => "back_end/file_rename.php?basic_path=".$path,
					"form" => array
					(
						"old_file_name" => "none",
						"new_file_name" => "none"
					)
				)
			)
		);
		echo "$path ";
		
		if ($opendir = opendir($path))
		{
			while (($file = readdir($opendir)) !==FALSE)
			{	
				//if ($file != "." && $file != ".." && strtolower(substr($file, strrpos($file, '.') + 1)) == 'xml')			這個是指定某種檔案
				
			if ($file != "." && $file != "..")				//找屬於自己的目錄
				{
					
					if ( strstr($file, '.') )
					{
						if( $first_file == 0 )
						{
							$first_file = 1;
							$json ['link']['obj_file_manager'] = array();
							$json ['link']['obj_file_manager']['0'] = array();
							$json ['link']['obj_file_manager']['download'] = array();
							$json ['link']['obj_file_manager']['del_file'] = array();
						}
						array_push( $json ['link']['obj_file_manager']['0'], $file);
						array_push( $json ['link']['obj_file_manager']['download'], "back_end/download.php?download_path=".$path."&file_name=".$file);
						array_push( $json ['link']['obj_file_manager']['del_file'], "back_end/del_file.php?basic_path=".$path."&file_name=".$file);
					
					}
					else											//沒點就是目錄
					{
						if( $first_dir == 0 )
						{
							$first_dir = 1;
							$json ['link']['obj_dir_manager'] = array();
							$json ['link']['obj_dir_manager']['0'] = array();
							$json ['link']['obj_dir_manager']['dir_entry'] = array();
							$json ['link']['obj_dir_manager']['download'] = array();
							$json ['link']['obj_dir_manager']['del_file'] = array();
							
						}
						array_push( $json ['link']['obj_dir_manager']['0'], $file);
						array_push( $json ['link']['obj_dir_manager']['dir_entry'], "group_upload_space.php?basic_path=".$path."&path=".$file);
						array_push( $json ['link']['obj_dir_manager']['download'], "back_end/download.php?download_path=".$path."&file_name=".$file);
						array_push( $json ['link']['obj_dir_manager']['del_file'], "back_end/del_file.php?basic_path=".$path."&file_name=".$file);
					}
				}
			}
		}
		
		//有path, path = none 即到file root
		//path != none 即到該file
	
	echo json_encode( $json );
	
	
?>