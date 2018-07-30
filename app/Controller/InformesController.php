<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Categorias Controller
 *
 * @property Categoria $Categoria
 */
class InformesController extends AppController {

	public $helpers = array('Html', 'Form', 'Session', 'Js');
	var $uses = array('Producto','Factura','User','Categoria','Detalle','Transporte','Pago','Cheque');
	public $components = array('Paginator','RequestHandler');

	public function beforeFilter() {
        parent::beforeFilter();
		$this->Auth->allow(array('generarplanillaprecios','generarplanillaprecios2','generarplanillapreciosdistribuidor2','generarplanillapreciosdistribuidor'));
        if($this->Session->read('Auth.User')){
	     	if ($this->Auth->user('role') == 'admin'){
                $this->Auth->allow(); // Letting users register themselves
                $listacategorias=$this->Categoria->find('list',array('fields'=>array('id','nombre')));
                $this->set('listacategorias',$listacategorias);
            }else{
				if ($this->Auth->user('role') == 'depobancario'){
                    $this->Auth->allow('depositosaccesos'); // Letting users register themselves
                    $listacategorias=$this->Categoria->find('list',array('fields'=>array('id','nombre')));
                    $this->set('listacategorias',$listacategorias);
                }
                //$this->Auth->allow(array('generarplanillaprecios','generarplanillaprecios2','generarplanillapreciosdistribuidor2','generarplanillapreciosdistribuidor'));
            }
			$this->set('operarios',array('1'=>'Marcos Correa','2'=>'Matias Medrano','3'=>'Juan Marchettini','4'=>'Pablo Martin','5'=>'Rolo Arancibia','6'=>'Leo Graton'));
      
	    }
    }

    //FUNCIONES PARA TRABAJAR EN LOS CONTROLADORES
    private function generarlistahijopadre(){
       $lista= $this->Categoria->find('list',array('fields'=>array('id','subcategoria_id')));
       return $lista;
    }

        public function generarhijos($n=null, $ventas=true){
            if ($ventas){
                $infoproducto=array('cantvendida'=>0,'costo'=>0,'venta'=>0,'ganancia'=>0);
            }else{
                 $infoproducto=array('stock'=>0,'preciocompra'=>0,'valorizacioncat'=>0,'total'=>0);
            }
           foreach ($n as $value) {
            
               $x[$value]=$this->Categoria->find('list',array('fields'=>array('id'), 'conditions'=>array('Categoria.subcategoria_id'=>$value)));
               
               if (empty($x[$value])){
                    $x[$value]=$infoproducto;
               }else{

                   foreach ($x[$value] as $subitem) {
                       $x[$value][$subitem] = $infoproducto;
                   }
                }
                if (isset($x['multiselect-all'])){
                    unset($x['multiselect-all']);
                }
                

               
               
           }
            return $x;
        }

    //se ingresa el array con todos los productos, se elimina el producto que no se encuentra en el arreglo de categorias disponibles
    private function quitarcategorias($listaproducto=null,$catdisponible=null){
        $listahijospadre = $this->Categoria->find('list',array('fields'=>array('id','subcategoria_id')));
       
        foreach ($listaproducto as $key=>$producto) {
            //debug($key);
            $pardreaux=$listahijospadre[$producto['Producto']['categoria_id']];
            if (($pardreaux ==0) || ($pardreaux==null)){
                $pardreaux=$producto['Producto']['categoria_id'];
                
            }
            if (!in_array($pardreaux,$catdisponible)){ 
                unset($listaproducto[$key]);
            }
        }

        return $listaproducto;

    }

    //FIN DE FUNCIONES PARA TRABAJAR EN LOS CONTROLADORES
    public function cantidadporproductos($desde=null, $hasta=null ,$categoriaid=null){
        $this->layout = 'backend';
        $listadecategorias=array();
        $prueba=array();
        $botonimprimir=false;
        $showproductos=0;

        $listacategorias = $this->Categoria->find('list',array('fields'=>array('id','nombre'), 'conditions'=>array('Categoria.subcategoria_id'=>0)));

        $this->set('listacategoriaspadre',$listacategorias);

        $listaidcategoria=$this->Categoria->find('list',array('fields'=>array('id','id'),'conditions'=>array('Categoria.subcategoria_id'=>0)));

        $result = $this->generarhijos($listaidcategoria);
        $this->set('listadodecostosporcategoria', $result);
        

        
        if ($this->request->is('post')){
            
            $desde= $this->request->data['Factura']['desde']['year'].'-'.$this->request->data['Factura']['desde']['month'].'-'.$this->request->data['Factura']['desde']['day'];
            $time = strtotime($desde);
            $desde = date('Y-m-d',$time);
            
            $hasta= $this->request->data['Factura']['hasta']['year'].'-'.$this->request->data['Factura']['hasta']['month'].'-'.$this->request->data['Factura']['hasta']['day'];
            $time = strtotime($hasta);

            $hasta = date('Y-m-d',$time);
            $botonimprimir=true;
            
            if (isset($this->request->data['Factura']['categoriaid'])){
                $listadecategorias=$this->request->data['Factura']['categoriaid'];
            }

            if (isset($this->request->data['Factura']['showproductos'])){
                $showproductos=$this->request->data['Factura']['showproductos'];
            }

        $prueba= $this->Producto->find('all', array(
		    'joins' => array(
		        array(
		            'table' => 'categorias',
		            'alias' => 'Categoriasjoin',
		            'type' => 'LEFT',
		            'conditions' => array(
		                'Categoriasjoin.id = Producto.categoria_id',
		            )
		        ),
		        array(
		            'table' => 'detalles',
		            'alias' => 'Detallejoin',
		            'type' => 'INNER',
		            'conditions' => array(
		                'Detallejoin.producto_id = Producto.id'
		            )
		        ),
		        array(
		            'table' => 'facturas',
		            'alias' => 'Facturajoin',
		            'type' => 'INNER',
		            'conditions' => array(
		                'Facturajoin.id = Detallejoin.factura_id',
		                'Facturajoin.created >='=>$desde, 'Facturajoin.created <='=>$hasta

		            )
		        )
		    ),
		    
		    'fields'=>array('Producto.id','Producto.nombre','Producto.stock','Producto.preciocompra' ,'Producto.categoria_id','Producto.id','Producto.categoria_id' ,'Categoriasjoin.nombre','Categoriasjoin.subcategoria_id','SUM(Detallejoin.cantidad) AS total','SUM(Detallejoin.precio * Detallejoin.cantidad) AS precio', 'SUM(Detallejoin.costo * Detallejoin.cantidad) AS costo'),
		    'order'=>array('Categoriasjoin.subcategoria_id'=>'ASC','Categoriasjoin.nombre'=>'ASC','total'=>'DESC'),
		    'group'=>array('Detallejoin.producto_id'),
		    
		    
		));


        //Se depura la lista obtenida, eliminando los productos que pertenecen a una subcategoria padre no seleccionada por el usuario desde el frontend
        
        $prueba=$this->quitarcategorias($prueba,$listadecategorias);
       
        }
		
 



        // Genero una lista con La categoria hija y su categoria padre
        $this->set('listahijospadre',$this->Categoria->find('list',array('fields'=>array('id','subcategoria_id'))));

        $this->set('categhabilidada',$listadecategorias);
        $this->set('botonimprimir',$botonimprimir);
        $this->set('suma', $prueba); 
        $this->set('showproductos',$showproductos);    
    }



