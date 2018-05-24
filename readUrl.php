<?php
/**
 * 读取文件中的连接，根据这些链接获取对应的邮箱
 */
require_once "./parse.php";
require_once "./page.php";
require_once './fakeData.php';

date_default_timezone_set("PRC");

set_time_limit(0);
if(count($argv)<3){
	echo "参数错误".PHP_EOL;die;
}
$from = intval($argv[1]);
$to = intval($argv[2]);

for($i = $from; $i<$to+1; $i++){
	$fileName = "page_{$i}_urls.csv";
	echo "******开始爬第{$i}个文件,文件名称:{$fileName}".PHP_EOL;
	$filePath = "./pageData/{$fileName}";
	$dataArr = getUrlFromFile($filePath);
	foreach ($dataArr as $key => $data) {
		if(count($data)==2){
			getUserEmailByUrl($data[0],$data[1]);
		}elseif(count($data)==3){
			getUserEmailByUrl($data[0],$data[1].','.$data[2]);
		}
		$rand = rand(5,10);
		echo date('Y-m-d H:i:s',time())."   休眠{$rand}秒  .zZ".PHP_EOL;
		sleep($rand);
	}
}

//从文件中获取url
function getUrlFromFile($path) {
	$re = array();
	$file = fopen($path,'r');
	while ($data = fgetcsv($file)) {
		if($data[0]=='rank'){//第一行跳过
			continue;
		}
		array_push($re,$data);
	}
	return $re;
}