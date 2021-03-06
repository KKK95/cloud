<?php
	header("Content-Type: text/html; charset=UTF-8");
			
	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("../../login_check.php");
	
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
		var meeting_now_info = 0;
		var get_meeting_now_info = 0;
		
		var obj;
		
		
		function get_meeting_now_info_request() 					//取得會議id
		{
			request = createRequest();
			if (request != null) 
			{
				var url = '../../back_end/meeting/get_info/get_meeting_running_info.php';

				request.open("GET", url, true);
				request.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
				request.onreadystatechange = displayResult;		//千萬不能加括號
				request.send(null);								// 送出請求（由於為 GET 所以參數為 null）
			}
		}
		function displayResult() 
		{	
console.log(request.responseText);
			if (request.readyState == 4) 				//唯有確定請求已處理完成（readyState 為 4）時，而且 HTTP 回應為 200 OK
			{
				if (request.status == 200) 
				{
					if (	request.responseText.indexOf("{") != -1	)
					{
						obj = eval('(' + request.responseText + ')');
						
						console.log(request.responseText);
						if ( obj['contents'] && obj.contents['obj_meeting_now'] && obj.contents.obj_meeting_now != "none")
						{
							get_meeting_now_info = obj.contents.obj_meeting_now.topic.length;
							if (get_meeting_now_info != meeting_now_info)
								update_meeting_now_list();
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
		
		setInterval("get_meeting_now_info_request();", 1000) //每隔一秒發出一次查詢
			
		function update_meeting_now_list() 
		{  
			var link = "";
			var topic = "";
			var meeting_date = "";
			var meeting_time = "";
			var moderator = "";
			
			for (var i = 0; i < get_meeting_now_info; i++ )
			{
				link = obj.contents.obj_meeting_now.meeting_id[i];
				topic = obj.contents.obj_meeting_now.topic[i];
				meeting_date = obj.contents.obj_meeting_now.meeting_day[i];
				meeting_time = obj.contents.obj_meeting_now.meeting_time[i];
				moderator = obj.contents.obj_meeting_now.moderator[i];
				
				document.getElementById("meeting_topic" + i).innerHTML = document.getElementById("meeting_topic" + i).innerHTML + 
					'<td id = "tableValueCol1">' + 
					'<a style="color:#333333;width:auto;line-height:200%;" href="' + link + '">' + topic + '</a></td>' +
					'<td id="tableValueCol2">' + meeting_date + '</td>' +
					'<td id="tableValueCol1">' + meeting_time + '</td>' +
					'<td id="tableValueCol2">' + moderator + '</td>';
			}
			meeting_now_info = get_meeting_now_info;
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
		        			<dt><a href="">會員瀏覽</a></dt>
		        			<dt><a href="">會員資料</a></dt>
		        			<dt><a href="">修改密碼</a></dt>
		        			<dt><a href="">會員管理</a></dt>
							
		        			<dt><a href="">登出</a></dt>
	        		</dt>
					<dt id="group" class="left">
	        			會議群組
		        			<dt><a href="./group/group_list.php">會議群組列表</a></dt>
	        		</dt>
	        		<dt id="conventionBar" class="left">
	        			會議專區
		        			<dt><a href="">會議瀏覽</a></dt>
		        			<dt><a href="">會議紀錄</a></dt>
		        			<dt><a href="">會議管理</a></dt>
		        			<dt><a href="">修改請求</a></dt>
	        		</dt>
					<dt id="cloud" class="left">
	        			雲端專區
		        			<dt><a href="">個人雲端</a></dt>
							<dt><a href="">群組雲端</a></dt>
	        		</dt>
					<dt id="talk" class="left">
	        			討論區
		        			<dt><a href="">會議聊天室</a></dt>
							<dt><a href="">會議紀錄</a></dt>
	        		</dt>
	        	</dl>
	        	
				
	        	
	        	<div id="main_in_main">
					<div id="main_sub">
			        	<p id="conventionTittle">進行中的會議</p><!--管理員/紀錄-->
					
						<table id="table">
							<tr>
							<table id="table">
								<td id="tableTittleCol1" style="width:320px">會議標題</td>
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
										echo "<tr id=\"meeting_topic".$i."\"></tr>";
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
								<td id="tableTittleCol1">會議標題</td>
								<td id="tableTittleCol2">日期</td>
								<td id="tableTittleCol1">時間</td>
								<td id="tableTittleCol2">召集人</td>
						    </tr>
						    
							<?php	
								if (isset($result))
									$num_rows = $result->num_rows;	
								else
									$num_rows = 0;
								
							if ( $num_rows == 0 )
							{	echo "目前尚未建立關於你的會議群組";	}
							else
							{			
							
								for($i=1 ; $i <= $num_rows ; $i++) 
								{
									$row=$result->fetch_array();
									$meeting_date = date("Y-m-d", strtotime($row['time']));
									$meeting_time = date("H:i", strtotime($row['time']));
									
									$title = $row['title'];
									$meeting_id = $row['meeting_id'];
									$moderator = $row['name'];

									echo "<tr><!--最多五欄-->";
									
									echo "<td>";
									echo "<a style=\"color:#333333;width:auto;line-height:200%;\" 
											href=\"./meeting/em_meeting_info.php?meeting_id=".$meeting_id."\">".$title."</a> ";					
									echo "</td>";
									
									echo "<td id=\"tableValueCol2\">$meeting_date</td>";
									echo "<td id=\"tableValueCol1\">$meeting_time</td>";
									echo "<td id=\"tableValueCol2\">$moderator</td>";
									echo "</tr>";
								}
							}
						    ?>
					    </table>
				    </div>
				    
				    <div id="main_sub">
					    <p id="conventionTittle">結束會議</p><!--管理員/紀錄-->
					
						<table id="table">
							<tr>
								<td id="tableTittleCol1">會議標題</td>
								<td id="tableTittleCol2">日期</td>
								<td id="tableTittleCol1">時間</td>
								<td id="tableTittleCol2">召集人</td>
						    </tr>
						    
						    <?php
								$meeting_time = date("Y-m-d H:i:s");
							
								$sql = "select scheduler.*, member.name
										from meeting_scheduler as scheduler, member, join_meeting_member as j_m_m
										where scheduler.meeting_id = j_m_m.meeting_id and j_m_m.member_id = '".$id."'
										and member.id = scheduler.moderator_id and scheduler.time < '".$meeting_time."'
										order by scheduler.time desc";
										
								$result = $conn->query($sql);
							
							if (isset($result))
								$num_rows = $result->num_rows;	
							else
								$num_rows = 0;
								
							if ( $num_rows == 0 )
							{	echo "目前尚未建立關於你的會議群組";	}
							else
							{			
								for($i=1 ; $i<=$num_rows ; $i++) 
								{
									$row=$result->fetch_array();
									
									$meeting_date = date("Y-m-d", strtotime($row['time']));
									$meeting_time = date("H:i", strtotime($row['time']));
									
									$title = $row['title'];
									$meeting_id = $row['meeting_id'];
									$moderator = $row['name'];

									echo "<tr><!--最多五欄-->";

									echo "<td>";
									echo "<a style=\"color:#333333;width:auto;line-height:200%;\" 
											href=\"./meeting/em_meeting_info.php?meeting_id=".$meeting_id."\">".$title."</a> ";					
									echo "</td>";
									
									echo "<td id=\"tableValueCol2\">$meeting_date</td>";
									echo "<td id=\"tableValueCol1\">$meeting_time</td>";
									echo "<td id=\"tableValueCol2\">$moderator</td>";
									echo "</tr>";
								}
							}
						    ?>
						    
					    </table>
				    </div>

			    </div>
			    
	        </div>
		</div>
		
		
		
	</body>
</html>

