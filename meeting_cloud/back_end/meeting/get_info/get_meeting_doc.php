<?php
	
		//127.0.0.1:8080/meeting_cloud/back_end/meeting/get_info/get_meeting_doc.php?meeting_id=4
		header("Content-Type: text/html; charset=UTF-8");
		
		if(!isset($_SESSION))
		{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

		require_once("../../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	//	require_once("../../../login_check.php");	
		
		if (isset($_SESSION["id"]))
			$id = $_SESSION["id"];
		else
			$id = "a@";
		
		$sql = "select * from group_meeting_now where member_id = '".$id."'";
		$result=$conn->query($sql);
														
		$num_rows = $result->num_rows;					//看是否在會議中
		if (isset($_GET['meeting_id']))							//否
		{	$meeting_id = $_GET['meeting_id'];	}
		else if ($num_rows!=0)											//是
		{
			$row = $result->fetch_array();
			$meeting_id = $row['meeting_id'];
		}

		$sql = "select * from meeting_scheduler where meeting_id = '".$meeting_id."'";
		$result=$conn->query($sql);
		$row=$result->fetch_array();
		$group_id = $row['group_id'];
		
		if (isset($_GET['topic_id']))
		{	$path = "upload_space/group_upload_space/".$group_id."/".$meeting_id."/".$_GET['topic_id']."/";	}
		else
		{	$path = "upload_space/group_upload_space/".$group_id."/".$meeting_id."/";	}
		$relative_path = "../../".$path;			//get_meeting_doc 的相對路徑
		$first_file = 0;
		
		$json = array
		(
			"link" => array(),
		);
		
		if ($opendir = opendir($relative_path))
		{
			while (($file = readdir($opendir)) !==FALSE)
			{	
				//if ($file != "." && $file != ".." && strtolower(substr($file, strrpos($file, '.') + 1)) == 'xml')			這個是指定某種檔案

				if ($file != "." && $file != "..")				//有點就不是目錄
				{
					
					if ( strstr($file, '.') )
					{
						if( $first_file == 0 )
						{
							$first_file = 1;
							$json ['link']['obj_doc_list'] = array();
							$json ['link']['obj_doc_list']['remark_name'] = array();
							$json ['link']['obj_doc_list']['download'] = array();
							$json ['link']['obj_doc_list']['open_doc'] = array();
						}
						$file=iconv("BIG5", "UTF-8",$file);
						array_push( $json ['link']['obj_doc_list']['remark_name'], $file);
						array_push( $json ['link']['obj_doc_list']['download'], "back_end/upload_space/download.php?download_path=".$path."&file_name=".$file );
						array_push( $json ['link']['obj_doc_list']['open_doc'], "back_end/".$path.$file );
						//這邊要用 em_meeting_running 看 download.php 的相對路徑
						//而不是 get_meeting_doc 看 download.php 的相對路徑
					}
				}
			}
		}
		if ($first_file == 0)
			$json ['link']['obj_doc_list'] = "none";
	
	echo json_encode($json);
?>