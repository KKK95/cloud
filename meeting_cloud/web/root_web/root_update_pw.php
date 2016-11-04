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
	        			<dt id = "member_SubBar" style="margin:0;width:150px;display:none;">
		        			<dt><a href="">會員瀏覽</a></dt>
		        			<dt><a href="">會員資料</a></dt>
							<dt><a href="">我的雲端空間</a></dt>
		        			<dt><a href="../back_end/logout.php">登出</a></dt>
	        			</dt>
	        		</dt>
	        		<dt id="meeting_Bar" class="left">
	        			會議專區
	        			<dt id = "meeting_SubBar" style="margin:0;width:150px;display:none;">
		        			<dt><a href="em_meeting_list.php">會議管理</a></dt>
							<dt><a href="em_group_list.php">群組管理</a></dt>
		        			<dt><a href="">修改請求</a></dt>
	        			</dt>
	        		</dt>
	        	</dl>
	        	
	        	
	        	<div id="main">
	        	<form name="loginform" method="post" action="../back_end/update_pw.php">
		        	<p id="conventionTittle">修改密碼</p>
				
					<table id="table">
					    <tr>
							<td id="tableTittle2">舊密碼</td>
							<td id="tableValue2"><input id="tableValue2" type="password" name="old_pw"/></td>
					    </tr>
						<tr>
							<td id="tableTittle1">新密碼</td>
							<td id="tableValue1"><input id="tableValue1" type="password" name="new_pw"/></td>
					    </tr>
					    <tr>
							<td id="tableTittle2">再次確認新密碼</td>
							<td id="tableValue2"><input id="tableValue2" type="password" name="new_pw_again"/></td>
					    </tr>
				    </table>
				    
				    <input id="tableButton" type="submit" name="send" value="確認送出"/>
				</form>
			    </div>
			    
	        </div>
		</div>
	</body>
</html>

