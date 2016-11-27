<?php

	//http://127.0.0.1:8080/meeting_cloud/web/employee_web/meeting/em_meeting_info.php?meeting_id=4
	
	if(!isset($_SESSION))
	{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
//	require_once("../../../../login_check.php");
	
	if (isset($_SESSION["id"]))
		$id = $_SESSION["id"];
	else
		$id = "a@";
	
	$meeting_id = $_GET['meeting_id'];
	$topic_id = $_GET['topic_id'];
	
	$sql = "select * from group_meeting_now where member_id = '".$id."' and meeting_id = '".$meeting_id."'";
	$result = $conn->query($sql);
	$join_meeting = $result->num_rows;
	if ($join_meeting != 1)
		header("Location: ../../employee_center.php" );
	
	
	
	$sql = "select * from meeting_scheduler where meeting_id = '".$meeting_id."'";
	$result = $conn->query($sql);
	$row=$result->fetch_array();
	$meeting_title = $row['title'];
	$group_id = $row['group_id'];
	$moderator_id = $row['moderator_id'];					//看是否主席
	$minutes_taker_id = $row['minutes_taker_id'];
	$over = $row['over'];
	
	$sql = "select * from group_meeting_topics where meeting_id = '".$meeting_id."' and topic_id = '".$topic_id."'";
	$result = $conn->query($sql);
	$row=$result->fetch_array();
	$meeting_topic = $row['topic'];
	
	
	
	
?>


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link rel="stylesheet" type="text/css" href="../../../main_css/main.css">
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	
	<script language="JavaScript" src="../../../main_js/leftBarSlide.js"></script>
	
	<script>
		var now_meeting_member = 0;
		var get_now_meeting_member = 0;
		
		var join_meeting_member = 0;
		var get_join_meeting_member = 0;
	
		var now_num_of_question = 1;
		var get_num_of_question = 0;
		
		var now_num_of_answer = 0;
		var get_num_of_answer = 0;
		
		var now_num_of_doc = 0;
		var get_num_of_doc = 0;
		
		var now_num_of_content = 0;
		var get_num_of_content = 0;
		
		var now_num_of_meeting_minutes = 0;
		var get_num_of_meeting_minutes = 0;
		
		
		var group_id = <?php echo $group_id; ?>;
		var meeting_id = <?php echo $meeting_id; ?>;
		var topic_id = <?php echo $topic_id; ?>;
		
		var obj;
		var go_back = '../../../../';
		
		function upload_doc() 
		{
			
			var formData = new FormData();
			var doc = document.upload_doc_form.doc;
			formData.append("fileToUpload", doc.files[0]);			//把doc 放進一個form裏面再送出去
			
			var upload_request = createRequest();

			if (upload_request != null) 
			{
				var url = go_back + 'back_end/upload_space/upload.php?upload_path=group_upload_space/' + group_id + '/' + meeting_id + '/' + topic_id + '/';

				upload_request.addEventListener('progress', function(e) {
					var done = e.position || e.loaded, total = e.totalSize || e.total;
					console.log('upload_request progress: ' + (Math.floor(done/total*1000)/10) + '%');
				}, false);
				if ( upload_request.upload ) {
					upload_request.upload.onprogress = function(e) {
						var done = e.position || e.loaded, total = e.totalSize || e.total;
						console.log('upload_request.upload progress: ' + done + ' / ' + total + ' = ' + (Math.floor(done/total*1000)/10) + '%');
					};
				}
				upload_request.onreadystatechange = function(e) {
					if ( 4 == this.readyState ) {
						console.log(['upload_request upload complete', e]);
					}
				};
				upload_request.open("POST", url, true);
		//		upload_request.setRequestHeader("Content-Type", "multipart/form-data");			上傳文件不能有這個
		
				upload_request.send(formData);
				request.onreadystatechange = displayResult;
				document.upload_doc_form.doc.value = "";
			}

		}
		
		function get_meeting_doc_list_request()					//取得會議文件列表 
		{
			request = createRequest();
			if (request != null) 
			{
				var url = go_back + 'back_end/meeting/get_info/get_meeting_doc.php?meeting_id=' + meeting_id + '&topic_id=' + topic_id;

				request.open("GET", url, true);
				request.onreadystatechange = displayResult;		// 千萬不能加括號
				request.send(null);								// 送出請求（由於為 GET 所以參數為 null）
			}
		}
		
		function update_doc_list() 
		{  
			var link = "";

			
			for (var i = 1; i <= get_num_of_doc; i++ )
			{
				
				link = go_back + obj.link.obj_doc_list.open_doc[i-1];
				doc_name = obj.link.obj_doc_list.remark_name[i-1];
				
				document.getElementById("doc_list" + i).innerHTML = 
					'<a href="' + link + '" style="color:#333333;width:auto;line-height:200%;">' + 
					doc_name + '</a>';

			}
			now_num_of_doc = get_num_of_doc;
		}
		
		
		
		function answer_request(answer,question_id,id)
		{

			console.log(answer);
			alert(answer);

			answer_request = createRequest();
			if (answer_request != null) 
			{
				var url = go_back + 'back_end/meeting/set_info/set_meeting_answer.php?meeting_id=' + meeting_id + '&topic_id=' + topic_id + '&question_id=' + question_id;

				console.log(url);
				answer_request.open("POST", url, true);
				answer_request.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
				answer_request.send("answer=" + answer);						// 送出請求（由於為 GET 所以參數為 null）
				document.getElementById(id).value = "";
				answer_request.onreadystatechange = displayResult;
			}

		}

		function get_topic_answer_request() 					//取得會議id
		{
			request = createRequest();
			if (request != null) 
			{
				var url = go_back + 'back_end/meeting/get_info/get_meeting_answer.php?meeting_id=' + meeting_id + '&topic_id=' + topic_id;

				request.open("GET", url, true);
				request.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
				request.onreadystatechange = displayResult;		//千萬不能加括號
				request.send(null);								// 送出請求（由於為 GET 所以參數為 null）
			}
		}
		
		function update_answer() 
		{  
			
			var answer = "";
			var question_id = 0;
			
			for (var i = 0; i < get_num_of_answer; i++ )
			{
				
				answer = obj.contents.obj_answer.head_answer[i];
				question_id = obj.contents.obj_answer.question_id[i];
				
				document.getElementById("meeting_answer" + question_id).innerHTML = 
					'<td id = "tableValueCol1">回答</td>' + 
					'<td id = "tableValueCol2">' + answer + '</td>';
			}
			
			now_num_of_answer = get_num_of_answer;
		}
		
		
		
		function ask_question() 
		{
			ask_question_request = createRequest();
			if (ask_question_request != null) 
			{
				var url = go_back + 'back_end/meeting/set_info/set_meeting_question.php?meeting_id=' + meeting_id + '&topic_id=' + topic_id;

				console.log(url);
				ask_question_request.open("POST", url, true);
				ask_question_request.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
				ask_question_request.send("question=" + document.set_new_question_form.question.value);						// 送出請求（由於為 GET 所以參數為 null）
				document.set_new_question_form.question.value = "";
				request.onreadystatechange = displayResult;
			}
		}
		
		function get_topic_question_request() 					//
		{
			request = createRequest();
			if (request != null) 
			{
				var url = go_back + 'back_end/meeting/get_info/get_meeting_question.php?meeting_id=' + meeting_id + '&topic_id=' + topic_id;

				request.open("GET", url, true);
				request.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
				request.onreadystatechange = displayResult;		//千萬不能加括號
				request.send(null);								// 送出請求（由於為 GET 所以參數為 null）
			}
		}
		
		function update_question() 
		{  
			var question = "";
			var question_id = 0;
			var count = 0;
			var meeting_doc_row = 0;
			
			for (var i = now_num_of_question; i <= get_num_of_question; i++ )
			{
				count = count + 1;
				meeting_doc_row = count % 2;
				if (meeting_doc_row == 0)	meeting_doc_row = 2;
				
				question_id = obj.contents.obj_question.question_id[i-1];
				question = obj.contents.obj_question.head_question[i-1];
				
				document.getElementById("meeting_question" + i).innerHTML = 
					'<td id="tableValueCol1">問題 ' + count + '. </td>' + 
					'<td id = "tableValueCol1">' + question + '</td>';
				
				if ( document.getElementById("meeting_answer" + i).value );
				else
				{
					document.getElementById("meeting_answer" + i).innerHTML = 
						'<td id = "tableTittle1" >' + 																	//answer_request
						'<input id = "Button" name = "set_answer' + i + '" type = "submit" value = "確認送出" onclick = "answer_request(document.getElementById(\'answer' + i + '\').value,' + question_id + ', \'answer' + i + '\' );"/>' + 
						'</td>' + 
						'<td id = "tableValueCol1"><textarea id="answer'+ i + '" name="answer" cols="50" rows="2" style="overflow-y:auto;"></textarea></td>';
				}
			}
			
			now_num_of_question = get_num_of_question + 1;
		
		}
		
		
		
		function set_content() 
		{
			set_content_request = createRequest();
			if (set_content_request != null) 
			{
				var url = go_back + 'back_end/meeting/set_info/set_meeting_content.php?meeting_id=' + meeting_id + '&topic_id=' + topic_id;

				console.log(url);
				set_content_request.open("POST", url, true);
				set_content_request.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
				set_content_request.send("content=" + document.set_content_form.content.value);						// 送出請求（由於為 GET 所以參數為 null）
				document.set_new_question_form.question.value = "";
				set_content_request.onreadystatechange = displayResult;
			}
		}
		
		function get_content_request() 					//取得會議id
		{
			request = createRequest();
			if (request != null) 
			{
				var url = go_back + 'back_end/meeting/get_info/get_meeting_content.php?meeting_id=' + meeting_id + '&topic_id=' + topic_id;

				request.open("GET", url, true);
				request.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
				request.onreadystatechange = displayResult;		//千萬不能加括號
				request.send(null);								// 送出請求（由於為 GET 所以參數為 null）
			}
		}
		
		function update_content() 
		{
			
			var content = "";
			var content_id = 0;
			
			for (var i = now_num_of_content; i < get_num_of_content; i++ )
			{
				
				content = obj.contents.obj_content.head_content[i];
				content_id = obj.contents.obj_content.content_id[i];

				document.getElementById("meeting_content" + content_id).innerHTML = 
					'<td id = "tableValueCol2">' + content + '</td>';
			}
			
			now_num_of_content = get_num_of_content;
		}
		
		
		
		function set_meeting_minutes() 
		{
			set_meeting_minutes_request = createRequest();
			if (set_meeting_minutes_request != null) 
			{
				var url = go_back + 'back_end/meeting/set_info/set_meeting_minutes.php?meeting_id=' + meeting_id + '&topic_id=' + topic_id;

				console.log(url);
				set_meeting_minutes_request.open("POST", url, true);
				set_meeting_minutes_request.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
				set_meeting_minutes_request.send("meeting_minutes=" + document.set_meeting_minutes_form.meeting_minutes.value);						// 送出請求（由於為 GET 所以參數為 null）
				document.set_meeting_minutes_form.meeting_minutes.value = "";
				set_meeting_minutes_request.onreadystatechange = displayResult;
			}
		}
		
		function get_meeting_minutes_request() 					//取得會議id
		{
			request = createRequest();
			if (request != null) 
			{
				var url = go_back + 'back_end/meeting/get_info/get_meeting_minutes.php?meeting_id=' + meeting_id + '&topic_id=' + topic_id;

				request.open("GET", url, true);
				request.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
				request.onreadystatechange = displayResult;		//千萬不能加括號
				request.send(null);								// 送出請求（由於為 GET 所以參數為 null）
			}
		}
		
		function update_meeting_minutes() 
		{
			
			var meeting_minutes = "";
			var meeting_minutes_id = 0;
			
			for (var i = now_num_of_meeting_minutes; i < get_num_of_meeting_minutes; i++ )
			{
				
				meeting_minutes = obj.contents.obj_meeting_minutes.head_meeting_minutes[i];
				meeting_minutes_id = obj.contents.obj_meeting_minutes.meeting_minutes_id[i];
				
				console.log(meeting_minutes);
				console.log(meeting_minutes_id);
				
				document.getElementById("meeting_minutes" + meeting_minutes_id).innerHTML = 
					'<td id = "tableValueCol1">' + meeting_minutes + '</td>';
			}
			
			now_num_of_meeting_minutes = get_num_of_meeting_minutes;
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
						
				//		console.log(request.responseText);
						if ( obj['contents'] && obj.contents['obj_question'] && obj.contents.obj_question != "none")
						{
							
							get_num_of_question = obj.contents.obj_question.head_question.length;
							if (get_num_of_question >= now_num_of_question)
								update_question();
						}
						else if ( obj['contents'] && obj.contents['obj_answer'] && obj.contents.obj_answer != "none")
						{
							get_num_of_answer = obj.contents.obj_answer.head_answer.length;
							if (get_num_of_answer > now_num_of_answer)
								update_answer();
						}
						else if ( obj['link'] && obj.link['obj_doc_list'] && obj.link.obj_doc_list != "none" )
						{
							get_num_of_doc = obj.link.obj_doc_list.remark_name.length;
					//		console.log('get num of doc = ' + get_num_of_doc);
					//		console.log('now num of doc = ' + now_num_of_doc);
							if (get_num_of_doc > now_num_of_doc);
								update_doc_list();
						}
						else if ( obj['contents'] && obj.contents['obj_content'] && obj.contents.obj_content != "none")
						{
							get_num_of_content = obj.contents.obj_content.head_content.length;
							if ( get_num_of_content > now_num_of_content )
								update_content();
					//		console.log(request.responseText);
						}
						else if ( obj['contents'] && obj.contents['obj_meeting_minutes'] && obj.contents.obj_meeting_minutes != "none")
						{
							get_num_of_meeting_minutes = obj.contents.obj_meeting_minutes.head_meeting_minutes.length;
							if ( get_num_of_meeting_minutes > now_num_of_meeting_minutes )
								update_meeting_minutes();
							console.log(request.responseText);
						}
						else if ( obj['contents'] && obj.contents['obj_meeting_member_list'] && obj.contents.obj_meeting_member_list != "none")
						{
							get_join_meeting_member = obj.contents.obj_meeting_member_list.name.length;
							get_now_meeting_member = obj.contents.now_meeting_member;
							console.log("從server 收到有多少人已加入會議 : " + get_now_meeting_member);
							console.log("有多少人已加入會議 : " + now_meeting_member);
							if (join_meeting_member != get_join_meeting_member || now_meeting_member != get_now_meeting_member)
								update_member_list();
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
		
		setInterval("get_topic_answer_request();", 1300) 		//取得回答
		setInterval("get_topic_question_request();", 1100) 		//取得提問
		setInterval("get_meeting_doc_list_request();", 1200)	//取得附件列表
		setInterval("get_meeting_member_list_request();", 870) 	//取得會員名單
		setInterval("get_content_request();", 1600) 			//議題說明
		setInterval("get_meeting_minutes_request();", 2000) 	//議題決議
		
		
		
		
		function get_meeting_member_list_request() 					//取得會議id
		{
			request = createRequest();
			if (request != null) 
			{
				var url = go_back + 'back_end/meeting/get_info/get_meeting_member_list.php?meeting_id=' + meeting_id;

				request.open("GET", url, true);
				request.onreadystatechange = displayResult;		//千萬不能加括號
				request.send(null);								// 送出請求（由於為 GET 所以參數為 null）
			}
		}
		
		function update_member_list()
		{  
			var count_online = 0;
			var count_offline = 0;
			var online = 0;
			var name = "";
			
			now_meeting_member = 0;
			join_meeting_member = get_join_meeting_member;
			
			for (var i = 0; i < get_join_meeting_member; i++ )
			{
				name = obj.contents.obj_meeting_member_list.name[i];
				online = obj.contents.obj_meeting_member_list.online[i];
				console.log(obj.contents.obj_meeting_member_list.online[i]);
				console.log(online);
				if (online == 1)						//在線
				{
					count_online = count_online + 1;
					document.getElementById("online" + count_online).innerHTML = 
					'<td height="50px" name="online' + count_online + '" style="text-align:center;">' + name + '</td>';
				}
				else if (online == 0)
				{
					count_offline = count_offline + 1;
					document.getElementById("offline" + count_offline).innerHTML =  
					'<td height="50px" name="offline' + count_offline + '" style="text-align:center;">' + name + '</td>';
				}	
				
			}
			for (var i = count_online + 1; i < 30 ; i++)
				document.getElementById("online" + i).innerHTML = "";
			
			for (var i = count_offline + 1; i < 30 ; i++)
				document.getElementById("offline" + i).innerHTML = "";
			now_meeting_member = count_online;
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
					會議資訊
						<dt><a href="em_meeting_running.php?meeting_id=<?php echo $meeting_id; ?>">返回會議議題列表</a></dt>
						<dt><a href="em_meeting_running_vote.php?meeting_id=<?php echo $meeting_id; ?>&topic_id=<?php echo $topic_id; ?>">投票</a></dt>
						
						<dt><a href="../../../../back_end/em_meeting_end.php">結束會議</a></dt>
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
			<p id="conventionTittle">會議 - <?php echo $meeting_title; ?></p>
			<p id="conventionTittle">議題 - <?php echo $meeting_topic; ?></p>
			
				
				<div id="main_sub">
					<p id="conventionTittle">說明</p>
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
										$num_of_meeting_content = 30;
										for ($i = 1; $i <= $num_of_meeting_content; $i++)
										{	echo "<tr id = \"meeting_content".$i."\"></tr>";	}
									?>    
									
									<tr></tr>
								</table>
							</div>
							</div>
						</tr>
						<?php
							if ($id == $moderator_id || $id == $minutes_taker_id)
							{
								echo "<tr>".
										"<table id=\"table\">".
											"<tr>".
												"<td id=\"tableTittle1\">說明</td>".
												"<form name=\"set_content_form\">".
													"<td id=\"tableValueCol1\"><textarea name=\"content\" cols=\"50\" rows=\"3\"></textarea></td>".
												"</form>".
											"</tr>".
										"</table>".
										"<input id=\"tableButton\" name=\"set_content\" type=\"submit\" value=\"確認送出\" onclick=\"set_content();\"/>".
									"</tr>";
							}
						?>
					</table>
				</div>
				
				
				<div id="main_sub">
					<p id="conventionTittle">決議</p>
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
										$num_of_meeting_minutes = 30;
										for ($i = 1; $i <= $num_of_meeting_minutes; $i++)
										{	echo "<tr id = \"meeting_minutes".$i."\"></tr>";	}
									?>    
									
									<tr></tr>
								</table>
							</div>
							</div>
						</tr>
						<?php
							if ($id == $moderator_id || $id == $minutes_taker_id)
							{
								echo "<tr>".
										"<table id=\"table\">".
											"<tr>".
												"<td id=\"tableTittle1\">決議</td>".
												"<form name=\"set_meeting_minutes_form\">".
													"<td id=\"tableValueCol1\"><textarea name=\"meeting_minutes\" cols=\"50\" rows=\"3\"></textarea></td>".
												"</form>".
											"</tr>".
										"</table>".
										"<input id=\"tableButton\" name=\"set_meeting_minutes\" type=\"submit\" value=\"確認送出\" onclick=\"set_meeting_minutes();\"/>".
									"</tr>";
							}
						?>
					</table>
				</div>
				
				
				<div id="main_sub">
					<p id="conventionTittle">會議議題中的問題</p>
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
										$num_of_meeting_question = 30;
										for ($i = 1; $i <= $num_of_meeting_question; $i++)
										{
											echo "<tr id = \"meeting_question".$i."\"></tr>";
											echo "<tr id = \"meeting_answer".$i."\"></tr>";
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
									<td id="tableTittle1">對會議議題提出問題</td>
									<form name="set_new_question_form">
										<td id="tableValueCol1"><textarea name="question" cols="50" rows="3" ></textarea></td>
										
									</form>
								</tr>
							</table>
							<input id="tableButton" name="set_new_question" type="submit" value="確認送出" onclick="ask_question();"/>
						</tr>
					</table>
				</div>
				
				<div id="main_sub">
					<p id="conventionTittle">附件</p><!--管理員/紀錄-->
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
							<div style="width:600px; height:200px; overflow:hidden;">
							<div style="width:620px; height:200px; overflow-y: auto;">
								<table id="table">
								
								
								
									<?php    
										$num_of_doc = 30;
										for ($i = 1; $i<=$num_of_doc; $i++)
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
								echo "<form name=\"upload_doc_form\" method=\"post\" enctype=\"multipart/form-data\" 
										action=\"../../../back_end/upload_space/upload.php?upload_path=group_upload_space/".$group_id."/".$meeting_id."/\">";
							?>
									<td id="tableValueCol1"><input id="tableValueCol1" type="file" name="doc" /></td>
									</form>
									
								</tr>
							</table>
							<input id="tableButton" name="upload_doc" type="submit" value="確認送出" onclick="upload_doc();"/>
							
						</tr>
					</table>
				</div>
				
				
			</div>
			
		</div>
	</div>
	
	
	<!--	============================================================================================	-->
	
	
	<div id = "right table" style="height:515px;">
		<dl style="margin:0;width:200;float:right;">
			<table align=right border=1>
				<table>
				<tr>
				<td id="tableTittle1">到場人</td>
				</tr>
				</table>
			<div style="width:200px;height:200px;text-align:center;overflow:hidden;" >
			<div style="width:220px;height:200px;overflow-y: auto;text-align:center;">
				<table style="width:200;">
				
				<?php 
					$join_meeting_member = 30;
					for ( $i = 0 ; $i < $join_meeting_member ; $i++ )
					{
						echo "<tr id=\"online".$i."\" bgcolor=\"white\">";
				//		echo "<td height=\"50px\" name=\"online".$i."\" style=\"text-align:center;\"></td>";
						echo "</tr>";
					}
				?>
				</table>
			</div>
			</div>
			</table>
			<table align=right border=1>
				<table>
				<tr>
				<td id="tableTittle1">尚未到場</td>
				</tr>
				</table>
			<div style="width:200px;height:260px;text-align:center;overflow:hidden;" >
			<div style="width:220px;height:260px;overflow-y: auto;text-align:center;">
				<table style="width:200;">
				
				<?php 
					$join_meeting_member = 30;
					for ( $i = 0 ; $i < $join_meeting_member ; $i++ )
					{
						echo "<tr id=\"offline".$i."\" bgcolor=\"white\">";
				//		echo "<td height=\"50px\" name=\"offline".$i."\" style=\"text-align:center;\"></td>";
						echo "</tr>";
					}
				?>
					
				</table>
			</div>
			</div>
			</table>
	</div>
</body>
</html>

