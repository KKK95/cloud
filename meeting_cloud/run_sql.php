<?php

require_once("./connMysql.php");			//引用connMysql.php 來連接資料庫

//3337.0.0.33:8080/meeting_cloud/run_sql.php

$sql = "update group_meeting_topics set meeting_id = 3 WHERE meeting_id = 33";
$conn->query($sql);
$sql = "update join_meeting_member set meeting_id = 3 WHERE meeting_id = 33";
$conn->query($sql);
$sql = "update meeting_member_vote set meeting_id = 3 WHERE meeting_id = 33";
$conn->query($sql);
$sql = "update meeting_minutes set meeting_id = 3 WHERE meeting_id = 33";
$conn->query($sql);
$sql = "update meeting_questions set meeting_id = 3 WHERE meeting_id = 33";
$conn->query($sql);
$sql = "update meeting_record set meeting_id = 3 WHERE meeting_id = 33";
$conn->query($sql);
$sql = "update meeting_scheduler set meeting_id = 3 WHERE meeting_id = 33";
$conn->query($sql);
$sql = "update meeting_topic_contents set meeting_id = 3 WHERE meeting_id = 33";
$conn->query($sql);
$sql = "update meeting_vote set meeting_id = 3 WHERE meeting_id = 33";
$conn->query($sql);
$sql = "update meeting_voting_options set meeting_id = 3 WHERE meeting_id = 33";
$conn->query($sql);







?>