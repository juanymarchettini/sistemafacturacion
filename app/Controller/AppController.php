<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $helpers = array('Html', 'Form', 'Session');

	public $components = array(
        'Session',
        'Auth' => array(
            'loginAction'=>array('controller' => 'Users', 'action' => 'login'),
            'loginRedirect' => array('controller' => 'Users', 'action' => 'Home'),
            'logoutRedirect' => array('controller' => 'Users', 'action' => 'login'), 
            'authorize' => array('Controller') 
        )
    );
   

    public function beforeFilter() {
    	parent::beforeFilter();
		$this->response->disableCache();
		$plan = $this->Session->read();
       
		
        $this->Auth->allow('logout','login','registro');
        
        if($this->Session->read('Auth.User')){
            if ($this->Auth->user('role') == 'admin'){
                $this->loadModel('Factura');
                $nrocontrasinasignar=0;
                $this->set('nrocontrasinasignar',$nrocontrasinasignar);

                $nropedidospendientes = $this->Factura->find('count',array('conditions'=>array('Factura.entregado'=>0,'Factura.cancelado'=>0,'Factura.facturado'=>0), 'order'=>array('Factura.id DESC') , 'limit'=>10, 'recursive'=>0 ));
                $this->set('nropedidospendientes',$nropedidospendientes);
                $this->loadModel('Pagospendiente');
                $nropagospendientesdeaprobacion= $this->Pagospendiente->find('count',array('conditions'=>array('Pagospendiente.status'=>2)));
                $this->set('nropagospendientesdeaprobacion',$nropagospendientesdeaprobacion);
            }
            
        }

        
       
    }

    public function isAuthorized($user) {
        // Admin can access every action
        if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }

        // Default deny
        $this->Session->setFlash(__('No tienes permisos para esta accion'), 'default', array('id' => 'notacces'), 'notacces');
        return false;
    }
}
