<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset='utf-8'>
		<title>Reporte</title>
		<link rel="stylesheet"  href="css/normalize.css">
		<link rel="stylesheet"  href="css/estilo.css">
	</head>

	<body>

		<?php
			if(isset($_GET['txtFechaInicial']))
			{
					
				$FechaInicial=$_GET['txtFechaInicial'];
			}else
			{
				
				$FechaInicial=date('Y-m-d', strtotime('today')); 
			}

			if(isset($_GET['txtFechaFinal']))
			{	
				
				$FechaFinal=$_GET['txtFechaFinal'];
			}else
			{
				
				$FechaFinal=date('Y-m-d', strtotime('today'));
			}

			if(isset($_GET['cmbRuta']))
			{
				$Ruta=$_GET['cmbRuta'];
			}else
			{
				$Ruta='';
			}

			
		?>





		<div class="container">
			<?php
				include_once "Menu_Header.html"
			?>
			<div class="formulario">
				<form method="get" name="frmReportePago" action="ReporteCobranzaImprimir.php">
					<table align="center">
						<tr>
							<td>	
								<label>Fecha Inicial:</label>
							</td>
							<td>
								<input  name="txtFechaInicial" type="date" value="<?php echo date('Y-m-d', strtotime($FechaInicial));  ?>" required>
							</td>	
						</tr>
						<tr>
							<td>
								<label>Fecha Final:</label>
							</td>
							<td>
								<input name="txtFechaFinal" type="date" value="<?php echo date('Y-m-d', strtotime($FechaFinal));  ?>" required>
							</td>
						</tr>
						<tr>
							<td>
								<label>Ruta:</label>
							</td>
							<td>
							<?php

							
							 $link=mysqli_connect('localhost','root','' , 'bodegon');

								$query="Select * from Rutas where IdRuta not in ('$Ruta')"


							?>
							<select name="cmbRuta" required>
								<?php	
									if($Ruta!="")
									{
										echo "<option value='$Ruta'>$Ruta</option>";		
									}
								
								?>
								<option value="Todas">Todas</option>
								<?php
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
							<td colspan="2"  align="center">
								<input name="btnReporte" type="submit" value="Reporte">
							</td>	
						</tr>
					</table>
				</form>
			</div><!--fin de formulario-->
		</div><!--container-->
	</body>
</html>