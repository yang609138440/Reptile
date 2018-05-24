<?php

//获取抓取下来的页面中10个用户的url,存入csv
function getDetailUrl($page) {
	$page_content = file_get_contents('text.txt');
	// var_dump($page_content);die;
	//解析页面信息
	$pattern = '/<a class="a-link-normal" href="\/gp\/profile\/amzn1.account(.+?)_name">/';
	preg_match_all($pattern, $page_content, $match);
	
	//存入文件
	$file = fopen("./pageData/page_{$page}_urls.csv",'w');
	fwrite($file, "rank,url".PHP_EOL);
	foreach ($match[0] as $key => $value) {

		$rank = ($page-1)*10 + 1 + $key;
		substr($value, 30, -2);
		$str = str_replace(['<a class="a-link-normal" href="','">'], ['https://www.amazon.com',''], $value);
		// var_dump($str);die;
		fwrite($file, "{$rank},{$str}".PHP_EOL);
	}
	fclose($file);
}

//获取用户的邮箱
function getUserEmailByUrl($rank,$url) {
	echo "-------------------------------".PHP_EOL;
	echo "正在爬取第{$rank}个,url:{$url}".PHP_EOL;
	$page_content = getDataByUrl($url);
	if($page_content==null){
		sleep(30);
		return;
	}
	//获取用户名
	// $pattern = '/"nameHeaderData":{"name":(.+?),"profileExists"/';
	$pattern = '/"nameHeaderData"(.+?)"profileExists"/';
	preg_match_all($pattern, $page_content, $name);
	$name = str_replace(['\r','\n','\r\n'], ['','',''], $name);
	$name = str_replace(['"nameHeaderData":{"name":"','","profileExists"'], ['',''], $name[0]);
	if(is_array($name)){
		$name = $name[0];
	}
	// var_dump($name);
	//获取邮箱1
	$pattern = '/"website":{"raw":(.+?),"normalized"/';
	preg_match_all($pattern, $page_content, $email1);
	$email1 = str_replace(['\r','\n','\r\n'], ['','',''], $email1);
	$email1 = str_replace(['"website":{"raw":',',"normalized"'], ['',''], $email1[0]);
	if(is_array($email1)){
		$email1 = $email1[0];
	}
	//获取邮箱2
	$pattern = '/"normalized":"(.+?)"},/';
	preg_match_all($pattern, $page_content, $email2);
	$email2 = str_replace(['\r','\n','\r\n'], ['','',''], $email2);
	$email2 = str_replace(['"normalized":"','"},'], ['',''], $email2[0]);
	if(is_array($email2)){
		$email2 = $email2[0];
	}


	// var_dump($name,$email1,$email2);die;
	echo "{$rank}-{$name}-{$email1}-{$email2}".PHP_EOL;


	//如果有非空的数据，则保存下来
	if($email1 != 'null' || $email2 != 'http://'){
		$file = fopen("./Data/{$rank}_{$name}.csv",'w');
		fwrite($file, "{$rank},{$name},{$email1},{$email2}".PHP_EOL);
		fclose($file);
		echo "***** rank:{$rank},有效数据,保存成功".PHP_EOL;
	}else{
		echo "***** rank:{$rank},无效数据".PHP_EOL;
	}

	echo "-------------------------------".PHP_EOL;

}

