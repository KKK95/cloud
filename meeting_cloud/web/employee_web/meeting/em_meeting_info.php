<?php

	//http://127.0.0.1:8080/meeting_cloud/web/employee_web/meeting/em_meeting_info.php?meeting_id=4
	
	if(!isset($_SESSION))
	{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
//	require_once("../../../login_check.php");
	
	$meeting_id = $_GET['meeting_id'];
	
	if (isset($_SESSION["id"]))
		$id = $_SESSION["id"];
	else
		$id = "a@";
	
	$sql = "select * from join_meeting_member where meeting_id = '".$meeting_id."' and member_id = '".$id."'";
	$result = $conn->query($sql);
	$join_meeting = $result->num_rows;
	if ($join_meeting != 1)
		header("Location: ../employee_center.php" );
	
	$sql = "select * from meeting_scheduler where meeting_id = '".$meeting_id."'";
	$result = $conn->query($sql);
	$row = $result->fetch_array();
	$meeting_title = $row['title'];
	$group_id = $row['group_id'];
	$over = $row['over'];
	$moderator_id = $row['moderator_id'];
	$minutes_taker_id = $row['minutes_taker_id'];
	$time = $row['time'];
	$year = date("Y", strtotime($time));
	$month = date("m", strtotime($time));
	$day = date("d", strtotime($time));
	$hour = date("H", strtotime($time));

?>


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link rel="stylesheet" type="text/css" href="../../main_css/main.css">
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	
	<script language="JavaScript" src="../../main_js/leftBarSlide.js"></script>
	
	<script>
		var now_num_of_meeting_topic = 0;
		var get_num_of_meeting_topic = 0;
		
		var now_num_of_doc = 0;
		var get_num_of_doc = 0;
		
		var obj;
		
		var meeting_id = <?php echo $meeting_id; ?>
		
		function set_topic() 
		{
			set_topic_request = createRequest();
			if (set_topic_request != null) 
			{

				var url = '../../../back_end/meeting/set_info/set_meeting_topic.php?meeting_id=' + meeting_id ;

				console.log(url);
				set_topic_request.open("POST", url, true);
				set_topic_request.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
				set_topic_request.send("topic=" + document.set_new_topic_form.topic.value);						// 送出請求（由於為 GET 所以參數為 null）
				document.set_new_topic_form.topic.value = "";
				request.onreadystatechange = displayResult;
			}
		}
		
		
		function get_meeting_info_request() 					//取得會議id
		{
			request = createRequest();
			if (request != null) 
			{
				var url = '../../../back_end/meeting/get_info/get_meeting_info.php?meeting_id=' + meeting_id ;

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
						if ( obj['contents'] && obj.contents['obj_meeting_topic'] && obj.contents.obj_meeting_topic != "none")
						{
							
							get_num_of_meeting_topic = obj.contents.obj_meeting_topic.topic.length;
							if (get_num_of_meeting_topic != now_num_of_meeting_topic)
								add_new_topic();
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
		
		setInterval("get_meeting_info_request();", 1000) //每隔一秒發出一次查詢
			
		function add_new_topic() 
		{  

			var count = now_num_of_meeting_topic;
			var meeting_topic_row = 0;
			var topic = 0;
			
			for (var i = now_num_of_meeting_topic; i < get_num_of_meeting_topic; i++ )
			{
				count = count + 1;
				meeting_topic_row = count % 2;
				topic_id = obj.contents.obj_meeting_topic.topic_id[i];
				
				if (meeting_topic_row == 0)	meeting_topic_row = 2;
				
				document.getElementById("meeting_topic" + count).innerHTML = 
					'<td id = "tableValueCol1' + meeting_topic_row + '">' + 
					'<a href = "./em_meeting_topic.php?meeting_id=' + meeting_id + '&topic_id=' + topic_id + '" ' + 
					'style = "color:#333333;width:auto;line-height:200%;">' +
					obj.contents.obj_meeting_topic.topic[i] + 
					'</a></td>';
				
				
			}
			now_num_of_meeting_topic = get_num_of_meeting_topic;
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
					會議資訊 <?php echo $id; ?>
						
						<dt><a href="em_meeting_info.php?meeting_id=<?php echo $meeting_id; ?>">會議議題</a></dt>
						<dt><a href="em_meeting_info_doc.php?meeting_id=<?php echo $meeting_id; ?>">會議文件</a></dt>
						<dt><a href="em_meeting_info_member_list.php?meeting_id=<?php echo $meeting_id; ?>">與會者名單</a></dt>
						<dt><a href="../group/group.php?group_id=<?php echo $group_id; ?>">返回群組</a></dt>
						<dt><a href="">登出</a></dt>
				</dt>
				<?php
				
				$meeting_record_sql = "select record.*, scheduler.title ".
									  "from meeting_record as record, meeting_scheduler as scheduler ".
									  "where record.group_id = '".$group_id."' and record.meeting_id = scheduler.meeting_id ".
									  "and scheduler.over = 1";
									  
				$meeting_record_result = $conn->query($meeting_record_sql);
				
				$num_of_meeting_record = $meeting_record_result->num_rows;
				
				for ( $i = 1; $i <= $num_of_meeting_record; $i++)
				{
					if ($i == 1)
						echo '<dt id="memberBar" class="left">'.'過往記錄';
					$meeting_record_row = $meeting_record_result->fetch_array();
					$record_id = $meeting_record_row['meeting_id'];
					$record_title = $meeting_record_row['title'];
					echo	'<dt><a href="../meeting_record.php?meeting_id='.$record_id.'&state=meeting_now&meeting_now_id='.$meeting_id.'">'.
							$record_title.'</a></dt>';
					
					if ($i == $num_of_meeting_record)
						echo '</dt>';

				}
				
				?>
			</dl>
			
			
			<div id="main_in_main">
				<?php
					echo "<p id=\"conventionTittle\">會議 - ".$meeting_title."</p>"
				?>
				
				<?php
					$sql = "select * from group_meeting_now where meeting_id = '".$meeting_id."'";

					$result = $conn->query($sql);						//再抓出群組中的成員
					$num_rows = $result->num_rows;
				
					if ( $num_rows == 0 && ( $moderator_id == $id || $minutes_taker_id == $id ) )
					{
						$sql = "select m.id, m.name, m.mail
								from group_member as gm, member as m, group_leader as gl
								where 
								gm.group_id = '".$group_id."'
								and (gm.member_id = m.id or gl.member_id = m.id)
								and gl.group_id = gm.group_id
								group by m.id";

						$result=$conn->query($sql);						//再抓出群組中的成員
						$num_rows = $result->num_rows;
						
						echo	'<div id="main_sub">'.
							
								'<p id="conventionTittle">更改會議資訊</p>'.
								'<table id="table">'.
								'<form name="update_meeting_scheduler_form" method="post" action="../../../back_end/meeting/update_info/update_meeting_scheduler.php">'.
									'<tr>'.
										'<td id="tableTittle1">會議名稱</td>'.
										'<td id="tableValue1"><input id="tableValue1" type="text" name="meeting_title" value="'.$meeting_title.'"/></td>'.
									'</tr>'.
									'<tr>'.
										'<td id="tableTittle1">會議主席</td>'.
										'<td id="tableValue1">'.
											'<select name="moderator_id">';
												
								if ($num_rows==0)
								{	$state = "";	}	
								else
								{	
									for( $i = 1; $i <= $num_rows; $i++ )
									{
										$row = $result->fetch_array();
										if ($row['id'] == $moderator_id)
											echo '<option value="'.$row['id'].'" selected="selected">'.$row['name'].'</option>';
										else
											echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
									}
								}

						echo				'</select>'.
										'</td>'.
									'</tr>'.
									'<tr>'.
										'<td id="tableTittle1">會議記錄人</td>'.
										'<td id="tableValue1">'.
											'<select name="minutes_taker_id">';

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
										if ($row['id'] == $minutes_taker_id )
											echo '<option value="'.$row['id'].'" selected="selected">'.$row['name'].'</option>';
										else
											echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
									}
								}

						echo				'</select>'.
										'</td>'.
									'</tr>'.
									'<tr>'.
										'<td id="tableTittle2">會議創立日期</td>'.
										'<td id="tableValue2">'.
											'<select name="year" size="1" >';
											for($i = 2016; $i <= 2018; $i++)
											{
												if ( (int)$year == $i)
													echo	'<option value="'.$i.'" selected="selected">'.$i.'</option>';
												else
													echo	'<option value="'.$i.'" >'.$i.'</option>';
											}

						echo				'</select>年'.
											'<select name="month" >';
											for($i = 1; $i <= 12; $i++)
											{
												if ( (int)$month == $i)
													echo	'<option value="'.$i.'" selected="selected">'.$i.'</option>';
												else
													echo	'<option value="'.$i.'" >'.$i.'</option>';
											}
						echo				'</select>月'.
											'<select name="day" >';
											for($i = 1; $i <= 31; $i++)
											{
												if ( (int)$day == $i)
													echo	'<option value="'.$i.'" selected="selected">'.$i.'</option>';
												else
													echo	'<option value="'.$i.'" >'.$i.'</option>';
											}
						echo				'</select>日'.
											'<select name="hour" >';
												for($i = 1; $i <= 31; $i++)
												{
													if ( (int)$hour == $i)
														echo	'<option value="'.$i.'" selected="selected">'.$i.'</option>';
													else
														echo	'<option value="'.$i.'" >'.$i.'</option>';
												}
						echo				'</select>時'.
										'</td>'.
									'</tr>'.
									'<input type="hidden" name="meeting_id" value="'.$meeting_id.'" />'.
								'</form>'.
							'</table>'.
							
							'<tr>'.
								'<td id="tableTittleCol1" style="border-radius: 4px;">'.
									'<input id="tableButton" type="button" name="update_meeting_scheduler" onclick="update_meeting_scheduler_form.submit()" value="修改" style="border-radius: 4px;" />'.
								'</td>'.
							'</tr>'.
							
						'</div>';
					}
				?>
<!-- ==================================================================================================================================== -->
				
				<div id="main_sub">
					<p id="conventionTittle">會議議題</p>
					<table id="table">
						<tr>
							<table id="table">
								<tr>
									<td id="tableTittleCol1" > </td>
								</tr>
							</table>
						</tr>
						<tr>
							<div style="width:600px; height:200px; overflow:hidden;">
							<div style="width:620px; height:200px; overflow-y: auto;">
								<table id="table">
								
								
								
									<?php    
										$num_of_meeting_topic = 30;
										for ($i =1; $i<=$num_of_meeting_topic; $i++)
											echo "<tr id = \"meeting_topic".$i."\"></tr>";
									?>    
									
									
									<tr></tr>
								</table>
							</div>
							</div>
						</tr>
						<?php
							if ($over != 1)
							{
								echo "<tr>".
										"<table id=\"table\">".
											"<tr>".
												"<td id=\"tableTittle1\">新增會議議題</td>".
												"<form name = \"set_new_topic_form\" >".
													"<td id=\"tableValueCol1\"><textarea name=\"topic\" cols=\"50\" rows=\"3\"></textarea></td>".
												"</form>".
											"</tr>".
										"</table>".
										"<input id=\"tableButton\" name=\"set_new_topic\" type=\"submit\" value=\"確認送出\" onclick=\"set_topic();\"/>".
									"</tr>";
							}
						?>
					</table>
				</div>
				
				<?php
					if ($over != 1)
					{
						echo "<table id=\"table\">".
									"<tr>".
										"<td id=\"tableTittleCol2\" style=\"border-radius: 4px;\">".
											"<input id=\"tableButton\" type=\"button\"".
											" onclick=\"self.location.href='../../../back_end/em_meeting_start.php?meeting_id=".$meeting_id."'\"".
											" value=\"會議開始\" style=\"border-radius: 4px;\"/>".
										"</td>".
									"</tr>".
							"</table>";
					}
				?>
			</div>
			
		</div>
	</div>
</body>
</html>

