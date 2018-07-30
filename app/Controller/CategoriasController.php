<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Categorias Controller
 *
 * @property Categoria $Categoria
 */
class CategoriasController extends AppController {

	public $helpers = array('Html', 'Form', 'Session', 'Js');
	var $uses = array('Producto','Categoria', 'User');
	public $components = array('Paginator','RequestHandler');
	
	public function beforeFilter(){
        parent::beforeFilter();

        
        if($this->Session->read('Auth.User')){
        	if ($this->Auth->user('role') == 'admin'){
            	$this->Auth->allow();  
            }
	    }
	    $this->set('categorias', $this->Categoria->generateTreeList(null,null,'{n}.Categoria.nombre'));

    }

    public function ajaxsearchcategoria(){

        $this->layout='ajax';
        $busqueda=$_POST['busqueda'];
        $this->Categoria->recursive = 0;
		$this->set('categorias', $this->Categoria->find('all',array('conditions'=>array('OR'=>array('Categoria.nombre LIKE '=>'%'.$busqueda.'%')),'order'=>array('Categoria.nombre'=>'ASC','Categoria.id'=>'ASC'))));
       
        
        $titulo="Categoria";
        $this->set('subcategoria',$this->Categoria->find('list',array('fields'=>array('id','nombre'), 'conditions'=>array('Categoria.subcategoria_id'=>0) )));

        $this->set('titulo',$titulo);

    }


/** CRUD DE CATEGORIA
 * add method
 *
 * @return void
 */
	
	public function add() {
		$this->layout = 'backend';
		if ($this->request->is('post')) {
			$this->Categoria->create();
			if ($this->request->data['Categoria']['parent_id'] == null){
				$this->request->data['Categoria']['parent_id'] = 0;
			}	
			if ($this->Categoria->saveAll($this->request->data)) {
				$this->Session->setFlash(__('La categoría a sido salvada'));
				$this->redirect(array('action' => 'add'));
			} else {
				$this->Session->setFlash(__('La categoría no pudo ser salvada. Por favor, inténtelo nuevamente.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->layout = 'backend';
		if (!$this->Categoria->exists($id)) {
			throw new NotFoundException(__('Categoría inválida'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->request->data['Categoria']['parent_id'] == null){
				$this->request->data['Categoria']['parent_id'] = 0;
			}	
			if ($this->Categoria->saveAll($this->request->data)) {
				$this->Session->setFlash(__('La categoría a sido salvada'));
				$this->redirect(array('action' => 'lista'));
			} else {
				$this->Session->setFlash(__('La categoría no pudo ser salvada. Por favor, inténtelo nuevamente.'));
			}
		} else {
			$options = array('conditions' => array('Categoria.' . $this->Categoria->primaryKey => $id));
			$this->request->data = $this->Categoria->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 * @FALTA  CONTROLAR QUE NO TENGA HIJOS ASIGNADOS 
 */
	public function delete($id = null) {
		$this->layout = 'backend';
		$this->Categoria->id = $id;
		if (!$this->Categoria->exists()) {
			throw new NotFoundException(__('Categoría inválida'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Categoria->delete()) {
			$this->Session->setFlash(__('Categoría eliminada'));
			$this->redirect(array('action' => 'lista'));
		}
		$this->Session->setFlash(__('La categoría no fue eliminada'));
		$this->redirect(array('action' => 'lista'));
	}

/**
 * lista method
 *
 * @return void
 */
	public function lista() {
		$this->layout = 'backend';
		$this->Categoria->recursive = 2;
		$this->set('categorias', $this->Categoria->generateTreeList(null,null,'{n}.Categoria.nombre'));

		$this->set('subcategoria',$this->Categoria->generateTreeList(null,null,'{n}.Categoria.nombre'));
		
	}



	
}
