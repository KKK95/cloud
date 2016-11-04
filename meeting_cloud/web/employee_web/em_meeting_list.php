<?php
	header("Content-Type: text/html; charset=UTF-8");
			
	if(!isset($_SESSION))
	{  		session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("../back_end/login_check.php");
	
	$id = $_SESSION['id'];
	
	$sql = "select scheduler.*, member.name
			from meeting_scheduler as scheduler, member
			where scheduler.group_id in 
			(select gl.group_id
				FROM group_leader as gl, group_member as gm
				where gm.member_id = '".$id."' or gl.member_id = '".$id."'
                group by gl.group_id
			)
			and member.id = scheduler.create_meeting_member_id
            order by scheduler.time desc";
			
	$result = $conn->query($sql);
?>

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<link rel="stylesheet" type="text/css" href="../main_css/main.css">
        
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        
        <script language="JavaScript" src="../main_js/leftBarSlide.js"></script>
        
        <script>
	        function goNewMember()//重新導向到新增會議(會員會議)
	        {
	        	window.location = "http://www.google.com";
	        }
	        
	        function goDeleteMember()//重新導向到刪除會議
	        {
	        	window.location = "http://www.google.com";
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
	        		<dt id="member_Bar" class="left">
	        			會員專區
	        			<dl id = "member_SubBar" style="margin:0;width:150px;display:none;">
		        			<dt><a href="">會員瀏覽</a></dt>
		        			<dt><a href="">會員資料</a></dt>
		        			<dt><a href="">修改密碼</a></dt>
		        			<dt><a href="">會員管理</a></dt>
		        			<dt><a href="../back_end/logout.php">登出</a></dt>
	        			</dl>
	        		</dt>
	        		<dt id="meeting_Bar" class="left">
	        			會議專區
	        			<dl id = "meeting_SubBar" style="margin:0;width:150px;display:none;">
		        			<dt><a href="">會議瀏覽</a></dt>
		        			<dt><a href="">會議紀錄</a></dt>
							<dt><a href="view_meeting_question">會議Q & A</a></dt>
		        			<dt><a href="">會議管理</a></dt>
		        			<dt><a href="">修改請求</a></dt>
	        			</dl>
	        		</dt>
	        	</dl>
	        	
	        	
	        	<div id="main">
	        		
		        	<p id="meeting_Tittle">會議列表</p>
				
					<table id="table">
						<tr>
							<td id="tableTittleCol1" style="border-radius: 4px;">
								<input id="tableButton" type="button" onclick="goNewMember()" value="新增會議" style="border-radius: 4px;"/>
							</td>
							
							<td id="tableTittleCol2" style="border-radius: 4px;">
								<input id="tableButton" type="button" onclick="goDeleteMember()" value="刪除會議" style="border-radius: 4px;"/>
							</td>
					    </tr>
				    </table>
					
					<div id="main_sub">
			        	<p id="conventionTittle">將至會議</p><!--管理員/紀錄-->
							<table id="table">
						<tr>
							<td id="tableTittleCol1">會議編號</td>
							<td id="tableTittleCol2">名稱</td>
							<td id="tableTittleCol1">日期</td>
							<td id="tableTittleCol1">召集人</td>
					    </tr>
					    
					    <?php	
								$num_rows = $result->num_rows;	
								$today = date("Y-m-d");
								$end_meeting = 0;
							if ( $num_rows == 0 )
							{	echo "最近沒有會議";	}
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
									$create_meeting_member_id = $row['create_meeting_member_id'];
									echo "<tr><!--最多五欄-->";
									
									echo "<td id=\"\"><a href='../back_end/em_meeting_start.php' style=\"color:#333333;width:auto;line-height:200%;\">";
									echo $title;
									echo "</a></td>";
									
									echo "<td id=\"date\">$meeting_date</td>";
									echo "<td id=\"time\">$meeting_time</td>";
									echo "<td id=\"leader\">$create_meeting_member_id</td>";
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
								<td id="title">會議標題</td>
								<td id="date">日期</td>
								<td id="time">時間</td>
								<td id="leader">召集人</td>
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
									$create_meeting_member_id = $row['create_meeting_member_id'];
									echo "<tr><!--最多五欄-->";
									
									echo "<td id=\"\"><a href='' style=\"color:#333333;width:auto;line-height:200%;\">";
									echo $title;
									echo "</a></td>";
									
									echo "<td id=\"date\">$meeting_date</td>";
									echo "<td id=\"time\">$meeting_time</td>";
									echo "<td id=\"leader\">$create_meeting_member_id</td>";
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

