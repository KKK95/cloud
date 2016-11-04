<?php

		if(!isset($_SESSION))
		{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

		require_once("../connMysql.php");			//引用connMysql.php 來連接資料庫
		
		require_once("back_end/login_check.php");		//$_SESSION["id"]

//		localhost:8080/meeting_cloud/device/group_upload_space_center.php?basic_path=group_upload_space&id=emaa
		
		$sql = "select gl.group_id, gl.group_name from group_leader as gl, group_member as gm where
				gl.leader_id = '".$_SESSION["id"]."' or ( gm.member_id = '".$_SESSION["id"]."' and gm.group_id = gl.group_id )
				group by gl.group_id ";
				
		$result=$conn->query($sql);
		$row=$result->fetch_array();
		
		$path = $_GET['basic_path'];
		
		$first_dir = 0;
		
		$json = array
		(
			"link" => array
			(	
				"個人空間" => "user_upload_space.php?basic_path=user_upload_space/".$_SESSION["id"]
			),
		);
		

		$num_rows = $result->num_rows;
		
		if (($opendir = opendir($path)) && $num_rows > 0)
		{
			while ((($file = readdir($opendir)) !== FALSE) && $num_rows != 0 ) 
			{	
				//if ($file != "." && $file != ".." && strtolower(substr($file, strrpos($file, '.') + 1)) == 'xml')			這個是指定某種檔案
				if ( $row['group_id'] == $file )				//找屬於自己的目錄
				{
					if( $first_dir == 0 )
					{
						$first_dir = 1;
						$json ['link']['obj_dir_manager'] = array();
						$json ['link']['obj_dir_manager']['0'] = array();
						$json ['link']['obj_dir_manager']['dir_entry'] = array();					
					}
					array_push( $json ['link']['obj_dir_manager']['0'], $row['group_name']);
					array_push( $json ['link']['obj_dir_manager']['dir_entry'], "group_upload_space.php?basic_path=".$path."&path=".$file );
					$row=$result->fetch_array();
					$num_rows = $num_rows - 1;
				}

			}
		}

		echo json_encode( $json );

?>