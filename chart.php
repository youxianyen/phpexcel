<?php
$dir = dirname(__FILE__);  //查找当前脚本所在路径
require ($dir . './lib_mysqli.class.php');  //引入MySQL操作类文件
require ($dir . './dbconfig.php');
require ($dir . "./Classes/PHPExcel.php");    //引入文件 
$db = new lib_mysqli('127.0.0.1', 'root', '', 'phpexcel', '3306');  //实例化db类，连接数据库
$objPHPExcel = new PHPExcel();  //实例化PHPExcel类，等同于在桌面上新建一个Excel
$objSheet = $objPHPExcel->getActiveSheet();    //获得当前活动sheet

//开始本节课代码编写  本节课要实现图表的编辑功能
$array = [
    ['', '一班', '二班', '三班'],
    ['不及格', 20, 30, 40],
    ['良好', 30, 50, 50],
    ['优秀', 15, 17, 20]
];    //准备数据
$objSheet->fromArray($array);    //直接加载数组填充进单元格

//开始数组代码编写
$labels = [
    new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$1', null, 1),  //一班
    new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$1', null, 1),  //二班
    new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$D$1', null, 1),  //三班
];    //先取得绘制图表的标签

$xLabels = [
    new  PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$2:$A$4', null, 3)  //格式不知道，填null，3个单元格  取得图表x轴的刻度
];

$datas = [
    new  PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$B$2:$B$4', null, 3),  //取一班的数据
    new  PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$C$2:$C$4', null, 3),  //取二班的数据
    new  PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$D$2:$D$4', null, 3)  //取三班的数据
];    //取得绘图所需数据

$series = [
    new PHPExcel_Chart_DataSeries(
    	PHPExcel_Chart_DataSeries::TYPE_LINECHART,
    	PHPExcel_Chart_DataSeries::GROUPING_STANDARD,
    	range(0,count($labels) - 1),
    	$labels,
    	$xLabels,
    	$datas
    	)
];    //根据取得的东西做出一个图表的框架

$layout = new PHPExcel_Chart_Layout();
$layout->setShowVal(true);
$areas = new PHPExcel_Chart_PlotArea($layout, $series);
$legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, $layout, false);
$title = new PHPExcel_Chart_Title('高一学生成绩分布');
$ytitle = new PHPExcel_Chart_Title('value(人数)');
$chart = new PHPExcel_Chart(
	'line_chart', 
	$title,
	$legend,
	$areas,
	true,  //$plotVisibleOnly只读
	false,  // $displayBlanksAs是否空白显示
	null,
	$ytitle
	);    //生成一个图表
$chart->setTopLeftPosition('A7')->setBottomRightPosition('K25');    //给定图表所在表格中的位置
$objSheet->addChart($chart);    //将chart添加到表格中

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  //生成Excel
$objWriter->setIncludeCharts(true);

brower_export('Excel2007', 'chart.xlsx');  //输出到浏览器
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
