﻿<?php
	
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
		
		function file_size_unit($size,$decimal=2)
		{

			$size_unit = array('Bytes','KB','MB','GB','TB','PB','EB','ZB','YB');

			$flag = 0;

			while($size >= 1024)
			{
				$size = $size / 1024;
				$flag++;
			}

			return array('size' => number_format($size,$decimal),'unit' => $size_unit[$flag]);

		}


		
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
		{	$path = "group_upload_space/".$group_id."/".$meeting_id."/".$_GET['topic_id']."/";	}
		else
		{	$path = "group_upload_space/".$group_id."/".$meeting_id."/";	}
		$relative_path = "../../upload_space/".$path;			//get_meeting_doc 的相對路徑
		$first_file = 0;
		
		$json = array
		(
			"link" => array(),
		);
		if (is_dir($relative_path) != false)
		{
			if ($opendir = opendir($relative_path))
			{
				while (($file = readdir($opendir)) !==FALSE)
				{	
				//	if ($file != "." && $file != ".." && strtolower(substr($file, strrpos($file, '.') + 1)) == 'xml')			//這個是指定某種檔案

					if ($file != "." && $file != ".." && strtolower(substr($file, strrpos($file, '.') + 1)) != 'ini')				//有點就不是目錄
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
								$json ['link']['obj_doc_list']['size'] = array();
								$json ['link']['obj_doc_list']['date'] = array();
							}
							$size = abs(filesize($relative_path.$file));
							$size = file_size_unit($size);
							array_push( $json ['link']['obj_doc_list']['size'], $size['size'].$size['unit'] );
							array_push( $json ['link']['obj_doc_list']['date'], date("Y-m-d H:i", filectime($relative_path.$file)) );
							$file = iconv("BIG5", "UTF-8",$file);
							array_push( $json ['link']['obj_doc_list']['remark_name'], $file);
							array_push( $json ['link']['obj_doc_list']['download'], "back_end/upload_space/download.php?download_path=".$path.$file."&file_name=".$file );
							array_push( $json ['link']['obj_doc_list']['open_doc'], "back_end/upload_space/".$path.$file );
							
							//這邊要用 em_meeting_running 看 download.php 的相對路徑
							//而不是 get_meeting_doc 看 download.php 的相對路徑
						}
					}
				}
			}
		}
		
		if ($first_file == 0)
		{
		//	$json ['link']['obj_doc_list'] = "none";
			$json ['link']['obj_doc_list'] = array();
			$json ['link']['obj_doc_list']['remark_name'] = array();
			$json ['link']['obj_doc_list']['download'] = array();
			$json ['link']['obj_doc_list']['open_doc'] = array();
			$json ['link']['obj_doc_list']['size'] = array();
			$json ['link']['obj_doc_list']['date'] = array();
			
		}
	/*		
			array_push( $json ['link']['obj_doc_list']['remark_name'], "calender");
			array_push( $json ['link']['obj_doc_list']['download'], "https://drive.google.com/file/d/0Bz84tjygn2iQei1SbHVNX1g4cEU/view?usp=sharing" );
			array_push( $json ['link']['obj_doc_list']['open_doc'], "https://drive.google.com/file/d/0Bz84tjygn2iQei1SbHVNX1g4cEU/view?usp=sharing" );
			
			array_push( $json ['link']['obj_doc_list']['remark_name'], "i_don't_know");
			array_push( $json ['link']['obj_doc_list']['download'], "https://drive.google.com/file/d/0Bz84tjygn2iQb21FMjJ4d0lmNzQ/view?usp=sharing" );
			array_push( $json ['link']['obj_doc_list']['open_doc'], "https://drive.google.com/file/d/0Bz84tjygn2iQb21FMjJ4d0lmNzQ/view?usp=sharing" );
	*/		
			array_push( $json ['link']['obj_doc_list']['remark_name'], "test_txt_download.txt");
			array_push( $json ['link']['obj_doc_list']['download'], "back_end/upload_space/download.php?download_path=group_upload_space/10/4/1/abc.txt&file_name=abc.txt" );
			array_push( $json ['link']['obj_doc_list']['open_doc'], "back_end/upload_space/group_upload_space/10/4/1/105calendar.pdf");
			$size = abs(filesize("../../upload_space/group_upload_space/10/4/1/105calendar.pdf"));
			$size = file_size_unit($size);
			array_push( $json ['link']['obj_doc_list']['size'], $size['size'].$size['unit'] );
			array_push( $json ['link']['obj_doc_list']['date'], date("Y-m-d H:i", filectime("../../upload_space/group_upload_space/10/4/1/105calendar.pdf")) );
			
			
			array_push( $json ['link']['obj_doc_list']['remark_name'], "test_pdf_download.pdf");
			array_push( $json ['link']['obj_doc_list']['download'], "back_end/upload_space/download.php?download_path=group_upload_space/10/4/1/105calendar.pdf&file_name=105calendar.pdf" );
			array_push( $json ['link']['obj_doc_list']['open_doc'], "back_end/upload_space/group_upload_space/10/4/1/105calendar.pdf");
			$size = abs(filesize("../../upload_space/group_upload_space/10/4/1/105calendar.pdf"));
			$size = file_size_unit($size);
			array_push( $json ['link']['obj_doc_list']['size'], $size['size'].$size['unit'] );
			array_push( $json ['link']['obj_doc_list']['date'], date("Y-m-d H:i", filectime("../../upload_space/group_upload_space/10/4/1/105calendar.pdf")) );
	
	
	echo json_encode($json);
?>