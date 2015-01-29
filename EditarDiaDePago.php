

<DOCTYPE! html>
<html lang="es">
	<head>
		<meta charset='utf-8'>
		<title>Reporte Recibo</title>
		<link rel="stylesheet"  href="css/normalize.css">
		<link rel="stylesheet"  href="css/estilo.css">
	</head>
	<body>

		<?php

			if(isset($_GET['txtIdFactura']) && isset($_GET['txtDiaDePagoActual']) )
			{
				$IdFactura=$_GET['txtIdFactura'];
				$DiaDePagoActual=$_GET['txtDiaDePagoActual'];
				
			}else
			{
				$IdFactura='';
				$DiaDePagoActual='';
			}

			if(isset($_GET['btnActualizarDiaDePago']))
			{
				$boton=$_GET['btnActualizarDiaDePago'];
			}else
			{
				$boton="";
			}

			
			if(isset($_GET['cmbNuevoDiaDePago']))
			{
				$NuevoDiaDePago=$_GET['cmbNuevoDiaDePago'];
			}else
			{
				$NuevoDiaDePago="";
			}
				



				$link=mysqli_connect('localhost','root','','bodegon');
						

						if($boton=='Actualizar dia de pago')
							{			
								

								if(!mysqli_query($link,"update factura set DiaDePago='$NuevoDiaDePago'  where IdFactura='$IdFactura' "))
								{
								printf("Error - SQLSTATE %s.\n", mysqli_errno($link));
								}

									
								header("Location:ConsultaSaldo.php?Mensaje=Se Actualizo el dia de pago");					
							}


		?>

		<div class='container'>
			<?php

				include_once('Menu_Header.html');

			?>
			<div class='formulario'>
				<form name='frmEditarTotalFactura' method='get' action='EditarDiaDePago.php'>
					<table align='center' border='0px'>
						<tr>
							<td>
								<label>Factura:</label>
							</td>
							<td>
								<input name='txtIdFactura' type='text' value='<?php echo $IdFactura ?>' required readonly>
							</td>
						</tr>
						<tr>
							<td>
								<label>Dia de pago actual:</label>
							</td>
							<td>
								<input name='txtDiaDePagoActual' type='text' value='<?php echo $DiaDePagoActual ?>' required readonly>
							</td>
						</tr>
						<tr>
							<td>
								<label>Nuevo dia de Pago:</label>
							</td>
							<td>
								<select  name='cmbNuevoDiaDePago' required>
									<option value="Lunes">Lunes</option>
									<option value="Martes">Martes</option>
									<option value="Miercoles">Miercoles</option>
									<option value="Jueves">Jueves</option>
									<option value="Viernes">Viernes</option>
									<option value="Sabado">Sabado</option>
									<option value="Domingo">Domingo</option>
								</select>
							</td>
						</tr>
						<tr>
							<td></td>
							<td colspan='2' align='center'>
								<input  name='btnActualizarDiaDePago' type='submit' value='Actualizar dia de pago' >
							</td>
						</tr>
					</table>
					<table>

				
				</form>
			</div><!--formulario-->
		</div><!--Container-->
	</body>
</html>