<?php


	
	$IdCliente=$_GET['txtNoCliente'];
	$Factura=$_GET['txtFactura'];
	$IdRecibo=$_GET['txtIdRecibo'];
	$MontoPago=$_GET['txtMontoPago'];
	$FechaPago=$_GET['txtFechaPago'];
	 $TipoDocumento=$_GET['cmbTipoDocumento'];
 	$TipoPago=$_GET['cmbTipoPago'];
 	$boton=$_GET['btnAccion'];

 		$link=mysqli_connect('localhost','root','','bodegontest');

 	if($boton=='Guardar')
 	{	

		

		mysqli_query($link,"update pagos set 
		IdPago='$IdRecibo', IdFactura='$Factura', 
		MontoPago='$MontoPago', FechaPago='$FechaPago',
		TipoDocumento='$TipoDocumento', TipoPago='$TipoPago'  
		where IdPago='$IdRecibo'");

	}
	if ($boton=='Borrar') 
	{
		mysqli_query($link,"delete from pagos where IdPago='$IdRecibo'");
		
	} 
	
		header("location:ConsultaSaldoAccion.php?txtNoCliente=$IdCliente&btnAccion=Buscar Cliente");
	
	 

	

?>

