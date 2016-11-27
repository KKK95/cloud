<?php

	//http://127.0.0.1:8080/meeting_cloud/web/employee_web/meeting/em_meeting_info.php?meeting_id=4
	
	if(!isset($_SESSION))
	{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
//	require_once("../../../login_check.php");
	
	$meeting_id = $_GET['meeting_id'];
	
	if (isset($_SESSION["id"]))
		$id = $_SESSION["id"];
	else
		$id = "a@";
	
	$sql = "select * from join_meeting_member where meeting_id = '".$meeting_id."' and member_id = '".$id."'";
	$result = $conn->query($sql);
	$join_meeting = $result->num_rows;
	if ($join_meeting != 1)
		header("Location: ../employee_center.php" );
	
	
	
	$sql = "select * from meeting_scheduler where meeting_id = '".$meeting_id."'";
	$result = $conn->query($sql);
	$row=$result->fetch_array();
	$meeting_title = $row['title'];
	$group_id = $row['group_id'];
	$over = $row['over'];
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
		
		var group_id = <?php echo $group_id; ?>;
		var meeting_id = <?php echo $meeting_id; ?>;
		var go_back = '../../../';
		
		function upload_doc() 
		{
			
			var formData = new FormData();
			var doc = document.upload_doc_form.doc;
			formData.append("fileToUpload", doc.files[0]);			//把doc 放進一個form裏面再送出去
			
			var upload_request = createRequest();

			if (upload_request != null) 
			{
				var url = go_back + 'back_end/upload_space/upload.php?upload_path=group_upload_space/' + group_id + '/' + meeting_id;
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
			var url = go_back + 'back_end/meeting/get_info/get_meeting_doc.php?meeting_id=' + meeting_id;
			request = createRequest();
			console.log(url);
			if (request != null) 
			{
				
				request.open("GET", url, true);
				request.onreadystatechange = displayResult;		// 千萬不能加括號
				request.send(null);								// 送出請求（由於為 GET 所以參數為 null）
				request.onreadystatechange = displayResult;		// 千萬不能加括號
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
						
						if (  obj['link'] && obj.link['obj_doc_list'] && obj.link.obj_doc_list != "none" )
						{
							
							console.log(request.responseText);
							get_num_of_doc = obj.link.obj_doc_list.remark_name.length;
							if (get_num_of_doc > now_num_of_doc)
								add_new_doc();
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
		
		setInterval("get_meeting_doc_list_request();", 2000) //每隔一秒發出一次查詢
			
		
		function add_new_doc() 
		{  
			var count = 0;
			var meeting_doc_row = 0;
			
			for (var i = 0; i < get_num_of_doc; i++ )
			{
				count = count + 1;
				meeting_doc_row = count % 2;
				if (meeting_doc_row == 0)	meeting_topic_row = 2;
				
				document.getElementById("doc_list" + count).innerHTML = 
					'<a href="' + go_back + obj.link.obj_doc_list.open_doc[i] + '" style="color:#333333;width:auto;line-height:200%;">' + 
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
							<div style="width:600px; height:200px; overflow:hidden;">
							<div style="width:620px; height:200px; overflow-y: auto;">
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
						<?php
							if ( $over != 1 )
							{
								echo "<tr>".
										"<table id=\"table\">".
											"<tr>".
												"<td id=\"tableTittle1\">上傳會議文件</td>".

													"<form name=\"upload_doc_form\" method=\"post\" enctype=\"multipart/form-data\">".
														"<td id=\"tableValueCol1\"><input id=\"tableValueCol1\" type=\"file\" name=\"doc\" /></td>".
													"</form>".
											"</tr>".
										"</table>".
										"<input id=\"tableButton\" name=\"upload_doc\" type=\"submit\" value=\"確認送出\" onclick=\"upload_doc();\"/>".
									"</tr>";
							}
						?>
					</table>
				</div>
				
				
			</div>
			
		</div>
	</div>
</body>
</html>

