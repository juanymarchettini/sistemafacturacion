<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Pagos Controller
 *
 * @property Pago $Pago
 */
class PagosController extends AppController {

	public $helpers = array('Html', 'Form', 'Session', 'Js');
	var $uses = array('Pago','Categoria','Cuentabancaria' ,'User','Factura','Detalle','Proveedore','Tipopago','User','Pagospendiente','Proveedorpago');
	public $components = array('Paginator','RequestHandler');
	
	public function beforeFilter(){
        parent::beforeFilter();

        // PARA MAYORISTA O MINORISTA
        $this->Auth->allow(array('bienvenida','seccion','home','contactenos','mercadopagonotificaciones'));
        if($this->Session->read('Auth.User')){
        	if ($this->Auth->user('role') == 'admin'){
            	$this->Auth->allow();
            	$this->set('operadorid', $this->Auth->user('id'));  
            }

            if ($this->Auth->user('role') == 'transporte'){
            	$this->Auth->allow(array('ajaxbloquepago','ajaxverpagos','ajaxbusquedafiltros','deletecontrareembolso'));
            } 

            $this->Auth->allow(array('mercadopagook','mercadopagobad','statusdepositobancario'));
			     $this->set('listacuentas',$this->Cuentabancaria->find('list',array('fields'=>array('id','banco'))));
            $this->set('listatipodepagos',$this->Tipopago->find('list',array('fields'=>array('id','nombre'))));
            $this->set('listaproveedores',$this->Proveedore->find('list',array('fields'=>array('id','nombre'))));
            $this->set('listaoperadores', $this->User->find('list',array('fields'=>array('id','username'), 'conditions'=>array('User.role'=>array('transporte','admin')))));         
	      }
  }

/**
 * listadepagos method
 *
 * @return void
   Listar todos los pagos producidos por un usuario desde una fecha , hasta una fecha. O realizar un solo por fecha todos los clientes
 */ 
/**
 * listadepagos method
 *
 * @return void
   Listar todos los pagos producidos por un usuario desde una fecha , hasta una fecha. O realizar un solo por fecha todos los clientes
 */ 
	public function listadepagos($idusuario=0,$desde=null,$hasta=null) {
		$this->layout = 'backend';
		$this->Pago->recursive = 0;
    if ($this->request->is('post') || $this->request->is('put')) {
        //debug($this->request->data);
        if(!empty($this->request->data['Pago']['start'])){
          $desde=$this->request->data['Pago']['start'];
          $desde = date_create($desde);
          $desde = date_format($desde,'Y-m-d');
        }
        if(!empty($this->request->data['Pago']['end'])){
          $hasta=$this->request->data['Pago']['end'];
          $hasta = date_create($hasta);
          $hasta = date_format($hasta, 'Y-m-d');
        
        }
         
         $conditions=array('DATE(Pago.created) >='=>$desde, 'DATE(Pago.created) <='=> $hasta);

         $multiselect=$this->request->data['Pago']['tiposdepagos'];
         if (!empty($multiselect)){
          $conditions['tipopago_id']=$multiselect;
          unset($this->request->data['multiselect']);
         }

         $idusuario=$this->request->data['Pago']['user_id'];
         $conditions['Factura.user_id']=$idusuario;

         $this->Paginator->settings = array(
                'conditions' => $conditions,
                'fields'=>array('Pago.id','Pago.factura_id','Pago.monto','Pago.tipopago_id','nrocheque','created','status'),
                'recursive' =>  1,
                'limit' => 100,
                'order' => array('Pago.id'=>'ASC')
         );
         $this->request->data= $this->User->read(null,$idusuario);
        
    }else{
        $this->Paginator->settings = array(
          'conditions' => array('Factura.user_id'=>$idusuario),
          'fields'=>array('Pago.id','Pago.factura_id','Pago.monto','Pago.tipopago_id','nrocheque','created','status'),
          'recursive' =>  1,
          'limit' => 100,
          'order' => array('Pago.id'=>'ASC')
        );
        $this->request->data= $this->User->read(null,$idusuario);
    }

    

    $data = $this->Paginator->paginate('Pago');
		$this->set('pagos', $data);
		
	}

