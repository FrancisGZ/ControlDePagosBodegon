<?php


			if(isset($_GET['cmbRuta']))
			{
				$Ruta=$_GET['cmbRuta'];
			}else
			{
				$Ruta="";
			}

		

		error_reporting(E_ALL);
		include_once 'Classes/PHPExcel.php';
  
 
  					$link=mysqli_connect('localhost','root','' , 'bodegon');

   					$objPHPExcel = new PHPExcel();
    
    				 $objSheet= $objPHPExcel->setActiveSheetIndex(0);
    				 $objSheet->setCellValue('A1', 'Clave Cliente');
     				 $objSheet->setCellValue('B1', 'Factura');
     				 $objSheet->setCellValue('C1', 'Nombre');
     				 $objSheet->setCellValue('D1', 'Saldo');
     				 $objSheet->setCellValue('E1', 'Ruta');

  						 $i = 1;    
   						//while ($registro = mysql_fetch_object ($resultado)) {
 					 //$query="select * from rutas"; 

 					 if($Ruta=="TODAS")
						{
							$query="select * from  clientes as a inner join factura as b on (a.IdCliente=b.IdCliente) ";
						}else
						{
							$query="select * from  clientes as a inner join factura as b on (a.IdCliente=b.IdCliente) where a.Ruta='$Ruta'";	
						}



 					$resultado=$link->query($query);
     				
     				while($renglon=$resultado->fetch_array())
  					{   

  						$IdFactura=$renglon['IdFactura'];
    					$MontoTotalFactura=$renglon['MontoTotalFactura'];
    					$SaldoFactura=$renglon['SaldoFactura'];

    					$Saldo=Saldo($IdFactura,$MontoTotalFactura,$SaldoFactura, $link); 	

    					if($Saldo>0)
    					{
         					$i++;
    						$objSheet->setCellValue('A'.$i, $renglon['IdCliente']);
    						$objSheet->setCellValue('B'.$i, $renglon['IdFactura']);
    						$objSheet->setCellValue('C'.$i, $renglon['NombreCliente']);
    						$objSheet->setCellValue('D'.$i, '$'.$Saldo);
    						$objSheet->setCellValue('E'.$i, $renglon['Ruta']);
   						}
       
   					}

							$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
							$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
							$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
							$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
							$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
							$objPHPExcel->getActiveSheet()->setTitle('Listado');
							$objPHPExcel->setActiveSheetIndex(0);
							//header('Content-Type: application/vnd.ms-excel');
							header('Content-Disposition: attachment;filename="Listado.xls"');
							//header('Cache-Control: max-age=0');
							 
							$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
							$objWriter->save('php://output');
							exit;
							mysqli_close ();









				 function Saldo($IdFactura,$MontoTotalFactura,$SaldoFactura, $link)
						{
							$query="select * from pagos where IdFactura='$IdFactura'";
			
							$result =$link->query($query);

							$pagosAplicados =0;
							while($row = $result->fetch_array())
							{
							$pagosAplicados=$pagosAplicados + $row["MontoPago"];
			
							}


		 					if ($SaldoFactura>0) 
		 					{
		 	
		 	 					$SaldoDB=$MontoTotalFactura-$SaldoFactura;
		 
		 						$Saldo=$MontoTotalFactura-($pagosAplicados+$SaldoDB);

		 					}else
		 					{
		 		 				$Saldo=$MontoTotalFactura-$pagosAplicados;
		 					}

								$result->free();
		
								return $Saldo;
						}


?>							