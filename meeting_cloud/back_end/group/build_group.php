<?php
	
	if(!isset($_SESSION))
	{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了
	
	require_once("../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("../../login_check.php");
	
	$start = 1;
	
	
	
	$datetime = date("Y-m-d H:i:s");
	
	$sql = "insert INTO group_leader (member_id, group_name, date_time) 
			VALUES ('".$_SESSION['id']."', '".$_POST['group_name']."', '".$datetime."')";
	
	if($conn->query($sql))
	{	
	
		$sql = "select group_id from group_leader where date_time = '".$datetime."' and member_id = '".$_SESSION['id']."'";			//要取得group id
		
		$result = $conn->query($sql);
		
		$row = $result->fetch_array();
		
		$group_id = $row['group_id'];
		
		$file = "../upload_space/group_upload_space/".$group_id;
		
		echo $file;
		
		mkdir($file);
		
		$empty = $post = array();
	
		foreach ($_POST as $varname => $varvalue)
		{
			if (empty($varvalue))
			{	
				$sql = "delete from group_member		
				where group_id = '".$row['group_id']."
				member_id not in (	select id from member	)";
				$conn->query($sql);
				echo $sql;
				if ($_SESSION['platform'] == "device")
				{	echo "device/employee/group/group.php?group_id=".$row['group_id'];	}	
				else 
				{	
					header( "Location: ../../web/employee_web/group/group.php?group_id=".$row['group_id'] );	
				}		
				return;
			} 
			else if ($start >= 2)
			{
				
				$post[$varname] = $varvalue;
				$sql = "insert INTO group_member (group_id, member_id) 
												VALUES ('".$group_id."','"
														  .$post[$varname]."')";
				$conn->query($sql);
				echo $sql;
			}
			$start = $start + 1;
		}
		
	
		//刪除一些不在member 列表中的 member id
		
	}
	else
		echo "failed";
	
?>