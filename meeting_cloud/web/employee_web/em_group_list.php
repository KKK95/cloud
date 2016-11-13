<?php
	header("Content-Type: text/html; charset=UTF-8");
			
	if(!isset($_SESSION))
	{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("../back_end/login_check.php");
	
	$id=$_SESSION['id'];	
	
	//找出所有的group
	
    $sql = "SELECT gl.group_name, gl.group_id, gl.date_time, m.name
			FROM group_leader as gl, group_member as gm, member as m
			where (gm.member_id = '".$id."' or gl.member_id = '".$id."') 
			group by gl.group_id ";
	
	$result=$conn->query($sql);
	
	
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
	        			<dt id = "member_SubBar" style="margin:0;width:150px;display:none;">
		        			<dt><a href="">會員瀏覽</a></dt>
		        			<dt><a href="">會員資料</a></dt>
		        			<dt><a href="em_update_pw.php">修改密碼</a></dt>
							<dt><a href="">我的雲端空間</a></dt>
		        			<dt><a href="../back_end/logout.php">登出</a></dt>
	        			</dt>
	        		</dt>
	        		<dt id="meeting_Bar" class="left">
	        			會議專區
	        			<dt id = "meeting_SubBar" style="margin:0;width:150px;display:none;">
		        			<dt><a href="">會議瀏覽</a></dt>
		        			<dt><a href="">會議紀錄</a></dt>
		        			<dt><a href="">會議管理</a></dt>
		        			<dt><a href="">修改請求</a></dt>
	        			</dt>
	        		</dt>
	        	</dl>
	        	
	        	
	        	<div id="main">
	        		
		        	<p id="group_Tittle">群組列表</p>
				
					<table id="table">
						<tr>
							<td id="tableTittleCol1" style="border-radius: 4px;">
								<input id="tableButton" type="button" onclick="goNewMember()" value="新增群組" style="border-radius: 4px;"/>
							</td>
							
							<td id="tableTittleCol2" style="border-radius: 4px;">
								<input id="tableButton" type="button" onclick="goDeleteMember()" value="刪除群組" style="border-radius: 4px;"/>
							</td>
					    </tr>
				    </table>
					
					<table id="table">
						<tr>
							<td id="group_name">群組名稱</td>
							<td id="date">日期</td>
							<td id="time">時間</td>
							<td id="group_leader">發起人</td>
					    </tr>
					    
						<?php
							$num_rows = $result->num_rows;

							if ($num_rows == 0)
							{	echo "目前尚未建立關於你的群組";	}
							else
							{					
								for($i=1;$i<=$num_rows;$i++) 
								{
									echo "<tr><!--最多五欄-->";
									$row=$result->fetch_array();	//rs 在這裏, fetch_assoc 的 index 只能用字串, 而 fetch_array 能用數字和字串作 index
									echo "<td id=\"group_name\">";
									echo "<a href=\"group.php?group_id=".$row['group_id']."\" style=\"color:#333333;width:auto;line-height:200%;\">";
									echo $row['group_name'];
									echo "</a></td>";
									
									echo "<td id=\"date\">2016/10/01</td>";
									echo "<td id=\"time\">9:00</td>";
									echo "<td id=\"group_leader\">".$row['name']."</td>";
								//	array_push( $json['link']['group']['del'], "group.php?group_id=".$row['id']);
									//		這裏可以加東西
									
									echo "</tr><!--最多五欄-->";
								}
							}
						?>
					    
				    </table>

			    </div>
			    
	        </div>
		</div>
	</body>
</html>

