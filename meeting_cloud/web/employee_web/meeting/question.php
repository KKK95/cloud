<?php

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
	$group_id = $row['group_id'];
	
	$topic_id = $_POST['topic_id'];
	
?>


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link rel="stylesheet" type="text/css" href="../../main_css/main.css">
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	
	<script language="JavaScript" src="../../main_js/leftBarSlide.js"></script>
	
	<script>
		var now_num_of_question = 0;
		var get_num_of_question = 0;
		
		var get_num_of_answer = 0;
		var now_num_of_answer = 0;
		
		var obj;

		function ask() 
		{
			set_question_request = createRequest();
			if (set_question_request != null) 
			{
		<?php
				echo "var url = \"../../../back_end/meeting/set_info/set_meeting_question.php?meeting_id=".$meeting_id."\";";
		?>
				set_question_request.open("POST", url, true);
				set_question_request.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
				set_question_request.send("topic_id=" + <?php echo $topic_id; ?>);
				set_question_request.send("question=" + document.ask_form.question.value);						// 送出請求（由於為 GET 所以參數為 null）
				document.ask_form.question.value = "";
			}
		}
		
		function answer()
		{
			set_answer_request = createRequest();
			if (set_topic_request != null) 
			{
		<?php
				echo "var url = \"../../../back_end/meeting/set_info/set_meeting_answer.php?meeting_id=".$meeting_id."\";";
		?>
				set_answer_request.open("POST", url, true);
				set_answer_request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
				set_answer_request.send("topic_id=" + <?php echo $topic_id; ?>);
				set_answer_request.send("member=" + document.answer_form.answer.value);						// 送出請求（由於為 GET 所以參數為 null）
				document.answer_form.answer.value = "";
			}
		}
		
		function get_meeting_question_request() 					//取得會議id
		{
			get_question_request = createRequest();
			if (get_question_request != null) 
			{
		<?php
				echo "var url = \"../../../back_end/meeting/get_info/get_question.php?meeting_id=".$meeting_id."\";";
		?>

				get_question_request.open("post", url, true);
				get_question_request.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
				get_question_request.send("topic_id=" + <?php echo $topic_id; ?>);
				get_question_request.onreadystatechange = displayResult;		//千萬不能加括號
			}
		}
		
		function get_meeting_answer_request() 					//取得會議id
		{
			get_answer_request = createRequest();
			if (get_answer_request != null) 
			{
		<?php
				echo "var url = \"../../../back_end/meeting/get_info/get_meeting_member_list.php?meeting_id=".$meeting_id."\";";
		?>

				get_answer_request.open("post", url, true);
				get_answer_request.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
				get_answer_request.send("topic_id=" + <?php echo $topic_id; ?>);
				get_answer_request.onreadystatechange = displayResult;		//千萬不能加括號
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
						
						if ( obj['contents'] && obj.contents['obj_question'] && obj.contents.obj_question != "none")		//收到question
						{
							get_num_of_question = obj.contents.obj_question.head_question.length;
							if (get_num_of_question > now_num_of_question)
								add_new_question();
						}
						else if ( obj['contents'] && obj.contents['obj_answer'] && obj.contents.obj_answer != "none")		//收到answer
						{
							get_num_of_answer = obj.contents.obj_answer.head_answer.length;
							if (get_num_of_answer > now_num_of_answer)
								add_new_answer();
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
		
		setInterval("get_meeting_question_request();", 1000) //每隔一秒發出一次查詢
		setInterval("get_meeting_answer_request();", 1000) //每隔一秒發出一次查詢
			
		function add_new_question()
		{  
			var count = now_num_of_question;

			for (var i = now_num_of_question; i < get_num_of_question; i++ )
			{
				count = count + 1;
				
				document.getElementById("question" + count).innerHTML = document.getElementById("question" + count).innerHTML + 
					'<td id = "tableValueCol1" style="width:150px">' + obj.contents.obj_question.head_question[i] + '</td>';
				
				now_num_of_question = now_num_of_question + 1;
			}
		}
		
		function add_new_answer()
		{  

			for (var i = 0; i < get_num_of_answer; i++ )
			{
				count = obj.contents.obj_answer.question_id[i];
				
				
				document.getElementById("answer" + count).innerHTML = document.getElementById("answer" + count).innerHTML + 
					'<td id = "tableValueCol1" style="width:150px">' + obj.contents.obj_answer.head_answer[i] + '</td>';
				
				now_num_of_answer = now_num_of_answer + 1;
			}
		}
	</script>