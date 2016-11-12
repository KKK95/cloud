﻿<?php

	//http://127.0.0.1:8080/meeting_cloud/web/employee_web/meeting/em_meeting_info.php?meeting_id=4
	
	if(!isset($_SESSION))
	{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
//	require_once("../../../login_check.php");
	
	$meeting_id = $_GET['meeting_id'];
	
	$sql = "select * from meeting_scheduler where meeting_id = '".$meeting_id."'";
	$result = $conn->query($sql);
	$row=$result->fetch_array();
	$meeting_title = $row['title'];
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

		function set_topic() 
		{
			set_topic_request = createRequest();
			if (request != null) 
			{
		<?php
				echo "var url = \"../../../back_end/meeting/set_info/set_meeting_topic.php?meeting_id=".$meeting_id."\";";
		?>
				set_topic_request.open("POST", url, true);
				set_topic_request.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
				set_topic_request.send("topic=" + document.set_new_topic_form.topic.value);						// 送出請求（由於為 GET 所以參數為 null）
				document.set_new_topic_form.topic.value = "";
				console.log(document.set_new_topic_form.topic.value);
			}
		}
		
		function get_meeting_doc_list_request()					//取得會議文件列表 
		{
			request = createRequest();
			if (request != null) 
			{
		<?php
				echo "var url = \"../../../back_end/meeting/get_info/get_meeting_doc.php?meeting_id=".$meeting_id."\";";
		?>
				request.open("GET", url, true);
				request.onreadystatechange = displayResult;		// 千萬不能加括號
				request.send(null);								// 送出請求（由於為 GET 所以參數為 null）
			}
		}
		
		function get_meeting_info_request() 					//取得會議id
		{
			request = createRequest();
			if (request != null) 
			{
		<?php
				echo "var url = \"../../../back_end/meeting/get_info/get_meeting_info.php?meeting_id=".$meeting_id."\";";
		?>

				request.open("GET", url, true);
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
					obj = eval('(' + request.responseText + ')');
					
					if ( obj['contents'] && obj.contents['obj_meeting_topic'] && obj.contents.obj_meeting_topic != "none")
					{
						get_num_of_meeting_topic = obj.contents.obj_meeting_topic.topic.length;
						if (get_num_of_meeting_topic > now_num_of_meeting_topic)
							add_new_topic();
					}
					else if ( obj.link['obj_doc_list'] && obj.link.obj_doc_list != "none" )
					{
						
		//				console.log(request.responseText);
						get_num_of_doc = obj.link.obj_doc_list.remark_name.length;
						if (get_num_of_doc > now_num_of_doc)
							add_new_doc();
					}
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
		setInterval("get_meeting_doc_list_request();", 2000) //每隔一秒發出一次查詢
			
		function add_new_topic() 
		{  
			var count = now_num_of_meeting_topic;
			var meeting_topic_row = 0;
			
			for (var i = now_num_of_meeting_topic; i < get_num_of_meeting_topic; i++ )
			{
				count = count + 1;
				meeting_topic_row = count % 2;
				if (meeting_topic_row == 0)	meeting_topic_row = 2;
				
				document.getElementById("meeting_topic" + count).innerHTML = document.getElementById("meeting_topic" + count).innerHTML + 
					'<td id = "tableValueCol' + meeting_topic_row + '">' + obj.contents.obj_meeting_topic.topic[i] + '</td>';
				
				now_num_of_meeting_topic = now_num_of_meeting_topic + 1;
			}
		}
		
		function add_new_doc() 
		{  
			var count = now_num_of_doc;
			var meeting_doc_row = 0;
			
			for (var i = now_num_of_doc; i < get_num_of_doc; i++ )
			{
				count = count + 1;
				meeting_doc_row = count % 2;
				if (meeting_doc_row == 0)	meeting_topic_row = 2;
				
				document.getElementById("doc_list" + count).innerHTML = document.getElementById("doc_list" + count).innerHTML + 
					'<a href="' + obj.link.obj_doc_list.open_doc[i] + '" style="color:#333333;width:auto;line-height:200%;">' + 
					obj.link.obj_doc_list.remark_name[i] + '</a>';

				now_num_of_doc = now_num_of_doc + 1;
			}
			
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
					<dl id = "memberSubBar" style="margin:0;width:150px;display:none;">
						<dt><a href="">會員瀏覽</a></dt>
						<dt><a href="">會員資料</a></dt>
						<dt><a href="">修改密碼</a></dt>
						<dt><a href="">會員管理</a></dt>
						<dt><a href="">登出</a></dt>
					</dl>
				</dt>
				<dt id="conventionBar" class="left">
					會議專區
					<dl id = "conventionSubBar" style="margin:0;width:150px;display:none;">
						<dt><a href="">會議瀏覽</a></dt>
						<dt><a href="">會議紀錄</a></dt>
						<dt><a href="">會議管理</a></dt>
						<dt><a href="">修改請求</a></dt>
					</dl>
				</dt>
			</dl>
			
			
			<div id="main_in_main">
				<?php
					echo "<p id=\"conventionTittle\">會議 - ".$meeting_title."</p>"
				?>
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
							<div style="width:600px; height:125px; overflow:hidden;">
							<div style="width:620px; height:125px; overflow-y: auto;">
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
						<tr>
							<table id="table">
								<tr>
									<td id="tableTittle1">新增會議議題</td>
									<?php
										echo "<form name=\"set_new_topic_form\" method=\"post\"
												action=\"../../../back_end/meeting/set_info/set_meeting_topic.php?meeting_id=".$meeting_id."\">";
									?>
									<td id="tableValueCol1"><input id="tableValue1" type="text" name="topic" value="test?"/></td>
									
									</form>
								</tr>
							</table>
							<input id="tableButton" name="set_new_topic" type="submit" value="確認送出" onclick="set_topic();"/>
						</tr>
					</table>
				</div>

				<div id="main_sub">
					<p id="conventionTittle">會議文件</p><!--管理員/紀錄-->
					<table id="table">
						<tr>
							<table id="table">
								<tr>
									<td id="tableTittleCol1" style="width:400px">名稱</td>
									<td id="tableTittleCol2" style="width:100px">上傳時間</td>
									<td id="tableTittleCol1" style="width:100px">檔案大小</td>
								</tr>
							</table>
						</tr>
						<tr>
							<div style="width:600px; height:125px; overflow:hidden;">
							<div style="width:620px; height:125px; overflow-y: auto;">
								<table id="table">
								
								
								
									<?php    
										$num_of_doc = 30;
										for ($i =1; $i<=$num_of_doc; $i++)
											echo "<tr id = \"doc_list".$i."\"></tr>";
									?>    
									
									
									<tr></tr>
								</table>
							</div>
							</div>
						</tr>
						<tr>
							<table id="table">
								<tr>
									<td id="tableTittle1">上傳會議文件</td>
									<?php
										echo "<form name=\"upload_doc_form\" method=\"post\" 
												action=\"../../../back_end/upload_space/upload.php\">";
									?>
									<td id="tableValueCol1"><input id="tableValueCol1" type="file" name="my_doc"/></td>
									
									</form>
								</tr>
							</table>
							<input id="tableButton" name="upload_doc" type="submit" value="確認送出" onclick="upload_doc();"/>
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
							
						</tr>
					</table>
				</div>
				
				<table id="table">
						<tr>
							<td id="tableTittleCol2" style="border-radius: 4px;">
								<input id="tableButton" type="button" onclick="goDeleteMember()" value="會議開始" style="border-radius: 4px;"/>
							</td>
					    </tr>
				</table>
				
			</div>
			
		</div>
	</div>
</body>
</html>

