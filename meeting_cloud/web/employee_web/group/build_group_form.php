<!-- 127.0.0.1:8080/meeting_cloud/web/employee_web/group/build_group_form.php -->

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<link rel="stylesheet" type="text/css" href="../../main_css/main.css">
		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		
		<script language="JavaScript" src="../../main_js/leftBarSlide.js"></script>
        
		<script>  
			var count = 3;  
			var countMax = 20;  
			var total_member = 0;
			var input_box = count;
			var input_box_id = "member_id";
			
			function addField() 
			{  
				input_box_id = input_box_id + (count - 2);
				if(document.build_group[input_box_id].value.length > 0)
				{
					input_box = ( count + 1 ) % 2;
					if (input_box == 0)
						input_box = 2;
					if(count == countMax)  
						alert("最多"+countMax+"個欄位");  
					else      
						document.getElementById("add_input_box" + count).innerHTML = document.getElementById("add_input_box" + count).innerHTML + 
						'<tr>' + 
						'<td id = "tableTittle' + input_box + '">第 ' + count + ' 位會議群組成員</td>' + 
						'<td id = "tableValue' + input_box + '">' + 
						'<input id="tableValue' + input_box + '" type="text" name="member_id' + count + '" onclick="addField()"/></td>' +
						'</tr>';
					count = count + 1;
				}
				input_box_id = "member_id";
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
							<dt><a href="../employee_center.php">回主頁</a></dt>
		        			<dt><a href="">修改密碼</a></dt>
							<dt><a href="">個人雲端</a></dt>
		        			<dt><a href="../../../logout.php">登出</a></dt>
	        		</dt>
					<dt id="group" class="left">
	        			會議群組
		        			<dt><a href="./group_list.php">會議群組列表</a></dt>
	        		</dt>
	        		<dt id="conventionBar" class="left">
	        			會議專區
		        			<dt><a href="">會議瀏覽</a></dt>
		        			<dt><a href="">會議紀錄</a></dt>
		        			<dt><a href="">會議管理</a></dt>
		        			<dt><a href="">修改請求</a></dt>
	        		</dt>

	        	</dl>
	        	
	        	
	        	<div id="main">
	        		
		        	<p id="conventionTittle">會議群組資料</p>
					<form name="build_group" method="post" action="../../../back_end/group/build_group.php">
					<table id="table">
						<tr>
							<td id="tableTittle1">會議群組名稱</td>
							<td id="tableValue1"><input id="tableValue1" type="text" name="group_name"/></td>
					    </tr>
						<tr>
							<td id="tableTittle2">第 1 位會議群組成員</td>
							<td id="tableValue2"><input id="tableValue2" type="text" name="member_id1" onclick="addField()"/></td>
					    </tr>
						<tr>
							<td id="tableTittle1">第 2 位會議群組成員</td>
							<td id="tableValue1"><input id="tableValue2" type="text" name="member_id2" onclick="addField()"/></td>
					    </tr>
						<tr id = "add_input_box3"></tr>
						<tr id = "add_input_box4"></tr>
						<tr id = "add_input_box5"></tr>
						<tr id = "add_input_box6"></tr>
						<tr id = "add_input_box7"></tr>
						<tr id = "add_input_box8"></tr>
						<tr id = "add_input_box9"></tr>
						<tr id = "add_input_box10"></tr>
				<!--	    <span id="add_input_box"></span>  	-->
				    </table>
				    
				    
				    	<input id="tableButton" type="submit" value="建立群組"/>
				    </form>
				<!--	 	<a href="javascript:" onclick="addField()">新增欄位</a>  	-->
			    </div>
			    
	        </div>
		</div>
	</body>
</html>