  public function vermispagos($idusuario=0,$desde=null,$hasta=null) {
    //$this->layout = 'backend';
    $idusuario=$this->Session->read('Auth.User.id');
    $this->User->id = $idusuario;
    if (!$this->User->exists()) {
      throw new NotFoundException(__('Categoría inválida'));
    }

    $this->Pago->recursive = 0;
    if ($this->request->is('post') || $this->request->is('put')) {
        //debug($this->request->data);
        if(!empty($this->request->data['Pago']['start'])){
          $desde=$this->request->data['Pago']['start'];
          $desde = date_create($desde);
          $desde = date_format($desde,'Y-m-d');
        }
        if(!empty($this->request->data['Pago']['end'])){
          $hasta=$this->request->data['Pago']['end'];
          $hasta = date_create($hasta);
          $hasta = date_format($hasta, 'Y-m-d');
        
        }
         
         $conditions=array('DATE(Pago.created) >='=>$desde, 'DATE(Pago.created) <='=> $hasta);

         

         $idusuario=$this->request->data['Pago']['user_id'];
         $conditions['Factura.user_id']=$idusuario;
         $conditions['Pago.tipopago_id !=']=6;

         $this->Paginator->settings = array(
                'conditions' => $conditions,
                'fields'=>array('Pago.id','Pago.factura_id','Pago.monto','Pago.tipopago_id','nrocheque','created','status'),
                'recursive' =>  1,
                'limit' => 100,
                'order' => array('Pago.id'=>'ASC')
         );
         $this->request->data= $this->User->read(null,$idusuario);
        
    }else{
        $this->Paginator->settings = array(
          'conditions' => array('Factura.user_id'=>$idusuario),
          'fields'=>array('Pago.id','Pago.factura_id','Pago.monto','Pago.tipopago_id','nrocheque','created','status'),
          'recursive' =>  1,
          'limit' => 100,
          'order' => array('Pago.id'=>'ASC')
        );
        $this->request->data= $this->User->read(null,$idusuario);
    }

    

    $data = $this->Paginator->paginate('Pago');
    $this->set('pagos', $data);
    $this->set('categorias',$this->Categoria->find('all',array('conditions'=>array('OR'=>array('Categoria.subcategoria_id'=>0, 'Categoria.subcategoria_id'=>null )),'order'=>array('Categoria.nombre'=>'ASC'))));
        
  }



/**
 * Facturapagos method
 *
 * @return void
   Agrega un pago a una factura / factura id == idfactura
 */ 
	public function pagar($id=null) {
		$this->loadModel('Cheque');
		$statuspago=array('Pendiente'=>'Pendiente','Pago Parcial'=>'Pago Parcial', 'Pagado'=>'Pagado');
		
		$this->layout = 'backend';
		$this->Factura->recursive=1;
		$this->Pago->recursive=0;
		if (empty($this->request->data['Pago']['factura_id'])){
			 $this->request->data['Pago']['factura_id'] = $id;
		}else{
			 $id = $this->request->data['Pago']['factura_id'];
		}

		if (!$this->Factura->exists($id)) {
			throw new NotFoundException(__('Categoría inválida'));
		}
		
		
		$totalfactura= $this->Detalle->find('all', array('fields' =>array('SUM(Detalle.precio * Detalle.cantidad) AS total'), 'conditions'=>array('Detalle.factura_id'=>$id)));
		$totalpagado =  $this->Pago->find('all', array('fields' =>array('SUM(Pago.monto) AS total'), 'conditions'=>array('Pago.factura_id'=>$id, 'Pago.status'=>1)));
		
		if(empty($totalpagado[0][0]['total'])){ $totalpagado=0;}else{$totalpagado= $totalpagado[0][0]['total']; }
		if(empty($totalfactura[0][0]['total'])){ $totalfactura=0;}else{ $totalfactura=$totalfactura[0][0]['total']; }

		//Actualizo el estado de la factura
		$pagoresult= $totalfactura - $totalpagado;
		$this->Factura->id = $id;
		if ($pagoresult==0){
			$this->Factura->saveField('statuspago', 'Pagado');
		}else{
			if (($totalpagado >0) && ($totalfactura>$totalpagado)){
				$this->Factura->saveField('statuspago', 'Pago Parcial');
			}else{
				$this->Factura->saveField('statuspago', 'Pendiente');
			}
		}

		if ($this->request->is('post')){
			
			$this->Pago->create();	
			if($this->request->data['Pago']['tipopago_id']==3){
				$this->request->data['Cheque'][0]['monto']=$this->request->data['Pago']['monto'];
			}else{
				if (isset($this->request->data['Cheque'])){
					unset($this->request->data['Cheque']);
				}
			}
			if ($this->Pago->saveAll($this->request->data)) {
				$this->Session->setFlash(__('El Pago se Cargo Correctamente'));
				
        $this->redirect(array('controller'=>'Pagos','action' => 'pagar/'.$id));
			} else {
				$this->Session->setFlash(__('El Pago no pudo ser salvada. Por favor, inténtelo nuevamente.'));
			}	
		}

        $factura = $this->Factura->read(null, $id);
        
        $pagos = $this->Pago->find('all',array('conditions'=>array('Pago.factura_id'=>$id),'recursive'=>1));
      	
        $restofactura = (float)$totalfactura - (float) $totalpagado; 

      	$this->set('restofactura', $restofactura);
      	$this->set('totalfactura',$totalfactura);
      	$this->set('totalpagado',$totalpagado);
        
        $this->set('factura',$factura);
		    $this->set('pagos', $pagos);

	}



/**
 * delete method
 *
 * @throws NotFoundException
 * @param entero $id de la factura
 * @return void 
 */
	public function delete($id = null,$escheque=false) {
		$this->layout = 'backend';
		$this->Pago->id = $id;
		if (!$this->Pago->exists()) {
			throw new NotFoundException(__('Categoría inválida'));
		}
		$this->Pago->saveField('status', '0');
		$this->Pago->saveField('operador_id', $this->Session->read('Auth.User.id'));
		$data = $this->Pago->read(null, $id);

		if ($data['Pago']['tipopago_id']==3){
		  $this->loadModel('Cheque');
		  $datoscheque=$this->Cheque->find('first',array('conditions'=>array('Cheque.pago_id'=>$id)));
		  if (!empty($datoscheque)){
			$this->Cheque->id = $datoscheque['Cheque']['id'];
			if ($this->Cheque->delete()) {
				$this->Session->setFlash(__('El Pago y el Cheque se han cancelado'));
			}
		  }
		  
		}else{
		  $this->Session->setFlash(__('El Pago se han cancelado'));
		}
		$this->redirect(array('action' => 'pagar/'.$this->Pago->field('factura_id')));
		
	}
	public function deletecontrareembolso($id = null) {
		$this->layout = 'backend';
		$this->Pagospendiente->id = $id;

		if (!$this->Pagospendiente->exists()) {
			throw new NotFoundException(__('Categoría inválida'));
		}
		$this->Pagospendiente->saveField('status', '0');
		$this->Pagospendiente->saveField('operador_id', $this->Session->read('Auth.User.id'));
		$this->Session->setFlash(__('El Pago Pendiente se Cancelo Correctamente.'));
		$this->redirect(array('controller'=>'Transportes','action' => 'contrareembolsos/'.$this->Pagospendiente->field('transporte_id')));
		
	}

