<?php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {
    public $hasMany = 'Factura';
    public $validate = array(
        
        'role' => array(
            'valid' => array(
                'rule' => array('inList', array('admin', 'operador','deposito','cliente')),
                'message' => 'Please enter a valid role',
                'allowEmpty' => false
            )
        )
    );
    
    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new SimplePasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }
        return true;
    }
}
?>