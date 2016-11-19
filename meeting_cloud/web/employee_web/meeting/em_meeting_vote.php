<?php

	//http://127.0.0.1:8080/meeting_cloud/web/employee_web/meeting/em_meeting_vote.php?meeting_id=4&topic_id=1
	
	if(!isset($_SESSION))
	{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
//	require_once("../../../login_check.php");
	
	$meeting_id = $_GET['meeting_id'];
	$topic_id = $_GET['topic_id'];
	
	$sql = "select * from meeting_scheduler where meeting_id = '".$meeting_id."'";
	$result = $conn->query($sql);
	$row=$result->fetch_array();
	$meeting_title = $row['title'];
	$group_id = $row['group_id'];
	
	$sql = "select * from group_meeting_topics where meeting_id = '".$meeting_id."' and topic_id = '".$topic_id."'";
	$result = $conn->query($sql);
	$row=$result->fetch_array();
	$meeting_topic = $row['topic'];
	
	if (isset($_SESSION["id"]))
		$id = $_SESSION["id"];
	else
		$id = "a@";
?>


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link rel="stylesheet" type="text/css" href="../../main_css/main.css">
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	
	<script language="JavaScript" src="../../main_js/leftBarSlide.js"></script>
	
	<script>
		var now_num_of_voting = 0;
		var get_num_of_voting = 0;
		
		var now_num_of_option = 0;
		var get_num_of_option = 0;
		
		var group_id = <?php echo $group_id; ?>;
		var meeting_id = <?php echo $meeting_id; ?>;
		var topic_id = <?php echo $topic_id; ?>;
		
		var obj;

		function set_voting(issue, id) 
		{
			
			set_voting_request = createRequest();
			if (set_topic_request != null) 
			{
				var url = '../../../back_end/meeting/set_info/set_meeting_initiate_vote.php?meeting_id=' + meeting_id + '&topic_id=' + topic_id;
				set_voting_request.open("POST", url, true);
				set_voting_request.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
				set_voting_request.send("issue=" + issue);						// 送出請求（由於為 GET 所以參數為 null）
				document.getElementById(id).value = "";
			}
		}
		
		function set_option(option, issue_id) 
		{
			update_option_request = createRequest();
			if (update_option_request != null) 
			{
				var url = '../../../back_end/meeting/set_info/set_meeting_voting_option.php?meeting_id=' + meeting_id + '&topic_id=' + topic_id + '&issue_id=' + issue_id;

				update_option_request.open("POST", url, true);
				update_option_request.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
				update_option_request.send("option=" + option);						// 送出請求（由於為 GET 所以參數為 null）
				update_option_request.onreadystatechange = displayResult;
//				update_option_request.send("issue_id=" + issue_id);
			}
		}
		/*
		function vote_request(option_id, issue_id, id)
		{
			vote_request = createRequest();
			if (set_topic_request != null) 
			{
				var url = '../../../back_end/meeting/set_info/set_meeting_vote.php?meeting_id=' + meeting_id + '&topic_id=' + topic_id;
				vote_request.open("POST", url, true);
				vote_request.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
				vote_request.send("option_id=" + option_id);						// 送出請求（由於為 GET 所以參數為 null）
				vote_option_request.send("issue_id=" + issue_id);
				document.getElementById(id).value = "";

			}
		}
		*/
		function get_option_list_request() 					//取得會議id
		{
			request = createRequest();
			if (request != null) 
			{
				var url = '../../../back_end/meeting/get_info/get_meeting_voting_result.php?meeting_id=' + meeting_id + '&topic_id=' + topic_id;
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
					console.log(request.responseText);
					if (	request.responseText.indexOf("{") != -1	)
					{
						obj = eval('(' + request.responseText + ')');
						
						if ( obj['contents'] && obj.contents['obj_voting_result'] && obj.contents.obj_voting_result != "none")
						{
							get_num_of_voting = obj.contents.obj_voting_result.head_issue.length;
								update_voting();
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
		
		setInterval("get_option_list_request();", 1000) //每隔一秒發出一次查詢
			
		function update_voting() 
		{  
			var voting;
			var voting_id;
			var option = "";
			var obj_option = "";
			var count = 0;
			var option_count = 0;
			var result = 0;
			for ( var i = 0 ; i < get_num_of_voting ; i++ )
			{
				option_count = 0;
				count = count + 1;
				voting = obj.contents.obj_voting_result.head_issue[i];
				voting_id = obj.contents.obj_voting_result.issue_id[i];
				obj_option = "obj_" + voting_id;

				if ( now_num_of_voting == 0 )
				{	document.getElementById("first_voting").innerHTML = '<p id="conventionTittle">投票—' + voting + '</p>' ;	}
				else if ( i > now_num_of_voting )		//輸出一個新欄位
				{
					document.getElementById("voting" + count).innerHTML =
					'<div id="main_sub">' + 
					'<p id="conventionTittle">投票-' + voting + '</p>' + 
					'<table id = "table">' +
					'<tr>' + 
						'<div style="width:600px; height:200px; overflow:hidden;">' +
						'<div style="width:620px; height:200px; overflow-y: auto;">' +
							'<table id="table">' +
		'<tr name = "voting' + count + '-option1"></tr><tr name = "voting' + count + '-option2"></tr>' + 
		'<tr name = "voting' + count + '-option3"></tr><tr name = "voting' + count + '-option4"></tr>' +
		'<tr name = "voting' + count + '-option5"></tr>' +
							'</table>' +
						'</div>' + 
						'</div>' +
					'</tr>' + 
					'<tr>' +
						'<table id="table">' + 
							'<tr>' +
								'<td id="tableTittle1">對投票提出選項</td>' +
								'<form name="set_voting_option_form">' +
									'<td id="tableValueCol1"><input id="tableValue1" type="text" name="option" /></td>' + 
								'</form>' + 
							'</tr>' + 
						'</table>' + 
						'<input id="tableButton" name="set_voting_option" type="submit" value="確認送出" onclick="set_voting_option();"/>' + 
					'</tr>' +
					'</table>' + 
					'</div>';	
				}
				
				
				if ( obj.contents[obj_option] )			//如果有選項
				{
					get_num_of_option = obj.contents[obj_option].option.length;
					
					for ( var j = 0; j < get_num_of_option; j++ )								//輸出選項
					{
						option = obj.contents[obj_option].option[j];
						option_id = obj.contents[obj_option].option_id[j];
						option_count = option_count + 1;
						result = obj.contents[obj_option].result[j];
						if (document.getElementById("voting" + count + "-option" + option_count).innerHTML == "")
						{
							document.getElementById("voting" + count + "-option" + option_count).innerHTML = 
								'<td id="tableTittleCol2"><input type="checkbox" name="convention_id" value="' + option_id + '" /></td>' + 
								'<td id="tableValue1">' +
								'<input id="tableValue2" type="text" name="text" value="票數：' + result + '　' + option + '" readonly="readonly"/>' +
								'</td>';
						}
					}
					
				}
			}
			
			now_num_of_voting = get_num_of_voting;
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
				
					<div id="first_voting"> </div>
					
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
											echo "<tr id = \"voting1-option".$i."\"></tr>";
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
									<td id="tableTittle1">對投票提出選項</td>
									<form name="set_voting_option_form1">
										<td id="tableValueCol1"><input id="tableValue1" type="text" name="option"/></td>
										<td><input name="set_voting_option1" type="button" value="新增" onclick="set_option(document.set_voting_option_form1.option.value, 1); set_voting_option_form1.reset()" /></td>
									</form>
								</tr>
							</table>
							<input id="tableButton" name="vote1" type="submit" value="送出投票" onclick="set_voting_option_form1.submit();"/>

						</tr>
					</table>
				</div>
				<?php    
					$num_of_voting = 30;
					for ($i = 1; $i <= $num_of_voting; $i++)
						echo "<div id = \"voting".$i."\"></div>";
				?> 
 
				
			</div>
			
		</div>
	</div>
</body>
</html>
	
	