	/** TODO LO QUE REFIERA A LA CAJA  **/

    public function caja($desde=null,$hasta=null, $multiselect=array(),$inputclientefact=null,$pagoaceptado=null,$pagocancelado=null, $pagos=true){
    	$this->layout = 'backend';
    	$this->set('label','Movimientos de Caja');
    	if (empty($desde)){
             $desde=date("Y-m-d");
             $this->set('label','Caja del Día');
        }

        if (empty($hasta)){
            $hasta=date("Y-m-d");
        }

    	if ($this->request->is('post') || $this->request->is('put')) {
    		//debug($this->request->data);
    		if(!empty($this->request->data['Pago']['start'])){
    			$desde=$this->request->data['Pago']['start'];
    			$desde = date_create($desde);
    			$desde = date_format($desde,'Y-m-d');
    		}
    		if(!empty($this->request->data['Pago']['end'])){
    			$hasta=$this->request->data['Pago']['end'];
    			$hasta = date_create($hasta);
    			$hasta = date_format($hasta, 'Y-m-d');
        
    		}
    	   
    	   $conditions=array('DATE(Pago.created) >='=>$desde, 'DATE(Pago.created) <='=> $hasta);

    	   

	       $multiselect=$this->request->data['Pago']['tiposdepagos'];
	       if (!empty($multiselect)){
	       	$conditions['tipopago_id']=$multiselect;
	       	unset($this->request->data['multiselect']);
	       }

	       $inputclientefact=$this->request->data['Pago']['inputclientefact'];
	      	
	       if (!empty($inputclientefact)){

	       	$conditions['OR']['Factura.nombre LIKE']='%'.$inputclientefact.'%';
	        $conditions['OR']['Factura.apellido LIKE']='%'.$inputclientefact.'%';
	       	$conditions['OR']['Factura.email LIKE']='%'.$inputclientefact.'%';
	       	$conditions['OR']['Factura.id LIKE']='%'.$inputclientefact.'%';
          
	       }
  
  

	       if (isset($this->request->data['Pago']['pago-aceptado']) && !isset($this->request->data['Pago']['pago-cancelado'])){
	       		$conditions['Pago.status']=1;
	       }

	       if (!isset($this->request->data['Pago']['pago-aceptado']) && (isset($this->request->data['Pago']['pago-cancelado'])) ){
	       		$conditions['Pago.status']=0;
	       }

    		/*
	        $this->Paginator->settings = array(
                'fields' => array('Pago.*','Factura.id','Factura.nombre','Factura.localidad','Factura.apellido','Factura.email','Factura.tipodepago'),
                'conditions'=>$conditions,
                'limit' => 5000,
                'order' => array('Pago.id'=>'ASC')

	        );
	        */
	        $resultadoingresos = $this->Pago->find('all',array('fields' => array('Pago.*','Factura.id','Factura.nombre','Factura.localidad','Factura.apellido','Factura.email','Factura.tipodepago'),'conditions'=>$conditions, 'order' => array('Pago.id'=>'ASC')));
	        
	        $this->request->data=$this->request->data;
    	}else{
    		 /*
    		 $this->Paginator->settings = array(
	                    'fields' => array('Pago.*','Factura.id','Factura.nombre','Factura.localidad','Factura.apellido','Factura.email','Factura.tipodepago'),  
	                    'conditions'=>array('DATE(Pago.created) >='=>$desde, 'DATE(Pago.created) <='=> $hasta),      
	                    'limit' => 5000,
	                    'order' => array('Pago.id'=>'ASC')
	        );
			*/
    		$resultadoingresos = $this->Pago->find('all',array('fields' => array('Pago.*','Factura.id','Factura.nombre','Factura.localidad','Factura.apellido','Factura.email','Factura.tipodepago'), 'conditions'=>array('DATE(Pago.created) >='=>$desde, 'DATE(Pago.created) <='=> $hasta), 'order' => array('Pago.id'=>'ASC')));
    	}
        

        
        $movimientosegresos=$this->Proveedorpago->find('all',array('conditions'=>array('DATE(Proveedorpago.created) >='=>$desde, 'DATE(Proveedorpago.created) <='=> $hasta),'order' => array('Proveedorpago.id'=>'ASC')));
        //$movimientos = $this->Paginator->paginate('Pago');
        $movimientos = $resultadoingresos;
        $this->set('movimientosegresos', $movimientosegresos);
        $this->set('movimientos', $movimientos);
       
    }
    public function ajaxverpagos($idfactura=null){
    	$this->layout='ajax';
    	$pagos = $this->Pagospendiente->find('all',array('conditions'=>array('Pagospendiente.factura_id'=>$idfactura),'order'=>array('Pagospendiente.id'=>'DESC')));
    	$this->set('pagos',$pagos);
    }


