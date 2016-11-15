<?php

	//http://127.0.0.1:8080/meeting_cloud/web/employee_web/group/group.php?group_id=3
	
	if(!isset($_SESSION))
	{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
//	require_once("../../../login_check.php");
	
	$sql = "select gl.member_id, m.name, gl.group_name
			from group_leader as gl, member as m
			where 
			gl.group_id = '".$_GET['group_id']."' and m.id = gl.member_id";
			
	$result = $conn->query($sql);
	$row = $result->fetch_array();
	$group_id = $_GET['group_id'];
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
		function set_meeting_scheduler()
		{
			set_meeting_scheduler_form.submit();
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
		        			<dt><a href="">會員瀏覽</a></dt>
		        			<dt><a href="">會員資料</a></dt>
		        			<dt><a href="">修改密碼</a></dt>
		        			<dt><a href="">會員管理</a></dt>
							
		        			<dt><a href="">登出</a></dt>
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
												
												$state = "有群組成員";
												for($i=1;$i<=$num_rows;$i++)
												{
													$row=$result->fetch_array();
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
									</script>時
									<select name="hour" onchange="changeDate()">
									<script language="javascript">
										for(i=0;i<=23;i++)
										{document.write('<option value="'+i+'">'+i+'</option>');}
									</script>
								</td>
							</tr>
							<input type="hidden" name="group_id" value="<?php echo $group_id; ?>" />
						</form>
					</table>
					
					<tr>
						<td id="tableTittleCol1" style="border-radius: 4px;">
							<input id="tableButton" type="button" onclick="set_meeting_scheduler();" value="新增會議" style="border-radius: 4px;"/>
						</td>
					</tr>
					
				</div>
				
				<div id="main_sub">
					<p id="conventionTittle">將至會議</p><!--管理員/紀錄-->
					<table id="table">
						<tr>
							<table id="table">
								<tr>
									<td id="tableTittleCol1" style="width:320px">會議標題</td>
									<td id="tableTittleCol2" style="width:110px">日期</td>
									<td id="tableTittleCol1" style="width:70px">時間</td>
									<td id="tableTittleCol2" style="width:100px">召集人</td>
								</tr>
							</table>
						</tr>
						<tr>
							<div style="width:600px; height:125px; overflow:hidden;" >
							<div style="width:615px; height:125px; overflow-y: auto;">
								<table id="table">
									<?php	
									
									$id = "a@";
		
									$scheduler_sql = "select scheduler.*, member.name
											from meeting_scheduler as scheduler, member
											where scheduler.group_id in 
											(select gl.group_id
												FROM group_leader as gl, group_member as gm
												where ( gm.member_id = '".$id."' or gl.member_id = '".$id."' ) and gl.group_id = '".$group_id."'
												group by gl.group_id 
											)
											and member.id = scheduler.moderator_id
											order by scheduler.time desc";
											
									$scheduler_result = $conn->query($scheduler_sql);
								
									if (isset($scheduler_result))
										$num_of_meeting = $scheduler_result->num_rows;	
									else
										$num_of_meeting = 0;
									
									$today = date("Y-m-d");
									$end_meeting = 0;
									if ( $num_of_meeting == 0 )
									{	echo "目前尚未建立關於你的會議群組";	}
									else
									{			
															
										for($i=1 ; $i<=$num_of_meeting ; $i++) 
										{
											$scheduler_row = $scheduler_result->fetch_array();
											$meeting_date = date("Y-m-d", strtotime($scheduler_row['time']));
											$meeting_time = date("H:i", strtotime($scheduler_row['time']));
											
											if ((strtotime($today) - strtotime($meeting_date)) > 0)		//昨天的事
											{	$end_meeting = $i;	break;	}
											$title = $scheduler_row['title'];
											$meeting_id = $scheduler_row['meeting_id'];
											$moderator = $scheduler_row['name'];

											echo "<tr><!--最多五欄-->";
											
											echo "<td id=\"tableValueCol1\" style=\"width:320px\">";
												echo "<a href=\"../meeting/em_meeting_info.php?meeting_id=".$meeting_id."\" style=\"color:#333333;width:auto;line-height:200%;\">".$title."</a> ";
											echo "</td>";
											
											echo "<td id=\"tableValueCol2\" style=\"width:110px\">$meeting_date</td>";
											echo "<td id=\"tableValueCol1\" style=\"width:70px\">$meeting_time</td>";
											echo "<td id=\"tableValueCol2\" style=\"width:100px\">$moderator</td>";
											echo "</tr>";
										}
									}
									?>
									<td id="tableValueCol1" style="width:320px"><form id="6" name="6" method="post" action="../../back_end/em_meeting_start.php"><input type="hidden" name="meeting_id" value="6"/> <a href="" onclick="this.form.submit()" style="color:#333333;width:auto;line-height:200%;">group_b_testing_by_android</a> </form></td><td id="tableValueCol2" style="width:110px">2016-11-30</td><td id="tableValueCol1" style="width:70px">11:00</td><td id="tableValueCol2" style="width:100px">boy</td></tr>
									<td id="tableValueCol1" style="width:320px"><form id="6" name="6" method="post" action="../../back_end/em_meeting_start.php"><input type="hidden" name="meeting_id" value="6"/> <a href="" onclick="this.form.submit()" style="color:#333333;width:auto;line-height:200%;">group_b_testing_by_android</a> </form></td><td id="tableValueCol2" style="width:110px">2016-11-30</td><td id="tableValueCol1" style="width:70px">11:00</td><td id="tableValueCol2" style="width:100px">boy</td></tr>
									<td id="tableValueCol1" style="width:320px"><form id="6" name="6" method="post" action="../../back_end/em_meeting_start.php"><input type="hidden" name="meeting_id" value="6"/> <a href="" onclick="this.form.submit()" style="color:#333333;width:auto;line-height:200%;">group_b_testing_by_android</a> </form></td><td id="tableValueCol2" style="width:110px">2016-11-30</td><td id="tableValueCol1" style="width:70px">11:00</td><td id="tableValueCol2" style="width:100px">boy</td></tr>
									
									<tr></tr>
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
					<p id="conventionTittle">結束會議</p><!--管理員/紀錄-->
				
					<table id="table">
						<tr>
							<table id="table">
								<tr>
									<td id="tableTittleCol1" style="width:320px">會議標題</td>
									<td id="tableTittleCol2" style="width:110px">日期</td>
									<td id="tableTittleCol1" style="width:70px">時間</td>
									<td id="tableTittleCol2" style="width:100px">召集人</td>
								</tr>
							</table>
						</tr>
						<tr>
							<div style="width:600px; height:125px; overflow:hidden;" >
							<?php
							if ($num_of_meeting - $end_meeting >= 3)			//多於4筆資料的話框寬為 620px
								$width = 620;
							else
								$width = 600;
							echo "<div style=\"width:".$width."px; height:125px; overflow-y: auto;\">";
							?>
								<table id="table">
						
								<?php
								if ($end_meeting == 0)
								{	echo "沒有會議記錄";	}
								else
								{				
									for($i=$end_meeting ; $i<=$num_of_meeting ; $i++) 
									{
										if ($i != $end_meeting)	$scheduler_row = $scheduler_result->fetch_array();
										
										$meeting_date = date("Y-m-d", strtotime($scheduler_row['time']));
										$meeting_time = date("H:i", strtotime($scheduler_row['time']));
										
										$title = $scheduler_row['title'];
										$meeting_id = $scheduler_row['meeting_id'];
										$moderator = $scheduler_row['name'];

										echo "<tr><!--最多五欄-->";
										echo "<td id=\"tableValueCol1\" style=\"width:320px\">";
											echo "<form id=\"".$meeting_id."\" name=\"".$meeting_id."\" method=\"post\" action=\"../../back_end/em_meeting_start.php\">";
											echo "<input type=\"hidden\" name=\"meeting_id\" value=\"".$meeting_id."\"/> ";
											echo "<a href=\"\" onclick=\"this.form.submit()\" style=\"color:#333333;width:auto;line-height:200%;\">".$title."</a> ";
											echo "</form>" ;
										echo "</td>";
										
										echo "<td id=\"tableValueCol2\" style=\"width:110px\">$meeting_date</td>";
										echo "<td id=\"tableValueCol1\" style=\"width:70px\">$meeting_time</td>";
										echo "<td id=\"tableValueCol2\" style=\"width:100px\">$moderator</td>";
										echo "</tr>";
									}
								}
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

