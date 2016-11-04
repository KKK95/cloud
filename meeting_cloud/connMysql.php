<?php

	//確定是哪一個資料庫
	$db_host = "localhost";		//資料庫位置
	$db_table = "meeting_cloud_db";	//資料表名字
	$db_username = "root";		//資料庫帳號
	$db_password = "12345";		
	
	$conn = mysqli_connect($db_host, $db_username, $db_password);
	
	if (!$conn)	//連接到資料庫
		die ("無法連接到資料庫");
	
	else
	{
		mysqli_select_db($conn,$db_table);
		mysqli_set_charset ($conn,'utf8');
	}
?>