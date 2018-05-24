<?php
/**
 * 读取文件中的连接，根据这些链接获取对应的邮箱
 */
require_once "./parse.php";
require_once "./page.php";
require_once './fakeData.php';

set_time_limit(0);

$from = 901;
$to = 1000;

for($i = $from; $i<$to+1; $i++){
	$fileName = "page_{$i}_urls.csv";
	echo "******开始爬第{$i}个文件,文件名称:{$fileName}".PHP_EOL;
	$filePath = "./pageData/{$fileName}";
	$dataArr = getUrlFromFile($filePath);
	foreach ($dataArr as $key => $data) {
		getUserEmailByUrl($data[0],$data[1]);
		$rand = rand(7,12);
		echo "休眠{$rand}秒  .zZ".PHP_EOL;
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