<?php
 /* Ejemplo 1 generando excel desde mysql con PHP
    @Autor: Carlos Hernan Aguilar Hurtado
 */error_reporting(E_ALL);
include_once 'Classes/PHPExcel.php';
  
 
  $link=mysqli_connect('localhost','root','' , 'bodegon');

   $objPHPExcel = new PHPExcel();
    
     $objSheet= $objPHPExcel->setActiveSheetIndex(0);
     $objSheet->setCellValue('A1', 'IdRuta');
      $objSheet->setCellValue('B1', 'Sucursal');

   $i = 1;    
   //while ($registro = mysql_fetch_object ($resultado)) {
  $query="select * from rutas"; 
 $resultado=$link->query($query);
     while($renglon=$resultado->fetch_array())
  {   
         $i++;
    $objSheet->setCellValue('A'.$i, $renglon['IdRuta']);
    $objSheet->setCellValue('B'.$i, $renglon['IdSucursal']);
   
       
   }

$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setTitle('Rutas');
$objPHPExcel->setActiveSheetIndex(0);
//header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="ejemplo.xls"');
//header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;
mysql_close ();
?>