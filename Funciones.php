<?php
	
	//$link=mysqli_connect("localhost","root","","bodegon");
	$link =mysqli_connect('localhost','root','','bodegon');


	function ResultadoQuery($query)
	{
		global $link;
		

		$resultado=$link->query($query);

		$renglon=$resultado->fetch_array();

		return $renglon;
	}


	function VerificaSiExisteRegistro($query)
	{
		global $link;

		$resultado=$link->query($query);

		$renglon=$resultado->fetch_array();

		if(is_null($renglon))
		{
			$existe=false;
		}else
		{
			$existe=true;
		}

		return $existe;
	}

	function InsertaCliente($IdCliente,$NombreCliente,$Colonia,$Calle,$Telefono,$CodigoPostal,
								$Municipio,$Ruta)
	{

			global $link;

			if(!mysqli_query($link,"insert into Clientes (IdCliente,NombreCliente,Colonia,Calle,Telefono,CodigoPostal,
								Municipio,Ruta) values
							('$IdCliente','$NombreCliente','$Colonia','$Calle','$Telefono','$CodigoPostal','$Municipio','$Ruta')"))
				{
					printf("Error - SQLSTATE %s.\n", mysqli_errno($link));
				}

	}



	function InsertaFactura($IdFactura,$IdCliente,$NumeroDePretarjeta,$Financiamiento,$MontoTotalFactura,$FechaFactura,$Plazo,$Articulos,$PrimerDiaDePago,$DiaDePago,
								$PagoNormal,$PagoPuntual,$Observaciones,$Vendedor,$Comision)
	{
		global $link;

		if(!mysqli_query($link,"insert into factura (IdFactura,IdCliente,NumeroDePretarjeta,Financiamiento,MontoTotalFactura,FechaFactura,Plazo,Articulos,FechaPrimerPago,DiaDePago,
																PagoNormal,PagoPuntual,Observaciones,Vendedor,Comision) 
													values ('$IdFactura','$IdCliente','$NumeroDePretarjeta','$Financiamiento','$MontoTotalFactura','$FechaFactura','$Plazo','$Articulos',
														'$PrimerDiaDePago','$DiaDePago','$PagoNormal','$PagoPuntual','$Observaciones','$Vendedor','$Comision')"))
				{
					printf("Error - SQLSTATE %s.\n", mysqli_errno($link));
				}
	}




	function InsertaAval ($IdCliente,$NombreAval,$ColoniaAval,$CalleAval,$CodigoPostalAval,$MunicipioAval,$TelefonoAval)
	{
		global $link;

		if(!mysqli_query($link,"insert into Avales (IdCliente,NombreAval,ColoniaAval,CalleAval,CodigoPostalAval,MunicipioAval,TelefonoAval) values
														('$IdCliente','$NombreAval','$ColoniaAval','$CalleAval','$CodigoPostalAval','$MunicipioAval','$TelefonoAval')"))
				{
					printf("Error - SQLSTATE %s.\n", mysqli_errno($link));
				}
	}





	function InsertaPagosPretarjetaAFactura ($NumeroDePretarjeta,$IdFactura)
	{
		global $link;

		
			$queryVerificaSiExistenPagosEnPretarjeta="select * from pagospretarjeta where NumeroDePretarjeta='$NumeroDePretarjeta'";
			$existe=VerificaSiExisteRegistro($queryVerificaSiExistenPagosEnPretarjeta);

			if($existe)
			{				
				$queryPagos="select * from pagospretarjeta where NumeroDePretarjeta='$NumeroDePretarjeta'";

				

				$resultadoPagos =$link->query($queryPagos);


				
					while($renglonPagos = $resultadoPagos->fetch_array())
						{
							
							$IdPago=$renglonPagos["IdPago"];

							$MontoPago=$renglonPagos["MontoPago"];
							$TipoDocumento=$renglonPagos["TipoDocumento"];
							$TipoPago=$renglonPagos["TipoPago"];
							$FechaPago=$renglonPagos["FechaPago"];



							/*if(!mysqli_query($link, "insert into pagos (IdPago,IdFactura,MontoPago,TipoDocumento,TipoPago,FechaPago) 
								values ('$IdPago','$IdFactura','$MontoPago','$TipoDocumento','$TipoPago','$FechaPago')"))

								{
									printf("Error - SQLSTATE %s.\n", mysqli_errno($link));
								}*/



							if(!mysqli_query($link, "update pagos set IdFactura='$IdFactura' where IdPago='$IdPago'"))

								{
									printf("Error - SQLSTATE %s.\n", mysqli_errno($link));
								}




			
						}
				

					
				


				

			}
			
			
	}






	function InsertaClienteTemporal($NumeroDePretarjeta,$NombreCliente,$Colonia,$Calle,$Telefono,$CodigoPostal,
								$Municipio,$Ruta)
	{
		global $link;

		if(!mysqli_query($link,"insert into clientestemporal (NumeroDePretarjeta,NombreCliente,Colonia,Calle,Telefono,CodigoPostal,
								Municipio,Ruta) values
							('$NumeroDePretarjeta','$NombreCliente','$Colonia','$Calle','$Telefono','$CodigoPostal','$Municipio','$Ruta')"))
			{
			 printf("Error - SQLSTATE %s.\n", mysqli_errno($link));
			}
	}



	function InsertaFacturaTemporal($NumeroDePretarjeta,$Financiamiento,$MontoTotalFactura,$FechaFactura,$Plazo,$FechaPrimerPago,$PagoNormal,$PagoPuntual,$Vendedor,$Observaciones,$Comision,$Articulos)
	{
		global $link;

		if(!mysqli_query($link,"insert into facturatemporal (NumeroDePretarjeta,Financiamiento,MontoTotalFactura,FechaFactura,Plazo,FechaPrimerPago,PagoNormal,PagoPuntual,Vendedor,Observaciones,Comision,Articulos) 
													values ('$NumeroDePretarjeta','$Financiamiento','$MontoTotalFactura','$FechaFactura','$Plazo','$FechaPrimerPago','$PagoNormal','$PagoPuntual','$Vendedor','$Observaciones','$Comision','$Articulos')"))
				{
				printf("Error - SQLSTATE %s.\n", mysqli_errno($link));
				}


	}



	function InsertaAvalesTemporal($NumeroDePretarjeta,$NombreAval,$ColoniaAval,$CalleAval,$CodigoPostalAval,$MunicipioAval,$TelefonoAval)
	{
		global $link;

		if(!mysqli_query($link,"insert into AvalesTemporal (NumeroDePretarjeta,NombreAval,ColoniaAval,CalleAval,CodigoPostalAval,MunicipioAval,TelefonoAval) values
														('$NumeroDePretarjeta','$NombreAval','$ColoniaAval','$CalleAval','$CodigoPostalAval','$MunicipioAval','$TelefonoAval')"))
				{
				printf("Error - SQLSTATE %s.\n", mysqli_errno($link));
				}
	}


	function ObtenerDiaDeLaSemana ($FechaPrimerPago)
	{
		$ano=date('Y', strtotime($FechaPrimerPago));
			$mes=date('m', strtotime($FechaPrimerPago));
 			$dia=date('d', strtotime($FechaPrimerPago));	
 			$diaSemana = diaSemana($ano, $mes, $dia);

			if($diaSemana==1)
			{

	 			$DiaDePago="Lunes";
			}

			if($diaSemana==2)
			{

	 			$DiaDePago="Martes";
			}

			if($diaSemana==3)
			{

	 			$DiaDePago="Miercoles";
			}

			if($diaSemana==4)
			{

	 			$DiaDePago="Jueves";
			}

			if($diaSemana==5)
			{

	 			$DiaDePago="Viernes";
			}

			if($diaSemana==6)
			{

	 			$DiaDePago="Sabado";
			}	

			if($diaSemana==0)
			{

				 $DiaDePago="Domingo";
			}

			return $DiaDePago;

	}


	function diaSemana($ano,$mes,$dia)
{
    // 0->domingo     | 6->sabado
   
      $dia= date("w",mktime(0, 0, 0, $mes, $dia, $ano));

        return $dia;
}




	 function SaldoPretarjeta($NumeroDePretarjeta,$MontoTotalFactura)
	{
			
		global $link;

			$queryVerificaSiExistenPagosONotasDeCargo="select * from pagospretarjeta where NumeroDePretarjeta='$NumeroDePretarjeta'";
			$existe=VerificaSiExisteRegistro($queryVerificaSiExistenPagosONotasDeCargo);

			if($existe)
			{				
				$queryPagos="select * from pagospretarjeta where NumeroDePretarjeta='$NumeroDePretarjeta' and TipoDocumento='Pago'";

				 

				$resultadoPagos =$link->query($queryPagos);

				$pagosAplicados =0;//Inicializar a cero la variable que servira como contador de los pagos aplicados

				
					while($renglonPagos = $resultadoPagos->fetch_array())
						{
							$pagosAplicados=$pagosAplicados + $renglonPagos["MontoPago"];
			
						}
				

						$queryNotasDeCargo="select * from pagospretarjeta where NumeroDePretarjeta='$NumeroDePretarjeta' and TipoDocumento='Nota de Cargo'";
				


					$resultadoNotasDeCargo=$link->query($queryNotasDeCargo);

					$notasDeCargo=0;//Inicializar a cero la variable que servira como contador de las notas de cargo

					while ( $renglonNotasDeCargo=$resultadoNotasDeCargo->fetch_array()) 
						{
							$notasDeCargo=$notasDeCargo + $renglonNotasDeCargo["MontoPago"];
						}


						$Saldo=$MontoTotalFactura-($pagosAplicados-$notasDeCargo);

			}
			else
			{
				$Saldo=$MontoTotalFactura;
			}
			

		
						return $Saldo;
	}




	 function Saldo($IdFactura,$MontoTotalFactura,$SaldoInicialFactura )
	{

		global $link;
		
						$queryPagos="select * from pagos where IdFactura='$IdFactura' and TipoDocumento='Pago'";
			
								$resultadoPagos =$link->query($queryPagos);

								$pagosAplicados =0;

							while($renglonPagos = $resultadoPagos->fetch_array())
								{
									$pagosAplicados=$pagosAplicados + $renglonPagos["MontoPago"];
			
								}


						$queryNotasDeCargo="select * from pagos where IdFactura='$IdFactura' and TipoDocumento='Nota de Cargo'";

								$resultadoNotasDeCargo =$link->query($queryNotasDeCargo); 	

								$notasDeCargo=0;


							while ($renglonNotasDeCargo = $resultadoNotasDeCargo -> fetch_array()) 
								{
									$notasDeCargo = $notasDeCargo + $renglonNotasDeCargo["MontoPago"];
								}	

								 if ($SaldoInicialFactura>0) {
		 								

		 					 		 $SaldoDB=$MontoTotalFactura-$SaldoInicialFactura;
		 
		 							 $Saldo=$MontoTotalFactura-($pagosAplicados+$SaldoDB);

							    }else
		 						{
		 							  $Saldo=$MontoTotalFactura-($pagosAplicados-$notasDeCargo);
								}

									
		
									return $Saldo;
	}






		function ObetenerSaldoVencido($IdFactura,$Plazo,$MontoTotalFactura,$FechaPrimerPago,$Pago)
		{
		if($Plazo>0)
		{

				/*Verificar datos*/
				echo "</br>Fecha PrimerPago ".$FechaPrimerPago;
				echo "</br>Fecha Actual: ".date('Y-m-d', strtotime('today'));
			
				$datetime1 = date_create($FechaPrimerPago);//Fecha de la Factura
				$datetime2 =date_create(date('Y-m-d', strtotime('today')));//Fecha Actual
				//$datetime1->add(new DateInterval('P7D'));

				


				$interval = $datetime1->diff($datetime2);
				//$SemanasTranscurridas=floor(($interval->format('%a') / 7));
				$SemanasTranscurridas=floor(($interval->format('%a') / 7));

				
				echo "</br>Semanas transcurridas: ".$SemanasTranscurridas;

				 echo "</br>Semanas limite: ".$LimiteDeSemanas=ceil($Plazo*4.3);

				 //$LimiteDeSemanas=$Plazo*4.3;


				 if($LimiteDeSemanas>=$SemanasTranscurridas)
				 {
					$Semanas=$SemanasTranscurridas;
					 
				}
				else{

					$Semanas=$LimiteDeSemanas;
				}

				$SaldoVencido=$Semanas*$Pago;
				return $SaldoVencido;

	}
}






	function ObetenerSaldoVencidoPretarjeta($NumeroDePretarjeta,$Plazo,$MontoTotalFactura,$FechaPrimerPago,$Pago)
		{
		if($Plazo>0)
		{

				/*Verificar datos*/
				echo "</br>Fecha PrimerPago ".$FechaPrimerPago;
				echo "</br>Fecha Actual: ".date('Y-m-d', strtotime('today'));
			
				$datetime1 = date_create($FechaPrimerPago);//Fecha de la Factura
				$datetime2 =date_create(date('Y-m-d', strtotime('today')));//Fecha Actual
				//$datetime1->add(new DateInterval('P7D'));

				


				$interval = $datetime1->diff($datetime2);
				//$SemanasTranscurridas=floor(($interval->format('%a') / 7));
				$SemanasTranscurridas=floor(($interval->format('%a') / 7));

				
				echo "</br>Semanas transcurridas: ".$SemanasTranscurridas;

				 echo "</br>Semanas limite: ".$LimiteDeSemanas=ceil($Plazo*4.3);

				 //$LimiteDeSemanas=$Plazo*4.3;


				 if($LimiteDeSemanas>=$SemanasTranscurridas)
				 {
					$Semanas=$SemanasTranscurridas;
					 
				}
				else{

					$Semanas=$LimiteDeSemanas;
				}

				$SaldoVencido=$Semanas*$Pago;
				return $SaldoVencido;

	}
}


function ObetenerSaldoVencidoConFecha($IdFactura,$Plazo,$MontoTotalFactura,$FechaPrimerPago,$FechaSaldoVencido,$Pago)
		{
				$datetime1 = date_create($FechaPrimerPago);//Fecha de la Factura
				$datetime2 =date_create($FechaSaldoVencido);//Fecha Actual

			if(($Plazo>0) && ($FechaPrimerPago<$FechaSaldoVencido))
			{
				
							
				/*Verificar datos*/
						/*echo "</br>Fecha PrimerPago ".$FechaPrimerPago;
							echo "</br>Fecha SaldoVencido: ".$FechaSaldoVencido;*/
						
						


							$interval = $datetime1->diff($datetime2);
							
							$SemanasTranscurridas=floor(($interval->format('%a') / 7));

							
							/*echo "</br>Semanas transcurridas: ".$SemanasTranscurridas;

							echo "</br>Plazo ".$Plazo;

							 echo "</br>Semanas limite: ".$LimiteDeSemanas=ceil($Plazo*4.3);

							 echo "____";*/
							 $LimiteDeSemanas=ceil($Plazo*4.3);

							 


							 if($LimiteDeSemanas>=$SemanasTranscurridas)
							 {
								$Semanas=$SemanasTranscurridas;
								 
							}
							else{

								$Semanas=$LimiteDeSemanas;
							}

							$SaldoVencido=$Semanas*$Pago;
						
			}else
			{
				$SaldoVencido=0;
			}

				return $SaldoVencido;

}


/*function VerificarSaldoVencido($SaldoVencido,$Semanas,$Pago)
{
	
	$SaldoVencidoSegunSemanas=$Semanas*$Pago;

	if($SaldoVencidoSegunSemanas<$SaldoVencido)
	{

	}
	
}*/





	/*Genera documentos a la factura


	function GenerarDocumentos($IdFactura,$Plazo,$MontoTotalFactura,$FechaFactura,$link)
	{
	if($Plazo>0)
		{

			echo "<br>";

			echo "Cantidad de pagos semanales: ".$PagosSemanales=$Plazo*4;

			echo "<br>";

			$MontoPagoSemanal=$MontoTotalFactura/$PagosSemanales;			

			echo "Pago semanal: ".number_format($MontoPagoSemanal,2);

			$contador=1;
			
			$FechaPagoSemanal = new DateTime($FechaFactura);

			$FechaPagoSemanal->add(new DateInterval('P7D'));
			
			while($contador<=$PagosSemanales)
			{	
				echo "Semana".$contador;
				echo "<br>";
				echo "Fecha del Pago: "; 
				echo "<br>";

				echo $FechaPagoSemanalString=$FechaPagoSemanal->format('Y-m-d'); 
				echo "<br>";
				

				mysqli_query($link,"insert into documentos (IdFactura,MontoDocumento,FechaDocumento)
							values('$IdFactura','$MontoPagoSemanal','$FechaPagoSemanalString')");

					$FechaPagoSemanal->add(new DateInterval('P7D'));
				
				$contador++;	
				
			}

		}
	}*/



?>