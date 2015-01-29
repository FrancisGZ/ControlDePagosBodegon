<?php


	$link=mysqli_connect('localhost','root','','bodegon');


	$queryObtieneFechaFactura="Select * from factura where IdFactura='056000332'";

	$resutadoObtieneFechaFactura=$link->query($queryObtieneFechaFactura);

	if(mysqli_affected_rows($link)>0)
	{
		while ($renglon=$resutadoObtieneFechaFactura->fetch_array())
		 {
			$FechaFactura=$renglon['FechaFactura'];
			$IdFactura=$renglon['IdFactura'];
			$MontoTotalFactura=$renglon['MontoTotalFactura'];
			$Plazo=$renglon['Plazo'];
			$PagoPuntual=$renglon['PagoPuntual'];
			$PagoNormal=$renglon['PagoNormal'];

			//echo $IdFactura."-".$FechaFactura;


			//GenerarDocumentos($IdFactura,$Plazo,$MontoTotalFactura,$FechaFactura,$link); quitar cometarios para generar documentos
		 	
			echo "<br>Pagos Puntuales a la fecha".$Puntual=ObetenerSaldoVencido($IdFactura,$Plazo,$MontoTotalFactura,$FechaFactura,$PagoPuntual,$link);

			echo "<br>Pagos Normales a la fecha".$Normal=ObetenerSaldoVencido($IdFactura,$Plazo,$MontoTotalFactura,$FechaFactura,$PagoNormal,$link);
		}

	}



function ObetenerSaldoVencido($IdFactura,$Plazo,$MontoTotalFactura,$FechaFactura,$Pago,$link)
{
	if($Plazo>0)
	{
		//echo "Cantidad de pagos semanales: ".$PagosSemanales=ceil($Plazo*4.3);

		
				$datetime1 = date_create($FechaFactura);//Fecha de la Factura
				$datetime2 =date_create(date('Y-m-d', strtotime('today')));//Fecha Actual
				$datetime1->add(new DateInterval('P7D'));
				$interval = $datetime1->diff($datetime2);
				echo "Semanas transcurridas:".$Semanas=floor(($interval->format('%a') / 7));

				return $Semanas*$Pago;

				

	}
}


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
	}


 ?>