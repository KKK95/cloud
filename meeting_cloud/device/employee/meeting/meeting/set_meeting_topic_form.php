<?php

	header("Content-Type: text/html; charset=UTF-8");
	
	if(!isset($_SESSION))
	{  		session_start();	}			//�� session �禡, �ݥΤ�O�_�w�g�n���F

	require_once("../../connMysql.php");			//�ޥ�connMysql.php �ӳs����Ʈw
	
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