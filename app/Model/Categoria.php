<?php
App::uses('AppModel', 'Model');
/**
 * Capacitacione Model
 *
 * @property Categoria $Categoria
 */
class Categoria extends AppModel {
      public $actsAs = array('Tree');
	public $hasMany = array('Producto'=> array(
            'className' => 'Producto',
            'foreignKey' => 'categoria_id',
            'dependent' => false,
            'conditions' => array('Producto.stock >'=>0),
            'fields' => array('Producto.id','Producto.nombre','Producto.stock','Producto.codigo','Producto.disponible','Producto.categoria_id','Producto.preciocompra','Producto.iva','Producto.precio'),
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