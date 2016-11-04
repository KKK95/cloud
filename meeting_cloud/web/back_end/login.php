<?php

	header("Content-Type: text/html; charset=UTF-8");
	
	require_once ('../../connMysql.php');			//引用connMysql.php 來連接資料庫
	
	session_start();						//用 session 函式
	
	$sql = "SELECT id,pw,access FROM member WHERE id='".$_POST["id"]."'";		//sql 查詢語法, 查詢後會把結果返回到 $sql
		
	$result=$conn->query($sql);									//把上面查詢指令掉到 mysql_query 查詢, 由result得到查詢的結果
	
	$row=$result->fetch_array();								//只要一行資料
		
	$id = $row['id'];
		
	$pw = $row['pw'];
	
	$access = $row['access'];
	
	if (	isset($_SESSION["id"]) && ($_SESSION ["id"] != "")	)
	{	
		//登錄時, 這裏就分開了, 它會跟據你帳號本身的權限引導你去不同的頁面
			if ($row['access']=="em")
				header("Location: ../employee_web/employee_center.php"); 
			else if ($row['access']=="ls")
			{	header("Location: ../local_server_web/local_server_center.php"); 	}
			else if ($row['access']=="rt")
			{	header("Location: ../root_web/root_center.php"); 	}
				
	}
	if (	!isset($_SESSION["id"]) && !isset($_SESSION ["pw"])	)
	{
		
		if ($_POST["pw"] == $pw)		//如果密碼正確
		{
			$_SESSION["id"] = $id;
			$_SESSION["access"] = $access;
			if(	isset($_POST["rememberme"]) && ( $_POST["rememberme"] == "true" )	)		//如果看到 index 中的 rememberme 有勾選, 就setcookie
			{	
				setcookie("id", $_POST["id"], time()+365*24*60*60);							//cookie 名為 id, 它的值是 $_POST["id"], 時間是一年
				setcookie("pw", $_POST["pw"], time()+365*24*60*60);
			}
			else
			{
				setcookie("id", $_POST["id"], time()+365*24*60*60);
				setcookie("pw", $_POST["pw"], time()-100);
			}
//			echo	"登入成功";



			if ($row['access']=="em")
				header("Location: ../employee_web/employee_center.php"); 
			else if ($row['access']=="ls")
			{	header("Location: ../local_server_web/local_server_center.php"); 	}
			else if ($row['access']=="rt")
			{	header("Location: ../root_web/root_center.php"); 	}
		}
		else							//如果密碼不正確
		{	header("Location: index.php?loginfail=true"); 	}
		
	}

?>