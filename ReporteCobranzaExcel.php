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

		

		include("Funciones.php");

		error_reporting(E_ALL);
		include_once 'Classes/PHPExcel.php';
  
 
  					//$link=mysqli_connect('localhost','root','' , 'bodegon');

   					$objPHPExcel = new PHPExcel();
    
    				 $objSheet= $objPHPExcel->setActiveSheetIndex(0);
    				 $objSheet->setCellValue('A1', 'Factura');
    				 $objSheet->setCellValue('B1', 'Clave Cliente');
     				 $objSheet->setCellValue('C1', 'Nombre');
     				 $objSheet->setCellValue('D1', 'Pago');
     				 $objSheet->setCellValue('E1', 'Saldo');
     				 $objSheet->setCellValue('F1', 'Ruta');

  						 $i = 1;    
   					

 				

						if($Ruta!='Todas')
							{
									
									$query="select a.IdCliente,a.NombreCliente,b.IdFactura,sum(c.MontoPago) as Pagos,
									 a.Ruta, b.MontoTotalFactura,b.SaldoInicialFactura 
									from clientes as a inner join factura as b on (a.idCliente=b.IdCliente)
									inner join pagos as c on (b.idFactura=c.IdFactura)
									where a.Ruta='$Ruta' and  c.fechaPago between '$FechaInicial' and '$FechaFinal'
									and c.TipoDocumento not in ('Cancelacion','Bonificacion','Nota de Cargo') group by b.idfactura
									order by  a.Ruta,a.NombreCliente";

							}
							else{
									$query="select a.IdCliente,a.NombreCliente,b.IdFactura,sum(c.MontoPago) as Pagos,
									 a.Ruta, b.MontoTotalFactura,b.SaldoInicialFactura
									from clientes as a inner join factura as b on (a.idCliente=b.IdCliente)
									inner join pagos as c on (b.idFactura=c.IdFactura)
									where c.fechaPago between '$FechaInicial' and '$FechaFinal' 
									and c.TipoDocumento not in ('Cancelacion','Bonificacion','Nota de Cargo') group by b.idfactura
									order by  a.Ruta,a.NombreCliente";
								}


								$TotalPagos=0;
								$TotalSaldos=0;
								$ultimoRenglon=0;
 					$resultado=$link->query($query);
     				
     				while($renglon=$resultado->fetch_array())
  					{   

  						$IdFactura=$renglon['IdFactura'];
    					$MontoTotalFactura=$renglon['MontoTotalFactura'];
    					$SaldoInicialFactura=$renglon['SaldoInicialFactura'];

    					$Saldo=Saldo($IdFactura,$MontoTotalFactura,$SaldoInicialFactura); 	

    					
         					$i++;
    						$objSheet->setCellValue('A'.$i, $renglon['IdFactura']);
    						$objSheet->setCellValue('B'.$i, $renglon['IdCliente']);
    						$objSheet->setCellValue('C'.$i, $renglon['NombreCliente']);
    						$objSheet->setCellValue('D'.$i, $renglon['Pagos']);
    						$objSheet->setCellValue('E'.$i, $Saldo);
    						$objSheet->setCellValue('F'.$i, $renglon['Ruta']);
   						
       						$TotalPagos=$TotalPagos+$renglon['Pagos'];
       						$TotalSaldos=$TotalSaldos+$Saldo;

       							
   					}

   						$i++;
   						$PorcentajeCobranza=100*($TotalPagos/$TotalSaldos);

   							$PorcentajeCobranza=number_format($PorcentajeCobranza,2);

   							$objSheet->setCellValue('A'.$i, '');
    						$objSheet->setCellValue('B'.$i, '');
    						$objSheet->setCellValue('C'.$i, 'Total');
    						$objSheet->setCellValue('D'.$i, $TotalPagos);
    						$objSheet->setCellValue('E'.$i, $TotalSaldos);
    						$objSheet->setCellValue('F'.$i, $PorcentajeCobranza.'%');
   						

							$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
							$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
							$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
							$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
							$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
							$objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
							
							$objPHPExcel->getActiveSheet()->setTitle('Listado');
							$objPHPExcel->setActiveSheetIndex(0);
							//header('Content-Type: application/vnd.ms-excel');
							header('Content-Disposition: attachment;filename="Cobranza.xls"');
							//header('Cache-Control: max-age=0');
							 
							$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
							$objWriter->save('php://output');
							exit;
							mysqli_close ();









				/* function Saldo($IdFactura,$MontoTotalFactura,$SaldoFactura, $link)
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
						}*/


?>							