    // SE agrega un pago pendiente de aprobación
    // SE agrega un pago pendiente de aprobación
    public function ajaxbloquepago($idfactura=null, $flagsubmit=true){
    	$this->layout=false;
    	
    	if (empty($idfactura)){
    		$idfactura = $this->request->data['Pagospendiente']['factura_id'];
    	}
    	$this->set('idfactura',$idfactura);
    	// operador seria el transporte-id
    	
    	$this->Factura->id=$idfactura;

    	if ($flagsubmit){
	    	if ($this->request->is('ajax')) {
				
				$this->Pagospendiente->create();	
				if ($this->Pagospendiente->save($this->request->data)) {
					$this->render('ajaxmensajepagotransporteok');
				} else {
						$this->render('ajaxmensajepagotransportebad');
				}

			}
		}
		$transporteid= $this->Factura->field('transporte_id');
		$this->set('listatipodepagos',$this->Tipopago->find('list',array('fields'=>array('id','nombre'),'conditions'=>array('Tipopago.id'=>array(3,4)))));
		$this->set('operadorid', $this->Auth->user('id'));
		$this->set('transporteid', $transporteid);
		$this->Factura->recursive=-1;
		$this->set('infofactura',$this->Factura->read(null, $idfactura));
	 
    }
    public function ajaxbusquedafiltros($desde=null,$hasta=null){
    	$this->layout = 'backend';
    	$this->set('label','Movimientos de Caja');
    	//debug_backtrace()($_POST);
        if (empty($desde)){
            $desde=date("Y-m-d");
            $this->set('label','Caja del Día');
        }

        if (empty($hasta)){
            $hasta=date("Y-m-d");
        }

        $this->Paginator->settings = array(
                    'fields' => array('Pago.*','Factura.id','Factura.nombre','Factura.apellido','Factura.email','Factura.tipodepago'),
                    'conditions'=>array('DATE(Pago.created) BETWEEN "'.$desde.'" AND "'.$hasta.'"'),
                    'limit' => 70,
                    'order' => array('Pago.id'=>'ASC')
        );
        
        $movimientos = $this->Paginator->paginate('Pago');
       
        $this->set('movimientos', $movimientos);
        
    }

