<?php
App::uses('AppModel', 'Model');
/**
 * Capacitacione Model
 *
 * @property Categoria $Categoria
 */
class Fotosproducto extends AppModel {

	public $belongsTo = 'Producto';
	
}
?>