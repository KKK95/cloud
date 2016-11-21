<?php

	require_once("connMysql.php");
	
	$meeting_id = $_POST['meeting_id'];
	//$meeting_id = 10;
	
	$sql = "select * from meeting_scheduler where meeting_id = '".$meeting_id."'";
	$result = $conn->query($sql);
	$num_rows = $result->num_rows;
	
	if($num_rows==0) echo("Invalid meeting id");
	else header("Location: back_end/meeting/get_info/get_meeting_info.php?meeting_id=".$meeting_id);
	
?>