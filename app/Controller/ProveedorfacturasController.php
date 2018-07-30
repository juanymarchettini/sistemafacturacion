<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Categorias Controller
 *
 * @property Categoria $Categoria
 */
class ProveedorfacturasController extends AppController {

	public $helpers = array('Html', 'Form', 'Session', 'Js');
	var $uses = array('Producto','Proveedorfactura','Proveedore','User','Categoria','Proveedordetalle','Proveedorpago');
	public $components = array('Paginator','RequestHandler');

	
	public function beforeFilter() {
        parent::beforeFilter();
        $this->set('listaproveedores',$this->Proveedore->find('list',array('fields'=>array('id','nombre'))));
       
        if($this->Session->read('Auth.User')){
	     	if ($this->Auth->user('role') == 'admin'){
                $this->Auth->allow();
                 $this->set('listaoperadores',$this->User->find('list',array('fields'=>array('id','username'),'conditions'=>array('role'=>'admin'))));
            }
	     }
    }
    
    public function viewprint($id=null,$printview='factura'){
        $this->layout = 'backend';
        $this->Proveedorfactura->id = $id;
        $this->Proveedordetalle->recursive=2;
        $this->loadModel('Tipopago');
        $this->set('listatipodepagos',$this->Tipopago->find('list',array('fields'=>array('id','nombre'))));
        $productlistxcat =$this->Producto->find('list', array('fields'=>array('id','categoria_id'), 'order'=>array('Producto.categoria_id'=>'ASC','Producto.orden'=>'ASC')));
       
        $cantidadporcategorias= $this->Categoria->find('list', array('id'));
        $nombreporcategorias= $this->Categoria->find('list', array('fields'=>array('id','nombre')));

        foreach ($cantidadporcategorias as $key => $value) {
            $cantidadporcategorias[$key]=0;
        }

        if (!$this->Proveedorfactura->exists()) {
            throw new NotFoundException(__('Invalid Nro Factura'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Proveedorfactura->save($this->request->data)){
                $this->Session->setFlash(__('Se actualizaron Correctamente los Datos de Pago & Envio.') , 'backend/flash/goodflash');
            }
        }

        $this->set('pedido',$this->Proveedorfactura->read(null, $id));
        $this->request->data = $this->Proveedorfactura->read(null, $id);
        $facturabeta=$this->Proveedorfactura->find('first',array('conditions'=>array('Proveedorfactura.id'=>$id)));
       
        // LISTA DE PRODUCTOS CON SU CATEGORIA ID Idprod->Idcat;
        $this->set('productlistxcat',$productlistxcat);
        //Todas las CAtegorias con TOtal en 0   Idcat->0
        $this->set('cantidadporcategorias',$cantidadporcategorias);
        // Nombre de la Cateogría
        $this->set('nombreporcategorias',$nombreporcategorias);
        
        switch ($printview) {
                case 'factura':
                    $this->layout =false;
                    $this->render('printpedido');
                    break;
                case 'encomienda':
                    $this->layout =false;
                    $this->render('printencomienda');
                    break;
        }
        
        
    }
    

    public function gastosadd(){
        $this->layout = 'backend';
        $this->Categoria->recursive=2;
        //Basicos
        $this->set('userid', $this->Auth->user('id'));

        $productlistxcat =$this->Producto->find('list', array('fields'=>array('id','categoria_id'), 'order'=>array('Producto.categoria_id'=>'ASC','Producto.orden'=>'ASC')));
        $nombreporcategorias= $this->Categoria->find('list', array('fields'=>array('id','nombre')));
        
        $this->Proveedorfactura->Behaviors->attach('MeioUpload', array(
                    'archivo' => array(
                            'dir' => 'img{DS}gastos',
                            'create_directory' => true,
                            'allowed_mime' => array('image/jpeg', 'image/jpg', 'image/png','image/JPEG', 'image/JPG', 'image/PNG', 'application/pdf', 'text/plain', 'application/msword',  'application/vnd.ms-powerpoint', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.wordprocessingml.template', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/zip'),
                            'default' => 'default.jpg',
                        )
        ));

        

            
        if ($this->request->is('post') || $this->request->is('put')) {
                if (!empty($this->request->data['Proveedordetalle'])){

                     /* Quito Articulos con Cantidad 0 y Actualizo el total */
                    $total = 0;
                    foreach ($this->request->data['Proveedordetalle'] as $key => $value) {
                        if  ((!isset($value['cantidad'])) || ($value['cantidad'] < 1)){
                            unset($this->request->data['Proveedordetalle'][$key]);
                        }else{
                            $total=$total + (float) $value['cantidad'] * (float) $value['precio'];
                        }
                    }
                   
                    $this->request->data['Proveedorfactura']['total'] = $total;
                    $data = $this->request->data;

                
                    if ($this->Proveedorfactura->saveAll($this->request->data)) {
                        $this->Session->setFlash(__('Se ha Cargado Correctamente su Pedido'),'backend/flash/goodflash');  
                         $this->redirect(array('action'=>'listafacturas/true'));
                    }else{
                        $this->Session->setFlash(__('UPS!!!!!! Se produjo un error. Intentelo nuevamente.'));
                    }

                }else{
                    $this->Session->setFlash(__('No se Cargo detalle para la factura!!'));
                }
        
        }

        $this->set('catname',$nombreporcategorias);
        $this->set('categorias',$this->Categoria->find('all',array('conditions'=>array('Categoria.subcategoria_id'=>0),'order'=>array('Categoria.nombre'=>'ASC'))));
                
    }

    public function gastosedit($id=null){
        $this->layout = 'backend';
        $this->Categoria->recursive=2;
        //Basicos
        if (!$this->Proveedorfactura->exists($id)) {
            throw new NotFoundException(__('Proveedorfactura inválida'));
        }
        $this->set('userid', $this->Auth->user('id'));

        $productlistxcat =$this->Producto->find('list', array('fields'=>array('id','categoria_id'), 'order'=>array('Producto.categoria_id'=>'ASC','Producto.orden'=>'ASC')));
        $nombreporcategorias= $this->Categoria->find('list', array('fields'=>array('id','nombre')));
        
        $this->Proveedorfactura->Behaviors->attach('MeioUpload', array(
                    'archivo' => array(
                            'dir' => 'img{DS}gastos',
                            'create_directory' => true,
                            'allowed_mime' => array('image/jpeg', 'image/jpg', 'image/png','image/JPEG', 'image/JPG', 'image/PNG', 'application/pdf', 'text/plain', 'application/msword',  'application/vnd.ms-powerpoint', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.wordprocessingml.template', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/zip'),
                            'default' => 'default.jpg',
                        )
        ));

       if ($this->request->is('post') || $this->request->is('put')) {
                if (!empty($this->request->data['Proveedordetalle'])){

                     /* Quito Articulos con Cantidad 0 y Actualizo el total */
                    $total = 0;
                    foreach ($this->request->data['Proveedordetalle'] as $key => $value) {
                        if  ((!isset($value['cantidad'])) || ($value['cantidad'] < 1)){
                            unset($this->request->data['Proveedordetalle'][$key]);
                        }else{
                            $total= $total + $value['cantidad'] * (float) $value['precio'];
                        }
                    }
                    

                    $this->request->data['Proveedorfactura']['total'] = $total;
                    $data = $this->request->data;

                
                    if ($this->Proveedorfactura->saveAll($this->request->data)) {
                        $this->Session->setFlash(__('Se ha Cargado Correctamente su Pedido'),'backend/flash/goodflash'); 
                        $this->redirect(array('action'=>'listafacturas',1));
                    }else{
                        $this->Session->setFlash(__('UPS!!!!!! Se produjo un error. Intentelo nuevamente.'));
                    }

                }else{
                    $this->Session->setFlash(__('No se Cargo detalle para la factura!!'));
                }
        
        }

        $options = array('conditions' => array('Proveedorfactura.' . $this->Proveedorfactura->primaryKey => $id));
        $this->request->data = $this->Proveedorfactura->find('first', $options);
        $this->set('catname',$nombreporcategorias);
        $this->set('categorias',$this->Categoria->find('all',array('conditions'=>array('Categoria.subcategoria_id'=>0),'order'=>array('Categoria.nombre'=>'ASC'))));
                
    }
    public function add(){
        $categoriapadrelista=$this->Categoria->find('list',array('fields'=>array('Categoria.id','Categoria.subcategoria_id'), 'conditions'=>array('Categoria.subcategoria_id'=>0)));
        $this->set('categoriapadrelista',$categoriapadrelista);

        $categoriapadrenombre=$this->Categoria->find('list',array('fields'=>array('Categoria.id','Categoria.nombre'), 'conditions'=>array('Categoria.subcategoria_id'=>0)));
        $this->set('categoriapadrenombre',$categoriapadrenombre);

        $categoriahijopadrelista=$this->Categoria->find('list',array('fields'=>array('Categoria.id','Categoria.subcategoria_id'), 'conditions'=>array('Categoria.subcategoria_id !='=>0)));
        $this->set('categoriahijopadrelista',$categoriahijopadrelista);

        

        $this->set('categoriapadrelista',$categoriapadrelista);
        $this->layout = 'backend';
        $this->Categoria->recursive=2;
        //Basicos
        $this->set('userid', $this->Auth->user('id'));
        $this->Proveedorfactura->Behaviors->attach('MeioUpload', array(
                    'archivo' => array(
                            'dir' => 'img{DS}gastos',
                            'create_directory' => true,
                            'allowed_mime' => array('image/jpeg', 'image/jpg', 'image/png','image/JPEG', 'image/JPG', 'image/PNG', 'application/pdf', 'text/plain', 'application/msword',  'application/vnd.ms-powerpoint', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.wordprocessingml.template', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/zip'),
                            'default' => 'default.jpg',
                        )
        ));
        $productlistxcat =$this->Producto->find('list', array('fields'=>array('id','categoria_id'), 'order'=>array('Producto.categoria_id'=>'ASC','Producto.orden'=>'ASC')));
        $nombreporcategorias= $this->Categoria->find('list', array('fields'=>array('id','nombre')));

        if ($this->request->is('post') || $this->request->is('put')) {
             if (!empty($this->request->data['Proveedordetalle'])){

                 /* Quito Articulos con Cantidad 0 y Actualizo el total */
                $total = 0;
                foreach ($this->request->data['Proveedordetalle'] as $key => $value) {
                    if  ((!isset($value['cantidad'])) || ($value['cantidad'] < 1)){
                        unset($this->request->data['Proveedordetalle'][$key]);
                    }else{
                        $total=$total + (float) $value['cantidad'] * (float) $value['precio'];
                    }
                }
               
                $this->request->data['Proveedorfactura']['total'] = $total;
                $data = $this->request->data;

            
            if ($this->Proveedorfactura->saveAll($this->request->data)) {
                
                $this->Session->setFlash(__('Se ha Cargado Correctamente su Pedido'),'backend/flash/goodflash');
                 $this->redirect(array('action'=>'listafacturas'));
               
            }else{
                $this->Session->setFlash(__('UPS!!!!!! Se produjo un error. Intentelo nuevamente.'));
            }
          }else{
                $this->Session->setFlash(__('No se Cargo detalle para la factura!!'));
          }
        }

        $this->set('catname',$nombreporcategorias);
        $this->set('categorias',$this->Categoria->find('all',array('conditions'=>array('Categoria.subcategoria_id'=>0),'order'=>array('Categoria.nombre'=>'ASC'))));
                
    }

    public function edit($id=null){
        $this->layout = 'backend';
         $this->Proveedorfactura->Behaviors->attach('MeioUpload', array(
                    'archivo' => array(
                            'dir' => 'img{DS}gastos',
                            'create_directory' => true,
                            'allowed_mime' => array('image/jpeg', 'image/jpg', 'image/png','image/JPEG', 'image/JPG', 'image/PNG', 'application/pdf', 'text/plain', 'application/msword',  'application/vnd.ms-powerpoint', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.wordprocessingml.template', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/zip'),
                            'default' => 'default.jpg',
                        )
        ));
        if (!$this->Proveedorfactura->exists($id)) {
            throw new NotFoundException(__('Proveedorfactura inválida'));
        }
        //Basicos
        $this->set('userid', $this->Auth->user('id'));

        $productlistxcat =$this->Producto->find('list', array('fields'=>array('id','categoria_id'), 'order'=>array('Producto.categoria_id'=>'ASC','Producto.orden'=>'ASC')));
        $nombreporcategorias= $this->Categoria->find('list', array('fields'=>array('id','nombre')));

        //Basicos
        $this->set('userid', $this->Auth->user('id'));

        if ($this->request->is('post') || $this->request->is('put')) {
                if (!empty($this->request->data['Proveedordetalle'])){

                     /* Quito Articulos con Cantidad 0 y Actualizo el total */
                    $total = 0;
                    foreach ($this->request->data['Proveedordetalle'] as $key => $value) {
                        if  ((!isset($value['cantidad'])) || ($value['cantidad'] < 1)){
                            unset($this->request->data['Proveedordetalle'][$key]);
                        }else{
                            $total=$total + (float) $value['cantidad'] * (float) $value['precio'];
                        }
                    }
                   
                    $this->request->data['Proveedorfactura']['total'] = $total;
                    $data = $this->request->data;

                
                    if ($this->Proveedorfactura->saveAll($this->request->data)) {
                        $this->Session->setFlash(__('Se ha Cargado Correctamente su Pedido'),'backend/flash/goodflash'); 
                         $this->redirect(array('action'=>'listafacturas')); 
                    }else{
                        $this->Session->setFlash(__('UPS!!!!!! Se produjo un error. Intentelo nuevamente.'));
                    }

                }else{
                    $this->Session->setFlash(__('No se Cargo detalle para la factura!!'));
                }
        
        }
        
        $options = array('conditions' => array('Proveedorfactura.' . $this->Proveedorfactura->primaryKey => $id));
        $this->request->data = $this->Proveedorfactura->find('first', $options);
        $this->set('catname',$nombreporcategorias);
        $this->set('categorias',$this->Categoria->find('all',array('conditions'=>array('Categoria.subcategoria_id'=>0),'order'=>array('Categoria.nombre'=>'ASC'))));
                
    }
    
    public function view($id=null,$printview=false){
   		$this->layout = 'backend';
		$this->Factura->id = $id;
        $this->Detalle->recursive=2;
        $productlistxcat =$this->Producto->find('list', array('fields'=>array('id','categoria_id'), 'order'=>array('Producto.categoria_id'=>'ASC','Producto.orden'=>'ASC')));
       
        $cantidadporcategorias= $this->Categoria->find('list', array('id'));
        $nombreporcategorias= $this->Categoria->find('list', array('fields'=>array('id','nombre')));

        foreach ($cantidadporcategorias as $key => $value) {
            $cantidadporcategorias[$key]=0;
        }

        if (!$this->Factura->exists()) {
            throw new NotFoundException(__('Invalid Nro Factura'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Factura->save($this->request->data)){
                $this->Session->setFlash(__('Se actualizaron Correctamente los Datos de Pago & Envio.') , 'backend/flash/goodflash');
            }
        }

        $this->set('pedido',$this->Factura->read(null, $id));
        $this->request->data = $this->Factura->read(null, $id);
        $facturabeta=$this->Factura->find('first',array('conditions'=>array('Factura.id'=>$id)));
       
        // LISTA DE PRODUCTOS CON SU CATEGORIA ID Idprod->Idcat;
        $this->set('productlistxcat',$productlistxcat);
        //Todas las CAtegorias con TOtal en 0   Idcat->0
        $this->set('cantidadporcategorias',$cantidadporcategorias);
        // Nombre de la Cateogría
        $this->set('nombreporcategorias',$nombreporcategorias);
        
        switch ($printview) {
                case 'factura':
                    $this->layout =false;
                    $this->render('printpedido');
                    break;
                case 'encomienda':
                    $this->layout =false;
                    $this->render('printencomienda');
                    break;
        }
        
        
    }

     //es gasto (campo booleano) solo se utilizada para diferenciar gastos diarios etc de compra a proveedores
    public function listafacturas($esgasto=false){
        $this->layout = 'backend';
        $search=array();
        $conditions=array();
        //$this->Proveedorfactura->Behaviors->load('Containable');
        
        if ($this->request->is('post') || $this->request->is('put')) {
            
            if(!empty($this->request->data['Proveedorfactura']['start'])){
                $desde=$this->request->data['Proveedorfactura']['start'];
                $desde = date_create($desde);
                $desde = date_format($desde,'Y-m-d');
                $conditions['DATE(Proveedorfactura.fecha) >='] = $desde;
            }
            if(!empty($this->request->data['Proveedorfactura']['end'])){
                $hasta=$this->request->data['Proveedorfactura']['end'];
                $hasta = date_create($hasta);
                $hasta = date_format($hasta, 'Y-m-d');
                $conditions['DATE(Proveedorfactura.fecha) <='] = $hasta;
        
            }
            if(!empty($this->request->data['Proveedorfactura']['proveedor_id'])){
                $conditions['Proveedorfactura.proveedore_id'] = $this->request->data['Proveedorfactura']['proveedor_id'];
            }
           
            $conditions['Proveedorfactura.esgasto']=$this->request->data['Proveedorfactura']['esgasto'];
            $esgasto=$this->request->data['Proveedorfactura']['esgasto'];


            $search=$conditions;
            $this->Paginator->settings = array(
                'conditions'=> $conditions,
                'recursive' =>  1,
                'limit' => 200,
                'order' => array('Proveedorfactura.id'=>'DESC')
            );

            $totalgasto=$this->Proveedorfactura->find('all',array('fields'=>array('SUM(Proveedorfactura.total) AS TOTAL'),'conditions'=>$conditions));
            $texto='<b>Gastado en el Periodo: $</b>'.$totalgasto[0][0]['TOTAL'].'</br>'.'Entre las Fechas: '.$desde.' -- '.$hasta;
            $this->set('resumentexto',$texto);
        }else{
            $this->Paginator->settings = array(
                'conditions'=> array('Proveedorfactura.esgasto'=>$esgasto),
                'recursive' =>  1,
                'limit' => 100,
                'order' => array('Proveedorfactura.id'=>'DESC')
            );
        }

        $titulo="Lista de Facturas Proveedores";
        $data = $this->Paginator->paginate('Proveedorfactura');
        $this->set('pedidos', $data);
        $this->set('titulo',$titulo);
        $this->set('esgasto',$esgasto);
        $this->passedArgs["search"] =$search;
    }



    public function delete($id = null) {
        
        $this->layout = 'backend';
        $this->Proveedorfactura->id = $id;
        if (!$this->Proveedorfactura->exists()) {
            throw new NotFoundException(__($label.'inválida.'));
        }


        if (($this->Proveedorpago->deleteAll(array('Proveedorpago.proveedorfactura_id' => $id), false)) && ($this->Proveedorfactura->delete()) && ($this->Proveedordetalle->deleteAll(array('Proveedordetalle.proveedorfactura_id' => $id), false))){
            $this->Session->setFlash(__('Pudo ser Eliminado'),'backend/flash/goodflash');
            $this->redirect($this->referer());
        }
        $this->Session->setFlash(__('No pudo ser eliminado. Intentelo Nuevamente'));
        $this->redirect($this->referer());
    }
   



    public function addbeta(){
        $this->layout = 'backend';
        $this->Categoria->recursive=2;
        //Basicos
        $this->set('userid', $this->Auth->user('id'));

        $productlistxcat =$this->Producto->find('list', array('fields'=>array('id','categoria_id'), 'order'=>array('Producto.categoria_id'=>'ASC','Producto.orden'=>'ASC')));
        $nombreporcategorias= $this->Categoria->find('list', array('fields'=>array('id','nombre')));

        if ($this->request->is('post') || $this->request->is('put')) {
             if (!empty($this->request->data['Proveedordetalle'])){

                 /* Quito Articulos con Cantidad 0 y Actualizo el total */
                $total = 0;
                foreach ($this->request->data['Proveedordetalle'] as $key => $value) {
                    if  ((!isset($value['cantidad'])) || ($value['cantidad'] < 1)){
                        unset($this->request->data['Proveedordetalle'][$key]);
                    }else{
                        $total=$total + (float) $value['cantidad'] * (float) $value['precio'];
                    }
                }
               
                $this->request->data['Proveedorfactura']['total'] = $total;
                $data = $this->request->data;

            
            if ($this->Proveedorfactura->saveAll($this->request->data)) {
                
                $this->Session->setFlash(__('Se ha Cargado Correctamente su Pedido'),'backend/flash/goodflash');
                 $this->redirect(array('action'=>'listafacturas'));
               
            }else{
                $this->Session->setFlash(__('UPS!!!!!! Se produjo un error. Intentelo nuevamente.'));
            }
          }else{
                $this->Session->setFlash(__('No se Cargo detalle para la factura!!'));
          }
        }

        $this->set('catname',$nombreporcategorias);
        $this->set('categorias',$this->Categoria->find('all',array('conditions'=>array('Categoria.subcategoria_id'=>0),'order'=>array('Categoria.nombre'=>'ASC'))));
                
    }

    

}
?>