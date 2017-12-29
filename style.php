<?php
$dir = dirname(__FILE__);  //查找当前脚本所在路径
require ($dir . './lib_mysqli.class.php');  //引入MySQL操作类文件
require ($dir . './dbconfig.php');
require ($dir . "./Classes/PHPExcel.php");    //引入文件 
$db = new lib_mysqli('127.0.0.1', 'root', '', 'phpexcel', '3306');  //实例化db类，连接数据库
$objPHPExcel = new PHPExcel();  //实例化PHPExcel类，等同于在桌面上新建一个Excel
//开始本节课代码编写
$gradeInfo = $db->getAllGrade();  //查询所有的年级
foreach ($gradeInfo as $g_k => $g_v)
{   //select distinct(class) from user where grade=3 order by class asc
	$classInfo = $db->getClassByGrade($g_v['grade']);    //查询每个年级所有的班级
	
	foreach ($classInfo as $c_k => $c_v)
	{
		$info = $db->getDataByClassGrade($c_v['class'], $g_v['grade']);  //查询每个班级的学生信息.
		print_r($info);
	}
}
exit();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  //生成Excel
brower_export('Excel5', 'brower_excel03.xls');  //输出到浏览器
$objWriter->save("php://output");

//$r = $objWriter->save($dir.'/export_3.xls');  // 保存文件，保存成功返回0



function brower_export($type, $filename)
{
	//01simple-download-xls的例子代码，封装成方法
	if ($type == 'Excel5')
	{
		header('Content-Type: application/vnd.ms-excel');  //告诉浏览器要输出Excel03文件
	}
	else
	{
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  //告诉浏览器要输出Excel07文件   01simple-download-xlsx.php
	}   	
	
    header('Content-Disposition: attachment;filename="' . $filename .'"');  //告诉浏览器将输出文件的名称
    header('Cache-Control: max-age=0');  //禁止缓存

}
