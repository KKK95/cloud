<?php 
	
	if(!isset($_SESSION))
	{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("../../../login_check.php");	

	$result = 0;
	
	if (isset($_SESSION["id"]))
		$id = $_SESSION['id'];
	else
		$id = "a@";
	
	if (isset($_GET['meeting_id']))
	{	$meeting_id = $_GET['meeting_id'];	}
	else
	{
		$sql = "select * from group_meeting_now where member_id = '".$id."'";
		$result=$conn->query($sql);
		$row=$result->fetch_array();
		$meeting_id = $row['meeting_id'];
	}
	
	if (isset($_GET['topic_id']))
	{	$topic_id = $_GET['topic_id'];		}
	else if (isset($_POST['topic_id']))
	{	$topic_id = $_POST['topic_id'];		}
	else
	{	$topic_id = 0;	}
	
	if (isset($_GET['issue_id']))
	{	$issue_id = $_GET['issue_id'];		}
	else if (isset($_POST['issue_id']))
	{	$issue_id = $_POST['issue_id'];		}
	
	if (isset($_GET['option_id']))
	{	$option_id = $_GET['option_id'];		}
	else if (isset($_POST['option_id']))
	{	$option_id = $_POST['option_id'];		}
	
	if (isset($option_id) && isset($issue_id))
	{
//		do    select votes from meeting_voting_options where topic_id = '1' and meeting_id = '4' and issue_id = '1' and option_id = '1'
//		{     select votes form meeting_voting_options where topic_id = '1' and meeting_id = '4' and issue_id = '1' and option_id = '1'
			
			$sql = "select votes from meeting_voting_options where topic_id = '".$topic_id."' and meeting_id = '".$meeting_id."' ".
					"and issue_id = '".$issue_id."' and option_id = '".$option_id."'";
			echo $sql; 
			$result = $conn -> query($sql);
			$row = $result -> fetch_array();
			$votes = $row['votes'];
			$votes = $votes + 1;
			
			$sql = "update meeting_voting_options set votes = '".$votes."' ".
					"where topic_id = '".$topic_id."' and meeting_id = '".$meeting_id."' ".
					"and issue_id = '".$issue_id."' and option_id = '".$option_id."'";
				
			$conn->query($sql);
				
			$sql = "INSERT INTO meeting_member_vote value
					('".$meeting_id."', '".$topic_id."', '".$issue_id."', '".$option_id."', '".$id."')";
			
			$conn->query($sql);
			
//		}while (true);

	}
	
	
	
	if ($_SESSION['platform'] == "web")
	{
		header("Location: ../../../web/employee_web/meeting/meeting_running/em_meeting_running_vote.php?meeting_id=".$meeting_id."&topic_id=".$topic_id);
	}	
	
	
?>