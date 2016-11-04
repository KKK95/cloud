<?php
	//127.0.0.1:8080/meeting_cloud/web/index.php
?>
<!DOCTYPE HTML>
<html  xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        
        <script>
			$(document).ready(function(){
			    $("#div1").slideDown("slow");
			});
		</script>
		
		<script>
			function check_data()
			{
				if(document.loginform.id.value.length == 0)
					window.alert("帳號未填寫!");
				else if(document.loginform.pw.value.length == 0)
					window.alert("密碼未填寫!");
				else
					loginform.submit();
			}
		</script>
        
        <link rel="stylesheet" type="text/css" href="web/login_css/login.css">
        
        <title>智會GO</title>
    </head>
    <body>
    	
    	<table id="HEADER_SHADOW" width=100%  border="0" cellpadding="0" cellspacing="0">
		  <tr>
		  
		    <td width=100% height=50px bgcolor="#00AA55">
		  	<p id="HEADER">智會GO</p>
		  	</td>
		  
		  </tr>
		</table>
        
        <div id="div1" style="width:768px;height:300px;display:none;background-color:white;">
		
        	<form name="loginform" method="post" class="login" text-align = "center" action="web_login.php">
        		帳號: <input type="text" name="id" size="20"/>
        		<br><br>
        		密碼: <input type="password" name="pw" size="20"/>
        		<br><br>
				<a href="" target="" title="忘記密碼">忘記密碼</a>
				<a href="" target="" title="申請帳號">申請帳號</a>
				<br><br>
        		<input type="button" value="登入" onclick="check_data()"/>
        		<input type="reset" value="重置" />
        	</form>
			
        </div>
		
    </body>
</html>