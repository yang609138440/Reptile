<?php 
require_once "./page.php";
require_once "./parse.php";
require_once './fakeData.php';


$from = 119;
$to = 1000;

for($page=$from;$page<$to+1;$page++){
	echo ">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>正在爬取第{$page}页数据".PHP_EOL;
	$url = getPageUrl($page);
	getPageUserUrl($url);
	getDetailUrl($page);
	echo ">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>第{$page}页爬取完毕".PHP_EOL;
	$ranInt = rand(10,20);
	echo "休眠{$ranInt}秒  .zZ".PHP_EOL;
	sleep($ranInt);
}
