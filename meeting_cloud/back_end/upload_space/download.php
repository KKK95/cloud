<?php
		
		/*
127.0.0.1:8080/meeting_cloud/back_end/upload_space/download.php?download_path=group_upload_space/3/4/&file_name=test2.pdf
		*/	
		if(!isset($_SESSION))
		{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

		require_once("../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	//	require_once("../../login_check.php");
		
		$path = "./";
		$file_name = mb_convert_encoding($_GET['file_name'],"BIG-5","UTF-8");
		
		if ( isset($_GET['download_path']) && isset($_GET['file_name']) )			// $_GET['download_path'] 即為傳入要下載的檔案名稱 (含路徑)
		{
			$path = $path . $_GET['download_path'] . $_GET['file_name'];
			
			
			if ( false !== ($rst = strpos($_GET['file_name'], '.')) )
			{
			
				header("Content-type:application");
				header("Content-Length: " .(string)(filesize($path)));
				header("Content-Disposition: attachment; filename=".$_GET['file_name']);
				readfile($path);
			
	//		echo $path;
/*
			$file_name = $_GET['file_name'];
			$file_path = $path;
			$file_size = filesize($path);
			header('Pragma: public');
			header('Expires: 0');
			header('Last-Modified: ' . gmdate('D, d M Y H:i ') . ' GMT');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Cache-Control: private', false);
			header('Content-Type: application/octet-stream');
			header('Content-Length: ' . $file_size);
			header('Content-Disposition: attachment; filename="' . $file_name . '";');
			header('Content-Transfer-Encoding: binary');
			readfile($path);
*/
			}
/*---------------------------------------------------------------------------------------------------------------------------------------------------*/
			else
			{
				$zip = new ZipArchive;
				$path = $path."/";
				$zip_file = $_GET['file_name'].'.zip';
				$rootPath = realpath($path);
				$zip->open($zip_file, ZipArchive::CREATE);
				$files = new RecursiveIteratorIterator(
					new RecursiveDirectoryIterator($rootPath),
					RecursiveIteratorIterator::LEAVES_ONLY
				);
				
				foreach ($files as $name => $file)
				{
					// Skip directories (they would be added automatically)
					if (!$file->isDir())
					{
						// Get real and relative path for current file
						$filePath = $file->getRealPath();
						$relativePath = substr($filePath, strlen($rootPath) + 1);

						// Add current file to archive
						$zip->addFile($filePath, $relativePath);
					}
				}

				// Zip archive will be created only after closing object
				$zip->close();
				
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename='.basename($zip_file));
				header('Content-Transfer-Encoding: binary');
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header('Content-Length: ' . (string)(filesize($zip_file)));
				readfile($zip_file);
				
				if(file_exists($zip_file))
				{	unlink($zip_file);	}			//將檔案刪除
			}

		}
		else
		{
			echo "file :".$path."not found";
		}
	/*
		if ( false !== ($rst = strpos($_GET['download_path'], "user_upload_space")) )		//在我的空間
			header("Location: my_upload_space.php?basic_path=".$_GET['download_path']); 
		else
			header("Location: group_upload_space.php?basic_path=".$_GET['download_path']);
	*/	
?>