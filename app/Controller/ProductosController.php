<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class ProductosController extends AppController {
	
	public $helpers = array('Html', 'Form', 'Session', 'Js');
	var $uses = array('Producto','Categoria', 'Fotosproducto', 'User','Factura','Detalle');
	public $components = array('Paginator','RequestHandler');
	
	public function beforeFilter() {
        parent::beforeFilter();
        $this->set('categorias',$this->Categoria->find('list'));
        
        $this->Auth->allow(array('contacto','view','ajaxsearchproducto','listjson','listjsonfacturas','jsonproductodata','modal_listaproductos'));
        if($this->Session->read('Auth.User')){
        	if ($this->Auth->user('role') == 'admin'){
	     			$this->Auth->allow(); // Letting users register themselves
	    	}
	    }
		
    }

/// INICIO CRUD
	public function lista($busqueda=null) {
		$this->layout = 'backend';
		
		$this->Paginator->settings = array(
                'recursive' =>  0,
                'fields'=>array('Producto.id','Producto.nombre','Producto.iva','Producto.precio','Producto.preciocompra','Producto.preciobruto','Producto.codigo','Producto.stock','Producto.categoria_id','Producto.disponible','Categoria.*'),
                'limit' => 200,
                'order'=>array('Categoria.parent_id'=>'DESC','Producto.categoria_id'=>'ASC','Producto.nombre'=>'ASC','Producto.disponible'=>'ASC')
        );
        if (isset($_GET['busqueda'])){
                    $busqueda=$_GET['busqueda'];
        }
       
        if (!empty($busqueda)){
        	$cadena= explode(" ", $busqueda);
            $conditions=array();

            foreach ($cadena as $key => $options) {
            	
            	$conditions[]=array('Producto.nombre LIKE '=>'%'.$options.'%')	;
            	$conditions[]=array('Producto.codigo LIKE '=>'%'.$options.'%')	;

            }
        	$this->Paginator->settings['conditions']=array('OR'=>$conditions);
        }

        $listacategorias = $this->Categoria->find('list',array('fields'=>array('id','nombre'),array('conditions'=>array('Categoria.parent_id'=>0))));
        
		$data = $this->Paginator->paginate('Producto');
		$this->set('listacategorias', $listacategorias);
		$this->set('productos', $data);
	}

	

	public function view($id=null) {
		$this->Producto->recursive = 2;
		$this->Producto->id = $id;
		if (!$this->Producto->exists($id)) {
			throw new NotFoundException(__('Producto inválido.'));
		}
		$producto = $this->Producto->read(null, $id);
		$this->set('title_for_layout', 'Producto -'.$producto['Producto']['nombre']);
		$this->set('producto',$this->Producto->read(null, $id));
		$this->set('categorias',$this->Categoria->find('all',array('conditions'=>array('Categoria.parent_id'=>0),'order'=>array('Categoria.nombre'=>'ASC'))));
	}

	public function add() {
		
		$this->layout = 'backend';
		if ($this->request->is('post')) {
			$this->Producto->create();
			$this->Producto->Behaviors->attach('MeioUpload', array(
			        'imagen1' => array(
				            'dir' => 'img{DS}productos',
				            'create_directory' => true,
				            'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png','image/jpg' ,'image/JPEG', 'image/PJEGP', 'image/PNG', 'image/JPG'),
				            'default' => 'default.jpg',
				        ),
			        'imagen2' => array(
				            'dir' => 'img{DS}productos',
				            'create_directory' => true,
				           'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png','image/jpg' ,'image/JPEG', 'image/PJEGP', 'image/PNG', 'image/JPG'),
				            'default' => 'default.jpg',
				        ),
			        'imagen3' => array(
				            'dir' => 'img{DS}productos',
				            'create_directory' => true,
				           'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png','image/jpg' ,'image/JPEG', 'image/PJEGP', 'image/PNG', 'image/JPG'),
				            'default' => 'default.jpg',
				        ),
			        'imagen4' => array(
				            'dir' => 'img{DS}productos',
				            'create_directory' => true,
				            'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png','image/jpg' ,'image/JPEG', 'image/PJEGP', 'image/PNG', 'image/JPG'),
				            'default' => 'default.jpg',
				        ),
		        ));
			$flagmismocodigo=$this->Producto->find('first',array('conditions'=>array('OR'=>array('Producto.codigo'=>$this->request->data['Producto']['codigo'], 'Producto.nombre'=>$this->request->data['Producto']['nombre']))));
			if (empty($flagmismocodigo)){
				if ($this->Producto->saveAll($this->request->data)) {
					$this->Session->setFlash(__('El producto ha sido salvado'), 'backend/flash/goodflash');
					$this->redirect(array('action' => 'lista'));
				} else {
					$this->Session->setFlash(__('El producto no pudo ser salvada. Por favor intentelo nuevamente'), 'backend/flash/badflash');
				}
			}else{
				$this->Session->setFlash(__('Ya existe un Producto con el mismo Código o nombre'), 'backend/flash/badflash');
				
			}
		}
		$this->loadModel('Categoria');
		$this->set('ventas',array());
		$this->set('categorias',$this->Categoria->find('list',array('fields'=>array('id','nombre'), 'order'=>array('Categoria.nombre'=>'ASC'))));
	}

	public function edit($id = null) {
		
		$this->layout = 'backend';
		if (!$this->Producto->exists($id)) {
			throw new NotFoundException(__('Producto inválido.'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->Producto->Behaviors->attach('MeioUpload', array(
			        'imagen1' => array(
				            'dir' => 'img{DS}productos',
				            'create_directory' => true,
				           'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png','image/jpg' ,'image/JPEG', 'image/PJEGP', 'image/PNG', 'image/JPG'),
				            'default' => 'default.jpg',
				        ),
			        'imagen2' => array(
				            'dir' => 'img{DS}productos',
				            'create_directory' => true,
				            'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png','image/jpg' ,'image/JPEG', 'image/PJEGP', 'image/PNG', 'image/JPG'),
				            'default' => 'default.jpg',
				        ),
			        'imagen3' => array(
				            'dir' => 'img{DS}productos',
				            'create_directory' => true,
				            'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png','image/jpg' ,'image/JPEG', 'image/PJEGP', 'image/PNG', 'image/JPG'),
				            'default' => 'default.jpg',
				        ),
			        'imagen4' => array(
				            'dir' => 'img{DS}productos',
				            'create_directory' => true,
				            'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png','image/jpg' ,'image/JPEG', 'image/PJEGP', 'image/PNG', 'image/JPG'),
				            'default' => 'default.jpg',
				        ),
		        ));
			if ($this->Producto->saveAll($this->request->data)) {
				$this->Session->setFlash(__('El Producto ha sido salvado'));
				$this->redirect(array('action' => 'lista'));
			} else {
				$this->Session->setFlash(__('El Producto no pudo ser salvado, por favor intentelo nuevamente'));
			}
		} else {
			$this->Detalle->recursive=0;
			$detallesventa = $this->Detalle->find('all',array('fields'=>array('Detalle.*','Factura.id','Factura.nombre','Factura.apellido','Factura.created'),'conditions'=>array('Detalle.producto_id'=>$id),'order'=>array('Detalle.id'=>'DESC')));
			
			$options = array('conditions' => array('Producto.' . $this->Producto->primaryKey => $id));
			$this->request->data = $this->Producto->find('first', $options);
		}
		$this->loadModel('Categoria');
		$this->set('ventas',$detallesventa);
		$this->set('categorias',$this->Categoria->find('list',array('fields'=>array('id','nombre'))));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		
		$this->layout = 'backend';
		$this->Producto->id = $id;
		if (!$this->Producto->exists()) {
			$this->Producto->Behaviors->attach('MeioUpload', array(
			        'imagen1' => array(
				            'dir' => 'img{DS}productos',
				            'create_directory' => true,
				            'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png'),
				            'default' => 'default.jpg',
				        ),
			        'imagen2' => array(
				            'dir' => 'img{DS}productos',
				            'create_directory' => true,
				            'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png'),
				            'default' => 'default.jpg',
				        ),
			        'imagen3' => array(
				            'dir' => 'img{DS}productos',
				            'create_directory' => true,
				            'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png'),
				            'default' => 'default.jpg',
				        ),
			        'imagen4' => array(
				            'dir' => 'img{DS}productos',
				            'create_directory' => true,
				            'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png'),
				            'default' => 'default.jpg',
				        ),
		        ));
			throw new NotFoundException(__('Producto inválido.'));
		}
		
		if ($this->Producto->delete()) {
			$this->Session->setFlash(__('Producto eliminado'));
			$this->redirect(array('action' => 'lista'));
		}
		$this->Session->setFlash(__('El Producto no pudo ser eliminado'));
		$this->redirect(array('action' => 'lista'));
	}


