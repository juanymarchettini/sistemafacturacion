<?php
App::uses('AppModel', 'Model');
/**
 * Capacitacione Model
 *
 * @property Categoria $Categoria
 */
class Proveedordetalle extends AppModel {

	public $belongsTo = 'Proveedorfactura';
	//var $virtualFields = array('total' => 'SUM(Detalle.precio * Detalle.cantidad)');
	
}
?>