<?php

	//http://127.0.0.1:8080/meeting_cloud/web/employee_web/meeting/em_meeting_vote.php?meeting_id=4&topic_id=1
	
	if(!isset($_SESSION))
	{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
//	require_once("../../../../login_check.php");
	
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

	<link rel="stylesheet" type="text/css" href="../../../main_css/main.css">
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	
	<script language="JavaScript" src="../../../main_js/leftBarSlide.js"></script>
	
	<script>
		var now_meeting_member = 0;
		var get_now_meeting_member = 0;
		
		var join_meeting_member = 0;
		var get_join_meeting_member = 0;
		
		var now_num_of_voting = 0;
		var get_num_of_voting = 0;
		
		var now_num_of_option = 0;
		var get_num_of_option = 0;
		
		var group_id = <?php echo $group_id; ?>;
		var meeting_id = <?php echo $meeting_id; ?>;
		var topic_id = <?php echo $topic_id; ?>;
		
		var get_voting_list_time = 200;
		var get_meeting_member_list_time = 100;
		
		var obj;

		function set_voting(issue) 
		{
			
			set_voting_request = createRequest();
			if (set_voting_request != null) 
			{
				var url = '../../../../back_end/meeting/set_info/set_meeting_initiate_vote.php?meeting_id=' + meeting_id + '&topic_id=' + topic_id;
				set_voting_request.open("POST", url, true);
				set_voting_request.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
				set_voting_request.send("issue=" + issue);						// 送出請求（由於為 GET 所以參數為 null）
				set_voting_request.onreadystatechange = displayResult;
			}
		}
		
		function set_option(option, issue_id) 
		{
			update_option_request = createRequest();
			if (update_option_request != null) 
			{
				var url = '../../../../back_end/meeting/set_info/set_meeting_voting_option.php?meeting_id=' + meeting_id + '&topic_id=' + topic_id + '&issue_id=' + issue_id;

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
				vote_request.send("issue_id=" + issue_id);
				document.getElementById(id).value = "";

			}
		}
		*/
		function get_voting_list_request() 					//取得會議id
		{
	//		get_voting_list_time = 1000;
			request = createRequest();
			if (request != null) 
			{
				var url = '../../../../back_end/meeting/get_info/get_meeting_voting_result.php?meeting_id=' + meeting_id + '&topic_id=' + topic_id;
				request.open("GET", url, true);
				request.onreadystatechange = displayResult;		//千萬不能加括號
				request.send(null);								// 送出請求（由於為 GET 所以參數為 null）
			}
		}
		
		function get_meeting_member_list_request() 					//取得會議id
		{
	//		get_meeting_member_list_time = 1250;
			request = createRequest();
			if (request != null) 
			{
				var url = '../../../../back_end/meeting/get_info/get_meeting_member_list.php?meeting_id=' + meeting_id;

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
		
		setInterval("get_voting_list_request();", 900) //每隔一秒發出一次查詢
		setInterval("get_meeting_member_list_request();", 400)
		
		
			
		function update_voting() 
		{  
			var voting;
			var voting_id;
			var option = "";
			var obj_option = "";
			var count = 0;
			var option_count = 0;
			var result = 0;
			var form = "";
			
			console.log(get_num_of_voting);
			for ( var i = 0 ; i < get_num_of_voting ; i++ )
			{
				count = count + 1;
				voting = obj.contents.obj_voting_result.head_issue[i];
				voting_id = obj.contents.obj_voting_result.issue_id[i];
				obj_option = "obj_" + voting_id;
			/*
				if ( now_num_of_voting == 0 )
				{	document.getElementById("first_voting").innerHTML = '<p id="conventionTittle">投票—' + voting + '</p>' ;	}
			*/
				
				console.log("i = " + i);
				if ( i >= now_num_of_voting )		//輸出一個新欄位
				{
					document.getElementById("voting" + count).innerHTML =
					'<div id="main_sub">' + 
					'<p id="conventionTittle">投票-' + voting + '</p>' + 
					'<table id = "table">' +
					'<tr>' + 
						'<table id="table">' +
							'<tr>' +
								'<td id="tableTittleCol1" > </td>' +
							'</tr>' +
						'</table>' +
					'</tr>' +
					'<tr>' + 
						'<div style="width:600px; height:200px; overflow:hidden;">' +
						'<div style="width:620px; height:200px; overflow-y: auto;">' +
							'<form name="vote_form' + count + '" method="post" action="../../../../back_end/meeting/set_info/set_meeting_vote.php">' + 
							'<table id="table">' +
		'<tr id = "voting' + count + '-option1"></tr><tr id = "voting' + count + '-option2"></tr>' + 
		'<tr id = "voting' + count + '-option3"></tr><tr id = "voting' + count + '-option4"></tr>' +
		'<tr id = "voting' + count + '-option5"></tr>' +
								'<input name="issue_id" value="' + voting_id + '" type="hidden"/>' +
								'<input name="meeting_id" value="' + meeting_id + '" type="hidden"/>' +
								'<input name="topic_id" value="' + topic_id + '" type="hidden"/>' + 
							'</table>' +
							'</form>' + 
						'</div>' + 
						'</div>' +
					'</tr>' + 
					'<tr>' +
						'<form name="set_voting_option_form' + count + '">' +
						'<table id="table">' + 
							'<tr>' +
								'<td id="tableTittle1">對投票提出選項</td>' +
								
									'<td id="tableValueCol1"><input id="tableValue1" type="text" name="option" /></td>' + 
									'<td>' +
									'<input name="set_voting_option' + count + '" ' + 
											'type="button" value="新增" ' +
											'onclick="set_option(document.set_voting_option_form' + count + '.option.value, ' + voting_id + '); set_voting_option_form' + count + '.reset()" />' + 
									'</td>' + 
								 
							'</tr>' + 
						'</table>' + 
						'</form>' +
						'<div id = "vote' + count + '"> </div>' + 
					'</tr>' +
					'</table>' + 
					'</div>';	
					
				}
				
				
				if ( obj.contents[obj_option] )			//如果有選項
				{
					option_count = 0;
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
								'<td id="tableTittleCol2"><input type="radio" name="option_id" value="' + option_id + '" /></td>' + 
								'<td id="tableValue1">' +
								'<input id="tableValue2" type="text" name="text" value="票數：' + result + '　' + option + '" readonly="readonly"/>' +
								'</td>';
						}
					}
					if (obj.contents.obj_voting_result.member_vote[i] == 0)	//已投票
					{
						document.getElementById("vote" + count).innerHTML =
						'<input id="tableButton" type="submit" value="送出投票" onclick="vote_form' + count + '.submit();"/>';
					}
				}
				
			}
			
			now_num_of_voting = get_num_of_voting;
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
						<dt><a href="em_meeting_running_topic.php?meeting_id=<?php echo $meeting_id; ?>&topic_id=<?php echo $topic_id; ?>">返回議題</a></dt>
						
						<dt><a href="">結束會議</a></dt>
				</dt>
			</dl>
			
			
			<div id="main_in_main">
				<?php
					echo "<p id=\"conventionTittle\">會議 - ".$meeting_title."</p>"
				?>
				<p id="conventionTittle">議題 - <?php echo $meeting_topic; ?></p>
				
				<?php    
					$num_of_voting = 30;
					for ($i = 1; $i <= $num_of_voting; $i++)
						echo "<div id = \"voting".$i."\"></div>";
				?> 
				
				<tr>
					<table id="table">
						<tr>
							<td id="tableTittle1">投票標題</td>
							<form name="set_voting_form">
								<td id="tableValueCol1"><input id="tableValue1" type="text" name="issue" /></td>
							</form>
						</tr>
					</table>
					<input id="tableButton" type="submit" value="發起投票" onclick="set_voting(document.set_voting_form.issue.value); set_voting_form.reset()"/>
				</tr>
				
			</div>
			
			
			
		</div>
	</div>
	
	<!-- ============================================================================================================================== -->
	
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
	
	