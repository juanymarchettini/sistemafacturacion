<?php
App::uses('AppModel', 'Model');
/**
 * Capacitacione Model
 *
 * @property Categoria $Categoria
 */
class Producto extends AppModel {

	public $belongsTo = 'Categoria';
	public $virtualFields = array('codigonombre' => 'CONCAT(Producto.codigo + Producto.nombre)','preciobruto'=>'ROUND(Producto.precio * ((Producto.iva/100)+1),2)');
	
}
?>