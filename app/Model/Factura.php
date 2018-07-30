<?php
App::uses('AppModel', 'Model');
/**
 * Capacitacione Model
 *
 * @property Categoria $Categoria
 */
class Factura extends AppModel {
    public $actsAs = array('Containable');
	// /public $belongsTo = 'User';
    //public $virtualFields = array('totalclientev'=>'SUM(CAST(REPLACE(Factura.total, ",", "") AS DECIMAL(10,2)))');
    public $validate = array(
        'user_id' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Falta completar usuario'
            )
        ), 
        'email' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Falta ingresar EMail'
            )
        ),
        'nombre' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Falta Ingresar Nombre'
            )
        ),
        'apellido' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Falta Ingresar Apellido'
            )
        )
    );

	public $hasMany = array(
        'Detalle' => array(
            'className' => 'Detalle',
            'foreignKey' => 'factura_id',
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
        'Pago'=>array(
            'className' => 'Pago',
            'foreignKey' => 'factura_id',
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
    );
}
?>