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
					<dt id="cloud" class="left">
	        			雲端專區
	        			<dl id = "cloud" style="margin:0;width:150px;display:none;">
		        			<dt><a href="">資料列表-群組</a></dt>
							<dt><a href="">資料列表-個人</a></dt>
		        		</dl>
	        		</dt>
					<dt id="talk" class="left">
	        			討論區
	        			<dl id = "talk" style="margin:0;width:150px;display:none;">
		        			<dt><a href="">會議聊天室</a></dt>
							<dt><a href="">會議紀錄</a></dt>
		        		</dl>
	        		</dt>
					<dt id="group" class="left">
	        			會議群組
	        			<dl id = "group" style="margin:0;width:150px;display:none;">
		        			<dt><a href="">會議群組列表</a></dt>
							<dt><a href="">會議群組管理</a></dt>
							<dt><a href="">會議成員列表</a></dt>
							<dt><a href="">會議成員管理</a></dt>
		        		</dl>
	        		</dt>
					<dt id="write" class="left">
	        			會議簽名
	        			<dl id = "write" style="margin:0;width:150px;display:none;">
		        			<dt><a href="">會議簽到表</a></dt>
							<dt><a href="">會議投票</a></dt>
							<dt><a href="">會議投票結果表</a></dt>
		        		</dl>
	        		</dt>
	        	</dl>
	        	
	        	
	        	<div id="main">
	        		
		        	<p id="conventionTittle">會議資訊</p>
				
					<table id="table">
						<tr>
							<td id="tableTittle1">會議編號</td>
							<td id="tableValue1"><input id="tableValue1" type="text" name="name"/></td>
					    </tr>
						<tr>
							<td id="tableTittle2">會議名稱</td>
							<td id="tableValue2"><input id="tableValue2" type="text" name="date"/></td>
					    </tr>
					    <tr>
							<td id="tableTittle1">會議日期</td>
							<td id="tableValue1"><input id="tableValue1" type="text" name="people"/></td>
					    </tr>
						 <tr>
							<td id="tableTittle2">下載資料</td>
							<td id="tableValue2"><input id="tableValue2" type="text" name="download"/></td>
					    </tr>
						
						
						
				    </table>
					
					<input id="tableButton" type="submit" name="send-2" value="會議議題"/>
				    <input id="tableButton" type="submit" name="send" value="返回選單"/>
					

			    </div>
				
				
				
			    
	        </div>
			
		</div>
		<div id = "right table">
		<dl style="margin:0;width:10%;float:right;">
			<table align=right border=1>
			
			<tr>
			<td id="tableTittle1">到場人</td>
			</tr>
			<tr bgcolor="white">
			<td height="200px">存到場人用</td>
			</tr>
			<tr>
			<td id="tableTittle1">未到場人</td>
			</tr>
			<tr bgcolor="white">
			<td height="200px">存未到場人用</td>
			</tr>
			
			</table>
		</div>
	</body>
</html>

