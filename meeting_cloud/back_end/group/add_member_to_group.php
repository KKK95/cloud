<?php
	
	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了
	
	require_once("../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("../../login_check.php");
	
	$start = 1;
	
	$platform = "device";
		
	if (isset ($_SESSION["platform"]))
		$platform = $_SESSION["platform"];
	
	$empty = $post = array();
	
	foreach ($_POST as $varname => $varvalue)
	{
		if (empty($varvalue)) {
			return ;
		} 
		else if ($start > 1)
		{
			$post[$varname] = $varvalue;
			$sql = "insert INTO group_member (group_id, member_id) 
											VALUES ('".$_POST['group_id']."','"
													  .$post[$varname]."')";
			$result = $conn->query($sql);

		}
		$start = $start + 1;
	}
	
	$sql = "delete from group_member
			where group_id = '".$row['group_id']."
			member_id not in (	select id from member	)";
	$conn->query($sql);
	
	if ($platform == "device")
	{
		header("Location: ../../device/employee/group/group.php?group_id=".$_POST['group_id']);
	}	
	else if ($platform == "web")
	{
		header("Location: ../../web/employee_web/group/group.php?group_id=".$_POST['group_id']);
	}	

?>