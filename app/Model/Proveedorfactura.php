<?php
App::uses('AppModel', 'Model');
/**
 * Capacitacione Model
 *
 * @property Categoria $Categoria
 */
class Proveedorfactura extends AppModel {

	// /public $belongsTo = 'User';
    
    public $belongsTo = 'Proveedore';
	public $hasMany = array(
        'Proveedordetalle' => array(
            'className' => 'Proveedordetalle',
            'foreignKey' => 'proveedorfactura_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Proveedorpago' => array(
            'className' => 'Proveedorpago',
            'foreignKey' => 'proveedorfactura_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );
}
?>