//FIN CRUD

	public function ajaxsearchproducto(){

        $this->layout='ajax';
        $busqueda=$_POST['busqueda'];
		$this->Producto->recursive = 0;
		$this->Paginator->settings = array(
                'recursive' =>  0,
                 'fields'=>array('Producto.id','Producto.nombre','Producto.iva','Producto.precio','Producto.preciocompra','Producto.preciobruto','Producto.codigo','Producto.stock','Producto.categoria_id','Producto.disponible'),
                'conditions'=>array('OR'=>array('Producto.nombre LIKE '=>'%'.$busqueda.'%', 'Producto.codigo LIKE '=>'%'.$busqueda.'%')),
                'limit' => 400,
                'order'=>array('Categoria.subcategoria_id'=>'ASC','Producto.categoria_id'=>'ASC','Producto.nombre'=>'ASC','Producto.disponible'=>'ASC')
        );
        
        $listacategorias = $this->Categoria->find('list',array('fields'=>array('id','nombre'),array('conditions'=>array('Categoria.subcategoria_id'=>0))));
        
		$data = $this->Paginator->paginate('Producto');
		
		$titulo="Productos";
        $this->set('titulo',$titulo);
		$this->set('listacategorias', $listacategorias);
		$this->set('productos', $data);

   }


    public function listjson(){
      $this->layout= false;
      $this->Producto->recursive=-1;
      //$resultadofinal=array('id'=>0,'nombre'=>null, 'codigo'=>0, 'preciocompra'=>0, 'codigonombre'=>0);
      $resultado= $this->Producto->find('all',array('fields'=>array('Producto.id','Producto.codigonombre','Producto.nombre','Producto.codigo','Producto.categoria_id','Producto.preciocompra'), 'order'=>array('Producto.categoria_id'=>'ASC')));

      //debug($resultado);
      $resultadofinal=null;

      foreach ($resultado as $key => $value) {
            $resultadofinal[]=$value['Producto'];    
      }
      
      echo json_encode($resultadofinal);


    }

    public function listjsonfacturas(){
      $this->layout= false;
      $this->Producto->recursive=-1;
      //$resultadofinal=array('id'=>0,'nombre'=>null, 'codigo'=>0, 'preciocompra'=>0, 'codigonombre'=>0);
      $resultado= $this->Producto->find('all',array('fields'=>array('Producto.id','Producto.codigonombre','Producto.nombre','Producto.codigo','Producto.categoria_id','Producto.preciocompra'), 'order'=>array('Producto.categoria_id'=>'ASC')));
      $this->loadModel('Preciosproducto');

      $precio = $this->Preciosproducto->find('list',array('fields'=>array('categoria_id','precio'),'order'=>array('precio'=>'DESC'),'group'=>array('categoria_id')));
      
      $resultadofinal=null;

      foreach ($resultado as $key => $value) {
      	
      	if (isset($precio[$value['Producto']['categoria_id']])){
      		$value['Producto']['precio']=$precio[$value['Producto']['categoria_id']];
      	}else{
      		$value['Producto']['precio']=0;
      	}
      		
            $resultadofinal[]=$value['Producto'];    
      }
      
      echo json_encode($resultadofinal);


    }

    public function listjsonproductosconstock(){
      $this->layout= false;
      $this->Producto->recursive=-1;
    
      $resultado= $this->Producto->find('all',array('fields'=>array('Producto.id','Producto.codigonombre','Producto.nombre','Producto.codigo','Producto.stock','Producto.preciocompra','Producto.iva','Producto.precio'), 'conditions'=>array('stock >'=>0, 'disponible'=>true) ,'order'=>array('Producto.nombre'=>'ASC')));
     
      //debug($resultado);
     
      $resultadofinal=null;

      foreach ($resultado as $key => $value) {
      	
      	    		
            $resultadofinal[]=$value['Producto'];    
      }
      
      echo json_encode($resultadofinal);


    }

