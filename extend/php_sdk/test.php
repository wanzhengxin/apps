<?php
require_once 'AipImageClassify.php';
   const APP_ID = '14778297';
   const API_KEY = 'z9G7LDmewwP2eXbNVCGQ3nVD';
   const SECRET_KEY = 'X6DVY7mgGY0Zyy0Nixfys3HwR7mMHztQ';
   $image = file_get_contents('D:/phpstudy/PHPTutorial/WWW/ThinkPHP/apps/app/flowers/controller/7.jpg');

// 调用植物识别
$client = new AipImageClassify(APP_ID, API_KEY, SECRET_KEY);
$client->plantDetect($image);

// 如果有可选参数
$options = array();
$options["baike_num"] = 1;

// 带参数调用植物识别
$data=$client->plantDetect($image, $options);
var_dump($data);