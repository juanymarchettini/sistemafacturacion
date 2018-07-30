<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Categorias Controller
 *
 * @property Categoria $Categoria
 */
class FacturasController extends AppController {

	public $helpers = array('Html', 'Form', 'Session', 'Js');
	var $uses = array('Producto','Factura','User','Categoria','Detalle','Transporte','Pago','Tipopago');
	public $components = array('Paginator','RequestHandler');

	
	public function beforeFilter() {
        parent::beforeFilter();

       

        if($this->Session->read('Auth.User')){
	     	if ($this->Auth->user('role') == 'mayorista'){
                $this->Auth->allow(array('mi_carro','comprafinalizada','sumar_carro','remove_carro', 'cancelar_compra','mispedidos','vermispedidos' ,'delete'));
            }else{
                if ($this->Auth->user('role') == 'distribuidor'){
                    $this->Auth->allow(array('micarrodistribuidora','comprafinalizada','sumar_carro','remove_carro', 'cancelar_compra','mispedidos','vermispedidos' ,'delete'));
                }else{
                    if ($this->Auth->user('role') == 'stock'){
                    $this->Auth->allow(array('listaporclientes','listapendientes','view', 'printpedidocategorias','lista','ajaxsearchpedido' ,'cancelar_compra','activar_compra','delete','entregar_compra','armarpedido','facturarpedido','listadefacturas','facturascontrareembolsosinasignar','listadefacturasfinalizadas','listartodo','ingresoplata'));
                    }else{
                        if ($this->Auth->user('role') == 'admin'){
                            $this->Auth->allow(); // Letting users register themselves
                        }
                    }
                }
            }
            $this->set('operarios',array('1'=>'Marcos Correa','2'=>'Matias Medrano','3'=>'Juan Marchettini','4'=>'Pablo Martin','5'=>'Rolo Arancibia','6'=>'Leo Graton'));
	    }

         $this->set('listadetransportes',$this->Transporte->find('list',array('fields'=>array('id','nombre'))));
	    

    }
    
    public function dashboard(){
        $this->layout='backend';
        $clientes= $this->User->find('count');
        $facturas = $this->Factura->find('count',array('conditions'=>array('Factura.entregado'=>0,'Factura.cancelado'=>0,'Factura.facturado'=>0), 'order'=>array('Factura.id DESC') , 'limit'=>10, 'recursive'=>0 ));
        $productos = $this->Producto->find('count',array('conditions'=>array('Producto.disponible'=>1)));
        $facturado = $this->Factura->find('all',array('fields'=>array('YEAR(Factura.created) AS anio', 'MONTH(Factura.created) AS mes', 'SUM(total) AS totalfacturado'),'conditions'=>array('entregado'=>1,'cancelado'=>0), 'group'=>array('anio DESC', 'mes DESC' ),'recursive'=>-1));
        $pedidos =  $this->Factura->find('all',array('conditions'=>array('Factura.facturado'=>0), 'order'=>array('Factura.id DESC') , 'limit'=>10, 'recursive'=>0 ));
        $pagospendientes=array();
        $this->set('pedidos', $pedidos);
        $this->set('pagospendientes', $pagospendientes);
        $this->set('clientes', $clientes);
        $this->set('facturas', $facturas);
        $this->set('productos', $productos);
        $this->set('facturado', $facturado);
       
    }

