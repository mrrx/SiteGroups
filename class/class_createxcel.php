<?
//error_reporting(0);
header("Content-Type:text/htm;charset=utf-8");
require_once('../PHPExcel/Classes/PHPExcel.php');
require_once('../PHPExcel/Classes/PHPExcel/IOFactory.php');//duo
$use_group=$_SESSION['use_group'];
$name=$_SESSION['name'];
session_write_close();
$mod=$_GET['mod'];
//读取数据
$db=new DB();
$fun=new strfun();
$date=date("Y-m");
if($mod=="all"){
$sql1="select * from article where Use_group='$use_group' $condition order by Date asc";
$sql2="select * from article where Use_group='$use_group' $condition order by Date asc";
$outputFileName =iconv('utf-8','gbk',"全部文章收录数据表.xls");
}
else{
$condition=str_replace("\\","",$_GET['condition']);
$page=$_GET['page'];
$startnum=($page-1)*15;
$sql1="select * from article where Use_group='$use_group' $condition limit $startnum,15";
$sql2="select * from article where Use_group='$use_group' $condition limit $startnum,15";
$outputFileName =iconv('utf-8','gbk',"一页文章收录数据表.xls");
}
$data1=$db->get_all($sql1);
$n1=$db->num_rows($sql1);
$data2=$db->get_all($sql2);
$n2=$db->num_rows($sql2);
$my=$db->get_one("select * from site where Relationship='0' and Use_group='$use_group' and Status='1'");
$other=$db->get_all("select * from site where Relationship='1' and Use_group='$use_group' and Status='1'");
// 创建一个处理对象实例
$objExcel = new PHPExcel();
// 创建文件格式写入对象实例, uncomment
$objWriter = new PHPExcel_Writer_Excel5($objExcel);    // 用于其他版本格式
//$objWriter = new PHPExcel_Writer_Excel2007($objExcel); // 用于 2007 格式
//$objWriter->setOffice2003Compatibility(true);
//*************************************
//设置文档基本属性
$objProps = $objExcel->getProperties();
$objProps->setCreator($name);//创建者
$objProps->setLastModifiedBy($name);//最后修改者
$objProps->setTitle("文章收录数据");
$objProps->setSubject("文章收录数据");
$objProps->setDescription("文章收录数据");
$objProps->setKeywords("文章收录数据");
$objProps->setCategory("文章收录数据");

//*************************************
//设置当前的sheet索引，用于后续的内容操作。
//一般只有在使用多个sheet的时候才需要显示调用。
//缺省情况下，PHPExcel会自动创建第一个sheet被设置SheetIndex=0
$objExcel->setActiveSheetIndex(0);
$objActSheet = $objExcel->getActiveSheet();
//设置当前活动sheet的名称
$objActSheet->setTitle('文章收录');
//*************************************
//设置单元格内容
//设置标题
$cells_name=array('F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T');
$men=count($other)-1;
$men=$cells_name[$men];
//赋值
$objActSheet->setCellValue('A1', '文章标题');
$objActSheet->setCellValue('B1', '关键词');
$objActSheet->setCellValue('C1', '所属频道');
$objActSheet->setCellValue('D1', '发布人');
$objActSheet->setCellValue('E1', '相似度');
$objActSheet->setCellValue('F1', '状态');
$objActSheet->setCellValue('G1', '更新日期');
$objActSheet->setCellValue('H1', '发布日期');
$objActSheet->setCellValue('I1', '链接地址');


//设置宽度
$objActSheet->getColumnDimension('A')->setWidth(36);
$objActSheet->getColumnDimension('B')->setWidth(25);
$objActSheet->getColumnDimension('C')->setWidth(15);
$objActSheet->getColumnDimension('D')->setWidth(15);
$objActSheet->getColumnDimension('E')->setWidth(15);
$objActSheet->getColumnDimension('F')->setWidth(10);
$objActSheet->getColumnDimension('G')->setWidth(15);
$objActSheet->getColumnDimension('H')->setWidth(15);

