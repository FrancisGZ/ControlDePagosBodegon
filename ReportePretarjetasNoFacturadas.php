<DOCTYPE! html>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<title>Pretarjetas sin facturar</title>
		<link rel="stylesheet"  href="css/normalize.css">
		<link rel="stylesheet"  href="css/estilo.css">
	</head>
	<body>

		

		<div class="container">
				<?php 



					include_once "Menu_Header.html";
				?>

			<div class="formulario">
				<form name="frmReporteCliente" method="get" action="ReportePretarjetasNoFacturadasImprimir.php">
					<table align="center">
						<tr>
							<td>
								<label>Ruta:</label>
							</td>
							<td>
								<?php $link=mysqli_connect('localhost','root','' , 'bodegon');

								$query="Select * from Rutas";


									?>
									<select name="cmbRuta" required >
									<?php
									
							
										echo"<option value=TODAS>TODAS</option>";
										
				
									$resultado=$link->query($query);
 

									while($renglon=$resultado->fetch_array())
									{
										echo "<option value='$renglon[IdRuta]'>$renglon[IdRuta]</option>";
									}
									?>
									</select>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<input name="btnGenerarReporte" type="submit" value="Generar Reporte" >
							</td>
						</tr>
					</table>

				</form>
			</div><!--formulario-->
		</div><!--Container-->
	</body>
</html>