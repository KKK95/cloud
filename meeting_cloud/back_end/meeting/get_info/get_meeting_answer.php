<?php

		//���եκ��}
		//http://127.0.0.1:8080/meeting_cloud/back_end/meeting/get_info/get_meeting_answer.php?meeting_id=4&topic_id=2

		if(!isset($_SESSION))
		{  	session_start();	}			//�� session �禡, �ݥΤ�O�_�w�g�n���F

		require_once("../../../connMysql.php");			//�ޥ�connMysql.php �ӳs����Ʈw
	
		require_once("../../../login_check.php");	

		if (isset($_SESSION["id"]))
			$id = $_SESSION["id"];
		else
			$id = "a@";
		
		$sql = "select * from group_meeting_now where member_id = '".$id."'";
		$result=$conn->query($sql);
		
		$num_rows = $result->num_rows;					//�ݬO�_�b�|ĳ��
		if (isset($_GET['meeting_id']))							//�_
		{	$meeting_id = $_GET['meeting_id'];	}
		else if ($num_rows!=0)											//�O
		{
			$row=$result->fetch_array();
			$meeting_id = $row['meeting_id'];
		}
		
		if (isset($_GET['topic_id']))
		{	$topic_id = $_GET['topic_id'];	}
		else if (isset($_POST['topic_id']))
		{	$topic_id = $_POST['topic_id'];	}
		else
		{	$topic_id = 0;	}
		
		$json = array
		(
			"contents" => array(),
		);
			
		$sql = "select * from meeting_questions where meeting_id = '".$meeting_id."' and topic_id = '".$topic_id."' and answer != ''";
		$result=$conn->query($sql);									
		$num_rows = $result->num_rows;
		
		if ($num_rows == 0)
		{	$json ['contents']['obj_answer'] = "none";	}
		else
		{
			$json ['contents']['obj_answer'] = array();
			$json ['contents']['obj_answer']['head_answer'] = array();
			$json ['contents']['obj_answer']['topic_id'] = array();
			$json ['contents']['obj_answer']['question_id'] = array();
			
			for ($i = 1; $i <= $num_rows; $i++)
			{
				$row=$result->fetch_array();
				array_push ($json ['contents']['obj_answer']['head_answer'], $row['answer']);
				array_push ($json ['contents']['obj_answer']['topic_id'], $row['topic_id']);
				array_push ($json ['contents']['obj_answer']['question_id'], $row['question_id']);
			}
		}
		

		echo json_encode( $json );
		
?>