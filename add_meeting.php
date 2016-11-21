<?php

	require_once("connMysql.php");

	$id = "bw@";
	$datetime = date("Y-m-d H:i:s");
	
	$sql = "insert INTO group_leader (member_id, group_name, date_time) 
			VALUES ('".$id."', 'nuk', '".$datetime."')";
	
	if($result = $conn->query($sql))
		echo "build group success\n";
	else	
		echo "build group failed\n";	
	
	$sql = "select group_id from group_leader where date_time = '".$datetime."' and member_id = '".$id."'";			//­n¨ú±ogroup id
	
	$result = $conn->query($sql);
	
	$row=$result->fetch_array();
	
	$group_id = $row['group_id'];
	
	$meeting_title = $_POST['meeting_title'];
	//$meeting_title = 'add_test';
	
	$meeting_time = $_POST['meeting_time'];
	//$meeting_time = $datetime;
	
	$sql = "INSERT INTO meeting_scheduler value('', '".$group_id."', '".$meeting_title."', '".$id."', '".$meeting_time."')";
	$result = $conn->query($sql);
	
	$sql = "select * from meeting_scheduler where group_id = '".$group_id."' and time = '".$meeting_time."'";
	$result = $conn->query($sql);
	$row=$result->fetch_array();
	
	$meeting_id = $row['meeting_id'];
	
	echo("user id=" . $id . "<br />");
	echo("group id=" . $group_id . "<br />");
	echo("meeting id=" . $meeting_id . "<br />");
	echo("meeting title=" . $meeting_title . "<br />");
	echo("meeting time=" . $meeting_time . "<br />");
	
	header("Location: back_end/meeting/get_info/get_meeting_info.php?meeting_id=".$meeting_id);
	
?>