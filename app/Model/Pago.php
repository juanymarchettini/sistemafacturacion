<?php
App::uses('AppModel', 'Model');
/**
 * Capacitacione Model
 *
 * @property Categoria $Categoria
 */
class Pago extends AppModel {

	public $belongsTo = 'Factura';

	public $hasMany = array('Cheque'=> array(
            'className' => 'Cheque',
            'foreignKey' => 'pago_id',
            'dependent' => true,
            //'conditions' => array('Pago.tipopago_id'=>3)
        )
	);
	
}
?>