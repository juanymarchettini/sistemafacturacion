<?php 
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
// app/Controller/UsersController.php
class CitiesController extends AppController {
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
        $this->City->recursive = 0;
        $this->set('cities', $this->paginate());
    }

     public function add() {
     	$this->layout='backend';
        if ($this->request->is('post')) {
            $this->City->create();
            if ($this->City->save($this->request->data)) {
                $this->Session->setFlash(__('The City has been saved'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(
                __('The City could not be saved. Please, try again.')
            );
        }
    }

    public function edit($id = null) {
         $this->layout='backend';
        $this->City->id = $id;
        if (!$this->City->exists()) {
            throw new NotFoundException(__('Invalid City'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->City->save($this->request->data)) {
                $this->Session->setFlash(__('The City has been saved'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(
                __('The City could not be saved. Please, try again.')
            );
        } else {
            $this->request->data = $this->City->read(null, $id);
            
        }
    }

    public function delete($id = null) {
        $this->request->onlyAllow('post');

        $this->City->id = $id;
        if (!$this->City->exists()) {
            throw new NotFoundException(__('Invalid City'));
        }
        if ($this->City->delete()) {
            $this->Session->setFlash(__('City deleted'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('City was not deleted'));
        return $this->redirect(array('action' => 'index'));
    }
}
?>