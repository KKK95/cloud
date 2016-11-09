<html xmlns="http://www.w3.org/1999/xhtml">

<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<link rel="stylesheet" type="text/css" href="../main_css/main.css">
        
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		
		<script>
		window.onload = initPage;
		function get_json()
		{
				console.log("click\n");
				MakeRequest();
		}
		function initPage() 
		{
			var subBtn = document.getElementById("sub_btn");
			subBtn.onclick = function () 
			{
				console.log("click\n");
				MakeRequest();
			}
		}
		function MakeRequest() 
		{
			request = createRequest();
			if (request != null) 
			{
				var url = "../../back_end/meeting/get_info/get_meeting_voting_result.php";
				request.open("GET", url, true);
				request.onreadystatechange = displayResult;
				request.send(null);						// 送出請求（由於為 GET 所以參數為 null）
			}
		}
		function displayResult() 
		{
			console.log("displayResult\n");
			if (request.readyState == 4) 				//唯有確定請求已處理完成（readyState 為 4）時，而且 HTTP 回應為 200 OK
			{
				console.log("ready state = 4\n");
				if (request.status == 200) 
				{
					console.log("ready state = 200\n");
					console.log (request.responseText);
					var obj = eval('(' + request.responseText + ')');
					
				//	var obj2 = JSON.parse(request.responseText);
					for(var key in obj)
					{
						console.log (key);
						if (key == "head_issue")
						{
							console.log ( key + " : "); 
							console.log ( obj[key] + "\n");
						}
					}
					var obj_len = obj.contents.obj_voting_issue.head_issue.length;
					var voting;
					for (var i = 0; i < obj_len ; i++ )
					{
						voting = "obj_" + obj.contents.obj_voting_issue.issue_id[i];
						if (obj.contents[voting] != null)
							voting_len = obj.contents[voting].option[0].length;
						else
							voting_len = 0;
						document.getElementById("texta").innerHTML += obj.contents.obj_voting_issue.head_issue[i] + "\r\n";
						for (var j = 0; j < voting_len ; j++ )
						{	
							document.getElementById("texta").innerHTML += j + obj.contents[voting].option[j] + "-----------";
							document.getElementById("texta").innerHTML += obj.contents[voting].result[j] + " 票 \r\n";
						}
					}
					console.log (obj.contents.obj_voting_issue.head_issue[0]);
					
				//	alert ( obj2.test );
				/*	var disp = document.getElementById("disp");
					var txt = document.getElementById('disp').value; //获取textarea的值;      
					document.getElementById("disp").innerHTML += request.responseText + "\r\n";
				*/
				}
			}
		}
		function createRequest() 
		{
			try 
			{
				request = new XMLHttpRequest();
			} catch (tryMS) 
			{
				try 
				{
					request = new ActiveXObject("Msxml2.XMLHTTP");
				} catch (otherMS) 
				{
					try 
					{
						request = new ActiveXObject("Microsoft.XMLHTTP");
					} catch (failed) 
					{
						request = null;
					}
				}
			}
			return request;
		}
		
		setInterval("MakeRequest();", 5000) //每隔一秒發出一次查詢
		</script>
        
        <script language="JavaScript" src="../main_js/leftBarSlide.js"></script>
        
        <title>智會GO</title>
    </head>
	<body>
		
		<textarea id="texta" rows="30" cols="100">
		hihi
		</textarea>
		<input type="button" name="sub_btn" id="sub_btn" value="送出" />
		<input type="button" value="登入" onclick="get_json()"/>
	</body>
</html>