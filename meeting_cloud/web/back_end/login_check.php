<?php
	
	// 請查詢此機是local server 還是普通登錄
	
	if(!isset($_SESSION["id"]) || ($_SESSION["id"] == ""))		//還沒登入會自動跳回首頁
	{
		echo "beak home\n";
		header ("Location: index.php");
	}	
	
?>