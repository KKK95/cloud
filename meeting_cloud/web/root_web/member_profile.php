<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<link rel="stylesheet" type="text/css" href="main_css/main.css">
		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		
		<script language="JavaScript" src="main_js/leftBarSlide.js"></script>
        
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
		        			<dt><a href="">登出</a></dt>
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
	        		
		        	<p id="conventionTittle">會員資料</p>
				
					<table id="table">
						<tr>
							<td id="tableTittle1">帳號</td>
							<td id="tableValue1"><input id="tableValue1" type="text" name="account"/></td>
					    </tr>
						<tr>
							<td id="tableTittle2">姓名</td>
							<td id="tableValue2"><input id="tableValue2" type="text" name="name"/></td>
					    </tr>
					    <tr>
							<td id="tableTittle1">性別</td>
							<td id="tableValue1"><input id="tableValue1" type="text" name="sex"/></td>
					    </tr>
					    <tr>
							<td id="tableTittle2">連絡電話</td>
							<td id="tableValue2"><input id="tableValue2" type="text" name="phone"/></td>
					    </tr>
					    
					    <tr>
							<td id="tableTittle1">e-mail</td>
							<td id="tableValue1"><input id="tableValue1" type="text" name="mail"/></td>
					    </tr>
					    <tr>
							<td id="tableTittle2">身分</td>
							<td id="tableValue2">
								<input type="radio" name="status"/>學生
								<input type="radio" name="status"/>老師
								<input type="radio" name="status"/>校外人士
								<input type="radio" name="status"/>家長
							</td>
							
					    </tr>
				    </table>
				    
				    <form id="tableButton" action="http://www.google.com"><!--重新導向到會員編輯-->
				    	<input id="tableButton" type="submit" name="send" value="編輯會員資料"/>
				    </form>

			    </div>
			    
	        </div>
		</div>
	</body>
</html>

