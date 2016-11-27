<?php
	header("Content-Type: text/html; charset=UTF-8");
			
	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("../../login_check.php");
	
	//http://127.0.0.1:8080/meeting_cloud/web/employee_web/employee_center.php
	
	$meeting_time = date("Y-m-d H:i:s");
	//查詢會員有多少會議
	$id = $_SESSION['id'];
	
	$sql = "select scheduler.*, member.name
			from meeting_scheduler as scheduler, member, join_meeting_member as j_m_m
			where scheduler.meeting_id = j_m_m.meeting_id and j_m_m.member_id = '".$id."'
			and member.id = scheduler.moderator_id and scheduler.time > '".$meeting_time."'
			order by scheduler.time";
			
	$result = $conn->query($sql);
?>


<html xmlns="http://www.w3.org/1999/xhtml">

<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<link rel="stylesheet" type="text/css" href="../main_css/main.css">
        
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        
		
		
	<script>
		var meeting_now_list = 0;
		var get_meeting_now_list = 0;
		
		var now_meeting_list = 0;
		var get_meeting_list = 0;
		
		var now_meeting_record_list = 0;
		var get_meeting_record_list = 0;
		
		var obj;
		
		
		function get_meeting_list_request() 					//取得會議id
		{
			request = createRequest();
			if (request != null) 
			{
				var url = '../../back_end/meeting/get_info/get_meeting_list.php';

				request.open("GET", url, true);
				request.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
				request.onreadystatechange = displayResult;		//千萬不能加括號
				request.send(null);								// 送出請求（由於為 GET 所以參數為 null）
			}
		}
		function get_meeting_now_list_request() 					//取得會議id
		{
			request = createRequest();
			if (request != null) 
			{
				var url = '../../back_end/meeting/get_info/get_meeting_running_list.php';

				request.open("GET", url, true);
				request.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
				request.onreadystatechange = displayResult;		//千萬不能加括號
				request.send(null);								// 送出請求（由於為 GET 所以參數為 null）
			}
		}
		function get_meeting_record_list_request() 					//取得會議id
		{
			request = createRequest();
			if (request != null) 
			{
				var url = '../../back_end/meeting/get_info/get_meeting_record_list.php';

				request.open("GET", url, true);
				request.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
				request.onreadystatechange = displayResult;		//千萬不能加括號
				request.send(null);								// 送出請求（由於為 GET 所以參數為 null）
			}
		}
		
		
		function displayResult() 
		{	
			if (request.readyState == 4) 				//唯有確定請求已處理完成（readyState 為 4）時，而且 HTTP 回應為 200 OK
			{
				if (request.status == 200) 
				{
					if (	request.responseText.indexOf("{") != -1	)
					{
						obj = eval('(' + request.responseText + ')');
						
						console.log(request.responseText);
						if ( obj['contents'] && obj.contents['obj_meeting_now_list'] && obj.contents.obj_meeting_now_list != "none")
						{
							get_meeting_now_list = obj.contents.obj_meeting_now_list.topic.length;
							if ( get_meeting_now_list != meeting_now_list)
								update_meeting_now_list();
						}
						if ( obj['contents'] && obj.contents['obj_meeting_list'] && obj.contents.obj_meeting_list != "none")
						{
							get_meeting_list = obj.contents.obj_meeting_list.topic.length;
							if (get_meeting_list != now_meeting_list)
								update_meeting_list();
						}
						if ( obj['contents'] && obj.contents['obj_meeting_record_list'] && obj.contents.obj_meeting_record_list != "none")
						{
							get_meeting_record_list = obj.contents.obj_meeting_record_list.topic.length;
							if (get_meeting_record_list != now_meeting_record_list)
								update_meeting_record_list();
						}
					}
					else	console.log(request.responseText);
						
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
		
		setInterval("get_meeting_now_list_request();", 1000) //每隔一秒發出一次查詢
		setInterval("get_meeting_record_list_request();", 1200) //每隔一秒發出一次查詢
		setInterval("get_meeting_list_request();", 1100) //每隔一秒發出一次查詢
			
		function update_meeting_now_list() 
		{  
			var link = "";
			var topic = "";
			var meeting_date = "";
			var meeting_time = "";
			var moderator = "";
			var link_id = "";
			
			for (var i = 0; i < get_meeting_now_list; i++ )
			{
				
				topic = obj.contents.obj_meeting_now_list.topic[i];
				meeting_date = obj.contents.obj_meeting_now_list.meeting_day[i];
				meeting_time = obj.contents.obj_meeting_now_list.meeting_time[i];
				moderator = obj.contents.obj_meeting_now_list.moderator[i];
				meeting_id = obj.contents.obj_meeting_now_list.meeting_id[i];
				link = './meeting/em_meeting_info.php?meeting_id=' + meeting_id;
				
				document.getElementById("meeting_now_list" + i).innerHTML = 
					'<td id = "tableValueCol1" style="width:320px;">' + 
					'<a style="color:#333333;width:auto;line-height:200%;" href="' + link + '">' + topic + '</a></td>' +
					'<td id="tableValueCol2" style="width:110px;">' + meeting_date + '</td>' +
					'<td id="tableValueCol1" style="width:70px;">' + meeting_time + '</td>' +
					'<td id="tableValueCol2" style="width:100px;">' + moderator + '</td>';
			}
			meeting_now_list = get_meeting_now_list;
		}
		
		function update_meeting_list() 
		{  
			var link = "";
			var topic = "";
			var meeting_date = "";
			var meeting_time = "";
			var moderator = "";
			var link_id = "";
			
			for (var i = 0; i < get_meeting_list; i++ )
			{
				
				topic = obj.contents.obj_meeting_list.topic[i];
				meeting_date = obj.contents.obj_meeting_list.meeting_day[i];
				meeting_time = obj.contents.obj_meeting_list.meeting_time[i];
				moderator = obj.contents.obj_meeting_list.moderator[i];
				meeting_id = obj.contents.obj_meeting_list.meeting_id[i];
				link = './meeting/em_meeting_info.php?meeting_id=' + meeting_id;
				
				document.getElementById("meeting_list" + i).innerHTML = 
					'<td id = "tableValueCol1" style="width:320px;">' + 
					'<a style="color:#333333;width:auto;line-height:200%;" href="' + link + '">' + topic + '</a></td>' +
					'<td id="tableValueCol2" style="width:110px;">' + meeting_date + '</td>' +
					'<td id="tableValueCol1" style="width:70px;">' + meeting_time + '</td>' +
					'<td id="tableValueCol2" style="width:100px;">' + moderator + '</td>';
			}
			now_meeting_list = get_meeting_list;
		}
		
		function update_meeting_record_list() 
		{  
			var link = "";
			var topic = "";
			var meeting_date = "";
			var meeting_time = "";
			var moderator = "";
			var link_id = "";
			
			for (var i = 0; i < get_meeting_record_list; i++ )
			{
				topic = obj.contents.obj_meeting_record_list.topic[i];
				meeting_date = obj.contents.obj_meeting_record_list.meeting_day[i];
				meeting_time = obj.contents.obj_meeting_record_list.meeting_time[i];
				moderator = obj.contents.obj_meeting_record_list.moderator[i];
				meeting_id = obj.contents.obj_meeting_record_list.meeting_id[i];
				link = './meeting/em_meeting_info.php?meeting_id=' + meeting_id;
				
				document.getElementById("meeting_record_list" + i).innerHTML = 
					'<td id = "tableValueCol1" style="width:320px;">' + 
					'<a style="color:#333333;width:auto;line-height:200%;" href="' + link + '">' + topic + '</a></td>' +
					'<td id="tableValueCol2" style="width:110px;">' + meeting_date + '</td>' +
					'<td id="tableValueCol1" style="width:70px;">' + meeting_time + '</td>' +
					'<td id="tableValueCol2" style="width:100px;">' + moderator + '</td>';
			}
			now_meeting_record_list = get_meeting_record_list;
		}
	</script>
		
		
		
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
	        		<dt id="memberBar" class="left">
	        			會員專區
		        			<dt><a href="">修改密碼</a></dt>
							<dt><a href="">個人雲端</a></dt>
		        			<dt><a href="../../../logout.php">登出</a></dt>
	        		</dt>
					<dt id="group" class="left">
	        			會議群組
							<dt><a href="./group/build_group_form.php">建立群組</a></dt>
		        			<dt><a href="./group/group_list.php">會議群組列表</a></dt>
	        		</dt>
	        		<dt id="conventionBar" class="left">
	        			會議專區
		        			<dt><a href="">會議瀏覽</a></dt>
		        			<dt><a href="">會議紀錄</a></dt>
		        			<dt><a href="">會議管理</a></dt>
		        			<dt><a href="">修改請求</a></dt>
	        		</dt>

	        	</dl>
	        	
				
	        	
	        	<div id="main_in_main">
					<div id="main_sub">
			        	<p id="conventionTittle">進行中的會議</p><!--管理員/紀錄-->
					
						<table id="table">
							<tr>
							<table id="table">
								<td id="tableTittleCol1" style="width:335px">會議標題</td>
								<td id="tableTittleCol2" style="width:110px">日期</td>
								<td id="tableTittleCol1" style="width:70px">時間</td>
								<td id="tableTittleCol2" style="width:100px">召集人</td>
							</table>
							</tr>
						    <tr>
							<div style="width:600px; height:125px; overflow:hidden;" >
							<div style="width:615px; height:125px; overflow-y: auto;">
								<table id="table">
								<?php
									$meeting_now_list = 10;
									
									for ( $i = 0; $i < $meeting_now_list ; $i++)
										echo "<tr id=\"meeting_now_list".$i."\"></tr>";
								?>
								</table>
							</div>
							</div>
							</tr>
					    </table>
				    </div>
					
	        		<div id="main_sub">
			        	<p id="conventionTittle">將至會議</p><!--管理員/紀錄-->
					
						<table id="table">
							<tr>
							<table id="table">
								<td id="tableTittleCol1" style="width:335px">會議標題</td>
								<td id="tableTittleCol2" style="width:110px">日期</td>
								<td id="tableTittleCol1" style="width:70px">時間</td>
								<td id="tableTittleCol2" style="width:100px">召集人</td>
							</table>
							</tr>
						    <tr>
							<div style="width:600px; height:125px; overflow:hidden;" >
							<div style="width:615px; height:125px; overflow-y: auto;">
								<table id="table">
								<?php
									$meeting_now_list = 10;
									
									for ( $i = 0; $i < $meeting_now_list ; $i++)
										echo "<tr id=\"meeting_list".$i."\"></tr>";
								?>
								</table>
							</div>
							</div>
							</tr>
					    </table>
				    </div>
				    
				    <div id="main_sub">
			        	<p id="conventionTittle">會議紀錄</p><!--管理員/紀錄-->
					
						<table id="table">
							<tr>
							<table id="table">
								<td id="tableTittleCol1" style="width:335px">會議標題</td>
								<td id="tableTittleCol2" style="width:110px">日期</td>
								<td id="tableTittleCol1" style="width:70px">時間</td>
								<td id="tableTittleCol2" style="width:100px">召集人</td>
							</table>
							</tr>
						    <tr>
							<div style="width:600px; height:125px; overflow:hidden;" >
							<div style="width:615px; height:125px; overflow-y: auto;">
								<table id="table">
								<?php
									$meeting_now_list = 10;
									
									for ( $i = 0; $i < $meeting_now_list ; $i++)
										echo "<tr id=\"meeting_record_list".$i."\"></tr>";
								?>
								</table>
							</div>
							</div>
							</tr>
					    </table>
				    </div>

			    </div>
			    
	        </div>
		</div>
		
		
		
	</body>
</html>

