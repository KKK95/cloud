<?php
	
	header("Content-Type: text/html; charset=UTF-8");
	
	if(!isset($_SESSION))
	{  	session_start();	}			//�� session �禡, �ݥΤ�O�_�w�g�n���F

	require_once("../../../connMysql.php");			//�ޥ�connMysql.php �ӳs����Ʈw
	
//	require_once("../../../login_check.php");

	
	
	if (isset($_SESSION["id"]))
		$id = $_SESSION['id'];
	else
		$id = "a@";
	
	$meeting_id = $GET['meeting_id'];
	
	$sql = "select moderator_id from meeting_scheduler where moderator_id = '".$id."' and meeting_id = '".$meeting_id."'";			//��Xid ���b�}�l���|ĳ
	$result = $conn->query($sql);
	$meeting_now = $result->num_rows;

	if (isset($_POST['presenter_id']) && $meeting_now == 1)
	{
		$row = $result->fetch_array();
		$presenter_id = $_POST['presenter_id'];													//�ˬd²���̬O�_���b�P�@�ӷ|ĳ
		$sql = "select * from group_meeting_now where member_id = '".$presenter_id."' and meeting_id = '".$meeting_id."'";
		$result = $conn->query($sql);
		$meeting_now = $result->num_rows;	
		if ( $meeting_now == 1 )																//�T�{�o��ӤH�b�P�@�|ĳ��
		{
			$sql = "update group_meeting_now set action = 'none' where action = 'per' and meeting_id = '".$meeting_id."'";
			$conn->query($sql);
			
			$sql = "update group_meeting_now action = 'per' where meeting_id = '".$meeting_id."' and member_id = '".$presenter_id."'";
			$conn->query($sql);
		}
	}

?>