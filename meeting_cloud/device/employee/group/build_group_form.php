<?php
	
	header("Content-Type: text/html; charset=UTF-8");
			
	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("../../../login_check.php");

	$json = array
	(
		"form" => array
		(
			"build_group" => array
			(
				"func" => "build_group",
				"addr" => "../../../back_end/group/build_group.php",
				"form" => array
				(
					"group_name" => "none",
					"member_id" => "none",
				)
			),
		),
	);


	echo json_encode( $json );
?>