<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<link rel="stylesheet" type="text/css" href="main_css/main.css">
        
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        
        <script language="JavaScript" src="main_js/leftBarSlide.js"></script>
        
        <script>
	        function goNewMember()//重新導向到新增會員(會員編輯)
	        {
	        	window.location = "addMemberProfile.php";
	        }
	        
	        function goDeleteMember()//重新導向到刪除會員
	        {
	        	window.location = "http://www.google.com";
	        }
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
	        		
		        	<p id="conventionTittle">會員管理</p>
				
					<table id="table">
						<tr>
							<td id="tableTittleCol1" style="border-radius: 4px;">
								<input id="tableButton" type="button" onclick="goNewMember()" value="新增會員" style="border-radius: 4px;"/>
							</td>
							
							<td id="tableTittleCol2" style="border-radius: 4px;">
								<input id="tableButton" type="button" onclick="goDeleteMember()" value="刪除會員" style="border-radius: 4px;"/>
							</td>
					    </tr>
				    </table>
					
					<table id="table">
						<tr>
							<td id="tableTittleCol1">ID</td>
							<td id="tableTittleCol2">姓名</td>
							<td id="tableTittleCol1">性別</td>
							<td id="tableTittleCol2">連絡電話</td>
							<td id="tableTittleCol1">e-mail</td>
							<td id="tableTittleCol2">身分</td>
					    </tr>
					    
					    
					    <tr>
							<td id="tableValueCol1">0000</td>
							<td id="tableValueCol2"><a href="" style="color:#333333;width:auto;line-height:200%;">水腦勳</a></td>
							<td id="tableValueCol1">男</td>
							<td id="tableValueCol2">(09)32795027</td>
							<td id="tableValueCol1">andyasdjkqwd@gmail.com</td>
							<td id="tableValueCol2">學生</td>
					    </tr>
					    
					    <tr>
							<td id="tableValueCol1">0000</td>
							<td id="tableValueCol2"><a href="" style="color:#333333;width:auto;line-height:200%;">水腦勳</a></td>
							<td id="tableValueCol1">男</td>
							<td id="tableValueCol2">(09)32795027</td>
							<td id="tableValueCol1">andyasdjkqwd@gmail.com</td>
							<td id="tableValueCol2">學生</td>
					    </tr>
					    
					    <tr>
							<td id="tableValueCol1">0000</td>
							<td id="tableValueCol2"><a href="" style="color:#333333;width:auto;line-height:200%;">水腦勳</a></td>
							<td id="tableValueCol1">男</td>
							<td id="tableValueCol2">(09)32795027</td>
							<td id="tableValueCol1">andyasdjkqwd@gmail.com</td>
							<td id="tableValueCol2">學生</td>
					    </tr>
					    
				    </table>

			    </div>
			    
	        </div>
		</div>
	</body>
</html>

