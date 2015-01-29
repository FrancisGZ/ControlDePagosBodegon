<?php
			if(isset($_GET['txtFechaInicial']))
			{
					
				$FechaInicial=$_GET['txtFechaInicial'];
			}else
			{
				
				$FechaInicial="";
			}

			if(isset($_GET['txtFechaFinal']))
			{	
				
				$FechaFinal=$_GET['txtFechaFinal'];
			}else
			{
				
				$FechaFinal="";
			}

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
     				 $objSheet->setCellValue('D1', 'Pago');
     				 $objSheet->setCellValue('E1', 'Fecha Pago');
     				 $objSheet->setCellValue('F1', 'Recibo');
     				 $objSheet->setCellValue('G1', 'Tipo Pago');
     				 $objSheet->setCellValue('H1', 'Tipo Documento');
     				 $objSheet->setCellValue('I1', 'Ruta');

  						 $i = 1;    
   					

 				

						if($Ruta!='Todas')
							{
									$query="select a.IdCliente,a.NombreCliente,b.IdFactura,sum(c.MontoPago) as Pagos,
									Max(c.FechaPago) as FechaUltimoPago, a.Ruta, c.IdPago, c.TipoPago, c.TipoDocumento
									from clientes as a inner join factura as b on (a.idCliente=b.IdCliente)
									inner join pagos as c on (b.idFactura=c.IdFactura)
									where a.Ruta='$Ruta' and  c.fechaPago between '$FechaInicial' and '$FechaFinal'
									and c.TipoDocumento not in ('Cancelacion','Bonificacion')
									group by a.idCliente";

							}
							else{
									$query="select a.IdCliente,a.NombreCliente,b.IdFactura,sum(c.MontoPago) as Pagos,
									Max(c.FechaPago) as FechaUltimoPago, a.Ruta, c.IdPago, c.TipoPago,c.TipoDocumento
									from clientes as a inner join factura as b on (a.idCliente=b.IdCliente)
									inner join pagos as c on (b.idFactura=c.IdFactura)
									where c.fechaPago between '$FechaInicial' and '$FechaFinal' 
									and c.TipoDocumento not in ('Cancelacion','Bonificacion')
									group by a.idCliente ";
								}
							




 					$resultado=$link->query($query);
     				
     				while($renglon=$resultado->fetch_array())
  					{   

  						/*$IdFactura=$renglon['IdFactura'];
    					$MontoTotalFactura=$renglon['MontoTotalFactura'];
    					$SaldoFactura=$renglon['SaldoFactura'];

    					$Saldo=Saldo($IdFactura,$MontoTotalFactura,$SaldoFactura, $link); 	

    					if($Saldo>0)
    					{*/
         					$i++;
    						$objSheet->setCellValue('A'.$i, $renglon['IdCliente']);
    						$objSheet->setCellValue('B'.$i, $renglon['IdFactura']);
    						$objSheet->setCellValue('C'.$i, $renglon['NombreCliente']);
    						$objSheet->setCellValue('D'.$i, $renglon['Pagos']);
    						$objSheet->setCellValue('E'.$i, $renglon['FechaUltimoPago']);
    						$objSheet->setCellValue('F'.$i, $renglon['IdPago']);
    						$objSheet->setCellValue('G'.$i, $renglon['TipoPago']);
    						$objSheet->setCellValue('H'.$i, $renglon['TipoDocumento']);
    						$objSheet->setCellValue('I'.$i, $renglon['Ruta']);
   						
       
   					}

							$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
							$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
							$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
							$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
							$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
							$objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
							$objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);
							$objPHPExcel->getActiveSheet()->getColumnDimension("H")->setAutoSize(true);
							$objPHPExcel->getActiveSheet()->getColumnDimension("I")->setAutoSize(true);
							$objPHPExcel->getActiveSheet()->setTitle('Listado');
							$objPHPExcel->setActiveSheetIndex(0);
							//header('Content-Type: application/vnd.ms-excel');
							header('Content-Disposition: attachment;filename="Pagos.xls"');
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