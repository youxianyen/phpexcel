<?php
$dir = dirname(__FILE__);  //查找当前脚本所在路径
require ($dir . './lib_mysqli.class.php');  //引入MySQL操作类文件
require ($dir . './dbconfig.php');
require ($dir . "./Classes/PHPExcel.php");    //引入文件 
$db = new lib_mysqli('127.0.0.1', 'root', '', 'phpexcel', '3306');  //实例化db类，连接数据库
$objPHPExcel = new PHPExcel();  //实例化PHPExcel类，等同于在桌面上新建一个Excel
for ($i = 1; $i <= 3;$i++)
{
	if ($i > 1)  //从二年级开始创建
	{
	$objPHPExcel->createSheet();  //创建新的内置表
	}
	$objPHPExcel->setActiveSheetIndex($i - 1);  //设置当前sheet的下标
	$objSheet = $objPHPExcel->getActiveSheet();  //获取当前活动sheet
	$objSheet->setTitle($i . '年级');  //给当前活动sheet起个名称
	$data = $db->get_all('select username, score, class, grade from user where grade = 3 order by score desc');    //查询每个年级的学生数据
	$objSheet->setCellValue('A1', '姓名')->setCellValue('B1', '分数')->setCellValue('C1', '班级');  //填充数据
	$j = 2;

	foreach ($data as $key => $val)
	{
		$objSheet->setCellValue('A'.$j, $val['username'])->setCellValue('B'.$j, $val['score'])->setCellValue('C'.$j, $val['class'].'班');  //
		$j++;  //行
	}
}

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  //生成Excel
$r = $objWriter->save($dir.'/export_1.xls');  // 保存文件，保存成功返回0

if (!$r)
{
	echo ('success');  //
}
else 
{
	echo ('fail');
}