	public function totalcaja($desde=null,$hasta=null,$multiselect=array('1','4'),$pagoaceptado=true){
    	
    	$this->layout = 'backend';
    	$this->set('label','Movimientos');
    	
        $desde=date_create('2017-12-18');
        $desde= date_format($desde,'Y-m-d');
        // $desde=date("Y-m-d");
        $hasta=date("Y-m-d");
        $conditions=array('DATE(Pago.created) >='=>$desde, 'DATE(Pago.created) <='=> $hasta);
        $conditions['Pago.status']=1;

    	
       if (isset($this->request->data['Pago']['tiposdepagos'])){
       	 $multiselect=$this->request->data['Pago']['tiposdepagos'];
       }

       if (!empty($multiselect)){
       	$conditions['tipopago_id']=$multiselect;
       	unset($this->request->data['multiselect']);
       	$labelseccion= 'Caja : ';
       	if (in_array('1',$multiselect)){
       		$labelseccion=$labelseccion.' Efectivo';
       	}
       	if (in_array('2',$multiselect)){
       		$labelseccion=$labelseccion.' ,Deposito/Transferencia';
       	}

       	if (in_array('3',$multiselect)){
       		$labelseccion=$labelseccion.' ,Cheque';
       	}

       	if (in_array('4',$multiselect)){
       		$labelseccion=$labelseccion.' ,Contrareembolsos';
       	}

       	if (in_array('5',$multiselect)){
       		$labelseccion=$labelseccion.' ,Mercadopago';
       	}

       	if (in_array('6',$multiselect)){
       		$labelseccion=$labelseccion.' ,Ajuste';
       	}

       	$this->set('label',$labelseccion);
       }

       $resultadoingresos = array();
        
      

       $movimientosingresos=$this->Pago->find('all',array('fields'=>array("(EXTRACT(YEAR_MONTH FROM Pago.created)) AS aniomes",'SUM(Pago.monto) AS total'),'conditions'=>$conditions ,'group'=>"(EXTRACT(YEAR_MONTH FROM Pago.created))",'recursive'=>0));  
       
        
       //debug($movimientosingresos);
       
        $conditionsegresos=array('DATE(Proveedorpago.created) >='=>$desde, 'DATE(Proveedorpago.created) <='=> $hasta);
        $conditionsegresos['Proveedorpago.status']=1;

        if (!empty($multiselect)){
       	 $conditionsegresos['tipopago_id']=$multiselect;
        }


       $movimientosegresos=$this->Proveedorpago->find('all',array('fields'=>array("(EXTRACT(YEAR_MONTH FROM Proveedorpago.created)) AS aniomes",'SUM(Proveedorpago.monto) AS total'), 'conditions'=>$conditionsegresos,'order' => array('Proveedorpago.id'=>'ASC'),'group'=>"(EXTRACT(YEAR_MONTH FROM Proveedorpago.created))"));
        //debug($movimientosegresos);
        //$movimientos = $this->Paginator->paginate('Pago');
        
        $this->set('movimientosegresos', $movimientosegresos);
        $this->set('movimientosingresos', $movimientosingresos);

       
        $listameses[]='2017';
        $montoingreso[] = 0;
       foreach ($movimientosingresos as $key => $ingreso) {
       	 
       	 $listameses[]=$ingreso[0]['aniomes'];

       	 $montoingreso[]=$ingreso[0]['total'];
       }
        $chartingreso['name']="Ingresos";
        $chartingreso['data']=$montoingreso;
        //$jsoningreso = json_encode($chartingreso);
        
        $montoegreso[]=0;
        foreach ($movimientosegresos as $key => $egreso) {
       	 
       	 

       	 $montoegreso[]=$egreso[0]['total'];
        }
        $chartegreso['name']="Egresos";
        $chartegreso['data']=$montoegreso;

        $this->set('jsoningreso',$chartingreso);
        $this->set('jsonegreso',$chartegreso);
        $this->set('listameses',$listameses);
       
  }


/**
 * Seccion de Mercado Pago
 *
 * @throws NotFoundException
 * @param entero $id de la transaccion
 * @return void 
 */

