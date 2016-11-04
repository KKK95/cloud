<?php 

	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("back_end/login_check.php");
	
	$json = array
	(
		"form" => array
		(
			"build_group" => array
			(
				"func" => "建立群組",
				"addr" => "back_end/build_group.php",
				"form" => array
				(
					"group_name" => "none",
					"group_leader_id" => $_SESSION["id"],
					"number_id" => "none"
				)
			)
		)
	);
	
/*	$json['form'][0]['form']['member_id'] = array();
	for ($j=1; $j<=20; $j = $j+1)
	{
		array_push( $json['form']['0']['form']['member_id'], 'none' );
	}
*/	
	echo json_encode( $json );
	
?>	
			
			
			
			
			