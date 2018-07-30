<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Pagos Controller
 *
 * @property Pago $Pago
 */
class ProveedorpagosController extends AppController {

	public $helpers = array('Html', 'Form', 'Session', 'Js');
	var $uses = array('Proveedorpago','Proveedorfactura','Proveedordetalle','Tipopago','User','Pagospendiente');
	public $components = array('Paginator','RequestHandler');
	
	public function beforeFilter(){
        parent::beforeFilter();

        // PARA MAYORISTA O MINORISTA
        $this->Auth->allow(array('bienvenida','seccion','home','contactenos'));
        if($this->Session->read('Auth.User')){
        	if ($this->Auth->user('role') == 'admin'){
            	$this->Auth->allow();
            	$this->set('operadorid', $this->Auth->user('id'));  
            	$this->set('listatipodepagos',$this->Tipopago->find('list',array('fields'=>array('id','nombre'))));
            	$this->set('listaoperadores', $this->User->find('list',array('fields'=>array('id','username'), 'conditions'=>array('User.role'=>'admin'))));
            }
	    }
    }



/**
 * listadepagos method
 *
 * @return void
   Listar todos los pagos producidos por un usuario desde una fecha , hasta una fecha. O realizar un solo por fecha todos los clientes
 */ 
	public function listadepagos($idusuario=0,$desde=null,$hasta=null) {
		$this->layout = 'backend';
		$this->Proveedorpago->recursive = 0;
		$this->Paginator->settings = array(          
                    'limit' => 100,
                    'order' => array('Proveedorpago.id'=>'DESC')
        );
		$this->set('pagos', $this->paginate('Proveedorpago'));

	}

/**
 * Facturapagos method
 *
 * @return void
   Agrega un pago a una factura / factura id == idfactura
 */ 
	public function pagar($id=null) {
		$statuspago=array('Pendiente'=>'Pendiente','Pago Parcial'=>'Pago Parcial', 'Pagado'=>'Pagado');
		
		$this->layout = 'backend';
		$this->Proveedorfactura->recursive=1;
		$this->Proveedorpago->recursive=0;
		if (empty($this->request->data['Proveedorpago']['proveedorfactura_id'])){
			 $this->request->data['Proveedorpago']['proveedorfactura_id'] = $id;
		}else{
			 $id = $this->request->data['Proveedorpago']['proveedorfactura_id'];
		}
		if (!$this->request->is('post')){
			if (!$this->Proveedorfactura->exists($id)) {
				throw new NotFoundException(__('Factura inválida'));
			}
		}
		
		
		$totalfactura= $this->Proveedordetalle->find('all', array('fields' =>array('SUM(Proveedordetalle.precio * Proveedordetalle.cantidad) AS total'), 'conditions'=>array('Proveedordetalle.proveedorfactura_id'=>$id)));
		$totalpagado =  $this->Proveedorpago->find('all', array('fields' =>array('SUM(Proveedorpago.monto) AS total'), 'conditions'=>array('Proveedorpago.proveedorfactura_id'=>$id, 'Proveedorpago.status'=>1)));
		
		if(empty($totalpagado[0][0]['total'])){ $totalpagado=0;}else{$totalpagado= $totalpagado[0][0]['total']; }
		if(empty($totalfactura[0][0]['total'])){ $totalfactura=0;}else{ $totalfactura=$totalfactura[0][0]['total']; }

		//Actualizo el estado de la factura
		$pagoresult= $totalfactura - $totalpagado;
		$this->Proveedorfactura->id = $id;
		if ($pagoresult==0){
			$this->Proveedorfactura->saveField('statuspago', 'Pagado');
		}else{
			if (($totalpagado >0) && ($totalfactura>$totalpagado)){
				$this->Proveedorfactura->saveField('statuspago', 'Pago Parcial');
			}else{
				$this->Proveedorfactura->saveField('statuspago', 'Pendiente');
			}
		}

		if ($this->request->is('post')){
			
			$this->Proveedorpago->create();	
			if ($this->Proveedorpago->save($this->request->data)) {
				$this->Session->setFlash(__('El Pago se Cargo Correctamente'),'backend/flash/goodflash');
				$this->redirect(array('controller'=>'Proveedorpagos','action' => 'pagar/'.$id));
			} else {
				$this->Session->setFlash(__('El Pago no pudo ser salvada. Por favor, inténtelo nuevamente.'));
			}	
		}

        $factura = $this->Proveedorfactura->read(null, $id);
        
        $pagos = $this->Proveedorpago->find('all',array('conditions'=>array('Proveedorpago.proveedorfactura_id'=>$id)));
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
	public function delete($id = null) {
		$this->layout = 'backend';
		$this->Proveedorpago->id = $id;

		if (!$this->Proveedorpago->exists()) {
			throw new NotFoundException(__('Pago inválida'));
		}
		$this->Proveedorpago->saveField('status', '0');
		$this->Proveedorpago->saveField('operador_id', $this->Session->read('Auth.User.id'));
		$this->redirect(array('action' => 'pagar/'.$this->Proveedorpago->field('proveedorfactura_id')));
		
	}

	/** TODO LO QUE REFIERA A LA CAJA  **/

    public function caja($desde=null,$hasta=null, $muliseletc=array(),$inputclientefact=null,$pagoaceptado=null,$pagocancelado=null){
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

    		if(!empty($this->request->data['start'])){
    			$desde=$this->request->data['start'];
    		}
    		if(!empty($this->request->data['end'])){
    			$hasta=$this->request->data['end'];
        
    		}
    		$conditions=array('DATE(Pago.created) BETWEEN "'.$desde.'" AND "'.$hasta.'"' );
	        

	        $this->Paginator->settings = array(
	                    'fields' => array('Pago.*','Factura.id','Factura.nombre','Factura.apellido','Factura.email','Factura.tipodepago'),
	                    'conditions'=>$conditions,
	                    'limit' => 200,
	                    'order' => array('Pago.id'=>'ASC')
	        );
    	}else{
    		 $this->Paginator->settings = array(
	                    'fields' => array('Pago.*','Factura.id','Factura.nombre','Factura.apellido','Factura.email','Factura.tipodepago'),        
	                    'limit' => 150,
	                    'order' => array('Pago.id'=>'ASC')
	        );
    	}
        

        
        
        $movimientos = $this->Paginator->paginate('Pago');
        
        $this->set('movimientos', $movimientos);
        
    }
}