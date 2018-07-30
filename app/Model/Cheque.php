<?php
App::uses('AppModel', 'Model');
/**
 * Capacitacione Model
 *
 * @property Categoria $Categoria
 */
class Cheque extends AppModel {

	public $belongsTo ='Pago';
	
}
?>