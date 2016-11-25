﻿<?php

	//http://127.0.0.1:8080/meeting_cloud/web/employee_web/meeting/meeting_record.php?meeting_id=27
	
	if(!isset($_SESSION))
	{  	session_start();	}			//用 session 函式, 看用戶是否已經登錄了

	require_once("../../../connMysql.php");			//引用connMysql.php 來連接資料庫
	
//	require_once("../../../login_check.php");
	
	if (isset($_SESSION["id"]))
		$id = $_SESSION["id"];
	else
		$id = "a@";
	
	$meeting_id = $_GET['meeting_id'];

	
	$sql = "select * from meeting_scheduler where meeting_id = '".$meeting_id."'";
	$result = $conn->query($sql);
	$row=$result->fetch_array();
	$meeting_title = $row['title'];
	$group_id = $row['group_id'];
	$moderator_id = $row['moderator_id'];					//看是否主席
	
	$sql = "select * from group_meeting_topics where meeting_id = '".$meeting_id."'";
	$result = $conn->query($sql);
	
	$num_of_topic = $result->num_rows;		//看有多少個議題
	
	
	
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
					會議資訊
						<dt><a href="em_meeting_running.php?meeting_id=<?php echo $meeting_id; ?>">返回會議議題列表</a></dt>
						<dt><a href="em_meeting_running_vote.php?meeting_id=<?php echo $meeting_id; ?>&topic_id=<?php echo $topic_id; ?>">投票</a></dt>
						
						<dt><a href="">結束會議</a></dt>
				</dt>
			</dl>
			<p id="conventionTittle">會議 - <?php echo $meeting_title; ?></p>
		<?php
			
			for ($i = 1; $i <= $num_of_topic; $i++)
			{
				$row = $result->fetch_array();
				$meeting_topic = $row['topic'];
				$topic_id = $row['topic_id'];
				echo "<div id=\"main_in_main\">".
						"<p id=\"conventionTittle\">議題 - ".$meeting_topic."</p>".
						"<div id=\"main_sub\">".
							"<p id=\"conventionTittle\">說明</p>".
							"<table id=\"table\">".
								"<tr>".
									"<table id=\"table\">".
										"<tr>".
											"<td id=\"tableTittleCol1\" > </td>".
										"</tr>".
									"</table>".
								"</tr>".
								"<tr>".
									"<div style=\"width:600px; height:200px; overflow:hidden;\">".
									"<div style=\"width:605px; height:200px; overflow-y: auto;\">".
										"<table id=\"table\">";
						//				會議說明
						$meeting_content_sql = "select * from meeting_topic_contents ".
											   "where meeting_id = '".$meeting_id."' and topic_id = '".$topic_id."'";
											   
						$meeting_content_result = $conn->query($meeting_content_sql);
						$num_of_meeting_content = $meeting_content_result->num_rows;
						
								for ($j = 1; $j <= $num_of_meeting_content; $j++)
								{	
									$meeting_content_row = $meeting_content_result->fetch_array();
									echo "<tr id = \"meeting_content".$j."\">".
											'<td id = "tableValueCol2">'.$meeting_content_row['content'].'</td>'.
										 "</tr>";	
								}
						echo			"</table>".
									"</div>".
									"</div>".
								"</tr>".
							"</table>".
						"</div>";
						
				//=====================================================================================================================//
				
				echo 	"<div id=\"main_sub\">".
							"<p id=\"conventionTittle\">決議</p>".
							"<table id=\"table\">".
								"<tr>".
									"<table id=\"table\">".
										"<tr>".
											"<td id=\"tableTittleCol1\" > </td>".
										"</tr>".
									"</table>".
								"</tr>".
								"<tr>".
									"<div style=\"width:600px; height:200px; overflow:hidden;\">".
									"<div style=\"width:605px; height:200px; overflow-y: auto;\">".
										"<table id=\"table\">";
						//				會議決議
						$meeting_minutes_sql = "select * from meeting_minutes ".
											   "where meeting_id = '".$meeting_id."' and topic_id = '".$topic_id."'";
											   
						$meeting_minutes_result = $conn->query($meeting_minutes_sql);
						$num_of_meeting_minutes = $meeting_minutes_result->num_rows;
						
								for ($j = 1; $j <= $num_of_meeting_minutes; $j++)
								{	
									$meeting_minutes_row = $meeting_minutes_result->fetch_array();
									echo "<tr id = \"meeting_minutes".$j."\">".
											'<td id = "tableValueCol2">'.$meeting_minutes_row['meeting_minutes'].'</td>'.
										 "</tr>";	
								}
						echo			"</table>".
									"</div>".
									"</div>".
								"</tr>".
							"</table>".
						"</div>";
							
							
							
				//=====================================================================================================================//
				
				$meeting_question_sql = "select * from meeting_questions ".
										"where meeting_id = '".$meeting_id."' and topic_id = '".$topic_id."'";
				$meeting_answer_sql = "select * from meeting_questions ".
									  "where meeting_id = '".$meeting_id."' and topic_id = '".$topic_id."'";
									   
				$meeting_question_result = $conn->query($meeting_question_sql);
				$num_of_meeting_question = $meeting_question_result->num_rows;
				
				$meeting_answer_result = $conn->query($meeting_answer_sql);
				$num_of_meeting_answer = $meeting_answer_result->num_rows;
				
				if ($num_of_meeting_question > 0)
				{
					echo 	"<div id=\"main_sub\">".
								"<p id=\"conventionTittle\">Q & A</p>".
								"<table id=\"table\">".
									"<tr>".
										"<table id=\"table\">".
											"<tr>".
												"<td id=\"tableTittleCol1\" > </td>".
											"</tr>".
										"</table>".
									"</tr>".
									"<tr>".
										"<div style=\"width:600px; height:200px; overflow:hidden;\">".
										"<div style=\"width:620px; height:200px; overflow-y: auto;\">".
											"<table id=\"table\">";
							//				會議決議
							
							
									for ($j = 1; $j <= $num_of_meeting_question; $j++)
									{	
										$meeting_question_row = $meeting_question_result->fetch_array();
										echo "<tr id = \"meeting_question".$j."\">".
												'<td id = "tableValueCol1">'.$meeting_question_row['question'].'</td>'.
											 "</tr>";
										
										echo "<tr id = \"meeting_answer".$j."\">".
												'<td id = "tableValueCol2">'.$meeting_answer_row['answer'].'</td>'.
											 "</tr>";
									}
					echo					"</table>".
										"</div>".
										"</div>".
									"</tr>".
								"</table>".
							"</div>";
				}		
				
				$path = "../../../back_end/upload_space/group_upload_space/".$group_id."/".$meeting_id."/".$topic_id."/";
				$first_file = 0;
				if (is_dir($path) != false)
				{
					if ($opendir = opendir($path))
					{
						while (($file = readdir($opendir)) !==FALSE)
						{	

							if ($file != "." && $file != "..")				//有點就不是目錄
							{
								
								if ( strstr($file, '.') )
								{
									if( $first_file == 0 )
									{
										$first_file = 1;
										echo 	"<div id=\"main_sub\">".
													"<p id=\"conventionTittle\">附件</p>".
													"<table id=\"table\">".
														"<tr>".
															"<table id=\"table\">".
																"<tr></tr>".
															"</table>".
														"</tr>".
														"<tr>".
															"<div style=\"width:600px; height:200px; overflow:hidden;\">".
															"<div style=\"width:620px; height:200px; overflow-y: auto;\">".
																"<table id=\"table\">";
									}
									$file = iconv("BIG5", "UTF-8",$file);
									$file_link = $path.$file;
									echo						"<tr id = \"doc_list".$j."\">".
																'<a href="'.$file_link.'" style="color:#333333;width:auto;line-height:200%;">'.$file.'</a>'.
																"</tr>";
								}
							}
						}
						if ($first_file != 0)
						{
									echo						"</table>".
															"</div>".
															"</div>".
														"</tr>".
													"</table>".
												"</div>";
						}
					}
				}
										
										
										
										
			}
?>
				
				
			</div>
			
		</div>
	</div>
	
	
	<!--	============================================================================================	-->
	
</body>
</html>
