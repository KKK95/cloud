<?php
	header("Content-Type: text/html; charset=UTF-8");
			
	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("../back_end/login_check.php");
?>

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<link rel="stylesheet" type="text/css" href="../main_css/main.css">
        
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        
        <script language="JavaScript" src="../main_js/leftBarSlide.js"></script>
        
        <script>
	      
        </script>
        
        <title>智會GO</title>
    </head>
	<body>
		<table id="HEADER_SHADOW" width=100% border="0" cellpadding="0" cellspacing="0">
		<tr>
		  
		    <td width=100% height=50px bgcolor="#00AA55">
		  	<p id="HEADER">智會GO</p>
		  	</td>
		  
		  </tr>
		</table>
		
		<div id="divOrigin">
			<div id="divTop">
	        	<dl style="margin:0;width:20%;float:left;">
	        		<dt id="memberBar" class="left">
	        			會員專區
	        			<dl id = "memberSubBar" style="margin:0;width:150px;display:none;">
		        			<dt><a href="">會員瀏覽</a></dt>
		        			<dt><a href="">會員資料</a></dt>
		        			<dt><a href="">修改密碼</a></dt>
		        			<dt><a href="">會員管理</a></dt>
		        			<dt><a href="../back_end/logout.php">登出</a></dt>
	        			</dl>
	        		</dt>
	        		<dt id="conventionBar" class="left">
	        			會議專區
	        			<dl id = "conventionSubBar" style="margin:0;width:150px;display:none;">
		        			<dt><a href="">會議瀏覽</a></dt>
		        			<dt><a href="">會議紀錄</a></dt>
		        			<dt><a href="">會議管理</a></dt>
		        			<dt><a href="">修改請求</a></dt>
	        			</dl>
	        		</dt>
	        	</dl>
	        	
	        	
	        	<div id="main">
	        		
		        	<p id="conventionTittle">會議修改請求列表</p>
					
					<table id="table">
						<tr>
							<td id="tableTittleCol1">狀態</td>
							<td id="tableTittleCol2">建議編號</td>
							<td id="tableTittleCol1">會議編號</td>
							<td id="tableTittleCol2">會議名稱</td>
							<td id="tableTittleCol1">建議人</td>
							<td id="tableTittleCol2">建議日期</td>
					    </tr>
					    
					   
					    
				    </table>

			    </div>
			    
	        </div>
		</div>
	</body>
</html>

