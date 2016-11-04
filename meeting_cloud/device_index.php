<?php 

	$state = "none";
	
	if (isset($_GET["loginfail"])) 
	{ 
		$state = "login_fail";
	}
	
	$json = array
	(
		"form" => array
		(
			"login" => array 
			(
				"func" => "longin",
				"addr" => "device_login.php",
				"form" => array
				(
					"id" => "none",
					"pw" => "none"
				)
			)
		)
	);
	
	echo json_encode( $json );

	/*
php有二個函式：
json_encode()
json_decode()
用法：
json_encode(陣列)
上面是把陣列轉json
反解：
$array = json_decode(json,bool);
要注意decode
json_decode的第二個參數如果不給
他是把json轉成php的物件
如果第二個參數給true
則是轉成php的陣列
另外要注意的是：
如果你用json_encode去壓縮成json資料時
會發生「中文字編碼」異常的問題
但我要說明這不是錯誤。
而是他轉換成utf-8原始編碼形態
他是utf-8，但是不是你看得懂的那種
可是在json_decode時
他會幫你還原成你看得懂的中文
來個例子
array('sam','john','bill');
他的json形態是：
["sam","john","bill"]

array('name'=>'sam','city'=>'taipei','sex'=>'mail')
他的形態是：
{"sam":"name","city":"taipei","sex":"mail"}

多維形態可能會變這樣：
[{"key":"value"},{"key":"value"},{"key":"value"}]

至於什麼時候是中括什麼時候是大括是有規則的。
只有值沒有key時是中括
有key時就變成大括<pre lang="php">
*/
	
	
	?>