  public function mercadopagook($id=null,$formmercadopago=false){
    $statuspago=array('Pendiente'=>'Pendiente','Pago Parcial'=>'Pago Parcial', 'Pagado'=>'Pagado');
    $this->set('categorias',$this->Categoria->find('all',array('conditions'=>array('OR'=>array('Categoria.subcategoria_id'=>0, 'Categoria.subcategoria_id'=>null )),'order'=>array('Categoria.nombre'=>'ASC'))));
        
    

    $this->Factura->recursive=1;
    $this->Pago->recursive=0;
    $this->Factura->id = $id;
    $data=$this->Factura->find('first',array('conditions'=>array('Factura.id'=>$id)));

    if (!$this->Factura->exists($id)) {
      throw new NotFoundException(__('Categoría inválida'));
    }

    if (!$formmercadopago) {
      throw new NotFoundException(__('Ingreso No seguro! Pago no Aprobado'));
    }

    $totalfactura= $this->Detalle->find('all', array('fields' =>array('SUM(Detalle.precio * Detalle.cantidad) AS total'), 'conditions'=>array('Detalle.factura_id'=>$id)));
    $totalpagado =  $this->Pago->find('all', array('fields' =>array('SUM(Pago.monto) AS total'), 'conditions'=>array('Pago.factura_id'=>$id, 'Pago.status'=>1)));
    
    if(empty($totalpagado[0][0]['total'])){ $totalpagado=0;}else{$totalpagado= $totalpagado[0][0]['total']; }
    if(empty($totalfactura[0][0]['total'])){ $totalfactura=0;}else{ $totalfactura=$totalfactura[0][0]['total']; }

    $pagoresult= $totalfactura - $totalpagado;
   
    if (($data['Factura']['statuspago'] != 'Pagado') && ($pagoresult  > 0)){
        
        if ($formmercadopago == true && ($pagoresult >0)){
          
          $datapagos['Pago']['factura_id'] =$id;
          $datapagos['Pago']['monto'] =$totalfactura;
          $datapagos['Pago']['tipopago_id'] =5;
          $datapagos['Pago']['operador_id'] =$this->Auth->user('id');
          $this->Pago->create();  
          if ($this->Pago->save($datapagos['Pago'])) {
            //$this->redirect(array('controller'=>'Pagos','action' => 'mercadopagook',$id,false));
          } 
        
        }

        //Actualizo el estado de la factura
        $totalpagado =  $this->Pago->find('all', array('fields' =>array('SUM(Pago.monto) AS total'), 'conditions'=>array('Pago.factura_id'=>$id, 'Pago.status'=>1)));
        if(empty($totalpagado[0][0]['total'])){ $totalpagado=0;}else{$totalpagado= $totalpagado[0][0]['total']; }
        

        $pagoresult= $totalfactura - $totalpagado;

        if ($pagoresult==0){
          $this->Factura->saveField('statuspago', 'Pagado');
        }else{
          if (($totalpagado >0) && ($totalfactura>$totalpagado)){
            $this->Factura->saveField('statuspago', 'Pago Parcial');
          }else{
            $this->Factura->saveField('statuspago', 'Pendiente');
          }
        }
    }


    }
	
