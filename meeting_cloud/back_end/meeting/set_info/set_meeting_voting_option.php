<?php 
	
	if(!isset($_SESSION))
	{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
//	require_once("../../../login_check.php");	

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
	
	
	if (isset($_POST['option']) && isset($issue_id) && $issue_id != 0)
	{

		$option = $_POST['option'];
		
		$sql = "select * from meeting_voting_options 
				where	meeting_id = '".$meeting_id."' and topic_id = '".$topic_id."' 
				and		issue_id = '".$issue_id."'";
		$result = $conn->query($sql);
		$option_id = $result->num_rows + 1;	
		
		$sql = "INSERT INTO meeting_voting_options value 
				('".$meeting_id."', '".$topic_id."', '".$issue_id."', '".$option_id."', '".$option."', 0)";
		
		if ($conn->query($sql))
			echo "add new option success";
		else
		{
			echo "failed";
			echo $sql;
		}	
	}
	else
	{
		echo "not set option or have no issue_id";
	}
	
?>