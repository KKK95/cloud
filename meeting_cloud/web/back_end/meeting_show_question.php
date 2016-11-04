<?php
	if(!isset($_SESSION))
	{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../connMysql.php");			//引用connMysql.php 來連接資料庫

	require_once("login_check.php");
	
	$num_of_questions = $_GET['num_of_questions'];
	$meeting_id = $_GET['meeting_id'];
	
	$sql = "select question, answer form meeting_questions as m_q 
			where m_q.meeting_id = '".$meeting_id.
			"' and m_q.question_id <= '".$num_of_questions."'";
			
	$result = $conn->query($sql);
	
	$num_rows = $result->num_rows;	
	
	$json = array
	(
		"content" => array,
	);
	
	if ( $num_rows == 0 )
	{	echo "該會議目前沒有任何提問";	}
	else
	{		
		$json['content']['questions'] = array();
		$json['content']['questions']['question'] = array();
		$json['content']['questions']['answer'] = array();
		for($i=1 ; $i<=$num_rows ; $i++) 
		{
			$row=$result->fetch_array();
			array_push( $json['content']['questions']['question'], $row['question']);
			array_push( $json['content']['questions']['answer'], $row['answer']);
		}
		
		echo json_encode( $json );
	}
	
?>