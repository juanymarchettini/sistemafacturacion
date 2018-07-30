<?php 
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
// app/Controller/UsersController.php
class ProveedoresController extends AppController {
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
        $this->Proveedore->recursive = 0;
        $this->set('proveedores', $this->paginate());
    }

    public function add() {
     	$this->layout='backend';
        if ($this->request->is('post')) {
            $this->Proveedore->create();
            $result= $this->Proveedore->find('first',array('conditions'=>array('Proveedore.nombre'=>$this->request->data['Proveedore']['nombre'])));
            if (empty($result)){
                if ($this->Proveedore->save($this->request->data)) {
                    $this->Session->setFlash(__('The Proveedore has been saved'));
                    return $this->redirect(array('action' => 'index'));
                }
                $this->Session->setFlash(
                    __('The Proveedore could not be saved. Please, try again.')
                );
            }else{
                $this->Session->setFlash(
                    __('Error! Ya existe un proveedor con dicho nombre')
                );
            }
        }
    }

    public function edit($id = null) {
         $this->layout='backend';
        $this->Proveedore->id = $id;
        if (!$this->Proveedore->exists()) {
            throw new NotFoundException(__('Invalid Proveedore'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Proveedore->save($this->request->data)) {
                $this->Session->setFlash(__('The Proveedore has been saved'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(
                __('The Proveedore could not be saved. Please, try again.')
            );
        } else {
            $this->request->data = $this->Proveedore->read(null, $id);
            
        }
    }

    public function delete($id = null) {
        $this->request->onlyAllow('post');

        $this->Proveedore->id = $id;
        if (!$this->Proveedore->exists()) {
            throw new NotFoundException(__('Invalid Proveedore'));
        }
        if ($this->Proveedore->delete()) {
            $this->Session->setFlash(__('Proveedore deleted'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Proveedore was not deleted'));
        return $this->redirect(array('action' => 'index'));
    }
}
?>