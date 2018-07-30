<?php
App::uses('AppModel', 'Model');
/**
 * Capacitacione Model
 *
 * @property Categoria $Categoria
 */
class Pagospendiente extends AppModel {

	public $belongsTo = 'Factura';
	
}
?>