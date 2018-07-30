<h2>Tienes un Nuevo Pedido, desde la Web</h2>

<p><b>Datos del Comprador</b></p>
</br>

<p>
<?php		
	
	echo 'Nombre: '.$info['Factura']['nombre'].'</br>';
?></br>
</p>
<p>
<?php
	echo 'Apellido: '.	$info['Factura']['apellido'].'</br>';
?></br>
</p>
<p>
<?php
	echo 'Email: '.	$info['Factura']['email'].'</br>';
?></br>
</p>
<p>
<?php
	echo 'Direccion: '.	$info['Factura']['direccion'].'</br>';
?></br>
</p>
<p>
<?php
	echo 'Teléfono: '.	$info['Factura']['tel'].'</br>';
?></br>
</p>
<p>
<?php
	echo 'Localidad: '.	$info['Factura']['localidad'].'</br>';
?></br>
</p>
<p>
<?php
	echo 'Total de la Factura: '. $info['Factura']['total'].'</br>';
?></br>
</p>
<p>
<?php
	echo 'Comentario: '.	$info['Factura']['message'].'</br>';
?></br>
</p>
<p><b>Detalle Compra</b></p>
</br>

<table cellpadding="0" cellspacing="0">
	<tr>
			<th style="  min-width: 100px; padding:8px;">Producto</th>
			<th style="  min-width: 100px; padding:8px;">Codigo</th>
			<th style="  min-width: 100px; padding:8px;">Precio de Venta</th>
			<th style="  min-width: 100px; padding:8px;"> CANTIDAD </th>
			<th style="  min-width: 100px; padding:8px;"> Total Producto</th>
	</tr>
<?php 

	
 	foreach ($info['Detalle'] as $value) {
 		
 		
?>
		<tr>
			<td style="  min-width: 100px; padding:8px;"> <?php echo $value['nombre']; ?> </td>
			<td style="  min-width: 100px; padding:8px;"><b><?php echo $value['codigo']; ?> </b></td>
			<td style="  min-width: 100px; padding:8px;">$ <?php echo $value['precio']; ?></td>
			<td style="  min-width: 100px; padding:8px;"> <b><?php echo $value['cantidad']; ?> </b>unid.</td>
			<td style="  min-width: 100px; padding:8px;">$ <?php $totalinput = $value['precio'] * $value['cantidad'];  echo $totalinput; ?></td>
		</tr>	
<?php		
	}
?>
</table>
<style type="text/css">
table {
	border-right:0;
	clear: both;
	color: #333;
	margin-bottom: 10px;
	width: 100%;
}
th {
	border:0;
	border-bottom:2px solid #555;
	text-align: left;
	padding:4px;
}
th a {
	display: block;
	padding: 2px 4px;
	text-decoration: none;
}
th a.asc:after {
	content: ' ⇣';
}
th a.desc:after {
	content: ' ⇡';
}
table tr td {
	padding: 6px;
	text-align: left;
	vertical-align: top;
	border-bottom:1px solid #ddd;
}
table tr:nth-child(even) {
	
}
td.actions {
	text-align: center;
	white-space: nowrap;
}
table td.actions a {
	margin: 0px 6px;
	padding:2px 5px;
}

</style>

