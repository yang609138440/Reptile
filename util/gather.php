<?php



$dirPath = '../Data/';


echo "开始扫描文件夹[{$dirPath}]".PHP_EOL;
$handle = opendir($dirPath);
$filePathArr = array();
while($fileName = readdir($handle)){
	if(in_array($fileName, ['.','..'])){
		continue;
	}
	$filePath = $dirPath.$fileName;
	array_push($filePathArr,$filePath);
}


echo "开始汇总".PHP_EOL;
$newFile = fopen('../Data/all/all.csv','w');
fwrite($newFile, "排名,名称,网址1,网址2".PHP_EOL);
foreach ($filePathArr as $key => $filePath) {
	$content = file_get_contents($filePath);
	// var_dump($content);die;
	fwrite($newFile, $content);
}
fclose($newFile);
echo "汇总完成".PHP_EOL;

 

