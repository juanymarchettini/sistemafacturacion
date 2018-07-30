<?php
App::uses('AppModel', 'Model');
/**
 * Capacitacione Model
 *
 * @property Categoria $Categoria
 */
class Cuentabancaria extends AppModel {

	public $belongsTo = array('Pago');
	var $virtualFields = array('banconombre' => 'CONCAT(Cuentabancaria.banco +"-Cbu: "+Cuentabancaria.titular)');

	
}
?>