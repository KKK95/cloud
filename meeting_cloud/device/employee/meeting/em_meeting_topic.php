<?php

	//http://127.0.0.1:8080/meeting_cloud/web/employee_web/meeting/em_meeting_info.php?meeting_id=4
	
	if(!isset($_SESSION))
	{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
//	require_once("../../../login_check.php");
	
	if (isset($_SESSION["id"]))
		$id = $_SESSION["id"];
	else
		$id = "a@";
	
	$meeting_id = $_GET['meeting_id'];
	$topic_id = $_GET['topic_id'];
	
	$sql = "select * from meeting_scheduler where meeting_id = '".$meeting_id."'";
	$result = $conn->query($sql);
	$row=$result->fetch_array();
	$meeting_title = $row['title'];
	$group_id = $row['group_id'];
	$minutes_taker_id = $row['minutes_taker_id'];
	$moderator_id = $row['moderator_id'];
	
	$sql = "select * from group_meeting_topics where meeting_id = '".$meeting_id."' and topic_id = '".$topic_id."'";
	$result = $conn->query($sql);
	$row=$result->fetch_array();
	$meeting_topic = $row['topic'];
	
	
?>


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link rel="stylesheet" type="text/css" href="../../main_css/main.css">
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	
	<script language="JavaScript" src="../../main_js/leftBarSlide.js"></script>
	
	<script>
		var meeting_id = <?php echo $meeting_id; ?>;
		var topic_id = <?php echo $topic_id ?>;
	
		var now_num_of_question = 1;
		var get_num_of_question = 0;
		
		var now_num_of_answer = 0;
		var get_num_of_answer = 0;
		
		var now_num_of_doc = 0;
		var get_num_of_doc = 0;
		
		var group_id = <?php echo $group_id; ?>;
		var meeting_id = <?php echo $meeting_id; ?>;
		var topic_id = <?php echo $topic_id; ?>;
		
		var obj;
		
		function upload_doc() 
		{
			
			var formData = new FormData();
			var doc = document.upload_doc_form.doc;
			formData.append("fileToUpload", doc.files[0]);			//把doc 放進一個form裏面再送出去
			
			var upload_request = createRequest();

			if (upload_request != null) 
			{
				var url = '../../../back_end/upload_space/upload.php?upload_path=group_upload_space/' + group_id + '/' + meeting_id + '/' + topic_id;

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
		
		function answer_request(answer,question_id,id)
		{

			console.log(answer);
			alert(answer);

			answer_request = createRequest();
			if (answer_request != null) 
			{
				var url = '../../../back_end/meeting/set_info/set_meeting_answer.php?meeting_id=' + meeting_id + '&topic_id=' + topic_id + '&question_id=' + question_id;

				console.log(url);
				answer_request.open("POST", url, true);
				answer_request.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
				answer_request.send("answer=" + answer);						// 送出請求（由於為 GET 所以參數為 null）
				document.getElementById(id).value = "";
				answer_request.onreadystatechange = displayResult;
			}

		}
		
		function ask_question() 
		{
			ask_question_request = createRequest();
			if (ask_question_request != null) 
			{
				var url = '../../../back_end/meeting/set_info/set_meeting_question.php?meeting_id=' + meeting_id + '&topic_id=' + topic_id;

				console.log(url);
				ask_question_request.open("POST", url, true);
				ask_question_request.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
				ask_question_request.send("question=" + document.set_new_question_form.question.value);						// 送出請求（由於為 GET 所以參數為 null）
				document.set_new_question_form.question.value = "";
				request.onreadystatechange = displayResult;
			}
		}
		
		function get_topic_question_request() 					//取得會議id
		{
			request = createRequest();
			if (request != null) 
			{
				var url = '../../../back_end/meeting/get_info/get_meeting_question.php?meeting_id=' + meeting_id + '&topic_id=' + topic_id;

				request.open("GET", url, true);
				request.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
				request.onreadystatechange = displayResult;		//千萬不能加括號
				request.send(null);								// 送出請求（由於為 GET 所以參數為 null）
			}
		}
		
		function get_topic_answer_request() 					//取得會議id
		{
			request = createRequest();
			if (request != null) 
			{
				var url = '../../../back_end/meeting/get_info/get_meeting_answer.php?meeting_id=' + meeting_id + '&topic_id=' + topic_id;

				request.open("GET", url, true);
				request.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
				request.onreadystatechange = displayResult;		//千萬不能加括號
				request.send(null);								// 送出請求（由於為 GET 所以參數為 null）
			}
		}
		
		function get_meeting_doc_list_request()					//取得會議文件列表 
		{
			request = createRequest();
			if (request != null) 
			{
				var url = '../../../back_end/meeting/get_info/get_meeting_doc.php?meeting_id=' + meeting_id + '&topic_id=' + topic_id;

				request.open("GET", url, true);
				request.onreadystatechange = displayResult;		// 千萬不能加括號
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
							if (get_num_of_doc > now_num_of_doc);
								update_doc_list();
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
		
		setInterval("get_topic_answer_request();", 1000) //每隔一秒發出一次查詢
		setInterval("get_topic_question_request();", 1100) //每隔一秒發出一次查詢
		setInterval("get_meeting_doc_list_request();", 1300)
		
		function update_question() 
		{  
			var question = "";
			var question_id = 0;
			var count = 0;
			var meeting_doc_row = 0;
			
			for (var i = now_num_of_question; i <= get_num_of_question; i++ )
			{
				count = count + 1;
				
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
		
		function update_answer() 
		{  
			
			var answer = "";
			var question_id = 0;
			
			for (var i = 1; i <= get_num_of_answer; i++ )
			{
				
				answer = obj.contents.obj_answer.head_answer[i-1];
				question_id = obj.contents.obj_answer.question_id[i-1];
				
				document.getElementById("meeting_answer" + question_id).innerHTML = 
					'<td id = "tableValueCol1">回答</td>' + 
					'<td id = "tableValueCol2">' + answer + '</td>';
			}
			
			now_num_of_answer = get_num_of_answer;
		}
		
		function update_doc_list() 
		{  
			var link = "";

			
			for (var i = 1; i <= get_num_of_doc; i++ )
			{
				
				link = obj.link.obj_doc_list.open_doc[i-1];
				doc_name = obj.link.obj_doc_list.remark_name[i-1];
				
				document.getElementById("doc_list" + i).innerHTML = 
					'<a href="' + link + '" style="color:#333333;width:auto;line-height:200%;">' + 
					doc_name + '</a>';

			}
			now_num_of_doc = get_num_of_doc;
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
						<dt><a href="em_meeting_vote.php?meeting_id=<?php echo $meeting_id; ?>&topic_id=<?php echo $topic_id; ?>">投票</a></dt>
						<dt><a href="em_meeting_info.php?meeting_id=<?php echo $meeting_id; ?>">返回</a></dt>
						<dt><a href="em_meeting_info_doc.php?meeting_id=<?php echo $meeting_id; ?>">會議文件</a></dt>
						<dt><a href="em_meeting_info_member_list.php?meeting_id=<?php echo $meeting_id; ?>">與會者名單</a></dt>
						<dt><a href="../group/group.php?group_id=<?php echo $group_id; ?>">返回群組</a></dt>
						<dt><a href="">登出</a></dt>
				</dt>
			</dl>
			
			
			<div id="main_in_main">
				<?php
					echo "<p id=\"conventionTittle\">會議 - ".$meeting_title."</p>"
				?>
				<p id="conventionTittle">議題 - <?php echo $meeting_topic; ?></p>

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
										<td id="tableValueCol1"><input id="tableValue1" type="text" name="question" /></td>
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
				
				
				<!--	============================================================================================	-->
				
				


				
			</div>
			
		</div>
	</div>
</body>
</html>

