<h2>Tienes un Nuevo Pedido, desde la Web</h2>

<p><b>Datos del Comprador</b></p>
</br>
<?php		
	
	echo 'Nombre: '.$info['Producto']['nombre'].'</br>';
	echo 'Email: '.	$info['Producto']['email'].'</br>';
	echo 'Asunto: '.	$info['Producto']['asunto'].'</br>';
	echo 'Mensaje: '.	$info['Producto']['mensaje'].'</br>';
?>