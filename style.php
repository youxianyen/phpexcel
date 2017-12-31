<?php
$dir = dirname(__FILE__);  //查找当前脚本所在路径
require ($dir . './lib_mysqli.class.php');  //引入MySQL操作类文件
require ($dir . './dbconfig.php');
require ($dir . "./Classes/PHPExcel.php");    //引入文件 
$db = new lib_mysqli('127.0.0.1', 'root', '', 'phpexcel', '3306');  //实例化db类，连接数据库
$objPHPExcel = new PHPExcel();  //实例化PHPExcel类，等同于在桌面上新建一个Excel

//开始本节课代码编写  本节课要实现在Excel里面格式化文本
$objSheet = $objPHPExcel->getActiveSheet();    //获得当前单元格`
$objSheet->getDefaultStyle()
         ->getAlignment()
         ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)
         ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);    //设置Excel文件默认水平垂直方向居中
$objSheet->getDefaultStyle()->getFont()->setName('微软雅黑')->setSize(14);    //设置默认字体和大小
$objSheet->getStyle('A2:Z2')->getFont()->setSize(20)->setBold(True);  //设置年级所在行的字体大小
$objSheet->getStyle('A3:Z3')->getFont()->setSize(16)->setBold(True);  //设置班级所在行字体大小并加粗
$gradeInfo = $db->getAllGrade();  //查询所有的年级
$index = 0;
foreach ($gradeInfo as $g_k => $g_v)
{   
	$gradeIndex = getCells($index*2);    //获取年级信息所在列	
	$objSheet->setCellValue($gradeIndex.'2', '高'.$g_v['grade']);
    //select distinct(class) from user where grade=3 order by class asc
	$classInfo = $db->getClassByGrade($g_v['grade']);    //查询每个年级所有的班级
	
	foreach ($classInfo as $c_k => $c_v)
	{
		$nameIndex = getCells($index * 2);  //获得每个班级学生姓名所在位置
		$scoreIndex = getCells($index * 2 + 1);    //获得每个班级学生分数所在位置
        
        $objSheet->mergeCells($nameIndex. '3:' . $scoreIndex . '3');    //第三行的    合并每个班级的单元格
        $objSheet->getStyle($nameIndex. '3:' . $scoreIndex . '3')
                 ->getFill()
                 ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                 ->getStartColor()
                 ->setRGB('521351');  //4.6.18.	Formatting cells  填充班级所在列背景颜色

        $classBorderStyle = getBorderStyle('e351ca');
        $objSheet->getStyle($nameIndex. '3:' . $scoreIndex . '3')
                 ->applyFromArray($classBorderStyle);  //设置班级列边框样式
		$info = $db->getDataByClassGrade($c_v['class'], $g_v['grade']);  //查询每个班级的学生信息.
		$objSheet->setCellValue($nameIndex.'3', $c_v['class'].'班');    //填充班级信息
		$objSheet->getStyle($nameIndex)
		         ->getAlignment()
		         ->setWrapText(true);  //加入换行符
		$objSheet->setCellValue($nameIndex.'4', '姓名')
		         ->setCellValue($scoreIndex.'4', '分数');
		//$objSheet->setCellValue($nameIndex.'4', "姓名\n换行")->setCellValue($scoreIndex.'4', '分数');    //加入换行符
		$objSheet->getStyle($scoreIndex)
	             ->getNumberFormat()
	             ->setFormatCode(
	             PHPExcel_Style_NumberFormat::FORMAT_TEXT
	    );

		$j = 5;    //检查Excel表格，从第五行开始填充数据
		foreach ($info as $key => $val) 
		{
			//$objSheet->setCellValue($nameIndex.$j, $val['username'])->setCellValue($scoreIndex.$j, $val['score']);    //填充学生信息.
			$objSheet->setCellValue($nameIndex.$j, $val['username'])
			         ->setCellValueExplicit($scoreIndex.$j, $val['score'] . '1234567892564', PHPExcel_Cell_DataType::TYPE_STRING);    //填充学生信息.  方法参考文档4.5.1节
			$j++;  //跳到下一行
		}
		$index++;
	}

	$endGradeIndex = getCells($index * 2 - 1);    //获得每个年级的终止单元格
	$objSheet->mergeCells($gradeIndex . '2:' . $endGradeIndex . '2');    //在第二行    合并每个年级的单元格
	$objSheet->getStyle($gradeIndex . '2:' . $endGradeIndex . '2')
	         ->getFill()
	         ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	         ->getStartColor()
	         ->setRGB('e36951');  //4.6.18.	Formatting cells    填充年级所在列背景色
    
    $gradeBorderStyle = getBorderStyle('e3df51');  //获取年级所在行边框样式
    $objSheet->getStyle($gradeIndex . '2:' . $endGradeIndex . '2')
             ->applyFromArray($gradeBorderStyle);  //设置年级列边框样式

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

/*
  根据下标获得单元格所在列位置
*/
function getCells($index)
{
	$arr = range('A', 'Z');
	//$arr = array(A,B,C,D,E,F,G,H,I,J,K,M,N,...,Z);
	return $arr[$index];
}

/*
  获取不同的边框样式
*/
function getBorderStyle($color)
{
	$styleArray = [
	'borders' => [
	    'outline' => [
	        'style' => PHPExcel_Style_Border::BORDER_THICK,
	        'color' => ['rgb' => $color],
	    ]
	]
	];
	return $styleArray;
}
