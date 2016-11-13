<?php

	header("Content-Type: text/html; charset=UTF-8");
			
	if(!isset($_SESSION))
	{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
	require_once("../../../login_check.php");
	
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

		<link rel="stylesheet" type="text/css" href="../../main_css/main.css">
        
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        
        <script language="JavaScript" src="../../main_js/leftBarSlide.js"></script>
        
        
        
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
	        	
	        	
	        	<div id="main">
	        		
		        	<p id="conventionTittle">會議群組管理</p>
					<table id="table">
						<tr>
						<table id="table">
							<tr>
								<td id="tableTittleCol1" style="border-radius: 4px;">
									<input id="tableButton" type="button" onclick="self.location.href='./build_group_form.php'" value="新增群組" style="border-radius: 4px;"/>
								</td>
								
								<td id="tableTittleCol2" style="border-radius: 4px;">
									<input id="tableButton" type="button" onclick="goDeleteMember()" value="刪除群組" style="border-radius: 4px;"/>
								</td>
							</tr>
						</table>
						</tr>
						<tr>
						<table id="table">
							<tr>
								<table id="table">
								<tr>
									<td id="tableTittleCol1">會議群組名稱</td>
									<td id="tableTittleCol2">日期</td>
									<td id="tableTittleCol1">發起人</td>
								</tr>
								</table>
							</tr>
							
							<tr>
								<div style="width:600px; height:250px; overflow:hidden;" >
								<div style="width:615px; height:250px; overflow-y: auto;">
									<table id="table">
									<?php
										$num_rows = $result->num_rows;

										if ($num_rows == 0)
										{	echo "目前尚未建立關於你的群組";	}
										else
										{					
											for($i=1;$i<=$num_rows;$i++) 
											{
												
												$row=$result->fetch_array();
												$meeting_date = date("Y-m-d", strtotime($row['date_time']));
												echo "<tr><!--最多五欄-->";
												
												echo "<td id=\"tableValueCol1\" style=\"width:300px\">";
												echo "<a href=\"group.php?group_id=".$row['group_id']."\" style=\"color:#333333;width:auto;line-height:200%;\">";
												echo $row['group_name'];
												echo "</a></td>";
												
												echo "<td id=\"tableValueCol2\" style=\"width:100px\">".$meeting_date."</td>";
												echo "<td id=\"tableValueCol1\" style=\"width:160px\">".$row['name']."</td>";
											//	array_push( $json['link']['group']['del'], "group.php?group_id=".$row['id']);
												//		這裏可以加東西
												
												echo "</tr><!--最多五欄-->";
											}
										}
									?>
									</table>
								</div>
								</div>
							</tr>
							
							
							
						</table>
						</tr>
					</table>
			    </div>
			    
	        </div>
		</div>
	</body>
</html>

