<?php

	header("Content-Type: text/html; charset=UTF-8");
			
	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("back_end/login_check.php");
	
	$json = array
	(
		"link" => array
		(
			"會議開始" => "server_meeting_start_form.php",
			"登出系統" => "back_end/logout.php"
		)
	);

	echo json_encode( $json );
	
?>
