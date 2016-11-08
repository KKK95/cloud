<?php

	header("Content-Type: text/html; charset=UTF-8");
	
	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("../../login_check.php");	

	$json = array
	(
		"from" => array
		(
			"set_meeting_topic" => array
			(
				"func" => "set_meeting_topic",
				"addr" => "../../../back_end/meeting/set_info/set_meeting_topic.php?meeting_id=".$_GET['meeting_id'],
				"form" => array
				(
					"topic" => "none",
				),
			),
		),
	);

	echo json_encode( $json );
?>