    public function stockvalorizado($categoriaid=null){
            $this->layout = 'backend';
            $showproductos=false;
            $listadecategorias=array();
            $prueba=array();
            $result=array();
            $listacategorias = $this->Categoria->find('list',array('fields'=>array('id','nombre'), 'conditions'=>array('Categoria.subcategoria_id'=>0)));

            $this->set('listacategoriaspadre',$listacategorias);

            if ($this->request->is('post')){

                if (isset($this->request->data['Categoria']['categoriaid'])){
                    $listadecategorias=$this->request->data['Categoria']['categoriaid'];
                }

                if (isset($this->request->data['Categoria']['showproductos'])){
                    $showproductos=$this->request->data['Categoria']['showproductos'];
                }
               
                $result = $this->generarhijos($listadecategorias,false);
               
                
               
                $this->Paginator->settings = array('Producto'=>array(
                    'recursive' =>  0,
                    'fields'=>array('Producto.id','Producto.nombre','Producto.preciocompra','Producto.codigo','Producto.stock','Producto.categoria_id','Producto.disponible','Categoria.id','Categoria.nombre','Categoria.subcategoria_id'),
                    'conditions'=>array('OR'=>array('Categoria.id'=>$listadecategorias,'Categoria.subcategoria_id'=>$listadecategorias),'Producto.disponible'=>1,'Categoria.disponible'=>1),
                    'limit' => 1500,
                    'order'=>array('Categoria.subcategoria_id'=>'ASC','Producto.categoria_id'=>'ASC','Producto.nombre'=>'ASC','Producto.disponible'=>'ASC')
                ));
                $prueba=$this->Paginator->paginate('Producto');
                
            }
            $pendientesdearmar=$this->Detalle->query("SELECT Detalle.producto_id, SUM(Detalle.cantidad) As Detalle FROM detalles AS Detalle, facturas AS Factura WHERE Factura.empaquetado = 0 AND Detalle.factura_id = Factura.id GROUP BY Detalle.producto_id");
            
			$listapendientesdearmar=null;
			foreach ($pendientesdearmar as $key => $value) {
                //Detalle ya trae agrupado la cuma de la cantidad por productos
                $listapendientesdearmar[$value['Detalle']['producto_id']]= $value[0]['Detalle'];
			}
			//debug($listapendientesdearmar);
			$this->set('listapendientesdearmar',$listapendientesdearmar);
            $this->set('listadodecostosporcategoria', $result);
            $this->set('listahijospadre',$this->generarlistahijopadre());
            $this->set('productos',$prueba);
            $this->set('showproductos',$showproductos);

        }