     // EL ID REPRESENTA EL NRO DE PEDIDO
	private function registarpagoajax($id=null){
		$statuspago=array('Pendiente'=>'Pendiente','Pago Parcial'=>'Pago Parcial', 'Pagado'=>'Pagado');
		
		$this->Factura->recursive=1;
		$this->Pago->recursive=0;
		$this->Factura->id = $id;
		$data=$this->Factura->find('first',array('conditions'=>array('Factura.id'=>$id)));

		if (!$this->Factura->exists($id)) {
		  throw new NotFoundException(__('Categoría inválida'));
		}

		$totalfactura= $this->Detalle->find('all', array('fields' =>array('SUM(Detalle.precio * Detalle.cantidad) AS total'), 'conditions'=>array('Detalle.factura_id'=>$id)));
		$totalpagado =  $this->Pago->find('all', array('fields' =>array('SUM(Pago.monto) AS total'), 'conditions'=>array('Pago.factura_id'=>$id, 'Pago.status'=>1)));
		
		if(empty($totalpagado[0][0]['total'])){ $totalpagado=0;}else{$totalpagado= $totalpagado[0][0]['total']; }
		if(empty($totalfactura[0][0]['total'])){ $totalfactura=0;}else{ $totalfactura=$totalfactura[0][0]['total']; }

		$pagoresult= $totalfactura - $totalpagado;
	   
		if (($data['Factura']['statuspago'] != 'Pagado') && ($pagoresult  > 0)){
			
			if ($pagoresult >0){
			  
			  $datapagos['Pago']['factura_id'] =$id;
			  $datapagos['Pago']['monto'] =$totalfactura;
			  $datapagos['Pago']['tipopago_id'] =5;
			  $datapagos['Pago']['operador_id'] =$this->Auth->user('id');
			  $this->Pago->create();  
			  if ($this->Pago->save($datapagos['Pago'])) {
			  } 
			
			}

			//Actualizo el estado de la factura
			$totalpagado =  $this->Pago->find('all', array('fields' =>array('SUM(Pago.monto) AS total'), 'conditions'=>array('Pago.factura_id'=>$id, 'Pago.status'=>1)));
			if(empty($totalpagado[0][0]['total'])){ $totalpagado=0;}else{$totalpagado= $totalpagado[0][0]['total']; }
			

			$pagoresult= $totalfactura - $totalpagado;

			if ($pagoresult==0){
			  $this->Factura->saveField('statuspago', 'Pagado');
			}else{
			  if (($totalpagado >0) && ($totalfactura>$totalpagado)){
				$this->Factura->saveField('statuspago', 'Pago Parcial');
			  }else{
				$this->Factura->saveField('statuspago', 'Pendiente');
			  }
			}
		}


	}


	public function mercadopagoverificaciones($idpedido=null){
		if ($this->request->is('ajax')) {
		  $this->layout=false;
		  App::import('Vendor', 'mercadopago', array('file' =>'mercadopago/mercadopago.php'));
		  $mp = new MP('7681445286907972', 'n2GO0PVbHFlqOwtay3BLiU1RgFLVIyKY');
		  $this->Factura->id = $idpedido;
		  if (!$this->Factura->exists()) {
				throw new NotFoundException(__('Nro Factura Invalido'));
		  }
		  // Sets the filters you want
		  $filters = array(
			  "operation_type" => "regular_payment",
			  'external_reference' => $idpedido
		  );

		  // Search payment data according to filters
		  $searchResult = $mp->search_payment($filters,0,100);
		  $pagoaprobado=false;
		  $pagolabel = null;
		
		  if (!empty($searchResult['response']['results'])){
			 foreach ($searchResult['response']['results'] as $key => $collection) {
				 if ($collection['collection']['status'] == 'approved'){
					$pagoaprobado=true;
					break;
				 }else{
					$pagolabel= $collection['collection']['status'];
				 }
			 }
			 if ($pagoaprobado){
			   $this->registarpagoajax($idpedido);
			   echo 'Pagado! Se Actualizó el Pago.';
			 }else{
			   echo 'Atención Pago: '.$pagolabel;
			 }
			
		  }else{
			 echo 'No se Registro Pago.' ;
			 
			 
		  }
		}
	}	

  public function statusdepositobancario($id=null,$status=null){


        $this->layout=false;
        $this->Pago->recursive=1;
        
        $this->Pago->id = $id;
        if (!$this->Pago->exists()) {
            throw new NotFoundException(__('Pago Invalido'));
        }

        $this->Pago->saveField('statusdeposito', $status);
        $this->Session->setFlash(__('Su Pago Fue Actualizado'));
        return $this->redirect($this->referer());
        
   
  }


	
}