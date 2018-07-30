<?php
App::uses('AppModel', 'Model');
/**
 * Capacitacione Model
 *
 * @property Categoria $Categoria
 */
class Detalle extends AppModel {

	public $belongsTo = 'Factura';
	//var $virtualFields = array('total' => 'SUM(Detalle.precio * Detalle.cantidad)');
	
}
?>