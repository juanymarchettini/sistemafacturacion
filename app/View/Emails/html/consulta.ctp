
<img src="http://www.tiendaoverall.com.ar/img/logo.png" width="200px"  alt="Tienda Overall">
</br>
<h2>Consulta desde la web Tienda Overal</h2>

<p><b> 
</br>
<p><b>Datos del Comprador</b></p>
</br>
<?php		
	
	echo 'Nombre: '.$info['User']['nombre'].'</br>';
?></br>
<?php
	echo 'Apellido: '.	$info['User']['apellido'].'</br>';
?></br>
<?php
	echo 'Email: '.	$info['User']['email'].'</br>';
?></br>
<?php
	echo 'Direccion: '.	$info['User']['direccion'].'</br>';
?></br>
<?php
	echo 'Teléfono: '.	$info['User']['telefono'].'</br>';
?></br>
<?php
	echo 'Localidad: '.	$info['User']['localidad'].'</br>';
?></br>
<?php
	echo 'Consulta: '.	$info['User']['consulta'].'</br>';
?></br>
</br>
</b></p>