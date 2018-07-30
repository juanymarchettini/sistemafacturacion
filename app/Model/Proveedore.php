<?php
App::uses('AppModel', 'Model');
/**
 * Capacitacione Model
 *
 * @property Categoria $Categoria
 */
class Proveedore extends AppModel {

	public $hasMany = 'Proveedorfactura';
	//var $virtualFields = array('total' => 'SUM(Detalle.precio * Detalle.cantidad)');
	
}
?>