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
	        		<dt id="member_Bar" class="left">
	        			會員專區
	        			<dt id = "meeting_SubBar" style="margin:0;width:150px;display:none;">
		        			<dt><a href="">會員瀏覽</a></dt>
		        			<dt><a href="">會員資料</a></dt>
		        			<dt><a href="">修改密碼</a></dt>
		        			<dt><a href="">會員管理</a></dt>
		        			<dt><a href="../back_end/logout.php">登出</a></dt>
	        			</dt>
	        		</dt>
	        		<dt id="meeting_Bar" class="left">
	        			會議專區
	        			<dt id = "meeting_SubBar" style="margin:0;width:150px;display:none;">
		        			<dt><a href="">會議瀏覽</a></dt>
		        			<dt><a href="">會議紀錄</a></dt>
		        			<dt><a href="">會議管理</a></dt>
		        			<dt><a href="">修改請求</a></dt>
	        			</dt>
	        		</dt>
	        	</dl>
	        	
	        	
	        	<div id="main_in_main">
	        		
	        		<div id="main_sub">
			        	<p id="conventionTittle">將至會議</p><!--管理員/紀錄-->
					
						<table id="table">
							<tr>
								<td id="tableTittleCol1">名稱</td>
								<td id="tableTittleCol2">日期</td>
								<td id="tableTittleCol1">時間</td>
								<td id="tableTittleCol2">召集人</td>
						    </tr>
						    
						    <tr><!--最多五欄-->
								<td id="tableValueCol1"><a href='' style="color:#333333;width:auto;line-height:200%;">異質性網路OAO</a></td>
								<td id="tableValueCol2">2016/09/24</td>
								<td id="tableValueCol1">9:00</td>
								<td id="tableValueCol2">宇振吳</td>
						    </tr>
						    
					    </table>
				    </div>
				    
				    <div id="main_sub">
					    <p id="conventionTittle">結束會議</p><!--管理員/紀錄-->
					
						<table id="table">
							<tr>
								<td id="tableTittleCol1">名稱</td>
								<td id="tableTittleCol2">日期</td>
								<td id="tableTittleCol1">時間</td>
								<td id="tableTittleCol2">召集人</td>
						    </tr>
						    
						    <tr><!--最多五欄-->
								<td id="tableValueCol1"><a href='' style="color:#333333;width:auto;line-height:200%;">畢專~~~~~</a></td>
								<td id="tableValueCol2">2016/10/01</td>
								<td id="tableValueCol1">9:00</td>
								<td id="tableValueCol2">健文楊</td>
						    </tr>
						    
					    </table>
				    </div>

			    </div>
			    
	        </div>
		</div>
	 
	</body>
</html>

