<?php 
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
// app/Controller/UsersController.php
class UsersController extends AppController {

    public $helpers = array('Html', 'Form', 'Session', 'Js');
    public $components = array('Paginator','RequestHandler');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login','listjsonclientes', 'logout','emailpedidos','depositoslogin','ingreso','registro','contactenos','recuperarpass','transportelogin');
        
        if($this->Session->read('Auth.User')){
                if ($this->Auth->user('role') == 'admin'){
                    $this->Auth->allow();
                }
        }
     
    }
	
	// 1 es Transporte de a 4
    public function emailpedidos($idtranposrte=1){
        $this->layout=false;
        $this->loadModel('Pagospendiente');
        $this->loadModel('Transporte');
        $pagos=$this->Pagospendiente->find('all',array('fields'=>array('Factura.nombre','Factura.apellido','Pagospendiente.*'),'conditions'=>array('Pagospendiente.envioemail'=>0,'Pagospendiente.transporte_id'=>$idtranposrte,'Pagospendiente.status !='=>2),'recursive'=>0));
        $email=$this->Transporte->find('first',array('conditions'=>array('Transporte.id'=>$idtranposrte),'recursive'=>-1));
        
        //geneero la lista de id para luego enviado el email les pongo como enviados
        $listaid=$this->Pagospendiente->find('list',array('fields'=>array('Pagospendiente.id'),'conditions'=>array('Pagospendiente.envioemail'=>0,'Pagospendiente.transporte_id'=>$idtranposrte,'Pagospendiente.status !='=>2)));
        if (!empty($pagos)){
            $Email = new CakeEmail('noreply');
            $Email->template('emailpagos', 'default');
            $Email->emailFormat('html');
            $Email->viewVars(array('pagos' => $pagos));
            $Email->from(array('no-reply@tiendaoverall.com.ar' => 'TiendaOverall'));
            $Email->to($email['Transporte']['email']);
            $Email->cc(array('gratonlm@gmail.com','juanmarchettini@gmail.com'));
            $Email->subject('Resumen de Movimientos');
            if($Email->send()){
                $this->Session->setFlash(__('Gracias Por Inscribirse en Overall! Ingrese con su nueva cuenta'), 'default', array(), 'good');
                $this->Pagospendiente->updateAll(array('Pagospendiente.envioemail' => 1),array('Pagospendiente.id ' => $listaid));
            }
        }
    }
	
  

    public function registro() {
            $this->loadModel('Categoria');
            $this->set('catname',$this->Categoria->find('list',array('fields'=>array('Categoria.id','Categoria.nombre'))));
            $this->set('categorias',$this->Categoria->find('all',array('conditions'=>array('OR'=>array('Categoria.subcategoria_id'=>0, 'Categoria.subcategoria_id'=>null )),'order'=>array('Categoria.nombre'=>'ASC'))));
            if ($this->request->is('post')) {
            $this->request->data['User']['role']="mayorista";
            
            $datos= $this->User->find('first', array('conditions'=>array('User.username'=>$this->request->data['User']['username'])));
            if (empty($datos)) {
                $this->User->create();
                if ($this->User->save($this->request->data)) {
                    $data = $this->request->data;
                    $Email = new CakeEmail();
                    $Email->template('registro', 'default');
                    $Email->emailFormat('html');
                    $Email->viewVars(array('info' => $data));
                    $Email->from(array('no-reply@tiendaoverall.com.ar' => 'Tienda Overall'));
                    $Email->to($this->request->data['User']['username']);
                    $Email->subject('Bienvenidos a Tienda Overall');
                if($Email->send()){
                    $this->Session->setFlash(__('Gracias Por Inscribirse en Overall! Ingrese con su nueva cuenta'), 'default', array(), 'good');
                } 
               
                }else{
                    $this->Session->setFlash(('The user could not be saved. Please, try again.'), 'default', array(), 'bad');
                }
            }else{
                $this->Session->setFlash(__('Nombre de Usuario en uso!! Por favor registrese con otro nombre de usuario'), 'default', array(), 'bad');
            }
           
            return $this->redirect(array('controller' => 'Users', 'action' => 'ingreso'));
        }
    }

    public function recuperarpass() {
            $this->loadModel('Categoria');
            $this->set('catname',$this->Categoria->find('list',array('fields'=>array('Categoria.id','Categoria.nombre'))));
            $this->set('categorias',$this->Categoria->find('all',array('conditions'=>array('OR'=>array('Categoria.subcategoria_id'=>0, 'Categoria.subcategoria_id'=>null )),'order'=>array('Categoria.nombre'=>'ASC'))));
           
            if ($this->request->is('post')) {
            $datos= $this->User->find('first', array('conditions'=>array('User.username'=>$this->request->data['User']['email'])));
            if (!empty($datos)) {
                $passnew=Time();
                $datos['User']['password']=$passnew;
                $emailsend = $this->request->data['User']['email'];
                if ($this->User->save($datos['User'])) {
                    $data = $this->request->data;
                    $Email = new CakeEmail();
                    $Email->template('recuperarpass', 'default');
                    $Email->emailFormat('html');
                    $Email->viewVars(array('info' => $passnew));
                    $Email->from(array('no-reply@tiendaoverall.com.ar' => 'Tienda Overall'));
                    $Email->to(array($emailsend));
                    $Email->subject('Recupero de Pass Tienda Overall');
                
                if($Email->send()){
                    $this->Session->setFlash(__('Se ha enviado su nueva contraseña! Revise su casilla de Email'), 'default', array(), 'good');
                }
               
                }else{
                    $this->Session->setFlash(('The user could not be saved. Please, try again.'), 'default', array(), 'bad');
                }
            }else{
                $this->Session->setFlash(__('Nombre de Usuario inexistente en nuestro Sistema!! Por favor controle su nombre de usuario'), 'default', array(), 'bad');
            }
           
            return $this->redirect(array('controller' => 'Users', 'action' => 'recuperarpass'));
        }
    }

    public function contactenos() {
            $this->loadModel('Categoria');
            $this->set('catname',$this->Categoria->find('list',array('fields'=>array('Categoria.id','Categoria.nombre'))));
            $this->set('categorias',$this->Categoria->find('all',array('conditions'=>array('OR'=>array('Categoria.subcategoria_id'=>0, 'Categoria.subcategoria_id'=>null )),'order'=>array('Categoria.nombre'=>'ASC'))));
            if ($this->request->is('post')) {

                $data = $this->request->data;
                $Email = new CakeEmail();
                $Email->template('consulta', 'default');
                $Email->emailFormat('html');
                $Email->viewVars(array('info' => $data));
                $Email->from(array('consulta@tiendaoverall.com.ar' => 'Consulta Tienda Overall'));
                $Email->to('overallbb@hotmail.com');
                $Email->subject('Consulta tienda overall');
                if($Email->send()){
                    $this->Session->setFlash(__('Su consulta se ha enviado Correctamente. A la brevedad nos contactaremos'), 'default', array(), 'good');
                }else{
                     $this->Session->setFlash(__('Error al intentar enviar la conulta. Intentelo nuevamente'), 'default', array(), 'bad');
              
                } 
                  return $this->redirect(array('controller' => 'Users', 'action' => 'contactenos'));
            }
    }

    public function login() {
        $this->layout="ajax";
        if ($this->request->is('post')) {
            $this->Auth->logout();
            if ($this->Auth->login()) {

                
				return $this->redirect(array('controller'=>'facturas', 'action'=>'dashboard'));
            }
            $this->Session->setFlash(__('Las Credenciales Ingresadas son Incorrectas'), 'backend/flash/badflash');
        }
    }
	
	
    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

    public function lista($busqueda=null,$desde=null,$hasta=null) {
        $this->layout="backend";
        $this->User->recursive = 0;
        $search=null;
        $this->Paginator->settings = array(
                'recursive' =>  -1,
                'limit' => 300,
                'order'=>array('User.username'=>'ASC')
        );
        $conditions=null;
        

        if ($this->request->is('post') || $this->request->is('put')) {
            
            if(!empty($this->request->data['User']['start'])){
                $desde=$this->request->data['User']['start'];
                $desde = date_create($desde);
                $desde = date_format($desde,'Y-m-d');
                $conditions['DATE(User.created) >='] = $desde;
            }

            if(!empty($this->request->data['User']['end'])){
                $hasta=$this->request->data['User']['end'];
                $hasta = date_create($hasta);
                $hasta = date_format($hasta, 'Y-m-d');
                $conditions['DATE(User.created) <='] = $hasta;
        
            }

            if(!empty($this->request->data['User']['search'])){
                $conditions['OR'] = array('User.username LIKE '=>'%'.$busqueda.'%', 'User.nombre LIKE '=>'%'.$busqueda.'%' , 'User.apellido LIKE '=>'%'.$busqueda.'%');
            }
        }else{

            if (isset($_GET['search'])){
                $busqueda=$_GET['search'];
            }
           
            if (!empty($busqueda)){
                $this->Paginator->settings['conditions']=array('OR'=>array('User.username LIKE '=>'%'.$busqueda.'%', 'User.nombre LIKE '=>'%'.$busqueda.'%' , 'User.apellido LIKE '=>'%'.$busqueda.'%'));
                $conditions['OR']=array('User.username LIKE '=>'%'.$busqueda.'%', 'User.nombre LIKE '=>'%'.$busqueda.'%' , 'User.apellido LIKE '=>'%'.$busqueda.'%');
            }
        }

        
        $this->Paginator->settings = array(
            'conditions' => $conditions,
            'limit' => 200,
            'order' => array('User.id'=>'ASC')  
        );

        $data = $this->Paginator->paginate('User');
        $this->set('contadorusaurios',$this->User->find('count',array('conditions'=>$conditions)));
        $this->set('users', $data);
    }

    public function ajaxsearchcliente(){
            $this->layout='ajax';
            $busqueda=$_POST['busqueda'];
            $users = $this->User->find('all',array('conditions'=>array('OR'=>array('User.username LIKE '=>'%'.$busqueda.'%', 'User.nombre LIKE '=>'%'.$busqueda.'%',))));
            $this->set('users', $users);
            
    }

    

    public function view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->read(null, $id));
    }

    public function editarpass($id = null) {
        $this->User->id = $id;
        $this->layout="backend";
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved') , 'backend/flash/goodflash');
                return $this->redirect(array('action' => 'lista'));
            }
            $this->Session->setFlash(
                __('The user could not be saved. Please, try again.') , 'backend/flash/badflash'
            );
        } 
         $info=$this->User->read(null, $id);
         $info['User']['password']="";
         $this->request->data=$info;
    }   

    public function add() {
        $this->layout='backend';
        if ($this->request->is('post')) {
            $this->User->create();
            $flaguser=$this->User->find('first',array('conditions'=>array('User.cuit'=>$this->request->data['User']['cuit'])));
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('El se ha guardado Correctamente'),'backend/flash/goodflash');
                return $this->redirect(array('action' => 'lista'));
            }
            $this->Session->setFlash(
                __('The user could not be saved. Please, try again.'),'backend/flash/badflash'
            );
        }
    }

    public function ajaxbloquenuevocliente(){
        $this->layout='ajax';
        if ($this->request->is('post')) {
            $this->User->create();

            $cadena = str_replace(' ', '', $this->request->data['User']['cuit']);
            $this->request->data['User']['cuit']=$cadena;

            $flaguser=$this->User->find('first',array('conditions'=>array('User.cuit'=>$this->request->data['User']['cuit'])));
            if (empty($flaguser)){
                if ($this->User->save($this->request->data)) {
                    $this->Session->setFlash(__('El se ha guardado Correctamente'),'backend/flash/goodflash'); 
                }else{
                    $this->Session->setFlash(__('The user could not be saved. Please, try again.'),'backend/flash/badflash'); 
                }
            }else{
                $this->Session->setFlash(__('Ya Existe Usuario con dicho Cuit'),'backend/flash/badflash'); 
            }
            
        }
    }

    public function edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {

            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'),'backend/flash/goodflash');
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(
                __('The user could not be saved. Please, try again.'),'backend/flash/badflash'
            );
            
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
    }

    public function listjsonclientes(){
      $this->layout= false;
      $this->User->recursive=0;
      //$resultadofinal=array('id'=>0,'nombre'=>null, 'codigo'=>0, 'preciocompra'=>0, 'codigonombre'=>0);
      $this->loadModel('Factura');

      $resultado= $this->User->find('all',array('fields'=>array('username','apellido','nombre','id','telefono','direccion','provincia','cp','ciudad','cuit'),'conditions'=>array('OR'=>array('username LIKE'=>'%'.$_POST['phrase'].'%','nombre LIKE'=>'%'.$_POST['phrase'].'%','apellido LIKE'=>'%'.$_POST['phrase'].'%'))));
      
      $resultadofinal=null;

      foreach ($resultado as $key => $value) {
            if (isset($value['User']['password'])){
                unset($value['User']['password']);
            }
            $resultadofinal[]=$value['User'];    
        
      }
     
      echo json_encode($resultadofinal);


    }



    public function delete($id = null) {
        $this->request->onlyAllow('post');

        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'));
        return $this->redirect(array('action' => 'index'));
    }

    public function emailrecordatorio($id='overall2018'){

        if ($id=='overall2018'){

            $this->User->Behaviors->load('Containable');
           
            debug(
                $this->User->find('all',array('fields'=>array('User.id','User.username'),'contain' => array(
                    'Factura' => array(
                        
                        'conditions' => array("DATEDIFF(CURDATE(), Factura.created) <"=> 60),
                        'order' => 'Factura.created DESC',
                        'limit' => 1
                    )
                ),'conditions'=>array('User.role'=>array('mayorista','distribuidor')),'limit'=>500))
            );

        }else{
            echo 'Error de Token';
        }

    }

}
?>