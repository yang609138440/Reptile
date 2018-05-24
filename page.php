<?php



function getPageUrl($page){
	$url = "https://www.amazon.com/hz/leaderboard/top-reviewers/ref=cm_cr_tr_link_$page?page=$page";
	return $url;
}

//抓取页面数据，存入text.txt文件中
function getPageUserUrl($url) {
	global $agentarry;
	$ch = curl_init();  
	// $curlurl = "http://www.amztool.cn/index.php";  
	$curlurl = $url;  //要抓取的网址
	$referurl = "http://www.rabbitHome.com";  //来源网址
	$ip=mt_rand(11, 191).".".mt_rand(0, 240).".".mt_rand(1, 240).".".mt_rand(1, 240);   //随机ip  
	
	//$useragent="Mozilla/5.0 (Windows NT 6.1) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11";  //要得到类似这样useranget 可以自定义  
	$useragent=$agentarry[array_rand($agentarry,1)];  //随机浏览器useragent  


	// echo $ip.PHP_EOL;die;
	// echo $useragent;die;
	echo "构造ip:".$ip.PHP_EOL;


	$header = array(  
	    'CLIENT-IP:'.$ip,  
	    'X-FORWARDED-FOR:'.$ip,  
	);    //构造ip  
	curl_setopt($ch, CURLOPT_URL, $curlurl); //要抓取的网址  
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);  
	curl_setopt($ch, CURLOPT_REFERER, $referurl);  //模拟来源网址  
	curl_setopt($ch, CURLOPT_USERAGENT, $useragent); //模拟常用浏览器的useragent  
	  
	$page_content = curl_exec($ch);  

	//错误输出
	if(curl_errno($ch)){
	    echo '***********抓取错误************'.PHP_EOL.curl_error($ch);
	    // exit(); 
	    // //这里是设置个错误信息的反馈
	}

	//获取cookie
	// preg_match('/Set-Cookie:(.*);/iU',$page_content,$str); //这里采用正则匹配来获取cookie并且保存它到变量$str里，这就是为什么上面可以发送cookie变量的原因
	// $cookie = $str[1]; //获得COOKIE（SESSIONID）
	// echo "---------获取到cookie----------".PHP_EOL;
	// var_dump($str);
	// echo "-------------------------------".PHP_EOL;




	//存入文件
	$file = fopen('text.txt','w');
	fwrite($file, $page_content);
	fclose($file);
	echo "页面信息保存成功......".PHP_EOL;


	//关闭curl
	curl_close($ch);  
}


function getDataByUrl($url) {
	global $agentarry;
	$ch = curl_init();  
	// $curlurl = "http://www.amztool.cn/index.php";  
	$curlurl = $url;  //要抓取的网址
	$referurl = "http://www.rabbitHome.com";  //来源网址
	$ip=mt_rand(11, 191).".".mt_rand(0, 240).".".mt_rand(1, 240).".".mt_rand(1, 240);   //随机ip    
	$useragent=$agentarry[array_rand($agentarry,1)];  //随机浏览器useragent  

	echo "构造ip:".$ip.PHP_EOL;
	$header = array(  
	    'CLIENT-IP:'.$ip,  
	    'X-FORWARDED-FOR:'.$ip,  
	);    //构造ip  
	curl_setopt($ch, CURLOPT_URL, $curlurl); //要抓取的网址  
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);  
	curl_setopt($ch, CURLOPT_REFERER, $referurl);  //模拟来源网址  
	curl_setopt($ch, CURLOPT_USERAGENT, $useragent); //模拟常用浏览器的useragent  
	$page_content = curl_exec($ch);  
	//错误输出
	if(curl_errno($ch)){
	    echo '***********抓取错误************'.PHP_EOL.curl_error($ch);
	    // exit();
	    return null; 
	    //这里是设置个错误信息的反馈
	}

	//关闭curl
	curl_close($ch);  

	return $page_content;
}



