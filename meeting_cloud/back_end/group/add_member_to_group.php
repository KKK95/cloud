<?php
	
	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了
	
	require_once("../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("login_check.php");
	
	$start = 1;
	
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
													  .$varvalue."')";
			if($result = $conn->query($sql))
			{	echo "build group success\n";	}
			else
			{	
				echo "build group failed\n";	
			}
		}
		$start = $start + 1;
	}
	
	$sql = "delete from group_member
			where group_id = '".$row['group_id']."
			member_id not in (	select id from member	)
			";
	$conn->query($sql);
	
	header("Location: employee_center.php");

?>