    public function planillacantidadporproductos($desde='2017-01-01', $hasta='2018-01-01'){
            App::import('Vendor', 'PHPExcel', array('file' =>'classes/PHPExcel.php'));
            App::import('Vendor', 'Excel2007', array('file' =>'classes/PHPExcel/Writer/Excel2007.php'));

            // SE ARMAN LOS ARRAY PARA EL INFORME
            
             $listacategorias = $this->Categoria->find('list',array('fields'=>array('id','nombre'),array('conditions'=>array('Categoria.subcategoria_id'=>0))));

            if (empty($desde)) { 
                $desde= $this->request->data['Factura']['desde']['year'].'-'.$this->request->data['Factura']['desde']['month'].'-'.$this->request->data['Factura']['desde']['day'];
                $time = strtotime($desde);
                $desde = date('Y-m-d',$time);
            }

            if (empty($desde)) {
                $hasta= $this->request->data['Factura']['hasta']['year'].'-'.$this->request->data['Factura']['hasta']['month'].'-'.$this->request->data['Factura']['hasta']['day'];
                $time = strtotime($hasta);
                $hasta = date('Y-m-d',$time); 
            }
       
            $prueba= $this->Producto->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'categorias',
                        'alias' => 'Categoriasjoin',
                        'type' => 'LEFT',
                        'conditions' => array(
                            'Categoriasjoin.id = Producto.categoria_id'
                        )
                    ),
                    array(
                        'table' => 'detalles',
                        'alias' => 'Detallejoin',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Detallejoin.producto_id = Producto.id'
                        )
                    ),
                    array(
                        'table' => 'facturas',
                        'alias' => 'Facturajoin',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Facturajoin.id = Detallejoin.factura_id',
                            'Facturajoin.created >='=>$desde, 'Facturajoin.created <='=>$hasta

                        )
                    )
                ),
                
                'fields'=>array('Producto.id','Producto.nombre','Producto.preciocompra' ,'Producto.categoria_id','Producto.id','Producto.categoria_id' ,'Categoriasjoin.nombre','SUM(Detallejoin.cantidad) AS total','Detallejoin.precio', 'Detallejoin.costo'),
                'order'=>array('Categoriasjoin.nombre'=>'ASC','total'=>'DESC'),
                'group'=>array('Detallejoin.producto_id'),
                
                
            ));

            ///// FIN DEL ARMADO DE DATOS
           
            $styleLabelprecio = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 11,
                'name'  => 'Verdana'
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
              'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
              )
             ));
            $styleArray = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 11,
                'name'  => 'Verdana'
            ),
            'borders' => array(
              'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
              )
             )
            );
            $stylePrecios = array(
            'font'  => array(
                'bold'  => FALSE,
                'size'  => 10,
                'name'  => 'Verdana'
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
              'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
              )
             )
            );

            $styleCell = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 13,
                'name'  => 'Verdana',
                'color' => array('rgb' => 'FFFFFF')
            ),
            'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '003FFF')
            ));

            $styleheadtable = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 10,
                'name'  => 'Verdana',
                'color' => array('rgb' => '000000')
            ),
            'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'C4C4C4')
            ));  

            //objeto de PHP Excel
            $objPHPExcel = new PHPExcel();

            
            $filacount = 1;
            //algunos datos sobre autoría
            $objPHPExcel->getProperties()->setCreator("Planilla de Precios");
            $objPHPExcel->getProperties()->setLastModifiedBy("Tienda Overall");
            $objPHPExcel->getProperties()->setTitle("Planilla de Precios Overall");
            $objPHPExcel->getProperties()->setSubject("Planilla de Precios Overall");
            $objPHPExcel->getProperties()->setDescription("Planilla de Precios Tiendaoverall.com.ar");

            //Trabajamos con la hoja activa principal
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(11);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(11);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(11);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(13);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(13);
            
            
            $objPHPExcel->getActiveSheet()->mergeCells("A1:E2");
            $objPHPExcel->getActiveSheet()->SetCellValue("A".$filacount, 'INFORME DE VENTA '.$desde.' - '.$hasta);
            $objPHPExcel->getActiveSheet()->getStyle("A".$filacount)->applyFromArray($styleCell);
            
            $filacount=$filacount+2;
             $objPHPExcel->getActiveSheet()->mergeCells("A".$filacount.":E".$filacount);
            $objPHPExcel->getActiveSheet()->SetCellValue("A".$filacount, '(**) Nota: Si un producto no tiene un precio de costo, la ganancia sera 100%');  
            $filacount=$filacount+2;
            $objPHPExcel->getActiveSheet()->mergeCells("A".$filacount.":E".$filacount);
            
            $objPHPExcel->getActiveSheet()->SetCellValue("A".$filacount, 'Todos los precios incluyen IVA');  
           

            $categoriaid='-1';
            $filaTitulocantidades=-1;
            
            $idcategoria=0;
            $sumatotal=0;
            $idtotales=[];
            
            foreach ($prueba as $producto) {
                    if ($producto['Producto']['categoria_id'] != $idcategoria){ 

                        if ($idcategoria != 0){ 
                            
                            $idtotales[$idcategoria]=$sumatotal;
                            $sumatotal=0;
                        }

                        $filacount=$filacount+2;
                        
                        $objPHPExcel->getActiveSheet()->mergeCells("A".$filacount.":E".$filacount);
                        $objPHPExcel->getActiveSheet()->SetCellValue("A".$filacount, $listacategorias[$producto['Producto']['categoria_id']]);
                        $objPHPExcel->getActiveSheet()->getStyle("A".$filacount)->applyFromArray($styleCell);
                        $filacount=$filacount+2;

                        $objPHPExcel->getActiveSheet()->SetCellValue("A".$filacount, 'Nombre del Producto');
                        $objPHPExcel->getActiveSheet()->getStyle("A".$filacount.":E".$filacount)->applyFromArray($styleheadtable);
                        $objPHPExcel->getActiveSheet()->SetCellValue("B".$filacount, 'Cant');
                        $objPHPExcel->getActiveSheet()->SetCellValue("C".$filacount, 'Venta');
                        $objPHPExcel->getActiveSheet()->SetCellValue("D".$filacount, 'Costo');
                        $objPHPExcel->getActiveSheet()->SetCellValue("E".$filacount, 'Ganancia');
                        
                        $idcategoria = $producto['Producto']['categoria_id'];

                    }  

                    $filacount=$filacount+1;          

                    $objPHPExcel->getActiveSheet()->SetCellValue("A".$filacount, $producto['Producto']['nombre']);
                    $objPHPExcel->getActiveSheet()->SetCellValue("B".$filacount, $producto['0']['total']);
                    $sumatotal=$sumatotal+$producto['0']['total'];

                    $objPHPExcel->getActiveSheet()->SetCellValue("C".$filacount, $producto['Detallejoin']['precio']);
                    $objPHPExcel->getActiveSheet()->SetCellValue("D".$filacount, $producto['Producto']['preciocompra']);
                   
                    if ($producto['Detallejoin']['costo'] == 0){
                        $costo=(float)$producto['Producto']['preciocompra']*$producto['0']['total']; 
                    }else{
                        $costo=(float)$producto['Detallejoin']['costo']*$producto['0']['total']; 
                    }

                    $venta=(float)$producto['Detallejoin']['precio']*$producto['0']['total'];
                    
                    $objPHPExcel->getActiveSheet()->SetCellValue("E".$filacount, $venta - $costo);
                    
                                

            }
                        if ($idcategoria != 0){ 
                            $idtotales[$idcategoria]=$sumatotal;
                            $sumatotal=0;
                        }
                   
                   
                 
            


            $filacount=$filacount+2;
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$filacount, 'Overall');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$filacount)->applyFromArray($styleCell);
            $filacount=$filacount+1;
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$filacount, 'Cel: 0291-6451450');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$filacount)->applyFromArray($styleCell);
            $filacount=$filacount+1;
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$filacount, 'info@tiendaoverall.com.ar');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$filacount)->applyFromArray($styleCell);
            $filacount=$filacount+1;
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$filacount, 'www.tiendaoverall.com.ar');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$filacount)->applyFromArray($styleCell);
            $filacount=$filacount+1;
           
            

            //iteramos para los resultado
            //Titulo del libro y seguridad 
            $objPHPExcel->getActiveSheet()->setTitle('Info'.$desde.'-'.$hasta);
            $objPHPExcel->getSecurity()->setLockWindows(true);
            $objPHPExcel->getSecurity()->setLockStructure(true);


            // Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="InformesVentas-'.$desde.'-'.$hasta.'.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            //

            $download = 'InformesVentas-'.$desde.'-'.$hasta;
            $savedFile ="download/".$download ;
            if(file_exists($savedFile)) {     
                    // File doesn't exist, output error     
                    unlink($savedFile);
            }
            $objWriter->save($savedFile);
            $objWriter->save('php://output');
            //$this->response->file(WWW_ROOT.'download/'.$download, array('download' =>true, 'name' =>$download));
            

            exit;
            
            
        }

                /// GENERAR EXCEL DE MUESTRAS 
    public function generarplanillaprecios($rol=null){
        $this->Categoria->recursive = 2;
        $categorias = $this->Categoria->find('all',array('fields'=>array('Categoria.id','Categoria.nombre','Categoria.subcategoria_id','Categoria.descripcion','Categoria.disponible'),'conditions'=>array('Categoria.subcategoria_id'=>0,'Categoria.disponible'=>1),'order'=>array('Categoria.nombre'=>'ASC')));
        $this->set('categorias',$categorias);
        
        $viewHtml = new View($this, false);
        $viewHtml->set('renderView', true);
        $viewHtml->viewPath = 'informes';
        $this->layout =false;
        $this->response->type('application/pdf');
        $this->render('generarplanillapreciospdf');
        $this->Session->setFlash('', 'default', array('class' => 'errorventas'), 'badventas');   
    }

    /// GENERAR EXCEL DE MUESTRAS 
    public function generarplanillaprecios2($rol=null){
        App::import('Vendor', 'PHPExcel', array('file' =>'classes/PHPExcel.php'));
        App::import('Vendor', 'Excel2007', array('file' =>'classes/PHPExcel/Writer/Excel2007.php'));

        // SE ARMAN LOS ARRAY PARA EL INFORME
        
         //$cantidadporcategorias;

            
        $this->Categoria->recursive = 2;
        $categorias = $this->Categoria->find('all',array('fields'=>array('Categoria.id','Categoria.nombre','Categoria.subcategoria_id','Categoria.disponible'),'conditions'=>array('Categoria.subcategoria_id'=>0,'Categoria.disponible'=>1),'order'=>array('Categoria.nombre'=>'ASC')));
         
	    
        	
        ///// FIN DEL ARMADO DE DATOS
		$muestras=array();
        $styleLabelprecio = array(
        'font'  => array(
            'bold'  => true,
            'size'  => 11,
            'name'  => 'Verdana'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        ),
        'borders' => array(
          'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          )
         ));
		$styleArray = array(
        'font'  => array(
            'bold'  => true,
            'size'  => 11,
            'name'  => 'Verdana'
        ),
        'borders' => array(
          'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          )
         )
        );
        $stylePrecios = array(
        'font'  => array(
            'bold'  => FALSE,
            'size'  => 10,
            'name'  => 'Verdana'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        ),
        'borders' => array(
          'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          )
         )
        );

        $styleCell = array(
        'font'  => array(
            'bold'  => true,
            'size'  => 13,
            'name'  => 'Verdana',
            'color' => array('rgb' => 'FFFFFF')
        ),
        'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '003FFF')
        ));  

        //objeto de PHP Excel
        $objPHPExcel = new PHPExcel();

        
        $filacount = 1;
        //algunos datos sobre autoría
        $objPHPExcel->getProperties()->setCreator("Planilla de Precios");
        $objPHPExcel->getProperties()->setLastModifiedBy("Tienda Overall");
        $objPHPExcel->getProperties()->setTitle("Planilla de Precios Overall");
        $objPHPExcel->getProperties()->setSubject("Planilla de Precios Overall");
        $objPHPExcel->getProperties()->setDescription("Planilla de Precios Tiendaoverall.com.ar");

        //Trabajamos con la hoja activa principal
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        
        $objPHPExcel->getActiveSheet()->mergeCells("A1:H2");
        $objPHPExcel->getActiveSheet()->SetCellValue("A".$filacount, 'LISTA DE PRECIOS MAYORISTAS '.date('d-m-Y'));
        $objPHPExcel->getActiveSheet()->getStyle("A".$filacount)->applyFromArray($styleCell);
        
        $filacount=$filacount+2;
         $objPHPExcel->getActiveSheet()->mergeCells("A".$filacount.":F".$filacount);
        $objPHPExcel->getActiveSheet()->SetCellValue("A".$filacount, '(**) Los precios son por el total de productos de la categoria');  
        $filacount=$filacount+2;
         $objPHPExcel->getActiveSheet()->mergeCells("A".$filacount.":F".$filacount);
        
        $objPHPExcel->getActiveSheet()->SetCellValue("A".$filacount, 'Todos los precios incluyen IVA del 21% y estan sujetos a cambios sin previo aviso');  
       
        

        

        $categoriaid='-1';
        $filaTitulocantidades=-1;
        
        foreach ($categorias as $catseccion) {
                $filacount=$filacount+2;
                $filaTitulocantidades=$filacount;
                //$objPHPExcel->getActiveSheet()->mergeCells("A".$filacount.":E".$filacount);
                $objPHPExcel->getActiveSheet()->SetCellValue("A".$filacount, $catseccion['Categoria']['nombre']);
                $objPHPExcel->getActiveSheet()->getStyle("A".$filacount)->applyFromArray($styleCell);
             
               
            if (empty($catseccion['Subcategoria'])){
                
                // GENERO LOS LABEL DESDE HASTA
                $columnaTitulocantidades='B';
                foreach ($catseccion['Preciosproducto'] as $labelrangos) {
                
                  $objPHPExcel->getActiveSheet()->SetCellValue($columnaTitulocantidades.$filacount, $labelrangos['descripcion']);
                  $objPHPExcel->getActiveSheet()->getStyle($columnaTitulocantidades.$filacount)->applyFromArray($styleLabelprecio);
                    $columnaTitulocantidades= ++$columnaTitulocantidades;
                 
                }

                // COMO NO EXISTE SUBCATEGORIAS  QUIERE DECIR QUE SOLO HAY PRECIOS PARA ESTA CATEGORIA
                $filacount=$filacount+1;
                $objPHPExcel->getActiveSheet()->SetCellValue("A".$filacount, $catseccion['Categoria']['nombre']);
                $objPHPExcel->getActiveSheet()->getStyle("A".$filacount)->applyFromArray($styleArray);

                //LO MISMO QUE LABEL NADA MAS QUE CON LOS PRECIOS NO AUMENTO LA FILA+1 PORQUE COMPLETA LA LINEA
                $columnaTitulocantidades='B';
                foreach ($catseccion['Preciosproducto'] as $precios) {
                
                  $objPHPExcel->getActiveSheet()->SetCellValue($columnaTitulocantidades.$filacount, $precios['precio']);
                   $objPHPExcel->getActiveSheet()->getStyle($columnaTitulocantidades.$filacount)->applyFromArray($stylePrecios);
                    $columnaTitulocantidades= ++$columnaTitulocantidades;

                 
                }
                

            }else{
                foreach ($catseccion['Subcategoria'] as $subcategoria) {
					if ($subcategoria['disponible'] == true){
						// GENERO LOS LABEL DESDE HASTA
						$columnaTitulocantidades='B';
						foreach ($subcategoria['Preciosproducto'] as $labelrangos) {
						
							$objPHPExcel->getActiveSheet()->SetCellValue($columnaTitulocantidades.$filaTitulocantidades, $labelrangos['descripcion']);
							$objPHPExcel->getActiveSheet()->getStyle($columnaTitulocantidades.$filaTitulocantidades)->applyFromArray($styleLabelprecio);
							$columnaTitulocantidades= ++$columnaTitulocantidades;
						 
						}

						// COMO NO EXISTE SUBCATEGORIAS  QUIERE DECIR QUE SOLO HAY PRECIOS PARA ESTA CATEGORIA
						$filacount=$filacount+1;
						$objPHPExcel->getActiveSheet()->SetCellValue("A".$filacount, $subcategoria['nombre']);
						$objPHPExcel->getActiveSheet()->getStyle("A".$filacount)->applyFromArray($styleArray);

						//LO MISMO QUE LABEL NADA MAS QUE CON LOS PRECIOS NO AUMENTO LA FILA+1 PORQUE COMPLETA LA LINEA
						$columnaTitulocantidades='B';
						foreach ($subcategoria['Preciosproducto'] as $precios) {
						
						  $objPHPExcel->getActiveSheet()->SetCellValue($columnaTitulocantidades.$filacount, $precios['precio']);
						   $objPHPExcel->getActiveSheet()->getStyle($columnaTitulocantidades.$filacount)->applyFromArray($stylePrecios);
							$columnaTitulocantidades= ++$columnaTitulocantidades;
						 
						}
					}

                }                
            }
             
        }


        $filacount=$filacount+2;
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$filacount, 'Overall');
        $objPHPExcel->getActiveSheet()->getStyle('A'.$filacount)->applyFromArray($styleCell);
        $filacount=$filacount+1;
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$filacount, 'Cel: 0291-6451450');
        $objPHPExcel->getActiveSheet()->getStyle('A'.$filacount)->applyFromArray($styleCell);
        $filacount=$filacount+1;
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$filacount, 'info@tiendaoverall.com.ar');
        $objPHPExcel->getActiveSheet()->getStyle('A'.$filacount)->applyFromArray($styleCell);
        $filacount=$filacount+1;
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$filacount, 'www.tiendaoverall.com.ar');
        $objPHPExcel->getActiveSheet()->getStyle('A'.$filacount)->applyFromArray($styleCell);
        $filacount=$filacount+1;
       
        

        //iteramos para los resultado
        //Titulo del libro y seguridad 
        $objPHPExcel->getActiveSheet()->setTitle('PreciosOverall'.date('d-m-Y'));
        $objPHPExcel->getSecurity()->setLockWindows(true);
        $objPHPExcel->getSecurity()->setLockStructure(true);


        // Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="PreciosOverall-'.date('d-m-Y').'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //

        $download = 'ListadePreciosOverall.xlsx';
        $savedFile ="download/".$download ;
        if(file_exists($savedFile)) {     
                // File doesn't exist, output error     
                unlink($savedFile);
        }
        $objWriter->save($savedFile);
        $objWriter->save('php://output');
        //$this->response->file(WWW_ROOT.'download/'.$download, array('download' =>true, 'name' =>$download));
        

        exit;
        
        
    }

    public function generarplanillapreciosdistribuidor($rol=null){
       
        $this->Categoria->recursive = 2;
        $categorias = $this->Categoria->find('all',array('fields'=>array('Categoria.id','Categoria.nombre','Categoria.subcategoria_id','Categoria.descripcion','Categoria.disponible'),'conditions'=>array('Categoria.subcategoria_id'=>0,'Categoria.disponible'=>1),'order'=>array('Categoria.nombre'=>'ASC')));
        $this->set('categorias',$categorias);
        //debug($categorias);

        $viewHtml = new View($this, false);
        $viewHtml->set('renderView', true);
        $viewHtml->viewPath = 'informes';
        $this->layout =false;
        $this->response->type('application/pdf');
        $this->render('generarplanilladistribuidorspdf');
        $this->Session->setFlash('', 'default', array('class' => 'errorventas'), 'badventas');
             
  
    }

	public function generarplanillapreciosdistribuidor2($rol=null){
            App::import('Vendor', 'PHPExcel', array('file' =>'classes/PHPExcel.php'));
            App::import('Vendor', 'Excel2007', array('file' =>'classes/PHPExcel/Writer/Excel2007.php'));

            // SE ARMAN LOS ARRAY PARA EL INFORME
            
             //$cantidadporcategorias;

                
            $this->Categoria->recursive = 2;
            $categorias = $this->Categoria->find('all',array('fields'=>array('Categoria.id','Categoria.nombre','Categoria.subcategoria_id','Categoria.disponible'),'conditions'=>array('Categoria.subcategoria_id'=>0,'Categoria.disponible'=>1),'order'=>array('Categoria.nombre'=>'ASC')));
             
            
                
            ///// FIN DEL ARMADO DE DATOS
            $muestras=array();
            $styleLabelprecio = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 11,
                'name'  => 'Verdana'
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
              'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
              )
             ));
            $styleArray = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 11,
                'name'  => 'Verdana'
            ),
            'borders' => array(
              'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
              )
             )
            );
            $stylePrecios = array(
            'font'  => array(
                'bold'  => FALSE,
                'size'  => 10,
                'name'  => 'Verdana'
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
              'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
              )
             )
            );

            $styleCell = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 13,
                'name'  => 'Verdana',
                'color' => array('rgb' => 'FFFFFF')
            ),
            'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '003FFF')
            ));  

            //objeto de PHP Excel
            $objPHPExcel = new PHPExcel();

            
            $filacount = 1;
            //algunos datos sobre autoría
            $objPHPExcel->getProperties()->setCreator("Planilla de Precios");
            $objPHPExcel->getProperties()->setLastModifiedBy("Tienda Overall");
            $objPHPExcel->getProperties()->setTitle("Planilla de Precios Overall");
            $objPHPExcel->getProperties()->setSubject("Planilla de Precios Overall");
            $objPHPExcel->getProperties()->setDescription("Planilla de Precios Tiendaoverall.com.ar");

            //Trabajamos con la hoja activa principal
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
            
            $objPHPExcel->getActiveSheet()->mergeCells("A1:D2");
            $objPHPExcel->getActiveSheet()->SetCellValue("A".$filacount, 'LISTA DE PRECIOS DISTRIBUIDOR '.date('d-m-Y'));
            $objPHPExcel->getActiveSheet()->getStyle("A".$filacount)->applyFromArray($styleCell);
            
            $filacount=$filacount+2;
             $objPHPExcel->getActiveSheet()->mergeCells("A".$filacount.":F".$filacount);
            $objPHPExcel->getActiveSheet()->SetCellValue("A".$filacount, '(**) Los precios son por el total de productos de la categoria');  
            $filacount=$filacount+2;
             $objPHPExcel->getActiveSheet()->mergeCells("A".$filacount.":F".$filacount);
            
            $objPHPExcel->getActiveSheet()->SetCellValue("A".$filacount, 'Todos los precios incluyen IVA del 21% y estan sujetos a cambios sin previo aviso');  
           
            

            

            $categoriaid='-1';
            $filaTitulocantidades=-1;
            
            foreach ($categorias as $catseccion) {
                    $filacount=$filacount+2;
                    $filaTitulocantidades=$filacount;
                    //$objPHPExcel->getActiveSheet()->mergeCells("A".$filacount.":E".$filacount);
                    $objPHPExcel->getActiveSheet()->SetCellValue("A".$filacount, $catseccion['Categoria']['nombre']);
                    $objPHPExcel->getActiveSheet()->getStyle("A".$filacount)->applyFromArray($styleCell);
                 
                   
                if (empty($catseccion['Subcategoria'])){
                    
                    // GENERO LOS LABEL DESDE HASTA
                    $columnaTitulocantidades='B';
                    $index=sizeof($catseccion['Preciosproducto'])-1;
                    if(isset($catseccion['Preciosproducto'][$index])){
                        $labelrangos= $catseccion['Preciosproducto'][$index];

                        $objPHPExcel->getActiveSheet()->SetCellValue($columnaTitulocantidades.$filacount,'Precios $');
                        $objPHPExcel->getActiveSheet()->getStyle($columnaTitulocantidades.$filacount)->applyFromArray($styleLabelprecio);
                            $columnaTitulocantidades= ++$columnaTitulocantidades;
                         
                        // COMO NO EXISTE SUBCATEGORIAS  QUIERE DECIR QUE SOLO HAY PRECIOS PARA ESTA CATEGORIA
                        $filacount=$filacount+1;
                        $objPHPExcel->getActiveSheet()->SetCellValue("A".$filacount, $catseccion['Categoria']['nombre']);
                        $objPHPExcel->getActiveSheet()->getStyle("A".$filacount)->applyFromArray($styleArray);

                        //LO MISMO QUE LABEL NADA MAS QUE CON LOS PRECIOS NO AUMENTO LA FILA+1 PORQUE COMPLETA LA LINEA
                        $columnaTitulocantidades='B';
                        $index = sizeof($catseccion['Preciosproducto'])-1;
                        $precios= $catseccion['Preciosproducto'][$index];
                        
                        
                        $objPHPExcel->getActiveSheet()->SetCellValue($columnaTitulocantidades.$filacount, $precios['precio']);
                        $objPHPExcel->getActiveSheet()->getStyle($columnaTitulocantidades.$filacount)->applyFromArray($stylePrecios);
                        $columnaTitulocantidades= ++$columnaTitulocantidades;
                    }

                }else{
                    foreach ($catseccion['Subcategoria'] as $subcategoria) {
						if ($subcategoria['disponible'] == true){
							// GENERO LOS LABEL DESDE HASTA
							$columnaTitulocantidades='B';
							$index = sizeof($subcategoria['Preciosproducto'])-1;
							
							if(isset($subcategoria['Preciosproducto'][$index])){
								$labelrangos= $subcategoria['Preciosproducto'][$index];
									$objPHPExcel->getActiveSheet()->SetCellValue($columnaTitulocantidades.$filaTitulocantidades, 'Precios $');
									$objPHPExcel->getActiveSheet()->getStyle($columnaTitulocantidades.$filaTitulocantidades)->applyFromArray($styleLabelprecio);
									$columnaTitulocantidades= ++$columnaTitulocantidades;
			  
								// COMO NO EXISTE SUBCATEGORIAS  QUIERE DECIR QUE SOLO HAY PRECIOS PARA ESTA CATEGORIA
								$filacount=$filacount+1;
								$objPHPExcel->getActiveSheet()->SetCellValue("A".$filacount, $subcategoria['nombre']);
								$objPHPExcel->getActiveSheet()->getStyle("A".$filacount)->applyFromArray($styleArray);
							}

							//LO MISMO QUE LABEL NADA MAS QUE CON LOS PRECIOS NO AUMENTO LA FILA+1 PORQUE COMPLETA LA LINEA
							$columnaTitulocantidades='B';
							$index = sizeof($subcategoria['Preciosproducto'])-1;
						   
							if(isset($subcategoria['Preciosproducto'][$index])){
							  $precios= $subcategoria['Preciosproducto'][$index];
							  $objPHPExcel->getActiveSheet()->SetCellValue($columnaTitulocantidades.$filacount, $precios['precio']);
							   $objPHPExcel->getActiveSheet()->getStyle($columnaTitulocantidades.$filacount)->applyFromArray($stylePrecios);
								$columnaTitulocantidades= ++$columnaTitulocantidades;
							}
						}
                    }                
                }
                 
            }


            $filacount=$filacount+2;
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$filacount, 'Overall');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$filacount)->applyFromArray($styleCell);
            $filacount=$filacount+1;
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$filacount, 'Cel: 0291-6451450');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$filacount)->applyFromArray($styleCell);
            $filacount=$filacount+1;
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$filacount, 'info@tiendaoverall.com.ar');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$filacount)->applyFromArray($styleCell);
            $filacount=$filacount+1;
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$filacount, 'www.tiendaoverall.com.ar');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$filacount)->applyFromArray($styleCell);
            $filacount=$filacount+1;
           
            

            //iteramos para los resultado
            //Titulo del libro y seguridad 
            $objPHPExcel->getActiveSheet()->setTitle('PreciosOverall'.date('d-m-Y'));
            $objPHPExcel->getSecurity()->setLockWindows(true);
            $objPHPExcel->getSecurity()->setLockStructure(true);


            // Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="PreciosDistribuidorOverall.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            //

            $download = 'PreciosDistribuidorOverall.xlsx';
            $savedFile ="download/".$download ;
            if(file_exists($savedFile)) {     
                    // File doesn't exist, output error     
                    unlink($savedFile);
            }
            $objWriter->save($savedFile);
            $objWriter->save('php://output');
            //$this->response->file(WWW_ROOT.'download/'.$download, array('download' =>true, 'name' =>$download));
            

            exit;
            
            
        }

    /*** FIN DE LAS FUNCIONES PARA LA GENERACION DE LA GRILLA */

    //Calcula la plata que adeudan los clientes - Segun el tipo de pago
    
    public function deudasporcliente($clienteid=null){

        $this->layout = 'backend';
        $conditions[]=array('Factura.facturado'=>1,'Factura.entregado'=>1,'Factura.statuspago !='=>'Pagado','Factura.tipodepago !='=>'Contrareembolso');

           
            $this->Paginator->settings = array(
                'fields'=>array('user_id','email','nombre','apellido','totalclientev'),
                'conditions'=>array('Factura.facturado'=>1,'Factura.entregado'=>1,'Factura.statuspago !='=>'Pagado', 'Factura.tipodepago !='=>'Contrareembolso'),
                'recursive' => 0,
                'limit' => 80,
                'order' => array('totalclientev'=>'DESC'),
                'group' => array('user_id')
            );


            $facturas = $this->Paginator->paginate('Factura');

            $facturastotal=$this->Factura->find('all',array('fields'=>array('SUM(CAST(REPLACE(Factura.total, ",", "") AS DECIMAL(10,2))) AS totales') ,'conditions'=>$conditions,'recursive'=>-1));
            
            $facturasparciales=$this->Pago->find('all',array('fields'=>array('SUM(Pago.monto) AS totalparcial') ,'conditions'=>array('Factura.facturado'=>1,'Factura.entregado'=>1,'Factura.statuspago'=>'Pago Parcial','Factura.tipodepago !='=>'Contrareembolso','Pago.status'=>'1','Pago.tipopago_id !='=>6),'recursive'=>0));
           
       
        

        $totalfinal = $facturastotal[0][0]['totales'] - $facturasparciales[0][0]['totalparcial'];

        $this->set('facturas',$facturas);
        $this->set('totalfinal',$totalfinal);

        

    }

    public function totaldeudas($idtipopago=null){

        $this->layout = 'backend';
        $conditions[]=array('Factura.facturado'=>1,'Factura.entregado'=>1,'Factura.statuspago !='=>'Pagado');

        if ($this->request->is('post') || $this->request->is('put')) {
            
            if(!empty($this->request->data['Factura']['start'])){
                $desde=$this->request->data['Factura']['start'];
                $desde = date_create($desde);
                $desde = date_format($desde,'Y-m-d');
                $conditions['DATE(Factura.created) >='] = $desde;
            }

            if(!empty($this->request->data['Factura']['end'])){
                $hasta=$this->request->data['Factura']['end'];
                $hasta = date_create($hasta);
                $hasta = date_format($hasta, 'Y-m-d');
                $conditions['DATE(Factura.created) <='] = $hasta;
        
            }

            if(!empty($this->request->data['Pago']['tiposdepagos'])){
                $conditions['Factura.tipodepago'] = $this->request->data['Pago']['tiposdepagos'];
            }

            
           
            
            $facturastotal=$this->Factura->find('all',array('fields'=>array('SUM(CAST(REPLACE(Factura.total, ",", "") AS DECIMAL(10,2))) AS totales') ,'conditions'=>$conditions));

            $this->Paginator->settings = array(
                'conditions'=>$conditions,
                'recursive' => 1,
                'limit' => 80,
                'order' => array('Factura.id'=>'ASC')
            );
            $facturas = $this->Paginator->paginate('Factura');

            unset($conditions['Factura.statuspago !=']);
            $conditions['Factura.statuspago']='Pago Parcial';
            $facturasparciales=$this->Pago->find('all',array('fields'=>array('SUM(Pago.monto) AS totalparcial') ,'conditions'=>$conditions));

        }else{
            
            $this->Paginator->settings = array(
                'conditions'=>array('Factura.facturado'=>1,'Factura.entregado'=>1,'Factura.statuspago !='=>'Pagado'),
                'recursive' => 1,
                'limit' => 80,
                'order' => array('Factura.id'=>'ASC')
            );
            $facturas = $this->Paginator->paginate('Factura');

            $facturastotal=$this->Factura->find('all',array('fields'=>array('SUM(CAST(REPLACE(Factura.total, ",", "") AS DECIMAL(10,2))) AS totales') ,'conditions'=>$conditions,'recursive'=>-1));
            
            $facturasparciales=$this->Pago->find('all',array('fields'=>array('SUM(Pago.monto) AS totalparcial') ,'conditions'=>array('Factura.facturado'=>1,'Factura.entregado'=>1,'Factura.statuspago'=>'Pago Parcial','Pago.status'=>'1','Pago.tipopago_id !='=>6),'recursive'=>0));
           
       
        }

        $totalfinal = $facturastotal[0][0]['totales'] - $facturasparciales[0][0]['totalparcial'];
        $this->set('facturas',$facturas);
        $this->set('totalfinal',$totalfinal);

    }
	
	// Muestra todos los depositos y a que cuenta fueron, permite filtrar para saber
    public function depositobancarios(){
        $this->layout = 'backend';
        
        $conditions['Pago.tipopago_id'] = 2;
        $conditions['Pago.status']=1;
		
        if ($this->request->is('post') || $this->request->is('put')) {
            
            if(!empty($this->request->data['Pago']['start'])){
                $desde=$this->request->data['Pago']['start'];
                $desde = date_create($desde);
                $desde = date_format($desde,'Y-m-d');
                $conditions['DATE(Pago.created) >='] = $desde;
            }

            if(!empty($this->request->data['Pago']['end'])){
                $hasta=$this->request->data['Pago']['end'];
                $hasta = date_create($hasta);
                $hasta = date_format($hasta, 'Y-m-d');
                $conditions['DATE(Pago.created) <='] = $hasta;
        
            }

            if(!empty($this->request->data['Pago']['cuentabancos'])){
                $conditions['Pago.cuentabancaria_id'] = $this->request->data['Pago']['cuentabancos'];
            }
			
			if (isset($this->request->data['Pago']['pago-aceptado']) && !isset($this->request->data['Pago']['pago-cancelado'])){
                $conditions['Pago.statusdeposito']=1;
            }

            if (!isset($this->request->data['Pago']['pago-aceptado']) && (isset($this->request->data['Pago']['pago-cancelado'])) ){
                 $conditions['Pago.statusdeposito']=0;
            }
            

        }

        //lo genero para sumar todos los pagos aprobado solamente
        $conditions['Pago.status']=1;
        $pagostotal=$this->Pago->find('all',array('fields'=>array('SUM(Pago.monto) AS total','Pago.cuentabancaria_id') ,'conditions'=>$conditions,'group' =>array('Pago.cuentabancaria_id')));
        
        //se elimina para dspues mostrar un listado general

        $this->Paginator->settings = array(
            'conditions'=>$conditions,
            'recursive' => 1,
            'limit' => 100,
            'order' => array('Pago.id'=>'ASC')
        );

        $pagos = $this->Paginator->paginate('Pago');
        $this->set('pagos',$pagos);
        $this->set('pagostotal',$pagostotal);
        $this->loadModel('Cuentabancaria');
        $this->set('listacuentas',$this->Cuentabancaria->find('list',array('fields'=>array('id','banco'))));
    }
	
	
	public function depositosaccesos() {
        $this->layout = 'backenddeposito';
        $conditions['Pago.tipopago_id'] = 2;
        $conditions['Pago.status']=1;
        $conditions['Pago.cuentabancaria_id'] = array('1','2');
        if ($this->request->is('post') || $this->request->is('put')) {
            
            if(!empty($this->request->data['Pago']['start'])){
                $desde=$this->request->data['Pago']['start'];
                $desde = date_create($desde);
                $desde = date_format($desde,'Y-m-d');
                $conditions['DATE(Pago.created) >='] = $desde;
            }

            if(!empty($this->request->data['Pago']['end'])){
                $hasta=$this->request->data['Pago']['end'];
                $hasta = date_create($hasta);
                $hasta = date_format($hasta, 'Y-m-d');
                $conditions['DATE(Pago.created) <='] = $hasta;
            }

            if(!empty($this->request->data['Pago']['cuentabancos'])){
                $conditions['Pago.cuentabancaria_id'] = $this->request->data['Pago']['cuentabancos'];
            }
            
        }

        //lo genero para sumar todos los pagos aprobado solamente
        
        $pagostotal=$this->Pago->find('all',array('fields'=>array('SUM(Pago.monto) AS total','Pago.cuentabancaria_id') ,'conditions'=>$conditions,'group' =>array('Pago.cuentabancaria_id')));
        
		
		
        //se elimina para dspues mostrar un listado general

        $this->Paginator->settings = array(
            'conditions'=>$conditions,
            'recursive' => 1,
            'limit' => 200,
            'order' => array('Pago.id'=>'ASC')
        );

        $pagos = $this->Paginator->paginate('Pago');
        $this->set('pagos',$pagos);
        $this->set('pagostotal',$pagostotal);
        $this->loadModel('Cuentabancaria');
        $this->set('listacuentas',$this->Cuentabancaria->find('list',array('fields'=>array('id','banco'),'conditions'=>array('id !='=>3))));
   
    }


	// Muestra todos los depositos y a que cuenta fueron, permite filtrar para saber
    public function movimientoscheques(){
        $this->layout = 'backend';
        
        //$conditions['Pago.tipopago_id'] =3;
        $conditions['Cheque.status'] =1;
        
        if ($this->request->is('post') || $this->request->is('put')) {
            
            if(!empty($this->request->data['Cheque']['start'])){
                $desde=$this->request->data['Cheque']['start'];
                $desde = date_create($desde);
                $desde = date_format($desde,'Y-m-d');
                $conditions['DATE(Cheque.created) >='] = $desde;
            }

            if(!empty($this->request->data['Cheque']['end'])){
                $hasta=$this->request->data['Cheque']['end'];
                $hasta = date_create($hasta);
                $hasta = date_format($hasta, 'Y-m-d');
                $conditions['DATE(Cheque.created) <='] = $hasta;
        
            }
            if(!empty($this->request->data['Cheque']['nrocheque'])){
                $conditions['Cheque.nro LIKE ']='%'.$this->request->data['Cheque']['nrocheque'].'%';
            }

            
            if(!empty($this->request->data['Cheque']['estadocheque'])){
                $conditions['Cheque.estadocheque_id'] = $this->request->data['Cheque']['estadocheque'];
            }

            $order['Cheque.estadocheque_id']='ASC';
            $order['Cheque.fechacobrocheque']='ASC';

        }else{
            $order['Cheque.estadocheque_id']='ASC';
            $order['Cheque.fechacobrocheque']='ASC';
        }

       

        $this->Paginator->settings = array(
            'conditions'=>$conditions,
            'recursive' => 1,
            'limit' => 100,
            'order' => $order
        );

        $cheques = $this->Paginator->paginate('Cheque');
        $this->set('cheques',$cheques);
        $this->loadModel('Estadocheque');
        $estado=$this->Estadocheque->find('list',array('fields'=>array('id','titulo')));
        $this->set('listaestadocheque',$estado);
        $this->loadModel('Proveedore');
        $this->set('listaproveedores',$this->Proveedore->find('list',array('fields'=>array('id','nombre'))));
    }
	
	public function pedidosporoperario($idoperario=null){

        $this->layout = 'backend';
        $conditions[]=array('Factura.facturado'=>1,'Factura.entregado'=>1);
        $desde=null;
        $hasta=null;
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

            if(!empty($this->request->data['Factura']['armadopor'])){
                $conditions['Factura.armadopor'] = $this->request->data['Factura']['armadopor'];
            }

            
           
            
            $facturastotal=$this->Factura->find('count',array('conditions'=>$conditions));

            $this->Paginator->settings = array(
                'conditions'=>$conditions,
                'recursive' => 1,
                'limit' => 120,
                'order' => array('Factura.id'=>'ASC')
            );
            $facturas = $this->Paginator->paginate('Factura');

           
           
        }else{
            
            $conditions['Factura.armadopor']=array(1,2,3,4,5,6);
            $this->Paginator->settings = array(
                'conditions'=>array('Factura.facturado'=>1,'Factura.entregado'=>1,'Factura.armadopor'=>array(1,2,3,4,5,6)),
                'recursive' => 1,
                'limit' => 120,
                'order' => array('Factura.id'=>'ASC')
            );
            $facturas = $this->Paginator->paginate('Factura');

            $facturastotal=$this->Factura->find('count',array('conditions'=>$conditions,'recursive'=>-1));
            
           
       
        }

        $resultadoarmado=$this->resumenpedidosporoperarios($desde,$hasta);
       
        $this->set('facturas',$facturas);
        $this->set('resumenporoperario', $resultadoarmado);
        $this->set('totalfinal',$facturastotal);
    }

    private function resumenpedidosporoperarios($desde=null,$hasta=null){
      $operarios=array('1'=>'Marcos Correa','2'=>'Matias Medrano','3'=>'Juan Marchettini','4'=>'Pablo Martin','5'=>'Rolo Arancibia','6'=>'Leo Graton');
      $conditions['Factura.entregado'] = 1;
      $info['Operador']='';
      $info['Total']=0;
      $info['Correctos']=0;
      $info['Incorrectos']=0;

      $resultado['1']=$info;
      $resultado['2']=$info;
      $resultado['3']=$info;
      $resultado['4']=$info;
      $resultado['5']=$info;
      $resultado['6']=$info;
        if(!empty($desde)){
            $conditions['DATE(Factura.fechaenvio) >='] = $desde;
        }

        if(!empty($hasta)){
            $conditions['DATE(Factura.fechaenvio) <='] = $hasta;
        }

      foreach ($resultado as $key => $infovalue) {
          $conditions['Factura.armadopor'] = $key;
          $total=$this->Factura->find('count',array('conditions'=>$conditions));
         
          $conditions['Factura.armadocorrecto'] = 1;
          $correcto=$this->Factura->find('count',array('conditions'=>$conditions));
          
          $conditions['Factura.armadocorrecto'] = 0;
          $incorrecto=$this->Factura->find('count',array('conditions'=>$conditions));
          
		  unset($conditions['Factura.armadocorrecto']);
          $resultado[$key]['Operador']=$operarios[$key];
          $resultado[$key]['Total']=$total;
          $resultado[$key]['Correctos']=$correcto;
          $resultado[$key]['Incorrectos']=$incorrecto;
      }

      return $resultado;
    
    }

    /// GENERAR EXCEL DE MUESTRAS 
    public function generarplanillafacturante($rol=null){
        App::import('Vendor', 'PHPExcel', array('file' =>'classes/PHPExcel.php'));
        App::import('Vendor', 'Excel2007', array('file' =>'classes/PHPExcel/Writer/Excel2007.php'));

        // SE ARMAN LOS ARRAY PARA EL INFORME
        
         //$cantidadporcategorias;

            
        $this->Producto->recursive = 0;
        $productos = $this->Producto->find('all',array('fields'=>array('Producto.id','Producto.nombre','Producto.iva','Producto.codigo'),'conditions'=>array('Producto.disponible'=>1),'order'=>array('Producto.nombre'=>'ASC')));
         
        
            
        ///// FIN DEL ARMADO DE DATOS
        $muestras=array();
        $styleLabelprecio = array(
        'font'  => array(
            'bold'  => true,
            'size'  => 11,
            'name'  => 'Verdana'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        ),
        'borders' => array(
          'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          )
         ));
        $styleArray = array(
        'font'  => array(
            'bold'  => true,
            'size'  => 11,
            'name'  => 'Verdana'
        ),
        'borders' => array(
          'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          )
         )
        );
        $stylePrecios = array(
        'font'  => array(
            'bold'  => FALSE,
            'size'  => 10,
            'name'  => 'Verdana'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        ),
        'borders' => array(
          'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          )
         )
        );

        $styleCell = array(
        'font'  => array(
            'bold'  => true,
            'size'  => 13,
            'name'  => 'Verdana',
            'color' => array('rgb' => 'FFFFFF')
        ),
        'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '003FFF')
        ));  

        //objeto de PHP Excel
        $objPHPExcel = new PHPExcel();

        
        $filacount = 1;
        //algunos datos sobre autoría
        $objPHPExcel->getProperties()->setCreator("Planilla de Precios");
        $objPHPExcel->getProperties()->setLastModifiedBy("Tienda Overall");
        $objPHPExcel->getProperties()->setTitle("Planilla de Precios Overall");
        $objPHPExcel->getProperties()->setSubject("Planilla de Precios Overall");
        $objPHPExcel->getProperties()->setDescription("Planilla de Precios Tiendaoverall.com.ar");

        //Trabajamos con la hoja activa principal
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        

        $categoriaid='-1';
        $filaTitulocantidades=-1;

        $objPHPExcel->getActiveSheet()->SetCellValue("A".$filacount,'CODIGO');
        $objPHPExcel->getActiveSheet()->SetCellValue("B".$filacount,'DESCRIPCION');
        $objPHPExcel->getActiveSheet()->SetCellValue("C".$filacount,'IVADEFECTO');
        $objPHPExcel->getActiveSheet()->SetCellValue("D".$filacount,'PRECIOUNITARIO');
        $objPHPExcel->getActiveSheet()->SetCellValue("E".$filacount,'IDPUBLICACIONEXTERNA');
        $objPHPExcel->getActiveSheet()->SetCellValue("F".$filacount,'SOFTWAREEXTERNO');
        
        foreach ($productos as $catseccion) {
                $filacount=$filacount+1;
                $filaTitulocantidades=$filacount;
               
                $objPHPExcel->getActiveSheet()->SetCellValue("A".$filacount, $catseccion['Producto']['codigo']);
                $objPHPExcel->getActiveSheet()->SetCellValue("A".$filacount, $catseccion['Producto']['nombre']);
                $objPHPExcel->getActiveSheet()->SetCellValue("C".$filacount, $catseccion['Producto']['iva']);
                $objPHPExcel->getActiveSheet()->SetCellValue("D".$filacount, 1);
                $objPHPExcel->getActiveSheet()->SetCellValue("E".$filacount, $catseccion['Producto']['id']);
                $objPHPExcel->getActiveSheet()->SetCellValue("F".$filacount, 'Sistema Web');
                           
        }


             
        

        //iteramos para los resultado
        //Titulo del libro y seguridad 
        $objPHPExcel->getActiveSheet()->setTitle('ProductosServicios');
        $objPHPExcel->getSecurity()->setLockWindows(true);
        $objPHPExcel->getSecurity()->setLockStructure(true);


        // Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="ProductosServicios.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //

        $download = 'ProductosServicios.xlsx';
        $savedFile ="download/".$download ;
        if(file_exists($savedFile)) {     
                // File doesn't exist, output error     
                unlink($savedFile);
        }
        $objWriter->save($savedFile);
        $objWriter->save('php://output');
        //$this->response->file(WWW_ROOT.'download/'.$download, array('download' =>true, 'name' =>$download));
        

        exit;
        
        
    }
}