    public function view($id=null,$printview=false){
   		$this->layout = 'backend';
        if ($this->Auth->user('role') == 'stock'){
            $this->layout='backendstock';
        }
		$this->Factura->id = $id;
        $this->Detalle->recursive=2;
        $productlistxcat =$this->Producto->find('list', array('fields'=>array('id','categoria_id'), 'order'=>array('Producto.categoria_id'=>'ASC','Producto.orden'=>'ASC')));
		
        $this->set('listatipodepagos',$this->Tipopago->find('list',array('fields'=>array('id','nombre'))));
        $this->set('listaoperadores', $this->User->find('list',array('fields'=>array('id','username'), 'conditions'=>array('User.role'=>array('transporte','admin')))));         
           
        
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
        
        //SE BUSCA EL PREV Y EL NEXT segun si estan Facturados o no Facturados
        $prevnext=$this->Factura->find('neighbors',array('conditions'=>array('facturado'=>$facturabeta['Factura']['facturado'],'statuspago'=>$facturabeta['Factura']['statuspago']),'recursive'=>-1,'order'=>array('Factura.entregado'=>'ASC', 'Factura.id'=>'ASC'),'fields'=>'id','value'=>$id));

        $this->set('anteriorysiguiente',$prevnext);
       
       
       
        
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
    // NUEVA FACTURA
    // EDICION DE LA FACTURA CREADA POR EL CLIENTE
    public function add(){
        $this->layout = 'backend';
        if ($this->Auth->user('role') == 'stock'){
            $this->layout='backendstock';
        }

        $categoriapadrelista=$this->Categoria->find('list',array('fields'=>array('Categoria.id','Categoria.parent_id'), 'conditions'=>array('Categoria.parent_id'=>0)));
        $this->set('categoriapadrelista',$categoriapadrelista);


        $categoriapadrenombre=$this->Categoria->find('list',array('fields'=>array('Categoria.id','Categoria.nombre'), 'conditions'=>array('Categoria.parent_id'=>0)));
        $this->set('categoriapadrenombre',$categoriapadrenombre);

        $categoriahijopadrelista=$this->Categoria->find('list',array('fields'=>array('Categoria.id','Categoria.parent_id'), 'conditions'=>array('Categoria.parent_id !='=>0)));
        $this->set('categoriahijopadrelista',$categoriahijopadrelista);

        $listaproductoscategoriaid=$this->Producto->find('list',array('fields'=>array('id','categoria_id'), 'conditions'=>array('Producto.disponible'=>1)));
        $this->set('listaproductoscategoriaid',$listaproductoscategoriaid);



        $productlistxcat =$this->Producto->find('list', array('fields'=>array('id','categoria_id'), 'order'=>array('Producto.categoria_id'=>'ASC','Producto.orden'=>'ASC')));
        
        $this->set('listatipodepagos',$this->Tipopago->find('list',array('fields'=>array('id','nombre'))));
        $this->set('listaoperadores', $this->User->find('list',array('fields'=>array('id','username'), 'conditions'=>array('User.role'=>array('transporte','admin')))));         
           
       

        
        if ($this->request->is('post') || $this->request->is('put')) {
            if (!empty($this->request->data['Detalle']) && (!empty($this->request->data['Factura']['user_id']))){

                 /* Quito Articulos con Cantidad 0 y Actualizo el total */
                $total = 0;
                foreach ($this->request->data['Detalle'] as $key => $value) {
                    if  ((!isset($value['cantidad'])) || ($value['cantidad'] < 1)){
                        unset($this->request->data['Detalle'][$key]);
                    }else{
                        $total=$total + (float) $value['cantidad'] * (float) $value['precio'] *  ((((float)$value['iva']/100)+1));
                    }
                }
                $this->request->data['Factura']['totalbackup']=$total;
                $this->request->data['Factura']['total'] = $total;
                

                if ($this->Factura->saveAll($this->request->data)){
                    $this->Session->setFlash(__('Se actualizaron Correctamente los Datos') , 'backend/flash/goodflash');
                }
            }
        }

        $this->set('pedido',array());

        $cantidadporcategorias= $this->Categoria->find('list', array('id'));
        $nombreporcategorias= $this->Categoria->find('list', array('fields'=>array('id','nombre')));

        foreach ($cantidadporcategorias as $key => $value) {
            $cantidadporcategorias[$key]=0;
        }
       
        // LISTA DE PRODUCTOS CON SU CATEGORIA ID Idprod->Idcat;
        $this->set('productlistxcat',$productlistxcat);
        //Todas las CAtegorias con TOtal en 0   Idcat->0
        $this->set('cantidadporcategorias',$cantidadporcategorias);
        // Nombre de la Cateogría
        $this->set('nombreporcategorias',$nombreporcategorias);
        
       
        
    }   


// EDICION DE LA FACTURA CREADA POR EL CLIENTE
    public function edit($id=null){
        $this->layout = 'backend';
        if ($this->Auth->user('role') == 'stock'){
            $this->layout='backendstock';
        }

        $categoriapadrelista=$this->Categoria->find('list',array('fields'=>array('Categoria.id','Categoria.parent_id'), 'conditions'=>array('Categoria.parent_id'=>0)));
        $this->set('categoriapadrelista',$categoriapadrelista);


        $categoriapadrenombre=$this->Categoria->find('list',array('fields'=>array('Categoria.id','Categoria.nombre'), 'conditions'=>array('Categoria.parent_id'=>0)));
        $this->set('categoriapadrenombre',$categoriapadrenombre);

        $categoriahijopadrelista=$this->Categoria->find('list',array('fields'=>array('Categoria.id','Categoria.parent_id'), 'conditions'=>array('Categoria.parent_id !='=>0)));
        $this->set('categoriahijopadrelista',$categoriahijopadrelista);

        // esto se puede mejorar solo buscando los productos que estan en la factura no todos
        $listaproductoscategoriaid=$this->Producto->find('list',array('fields'=>array('id','categoria_id'), 'conditions'=>array('Producto.disponible'=>1)));
        $this->set('listaproductoscategoriaid',$listaproductoscategoriaid);

        $this->Factura->id = $id;
        $this->Detalle->recursive=2;

        $productlistxcat =$this->Producto->find('list', array('fields'=>array('id','categoria_id'), 'order'=>array('Producto.categoria_id'=>'ASC','Producto.orden'=>'ASC')));
        
        $this->set('listatipodepagos',$this->Tipopago->find('list',array('fields'=>array('id','nombre'))));
        $this->set('listaoperadores', $this->User->find('list',array('fields'=>array('id','username'), 'conditions'=>array('User.role'=>array('transporte','admin')))));         
           
       

        if (!$this->Factura->exists()) {
            throw new NotFoundException(__('Invalid Nro Factura'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            if (!empty($this->request->data['Detalle']) && (!empty($this->request->data['Factura']['user_id']))){

                 /* Quito Articulos con Cantidad 0 y Actualizo el total */
                $total = 0;
                foreach ($this->request->data['Detalle'] as $key => $value) {
                    if  ((!isset($value['cantidad'])) || ($value['cantidad'] < 1)){
                        unset($this->request->data['Detalle'][$key]);
                    }else{
                        $total=$total + (float) $value['cantidad'] * (float) $value['precio'];
                    }
                }
                $this->request->data['Factura']['totalbackup']=number_format($total,2);
                $this->request->data['Factura']['total'] = number_format($total,2);
                

                if ($this->Factura->saveAll($this->request->data)){
                    $this->Session->setFlash(__('Se actualizaron Correctamente los Datos') , 'backend/flash/goodflash');
                }
            }
        }

        $this->set('pedido',$this->Factura->read(null, $id));

        $this->request->data = $this->Factura->read(null, $id);
        //debug($this->request->data);

        $cantidadporcategorias= $this->Categoria->find('list', array('id'));
        $nombreporcategorias= $this->Categoria->find('list', array('fields'=>array('id','nombre')));

        foreach ($cantidadporcategorias as $key => $value) {
            $cantidadporcategorias[$key]=0;
        }
       
        // LISTA DE PRODUCTOS CON SU CATEGORIA ID Idprod->Idcat;
        $this->set('productlistxcat',$productlistxcat);
        //Todas las CAtegorias con TOtal en 0   Idcat->0
        $this->set('cantidadporcategorias',$cantidadporcategorias);
        // Nombre de la Cateogría
        $this->set('nombreporcategorias',$nombreporcategorias);
        
       
        
    }

    //id de detalle de factura el cual elimina esa linea de la tabla 
    public function deletedetalleajax($id=null){
        $this->layout='ajax';
        $this->loadModel('Detalle');
        $id=$_GET["id"];
        debug($id);
        $this->Detalle->id = $id;
        if ($this->request->is('ajax')) {
            if ($this->Detalle->exists()) {
                if ($this->Detalle->delete($id)) {
                    echo 'OK';
                }else{
                    echo 'No borra';
                }
            }else{
                echo 'No Existe';
            }
        }else{
            echo 'No entra por ajxa';
        }
    }


    public function vermispedidos($id=null){
        
        $this->Factura->id = $id;
        if (!$this->Factura->exists()) {
            throw new NotFoundException(__('Invalid Nro Factura'));
        }

        $productlistxcat =$this->Producto->find('list', array('fields'=>array('id','categoria_id')));
        
        $cantidadporcategorias= $this->Categoria->find('list', array('id'));
        $nombreporcategorias= $this->Categoria->find('list', array('fields'=>array('id','nombre')));

        foreach ($cantidadporcategorias as $key => $value) {
            $cantidadporcategorias[$key]=0;
        }

        
        
        $this->set('pedido',$this->Factura->read(null, $id));

        // LISTA DE PRODUCTOS CON SU CATEGORIA ID Idprod->Idcat;
        $this->set('productlistxcat',$productlistxcat);
        //Todas las CAtegorias con TOtal en 0   Idcat->0
        $this->set('cantidadporcategorias',$cantidadporcategorias);
        // Nombre de la Cateogría
        $this->set('nombreporcategorias',$nombreporcategorias);

        $this->set('categorias',$this->Categoria->find('all',array('conditions'=>array('OR'=>array('Categoria.parent_id'=>0, 'Categoria.parent_id'=>null )),'order'=>array('Categoria.nombre'=>'ASC'))));
        
        
    }
    public function lista(){
   		$this->layout = 'backend';
         if ($this->Auth->user('role') == 'stock'){
            $this->layout='backendstock';
        }
		$this->Factura->Behaviors->load('Containable');
       
        $this->Paginator->settings = array(
                'contain' => array('Pago'=>array('fields' => array('id', 'monto'))),
                'recursive' =>  1,
                'limit' => 30,
                'order' => array('Factura.entregado'=>'ASC', 'Factura.id'=>'ASC')
        
        
        );
		$data = $this->Paginator->paginate('Factura');
		$this->set('pedidos', $data);

    }

   // El $id representa el id del cliente
   public function listaporclientes($id=null){
        $this->layout = 'backend';
         if ($this->Auth->user('role') == 'stock'){
            $this->layout='backendstock';
        }
        $this->Factura->Behaviors->load('Containable');

        if( isset($this->request->data['User']['id']) && !empty($this->request->data['User']['id'])){
            if (empty($id)){
                $id = $this->request->data['User']['id'];
            }
        }

        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid Nro Cliente'));
        }
       
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->User->id = $this->request->data['User']['id'];
            $this->User->saveField('role', $this->request->data['User']['role']);
            $this->Session->setFlash(__('Se actualizo Correctamente, el Rol del usuario.'),'backend/flash/goodflash');
            return $this->redirect($this->referer());
            
        }

        $this->Paginator->settings = array(
                'contain' => array('Pago'=>array('fields' => array('id', 'monto','status'))),
                'recursive' =>  1,
                'limit' => 100,
                'conditions'=>array('Factura.user_id'=>$id,'Factura.facturado'=>1),
                'order' => array('Factura.statuspago'=>'DESC')
        
        
        );
        $this->request->data= $this->User->read(null,$id);
        $data = $this->Paginator->paginate('Factura');
        $this->set('pedidos', $data);

        // Cantidad de Facturas Adeudadas
        $facturasadeudadas= $this->Factura->find('count',array('conditions'=>array('user_id'=>$id,'facturado'=>1,'statuspago <>'=>'Pagado')));
        $this->set('facturasadeudadas',$facturasadeudadas);

        $totaladeudadas= $this->Factura->find('list', array('fields'=>array('id','total'),'conditions'=>array('user_id'=>$id,'facturado'=>1,'statuspago <>'=>'Pagado')));
        $facturasparciales=$this->Pago->find('all',array('fields'=>array('SUM(Pago.monto) AS totalparcial') ,'conditions'=>array('Factura.facturado'=>1,'Factura.user_id'=>$id,'Factura.entregado'=>1,'Factura.statuspago'=>'Pago Parcial','Pago.status'=>'1','Pago.tipopago_id !='=>6),'recursive'=>0));
        debug($facturasparciales);
        $totalvar=0;
        foreach ($totaladeudadas as $valuetotal) {
            $totalmp=str_replace(',','',$valuetotal);
            $totalmp=(float)$totalmp;
            $totalvar=$totalvar+$totalmp;
        }
        $this->set('totaladeudadas',$totalvar);

        //Ventas por mes 
         
         $resultmes=$this->Factura->find('all',array('fields'=>array("(EXTRACT(YEAR_MONTH FROM created)) AS aniomes",'SUM(CAST(total AS DECIMAL(10,6))) AS total'),'conditions'=>array('user_id'=>$id),'group'=>'EXTRACT(YEAR_MONTH FROM created)','order'=>array('Factura.id'=>'ASC') ,'recursive'=>-1));

		
        $listameses[]='2017';
        $listamesventas[]=0;
        foreach ($resultmes as $key => $value) {
            $listameses[]=$value[0]['aniomes'];
            $listamesventas[]=$value[0]['total'];
        }

        $this->set('listamesventas',$listamesventas);
        $this->set('listameses',$listameses);
		

       

   }
    
    //Status = 0 Pendiente . Status = 1 Entregados
    public function listapendientes($status=0){
        $this->layout = 'backend';
        if ($this->Auth->user('role') == 'stock'){
            $this->layout='backendstock';
        }
        $this->Factura->Behaviors->load('Containable');
        
        
            $this->Paginator->settings = array(
                    'contain' => array('Pago'=>array('fields' => array('id', 'monto'))),
                    'conditions'=> array('Factura.facturado'=>0),
                    'recursive' =>  1,
                    'limit' => 45,
                    'order' => array('Factura.id'=>'DESC')
            
            
            ); 
        $titulo="Pedidos Pendientes";
        $data = $this->Paginator->paginate('Factura');
        $this->set('pedidos', $data);
        $this->set('titulo',$titulo);

   }

    public function ajaxsearchpedido(){

        $this->layout='ajax';
        if(isset($_POST['busqueda'])){
            $busqueda=$_POST['busqueda'];
        }else{
            $busqueda="";
        }

        $this->Factura->Behaviors->load('Containable');
       
        $this->Paginator->settings = array(
                    'contain' => array('Pago'=>array('fields' => array('id', 'monto','status'))),
                    'conditions'=>array('Factura.facturado'=>0,'OR'=>array('Factura.nombre LIKE '=>'%'.$busqueda.'%', 'Factura.apellido LIKE '=>'%'.$busqueda.'%','Factura.id LIKE '=>'%'.$busqueda.'%','Factura.email LIKE '=>'%'.$busqueda.'%' )),
                    'recursive' =>  1,
                    'limit' => 100,
                    'order' => array('Factura.id'=>'ASC')
        );
        $titulo="Pedidos Pendientes";
        $data = $this->Paginator->paginate('Factura');
        $this->set('pedidos', $data);
        $this->set('titulo',$titulo);

   }

    

  
   
   
   
   public function mispedidos($id=null){
            
        $this->Paginator->settings = array(
                    'conditions'=>array('Factura.user_id'=>$this->Session->read('Auth.User.id')),
                    'recursive' =>  1,
                    'limit' => 50,
                    'order' => array('Factura.id'=>'DESC','Factura.entregado'=>'ASC')
        );
        $data = $this->Paginator->paginate('Factura');
        $this->set('pedidos', $data);
        $this->set('categorias',$this->Categoria->find('all',array('conditions'=>array('OR'=>array('Categoria.parent_id'=>0, 'Categoria.parent_id'=>null )),'order'=>array('Categoria.nombre'=>'ASC'))));
        

   }


	public function cancelar_compra($id=null){
		$this->layout=false;
        $this->Factura->recursive=1;
        
        $this->Factura->id = $id;
        if (!$this->Factura->exists()) {
            throw new NotFoundException(__('Factura Invalida'));
        }

        $this->Factura->saveField('facturado', 0);
        $this->Session->setFlash(__('Su Pedido Fue Facturado'));
        return $this->redirect($this->referer());
    
	}

    public function activar_compra($id=null){
        $this->layout=false;
       
        
        $this->Factura->id = $id;
        if (!$this->Factura->exists()) {
            throw new NotFoundException(__('Factura Invalida'));
        }
        
        $factura=$this->Factura->find('first', array('conditions'=>array('Factura.id'=>$id)));
        $factura['Factura']['cancelado']='0';
        
        
        if ($this->Factura->save($factura)) {
            $this->Session->setFlash(__('Factura Activada'));
            return $this->redirect($this->referer());
        }
        $this->Session->setFlash(__('La Facutra no pudo ser Activada, intentelo nuevamente.'));
        return $this->redirect(array('action' => 'lista'));
    
    }

    //status = 1 CORRECTO , 2 = Error
    public function statusarmado($id=null,$status=1){
        $this->layout=false;

        $this->Factura->id = $id;
        if (!$this->Factura->exists()) {
            throw new NotFoundException(__('Factura Invalida'));
        }
        
        $this->Factura->saveField('armadocorrecto', $status);
        $this->Session->setFlash(__('Su Estado  Fue Actualizado'));
        return $this->redirect($this->referer());
    
    }

    public function entregar_compra($id=null, $value=0){
        $this->layout=false;
        $this->Factura->recursive=1;
        
        $this->Factura->id = $id;
        if (!$this->Factura->exists()) {
            throw new NotFoundException(__('Factura Invalida'));
        }

        $factura=$this->Factura->find('first', array('fields'=>array('Factura.*'),'conditions'=>array('Factura.id'=>$id)));
        $factura['Factura']['entregado']=$value;
        if ($value!=0){
            $factura['Factura']['fechaenvio']=date("Y-m-d");
            
            if($factura['Factura']['empaquetado'] == 0){
               $factura['Factura']['empaquetado']=1;
               $factura['Factura']['armadopor']=5; // Asignamos al ROlo
               $factura['Factura']['armadocorrecto']=1;
               $factura['Factura']['fechaarmado']=date("Y-m-d H:i:s");
            }


        }else{
            $factura['Factura']['fechaenvio']='';
        }

        
        if ($this->Factura->save($factura)) {
            $this->Session->setFlash(__('Estado  Actualizado'));
            return $this->redirect($this->referer());
        }

        $this->Session->setFlash(__('El estado no pudo ser Actualizado, intentelo nuevamente.'));
        return $this->redirect(array('action' => 'lista'));
    
    }

    public function armarpedido($id=null,$flagsubmit=true){
        $this->layout=false;
        $this->Factura->recursive=1;
        

        if (isset($this->request->data['Armarpedido']['factura_id'])){
            $id=$this->request->data['Armarpedido']['factura_id'];
        }

        $this->Factura->id = $id;

        if (!$this->Factura->exists()) {
            throw new NotFoundException(__('Factura Invalida'));
        }

        $data=$this->Factura->find('first',array('conditions'=>array('Factura.id'=>$id)));
        $this->set('idfactura',$id);
        
        if ($flagsubmit){
            if ($this->request->is('ajax')) {               
                $this->Factura->saveField('empaquetado', $this->request->data['Armarpedido']['empaquetado']);
                $this->Factura->saveField('armadopor', $this->request->data['Armarpedido']['armadopor']);
                $this->Factura->saveField('armadocorrecto',1);
                $this->Factura->saveField('fechaarmado',date("Y-m-d H:i:s"));
                $this->render('ajaxmensajearmadook');

                
                $Email = new CakeEmail();
                $Email->from(array('no-reply@tiendaoverall.com.ar' => 'Tienda Overall')); 
                $Email->emailFormat('html');
                $Email->template('avisodearmado', 'default');
                $Email->viewVars(array('info' => $data['Factura']['id']));
                $Email->to($data['Factura']['email']);
                $Email->subject('Ya esta listo su Pedido! Nro: '.$data['Factura']['id']);
                $Email->send();
                
            }
        }else{
            $info=$this->Factura->read(null,$id);
            
            $this->request->data['Armarpedido']['armadopor']=$info['Factura']['armadopor'];
            $this->request->data['Armarpedido']['empaquetado']=$info['Factura']['empaquetado'];

        }


        //$this->Factura->saveField('empaquetado', $value);
        //$this->Factura->saveField('armadopor', $armadopor);
        //$this->Session->setFlash(__('Estado  Actualizado'));
        
        
    }

    // Pertenece a la seccion listadepedidospendientes : Esta funcion actualiza el campo facturado a True y pasa a ser una factura el pedido
    public function facturarpedido($id=null, $value=0){
        $this->layout=false;
        $this->Factura->recursive=1;
        
        $this->Factura->id = $id;
        if (!$this->Factura->exists()) {
            throw new NotFoundException(__('Factura Invalida'));
        }

        $this->Factura->saveField('facturado', $value);
        $this->Factura->saveField('fechafacturado', date("Y-m-d"));
        $this->Session->setFlash(__('Su Pedido Fue Facturado'));
        return $this->redirect($this->referer());
        
    }
    /**        
    
    ACA COMIENZA TODO SOBRE LA SECCION PEDIDOS YA FACTURADOS

    **/
    // MUESTRA TODOS LOS PEDIDOS YA FACTURADOS
    public function listadefacturas($search=null,$desde=null,$hasta=null){
        $this->layout = 'backend';
         if ($this->Auth->user('role') == 'stock'){
            $this->layout='backendstock';
        }
        $this->Factura->Behaviors->load('Containable');

        if (isset($_GET['searchfact'])){
                    $search=$_GET['searchfact'];
        }
        // SI EXISTE LA VARIABLE Y NO ESTA VACIA  ES QUE INGRESA POR EL SEARCH
        if (isset($this->request->data['Factura']['searchfact']) && (!empty($this->request->data['Factura']['searchfact'])) ){
            $search=$this->request->data['Factura']['searchfact'];
        }else{

            if (isset($this->passedArgs["search"])){
                $search=$this->passedArgs["search"];
            }
        }
        
        if ($this->request->is('post') || $this->request->is('put')) {

            if(!empty($this->request->data['Factura']['start'])){
                $desde=$this->request->data['Factura']['start'];
                $desde = date_create($desde);
                $desde = date_format($desde,'Y-m-d');
                $conditions['DATE(Factura.fechaenvio) >='] = $desde;
            }
            if(!empty($this->request->data['Factura']['end'])){
                $hasta=$this->request->data['Factura']['end'];
                $hasta = date_create($hasta);
                $hasta = date_format($hasta, 'Y-m-d');
                $conditions['DATE(Factura.fechaenvio) <='] = $hasta;
        
            }
			
			if(!empty($this->request->data['Pago']['tiposdepagos'])){
                $conditions['Factura.tipodepago'] = $this->request->data['Pago']['tiposdepagos'];
            }
           
           $conditions[]=array('Factura.facturado'=>1, 'OR' => array('Factura.statuspago != "Pagado"', 'Factura.entregado '=>0),'AND'=>array('OR'=>array('Factura.nombre LIKE '=>'%'.$search.'%', 'Factura.apellido LIKE '=>'%'.$search.'%','Factura.id LIKE '=>'%'.$search.'%','Factura.email LIKE '=>'%'.$search.'%','Factura.localidad LIKE '=>'%'.$search.'%','Factura.total LIKE '=> $search.'%' )));
           
        
        }else{

           $conditions= array('Factura.facturado'=>1, 'OR' => array('Factura.statuspago != "Pagado"', 'Factura.entregado '=>0),'AND'=>array('OR'=>array('Factura.nombre LIKE '=>'%'.$search.'%', 'Factura.apellido LIKE '=>'%'.$search.'%','Factura.id LIKE '=>'%'.$search.'%','Factura.email LIKE '=>'%'.$search.'%','Factura.localidad LIKE '=>'%'.$search.'%','Factura.total LIKE '=> $search.'%' )));
        }

        

        $this->Paginator->settings = array(
            'contain' => array('Pago'=>array('fields' => array('id', 'monto','status'))),
            'conditions'=>$conditions,
            'recursive' =>  1,
            'limit' => 200,
            'order' => array('Factura.id'=>'DESC')
        );
        $titulo="Facturas";
        $data = $this->Paginator->paginate('Factura');
        $this->set('pedidos', $data);
        $this->set('titulo',$titulo);
        $this->passedArgs["search"] = $search;
        $this->set('search', $search);
    }



    public function delete($id = null, $label='Factura') {
        
        $this->layout = 'backend';
        $this->Factura->id = $id;
        if (!$this->Factura->exists()) {
            throw new NotFoundException(__($label.'inválida.'));
        }

        

        
        if (($this->Factura->delete()) && ($this->Detalle->deleteAll(array('Detalle.factura_id' => $id), false))){
            
                $this->Session->setFlash(__($label.' eliminado'));
                $this->redirect($this->referer());
            
            
            $this->Session->setFlash(__('No pudo ser eliminado. Intentelo Nuevamente'));
        }
        
        $this->redirect($this->referer());
    }


    // MUESTRA TODOS LOS PEDIDOS YA FACTURADOS
    public function listadefacturasfinalizadas($search=null){
        $this->layout = 'backend';
        if ($this->Auth->user('role') == 'stock'){
            $this->layout='backendstock';
        }
        $this->Factura->Behaviors->load('Containable');
        
        // SI EXISTE LA VARIABLE Y NO ESTA VACIA  ES QUE INGRESA POR EL SEARCH
        if (isset($this->request->data['Factura']['searchfact']) && (!empty($this->request->data['Factura']['searchfact'])) ){
            $search=$this->request->data['Factura']['searchfact'];
        }else{

            if (isset($this->passedArgs["search"])){
                $search=$this->passedArgs["search"];
            }
        }

        $this->Paginator->settings = array(
                    'contain' => array('Pago'=>array('fields' => array('id', 'monto','status'))),
                    'conditions'=>array('Factura.facturado'=>1, 'Factura.entregado' =>1,'Factura.statuspago' =>'Pagado','OR'=>array('Factura.nombre LIKE '=>'%'.$search.'%', 'Factura.apellido LIKE '=>'%'.$search.'%','Factura.id LIKE '=>'%'.$search.'%','Factura.email LIKE '=>'%'.$search.'%','Factura.localidad LIKE '=>'%'.$search.'%','Factura.total LIKE '=> $search.'%' )),
                    'recursive' =>  1,
                    'limit' => 70,
                    'order' => array('Factura.id'=>'DESC')
        );


        $titulo="Facturas Finalizadas";
        $data = $this->Paginator->paginate('Factura');
        $this->set('pedidos', $data);
        $this->set('titulo',$titulo);
        $this->passedArgs["search"] = $search;
        $this->set('search', $search);
        
    }


/// BUSCADOR SUPERIOR

     // MUESTRA TODOS LOS PEDIDOS o FACTURAS
    public function listartodo($search=null){
        $this->layout = 'backend';
         if ($this->Auth->user('role') == 'stock'){
            $this->layout='backendstock';
        }
        $this->Factura->Behaviors->load('Containable');

        if (isset($_GET['search'])){
                    $search=$_GET['search'];
        }
        // SI EXISTE LA VARIABLE Y NO ESTA VACIA  ES QUE INGRESA POR EL SEARCH
        if (isset($this->request->data['Factura']['searchfact']) && (!empty($this->request->data['Factura']['searchfact'])) ){
            $search=$this->request->data['Factura']['searchfact'];
        }else{

            if (isset($this->passedArgs["search"])){
                $search=$this->passedArgs["search"];
            }
        }

        $this->Paginator->settings = array(
            'contain' => array('Pago'=>array('fields' => array('id', 'monto','status'))),
            'conditions'=>array('OR'=>array('Factura.nombre LIKE '=>'%'.$search.'%', 'Factura.apellido LIKE '=>'%'.$search.'%','Factura.id LIKE '=>'%'.$search.'%','Factura.email LIKE '=>'%'.$search.'%','Factura.localidad LIKE '=>'%'.$search.'%','Factura.total LIKE '=> $search.'%' )),
            'recursive' =>  1,
            'limit' => 70,
            'order' => array('Factura.id'=>'DESC')
        );
        $titulo="Todos los Movimientos";
        $data = $this->Paginator->paginate('Factura');
        $this->set('pedidos', $data);
        $this->set('titulo',$titulo);
        $this->passedArgs["search"] = $search;
        $this->set('search', $search);
    }


    public function ingresoplata(){
        $this->layout = 'backend';
         if ($this->Auth->user('role') == 'stock'){
            $this->layout='backendstock';
        }
        $this->Categoria->recursive=2;
        //Basicos
        $this->set('userid', $this->Auth->user('id'));

       

        

            
        if ($this->request->is('post') || $this->request->is('put')) {
                if (!empty($this->request->data['Detalle'])){

                     /* Quito Articulos con Cantidad 0 y Actualizo el total */
                    $total = 0;
                    foreach ($this->request->data['Detalle'] as $key => $value) {
                        if  ((!isset($value['cantidad'])) || ($value['cantidad'] < 1)){
                            unset($this->request->data['Detalle'][$key]);
                        }else{
                            $total=$total + (float) $value['cantidad'] * (float) $value['precio'];
                        }
                    }
                   
                    $this->request->data['Factura']['total'] = $total;
                    $datapagos['Pago']['factura_id'] ='';
                    $datapagos['Pago']['monto'] =$total;
                    $datapagos['Pago']['tipopago_id'] =1;
                    $datapagos['Pago']['operador_id'] =$this->Auth->user('id');

                    $data = $this->request->data;

                    //debug($data);

                    if ($this->Factura->saveAll($this->request->data)) {
                        $datapagos['Pago']['factura_id']=$this->Factura->id;
                        if ($this->Pago->save( $datapagos)) {
                         $this->Session->setFlash(__('Se ha Ingresado Correctamente'),'backend/flash/goodflash');  
                         $this->redirect(array('action'=>'ingresoplata'));
                        }
                    }else{
                        $this->Session->setFlash(__('UPS!!!!!! Se produjo un error. Intentelo nuevamente.'));
                    }
                    

                }else{
                    $this->Session->setFlash(__('No se Cargo detalle para la factura!!'));
                }
        
        }
        $nombreporcategorias= $this->Categoria->find('list', array('fields'=>array('id','nombre')));

        $this->set('catname',$nombreporcategorias);
        $this->set('categorias',$this->Categoria->find('all',array('conditions'=>array('Categoria.parent_id'=>0),'order'=>array('Categoria.nombre'=>'ASC'))));
                
    }

}
?>