<?php

	//http://127.0.0.1:8080/meeting_cloud/web/employee_web/group/group.php?group_id=3
	
	if(!isset($_SESSION))
	{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
//	require_once("../../../login_check.php");
	
	if (isset($_SESSION['id']))
		$id = $_SESSION['id'];
	else
		$id = 'a@';
	
	$group_id = $_GET['group_id'];
	
	$sql = "select * from member
			where member.id in
			(
				select gl.member_id from group_leader as gl 
				where gl.group_id = '".$group_id."' 
			) and member.id = '".$id."'";
	$result = $conn->query($sql);
	$in_group = $result->num_rows;
	
	$sql = "select * from member
			where member.id in
			(
				select gm.member_id from group_member as gm 
				where gm.group_id = '".$group_id."'
			) and member.id = '".$id."'";
	$result = $conn->query($sql);
	$in_group = $result->num_rows + $in_group;
	if ($in_group != 1)
		header("Location: ../employee_center.php" );
	
	
	$sql = "select gl.member_id, m.name, gl.group_name
			from group_leader as gl, member as m
			where 
			gl.group_id = '".$_GET['group_id']."' and m.id = gl.member_id";
			
	$result = $conn->query($sql);
	$row = $result->fetch_array();
	$leader_id = $row['member_id'];
	$leader_name = $row['name'];					//先抓出群組中的隊長
	$group_name = $row['group_name'];
	
	$sql = "select m.id, m.name, m.mail
			from group_member as gm, member as m, group_leader as gl
			where 
			gm.group_id = '".$group_id."'
			and (gm.member_id = m.id or gl.member_id = m.id)
			and gl.group_id = gm.group_id
			group by m.id";

	$result=$conn->query($sql);						//再抓出群組中的成員
	$num_rows = $result->num_rows;
	
?>


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link rel="stylesheet" type="text/css" href="../../main_css/main.css">
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	
	<script language="JavaScript" src="../../main_js/leftBarSlide.js"></script>
	
	<script>
		
		function invite_member()
		{
			invite_member_form.submit();
		}

		var group_id = <?php echo $group_id; ?>;
		
		var meeting_now_list = 0;
		var get_meeting_now_list = 0;
		
		var now_meeting_list = 0;
		var get_meeting_list = 0;
		
		var now_meeting_record_list = 0;
		var get_meeting_record_list = 0;
		
		var obj;
		var go_back = '../../../';
		
		function get_meeting_list_request() 					//取得會議id
		{
			request = createRequest();
			if (request != null) 
			{
				var url = go_back + 'back_end/meeting/get_info/get_meeting_list.php?group_id=' + group_id;

				request.open("GET", url, true);
				request.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
				request.onreadystatechange = displayResult;		//千萬不能加括號
				request.send(null);								// 送出請求（由於為 GET 所以參數為 null）
			}
		}

		function update_meeting_list() 
		{  
			var link = "";
			var topic = "";
			var meeting_date = "";
			var meeting_time = "";
			var moderator = "";
			var meeting_id = "";
			
			for (var i = 0; i < get_meeting_list; i++ )
			{
				
				topic = obj.contents.obj_meeting_list.topic[i];
				meeting_date = obj.contents.obj_meeting_list.meeting_day[i];
				meeting_time = obj.contents.obj_meeting_list.meeting_time[i];
				moderator = obj.contents.obj_meeting_list.moderator[i];
				meeting_id = obj.contents.obj_meeting_list.meeting_id[i];
				link = '../meeting/em_meeting_info.php?meeting_id=' + meeting_id;
				
				document.getElementById("meeting_list" + i).innerHTML = document.getElementById("meeting_list" + i).innerHTML + 
					'<td id = "tableValueCol1" style="width:320px;">' + 
					'<a style="color:#333333;width:auto;line-height:200%;" href="' + link + '">' + topic + '</a></td>' +
					'<td id="tableValueCol2" style="width:110px;">' + meeting_date + '</td>' +
					'<td id="tableValueCol1" style="width:70px;">' + meeting_time + '</td>' +
					'<td id="tableValueCol2" style="width:100px;">' + moderator + '</td>';
			}
			now_meeting_list = get_meeting_list;
		}
		
		setInterval("get_meeting_record_list_request();", 1200) 
		setInterval("get_meeting_list_request();", 1100) 
		
		function get_meeting_record_list_request() 					//取得會議id
		{
			console.log("fuck you");
			request = createRequest();
			if (request != null) 
			{
				var url = go_back + 'back_end/meeting/get_info/get_meeting_record_list.php?group_id=' + group_id;

				request.open("GET", url, true);
				request.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
				request.onreadystatechange = displayResult;		//千萬不能加括號
				request.send(null);								// 送出請求（由於為 GET 所以參數為 null）
			}
		}
		
		function update_meeting_record_list() 
		{  
			var link = "";
			var topic = "";
			var meeting_date = "";
			var meeting_time = "";
			var moderator = "";
			var meeting_id = "";
			
			for (var i = 0; i < get_meeting_record_list; i++ )
			{
				topic = obj.contents.obj_meeting_record_list.topic[i];
				meeting_date = obj.contents.obj_meeting_record_list.meeting_day[i];
				meeting_time = obj.contents.obj_meeting_record_list.meeting_time[i];
				moderator = obj.contents.obj_meeting_record_list.moderator[i];
				meeting_id = obj.contents.obj_meeting_record_list.meeting_id[i];
				link = '../meeting/meeting_record.php?state=group&meeting_id=' + meeting_id;
				
				document.getElementById("meeting_record_list" + i).innerHTML = document.getElementById("meeting_record_list" + i).innerHTML + 
					'<td id = "tableValueCol1" style="width:320px;">' + 
					'<a style="color:#333333;width:auto;line-height:200%;" href="' + link + '">' + topic + '</a></td>' +
					'<td id="tableValueCol2" style="width:110px;">' + meeting_date + '</td>' +
					'<td id="tableValueCol1" style="width:70px;">' + meeting_time + '</td>' +
					'<td id="tableValueCol2" style="width:100px;">' + moderator + '</td>';
			}
			now_meeting_record_list = get_meeting_record_list;
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
						if ( obj['contents'] && obj.contents['obj_meeting_list'] && obj.contents.obj_meeting_list != "none")
						{
							get_meeting_list = obj.contents.obj_meeting_list.topic.length;
							if (get_meeting_list != now_meeting_list)
								update_meeting_list();
						}
						else if ( obj['contents'] && obj.contents['obj_meeting_record_list'] && obj.contents.obj_meeting_record_list != "none")
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
							<dt><a href="./build_group_form.php">建立群組</a></dt>
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
			</dl>
			
			
			<div id="main_in_main">
				<?php
					echo "<p id=\"conventionTittle\">群組 - ".$group_name."</p>"
				?>
				<div id="main_sub">
	        		
		        	<p id="conventionTittle">創立會議</p>
					<table id="table">
						<form name="set_meeting_scheduler_form" method="post" action="../../../back_end/meeting/set_info/set_meeting_scheduler.php">
							<tr>
								<td id="tableTittle1">會議名稱</td>
								<td id="tableValue1"><input id="tableValue1" type="text" name="meeting_title"/></td>
							</tr>
							<tr>
								<td id="tableTittle1">會議主席</td>
								<td id="tableValue1">
									<select name="moderator_id">
										<?php
										
											if ($num_rows==0)
											{	$state = "";	}	
											else
											{	
												for( $i = 1; $i <= $num_rows; $i++ )
												{
													$row = $result->fetch_array();
													echo "<option value=\"".$row['id']."\">".$row['name']."</option>";
												}
											}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td id="tableTittle1">會議記錄</td>
								<td id="tableValue1">
									<select name="minutes_taker_id">
										<?php
											$sql = "select m.id, m.name, m.mail
													from group_member as gm, member as m, group_leader as gl
													where 
													gm.group_id = '".$group_id."'
													and (gm.member_id = m.id or gl.member_id = m.id)
													and gl.group_id = gm.group_id
													group by m.id";

											$result=$conn->query($sql);						//再抓出群組中的成員
											$num_rows = $result->num_rows;
											if ($num_rows==0)
											{	$state = "";	}	
											else
											{	
												for( $i = 1; $i <= $num_rows; $i++ )
												{
													$row = $result->fetch_array();
													echo "<option value=\"".$row['id']."\">".$row['name']."</option>";
												}
											}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td id="tableTittle2">會議創立日期</td>
								<td id="tableValue2">
									<select name="year" size="1" onchange="changeDate()">
									<script language="javascript">  
										for(i=2016;i<2018;i++)
										{document.write('<option value="'+i+'">'+i+'</option>');}
									</script>
									</select>年
									<select name="month" onchange="changeDate()">
									<script language="javascript">
										for(i=1;i<=12;i++)
										{document.write('<option value="'+i+'">'+i+'</option>');}
									</script>
									</select>月
									<select name="day" onchange="changeDate()">
									<script language="javascript">
										for(i=1;i<=31;i++)
										{document.write('<option value="'+i+'">'+i+'</option>');}
									</script>
									</select>日
									<script language="javascript">
									function changeDate()
									{
										var UserIndex = document.update.day.selectedIndex+1;
										var TempDate = new Array(31,28,31,30,31,30,31,31,30,31,30,31);
										if ((document.update.year.selectedIndex % 4 == 0 && document.update.year.selectedIndex % 100 != 0) || document.update.year.selectedIndex % 400 == 0)
										{TempDate[1]++;}
										if(document.update.day.options.length!=TempDate[document.update.month.selectedIndex])
										{
											var TempStr = '<select size="1" name="day">';
											for(i=1;i<=TempDate[document.update.month.selectedIndex];i++)
											{
												TempStr+='<option value="'+i+'"';
												if(i==UserIndex){TempStr+=' selected';}
												TempStr+='>'+i+'</option>';
											}
											document.update.day.outerHTML=TempStr+'</select>';
										}
									}
									</script>
									<select name="hour" onchange="changeDate()">
										<script language="javascript">
											for( i = 0; i <= 23; i++)
											{document.write('<option value="' + i + '">' + i + '</option>');}
										</script>
									</select>時
								</td>
							</tr>
							<input type="hidden" name="group_id" value="<?php echo $group_id; ?>" />
						</form>
					</table>
					
					<tr>
						<td id="tableTittleCol1" style="border-radius: 4px;">
							<input id="tableButton" type="button" name="set_meeting_scheduler" onclick="set_meeting_scheduler_form.submit()" value="新增會議" style="border-radius: 4px;" />
						</td>
					</tr>
					
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
					<p id="conventionTittle">會員管理</p>
					<table id="table">
						<tr>
							<table id="table">
								<tr>
									<td id="tableTittleCol1" style="width:150px">姓名</td>
									<td id="tableTittleCol1" style="width:150px">職位</td>
									<td id="tableTittleCol2" style="width:300px">e-mail</td>
								</tr>
							</table>
						</tr>
						<tr>
							<div style="width:600px; height:125px; overflow:hidden;" >
							<div style="width:620px; height:125px; overflow-y: auto;">
								<table id="table">
									<?php    
										
										$sql = "select m.id, m.name, m.mail
												from group_member as gm, member as m, group_leader as gl
												where 
												gm.group_id = '".$group_id."'
												and (gm.member_id = m.id or gl.member_id = m.id)
												and gl.group_id = gm.group_id
												group by m.id";

										$result=$conn->query($sql);						//再抓出群組中的成員
										$num_rows = $result->num_rows;
										
										if ($num_rows==0)
										{	$state = "";	}	
										else
										{	
					/*						if ($leader_id == $_SESSION["id"]){};						*/
											$state = "有群組成員";
											for($i=1;$i<=$num_rows;$i++)
											{
												$row=$result->fetch_array();
												$mail = "none";
											/*
												if ($row['mail'] == null)	$mail = "none";
												else	$mail = $row['mail'];
											*/
												echo "<tr>
														<td id=\"tableValueCol1\" style=\"width:150px\">".$row['name']."</td>
														<td id=\"tableValueCol2\" style=\"width:150px\">".$mail."</td>
														<td id=\"tableValueCol1\" style=\"width:300px\">none</td>
													</tr>";
												
												
											}
										}
									?>    
									<tr></tr>
								</table>
							</div>
							</div>
						</tr>
						<tr>
							<table id="table">
								<tr>
									<td id="tableTittle1">新增會員到此群組</td>
									<?php
										echo "<form name=\"invite_member_form\" method=\"post\"
												action=\"../../../back_end/group/add_member_to_group.php\">";
									?>
									<input id="tableValue1" type="hidden" name="group_id" value="<?php echo $group_id;	?>"/>
									<td id="tableValueCol1"><input id="tableValue1" type="text" name="member" /></td>
									
									</form>
								</tr>
							</table>
							<input id="tableButton" type="submit" value="確認送出" onclick="invite_member();"/>
							
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

