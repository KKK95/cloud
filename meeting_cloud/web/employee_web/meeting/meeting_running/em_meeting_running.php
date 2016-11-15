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
	
	$sql = "select * from group_meeting_now where member_id = '".$id."'";
	$result=$conn->query($sql);
	$row=$result->fetch_array();
	$meeting_id = $row['meeting_id'];
	
	$sql = "select * from meeting_scheduler where meeting_id = '".$meeting_id."'";
	$result = $conn->query($sql);
	$row=$result->fetch_array();
	$meeting_title = $row['title'];
	$group_id = $row['group_id'];
	
	
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
		
		var obj;

		function invite_member() 
		{
			invite_member_request = createRequest();
			if (invite_member_request != null) 
			{
		<?php
				echo "var url = \"../../../../back_end/meeting/set_info/set_meeting_member.php?meeting_id=".$meeting_id."\";";
		?>
				set_topic_request.open("POST", url, true);
				set_topic_request.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
				set_topic_request.send("member=" + document.invite_member_form.member.value);						// 送出請求（由於為 GET 所以參數為 null）
				document.invite_member_form.member.value = "";
			}
		}
		
		
		function get_meeting_member_list_request() 					//取得會議id
		{
			request = createRequest();
			if (request != null) 
			{
		<?php
				echo "var url = \"../../../../back_end/meeting/get_info/get_meeting_member_list.php?meeting_id=".$meeting_id."\";";
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
					if (	request.responseText.indexOf("{") != -1	)
					{
						obj = eval('(' + request.responseText + ')');
						
						if ( obj['contents'] && obj.contents['obj_meeting_member_list'] && obj.contents.obj_meeting_member_list != "none")
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
		
		setInterval("get_meeting_member_list_request();", 1000) //每隔一秒發出一次查詢
			
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
						<dt><a href="em_meeting_info.php?meeting_id=<?php echo $meeting_id; ?>">會議議題</a></dt>
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
				<div id="main_sub">
					<p id="conventionTittle">與會者名單</p>
					<table id="table">
						<table id="table">
							<tr>
								<table id="table">
									<tr>
										<td id="tableTittleCol1" style="width:150px">姓名</td>
										<td id="tableTittleCol1" style="width:150px">職位</td>
										<td id="tableTittleCol2" style="width:300px">e-mail</td>
									</tr>
								</table>
							</tr>
							<tr>
								<div style="width:600px; height:200px; overflow:hidden;" >
								<div style="width:620px; height:200px; overflow-y: auto;">
									<table id="table">
									
										<?php    
										$num_of_meeting_member = 30;
										for ($i =1; $i<=$num_of_meeting_member; $i++)
											echo "<tr id = \"meeting_member".$i."\"></tr>";
										?>    
										
										<tr></tr>
									</table>
								</div>
								</div>
							</tr>
						</table>
						<tr>
							<table id="table">
								<tr>
									<td id="tableTittle1">新增與會者</td>
									<?php
										echo "<form name=\"set_member_form\" method=\"post\"
												action=\"../../../back_end/meeting/set_info/set_meeting_topic.php?meeting_id=".$meeting_id."\">";
									?>
									<td id="tableValueCol1"><input id="tableValue1" type="text" name="member" /></td>
									
									</form>
								</tr>
							</table>
							<input id="tableButton" type="submit" value="確認送出" onclick="invite_member();"/>
						</tr>
					</table>
				</div>
				
			</div>
			
		</div>
	</div>
	
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
				<td id="tableTittle1">尚未</td>
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

