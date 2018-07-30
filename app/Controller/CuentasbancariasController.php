<?php 
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
// app/Controller/UsersController.php
class CuentasbancariasController extends AppController {
	public $helpers = array('Html', 'Form', 'Session', 'Js');
    public $components = array('Paginator','RequestHandler');

    public function beforeFilter() {
        parent::beforeFilter();
        if($this->Session->read('Auth.User')){
                if ($this->Auth->user('role') == 'admin'){
                    $this->Auth->allow();
                }
        }
     
    }

    public function index() {
        $this->layout='backend';
        $this->Cuentasbancaria->recursive = 0;
        $this->set('cuentasbancarias', $this->paginate());
    }

     public function add() {
     	$this->layout='backend';
        if ($this->request->is('post')) {
            $this->Cuentasbancaria->create();
            if ($this->Cuentasbancaria->save($this->request->data)) {
                $this->Session->setFlash(__('The Cuentasbancaria has been saved'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(
                __('The Cuentasbancaria could not be saved. Please, try again.')
            );
        }
    }

    public function edit($id = null) {
         $this->layout='backend';
        $this->Cuentasbancaria->id = $id;
        if (!$this->Cuentasbancaria->exists()) {
            throw new NotFoundException(__('Invalid Cuentasbancaria'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Cuentasbancaria->save($this->request->data)) {
                $this->Session->setFlash(__('The Cuentasbancaria has been saved'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(
                __('The Cuentasbancaria could not be saved. Please, try again.')
            );
        } else {
            $this->request->data = $this->Cuentasbancaria->read(null, $id);
            
        }
    }

    public function delete($id = null) {
        $this->request->onlyAllow('post');

        $this->Cuentasbancaria->id = $id;
        if (!$this->Cuentasbancaria->exists()) {
            throw new NotFoundException(__('Invalid Cuentasbancaria'));
        }
        if ($this->Cuentasbancaria->delete()) {
            $this->Session->setFlash(__('Cuentasbancaria deleted'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Cuentasbancaria was not deleted'));
        return $this->redirect(array('action' => 'index'));
    }
}
?>