/** Inicio Funciones para modal **/

   	// Devuelve la info de un producto en json
    public function jsonproductodata($id=null){
    	$this->layout='ajax';
    	$id=$_GET['codid'];
    	if ($this->request->is('ajax')) {
    		
    		$resultado= $this->Producto->find('first',array('fields'=>array('Producto.id','Producto.codigonombre','Producto.nombre','Producto.codigo','Producto.stock','Producto.preciocompra','Producto.iva','Producto.precio','Producto.preciobruto'), 'conditions'=>array('Producto.id'=>$id, 'Producto.disponible'=>1)));

    		echo json_encode($resultado['Producto']);
    	}

    }	

    public function modal_listaproductos($cadena=null){
    	$this->layout='ajax';
        $resultado=array();
        //$cadena=array();
        $conditions=array();
        
        if ($this->request->is('post') || $this->request->is('ajax')) {

        	if (isset($this->request->data['Producto']['searchprod']) && (!empty($this->request->data['Producto']['searchprod']))){
            	$cadena= explode(" ", $this->request->data['Producto']['searchprod']);
            }

            

            if (!empty($cadena)){
	            foreach ($cadena as $key => $options) {
	            	
	            	$conditions['OR'][]=array('Producto.nombre LIKE '=>'%'.$options.'%');
	            	$conditions['OR'][]=array('Producto.codigo LIKE '=>'%'.$options.'%');

	            }
	            
	            $resultado=$this->Producto->find('all',array('fields'=>array('id','nombre','codigo','stock','preciobruto','precio','iva','disponible','categoria_id'),'conditions'=>array('OR'=>$conditions),'limit'=>40));
        	}
            
        }else{
        	$resultado=$this->Producto->find('all',array('fields'=>array('id','nombre','codigo','stock','preciobruto','precio','iva','disponible','categoria_id'),'conditions'=>array(),'limit'=>40));
        }

        $this->set('resultado',$resultado);
    }

//


   

}
?>