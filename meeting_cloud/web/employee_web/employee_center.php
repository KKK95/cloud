<?php
	header("Content-Type: text/html; charset=UTF-8");
			
	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("../back_end/login_check.php");
	
	//查詢會員有多少會議
	$id = $_SESSION['id'];
	
	$sql = "select scheduler.*, member.name
			from meeting_scheduler as scheduler, member
			where scheduler.group_id in 
			(select gl.group_id
				FROM group_leader as gl, group_member as gm
				where gm.member_id = '".$id."' or gl.member_id = '".$id."'
                group by gl.group_id
			)
			and member.id = scheduler.moderator_id
            order by scheduler.time desc";
			
	$result = $conn->query($sql);
?>


<html xmlns="http://www.w3.org/1999/xhtml">

<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<link rel="stylesheet" type="text/css" href="../main_css/main.css">
        
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        
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
	        		<dt id="member_Bar" class="left">
	        			會員專區
	        			<dt id = "member_SubBar" style="margin:0;width:150px;display:none;">
							<dt><a href="./group/build_group_form.php">建立會議群組</a></dt>
		        			<dt><a href="">會員瀏覽</a></dt>
		        			<dt><a href="">會員資料</a></dt>
		        			<dt><a href="em_update_pw.php">修改密碼</a></dt>
							<dt><a href="">我的雲端空間</a></dt>
		        			<dt><a href="../../logout.php">登出</a></dt>
	        			</dt>
	        		</dt>
	        		<dt id="meeting_Bar" class="left">
	        			會議專區
	        			<dt id = "meeting_SubBar" style="margin:0;width:150px;display:none;">
		        			<dt><a href="em_meeting_list.php">會議管理</a></dt>
							<dt><a href="em_group_list.php">會議群組管理</a></dt>
	        			</dt>
	        		</dt>
	        	</dl>
	        	
	        	
	        	<div id="main_in_main">
	        		
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
								
								$today = date("Y-m-d");
								$end_meeting = 0;
							if ( $num_rows == 0 )
							{	echo "目前尚未建立關於你的會議群組";	}
							else
							{			
													
								for($i=1 ; $i<=$num_rows ; $i++) 
								{
									$row=$result->fetch_array();
									$meeting_date = date("Y-m-d", strtotime($row['time']));
									$meeting_time = date("H:i", strtotime($row['time']));
									
									if ((strtotime($today) - strtotime($meeting_date)) > 0)		//昨天的事
									{	$end_meeting = $i;	break;	}
									$title = $row['title'];
									$meeting_id = $row['meeting_id'];
									$moderator = $row['name'];

									echo "<tr><!--最多五欄-->";
									
									echo "<td>";
									echo "<form id=\"".$meeting_id."\" name=\"".$meeting_id."\" method=\"post\" action=\"../../back_end/em_meeting_start.php\">";
									echo "<input type=\"hidden\" name=\"meeting_id\" value=\"".$meeting_id."\"/> ";
									echo "<input id=\"tableValueCol1\" type=\"submit\" value=\"$title\" style=\"color:#333333;width:auto;line-height:200%;\" />";
									echo "</form>" ;
									
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
							if ($end_meeting == 0)
							{	echo "你還未開過會呢~";	}
							else
							{				
								for($i=$end_meeting ; $i<=$num_rows ; $i++) 
								{
									if ($i != $end_meeting)	$row=$result->fetch_array();
									
									$meeting_date = date("Y-m-d", strtotime($row['time']));
									$meeting_time = date("H:i", strtotime($row['time']));
									
									$title = $row['title'];
									$meeting_id = $row['meeting_id'];
									$moderator = $row['name'];

									echo "<tr><!--最多五欄-->";
									echo "<td>";

									echo "<form id=\"".$meeting_id."\" name=\"".$meeting_id."\" method=\"post\" action=\"../../back_end/em_meeting_start.php\">";
									echo "<input type=\"hidden\" name=\"meeting_id\" value=\"".$meeting_id."\"/> ";
									echo "<input id=\"tableValueCol1\" type=\"submit\" value=\"$title\" style=\"color:#333333;width:auto;line-height:200%;\" />";
									echo "</form>" ;

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

