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
	$data = $db->getDataByGrade($i);    //查询每个年级的学生数据
	$objSheet->setCellValue('A1', 'ID')->setCellValue('B1', '姓名')->setCellValue('C1', '分数')->setCellValue('D1', '班级');  //填充数据
	$j = 2;
    
	foreach ($data as $key => $val)
	{
		$objSheet->setCellValue('A'.$j, $val['id'])->setCellValue('B'.$j, $val['username'])->setCellValue('C'.$j, $val['score'].'分数')->setCellValue('D'.$j, $val['class'].'班级');  //
		$j++;  //行
	}
}

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
