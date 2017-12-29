<?php

$dir = dirname(__FILE__);    //找到当前脚本所在路径
require ($dir . "./Classes/PHPExcel.php");    //引入文件 
$objPHPExcel = new PHPExcel();    //实例化PHPExcel类，等同于在桌面新建一个Excel表格
$objSheet = $objPHPExcel->getActiveSheet();    //获得当前活动sheet的操作对象
$objSheet->setTitle('demo');    //给当前活动sheet设置名称
/*
$objSheet->setCellValue('A1', '姓名')->setCellValue('B1', '分数');    //给当前活动sheet填充数据
$objSheet->setCellValue('A2', '张三')->setCellValue('B2', '89');    //给当前活动sheet填充数据
*/
$array = array(
	array(),
    array('', '姓名', '分数'),
    array('', '李四', '88'),
    array('', '牛牛', '99')
);
$objSheet->fromArray($array);  //直接加载数据块来填充数据
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  //按照指定格式生成Excel文件
$objWriter->save($dir . '/demo1.xlsx');
