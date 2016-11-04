<?php

	header("Content-Type: text/html; charset=UTF-8");
			
	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("login_check.php");
	
	$server_meeting_start_form = array
	(
		"form" => array
		(
			"server_meeting_start" => array 
			(
				"func" => "會議主機準備會議",
				"addr" => "server_meeting_start.php",
				"form" => array
				(
					"ip" => "none"
				)
			)
		),	
		"state" => array();
	);
	
	echo json_encode( $employee_center );
?>