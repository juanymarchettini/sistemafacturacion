<?php
App::uses('AppModel', 'Model');
/**
 * Capacitacione Model
 *
 * @property Categoria $Categoria
 */
class Proveedorpago extends AppModel {

	public $belongsTo = 'Proveedorfactura';
	
}
?>