//设置边框
$objStyleA1 = $objActSheet->getStyle('A1');
$objBorderA1 = $objStyleA1->getBorders();  
$objBorderA1->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);  
$objBorderA1->getTop()->getColor()->setARGB('#000000'); // color  
$objBorderA1->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objBorderA1->getBottom()->getColor()->setARGB('#000000'); // color   
$objBorderA1->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objBorderA1->getLeft()->getColor()->setARGB('#000000'); // color    
$objBorderA1->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objBorderA1->getRight()->getColor()->setARGB('#000000'); // color
$ns=$n1+1;
$objActSheet->duplicateStyle($objStyleA1,'A1:'.$men.$ns);


//设置字体  
$objFontA1 = $objStyleA1->getFont();  
$objFontA1->setName('微软雅黑');  
$objFontA1->setSize(10);  
$objFontA1->setBold(true);  

//设置单元格样式
$objAlignA1 = $objStyleA1->getAlignment(); 
$objAlignA1->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);  
$objAlignA1->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//从指定的单元格复制样式信息. 
$objActSheet->duplicateStyle($objStyleA1, 'A1:I1');
//$objActSheet1->duplicateStyle($objStyleA11, 'A1:'.$men."2");
//表格颜色填充
$objStyleD3 = $objActSheet->getStyle('B2');
$objFillD3 = $objStyleD3->getFill();  
$objFillD3->setFillType(PHPExcel_Style_Fill::FILL_SOLID);  
$objFillD3->getStartColor()->setARGB('50C6EFCE');
$objActSheet->duplicateStyle($objStyleD3, 'B2:B'.$ns);
$objStyleE3 = $objActSheet->getStyle('E2');
$objFillE3 = $objStyleE3->getFill();  
$objFillE3->setFillType(PHPExcel_Style_Fill::FILL_SOLID);  
$objFillE3->getStartColor()->setARGB('50EAF1DD');
$objActSheet->duplicateStyle($objStyleE3, 'E2:E'.$ns);
$objStyleF3 = $objActSheet->getStyle('F2');
$objFillF3 = $objStyleE3->getFill();  
$objFillF3->setFillType(PHPExcel_Style_Fill::FILL_SOLID);  
$objFillF3->getStartColor()->setARGB('#FFEB9C');
$objActSheet->duplicateStyle($objStyleE3, 'F2:F'.$ns);
$objStyleF3 = $objActSheet->getStyle('G2');
$objFillG3 = $objStyleE3->getFill();  
$objFillG3->setFillType(PHPExcel_Style_Fill::FILL_SOLID);  
$objFillG3->getStartColor()->setARGB('50C6EFCE');
$objActSheet->duplicateStyle($objStyleE3, 'G2:G'.$ns);
//*************************************

//写入数据
$p=2;
foreach($data1 as $d){
$aname=$d['Uid'];
$achannelid=$d['Cid'];
$auser=$db->get_all("select * from user where Uid=$aname");
$achannel=$db->get_all("select * from channel where Cid=$achannelid");
//$ascn=$d['Prev_ranking']-$d['Ranking0'];
$objActSheet->setCellValue('A'.$p,$d['Title']);
$objActSheet->setCellValue('B'.$p,$d['Keyword']);
foreach($achannel as $gg){
$objActSheet->setCellValue('C'.$p,$gg['Channel_name']);
}
foreach($auser as $uu){
$objActSheet->setCellValue('D'.$p,$uu['Name']);
}
$objActSheet->setCellValue('E'.$p,$d['Similar']);
if($d['Status']=1){$ornot="是";}
else{$ornot="否"; }
$objActSheet->setCellValue('F'.$p,$ornot);
$objActSheet->setCellValue('G'.$p,$d['Date']);
$objActSheet->setCellValue('H'.$p,$d['Date2']);
$objActSheet->setCellValue('I'.$p,$d['Url']);
$p++;
}
//导出
//header('Content-Type: application/vnd.ms-excel; charset=utf-8');  
//header("Content-Disposition: attachment;filename=$outputFileName");  
//header('Cache-Control: max-age=0');  
//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
//$objWriter->save('php://output');  
$file = 'excel.xls';
$objWriter->save($file);
exit;  
?>
