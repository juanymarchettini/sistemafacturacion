<?php echo $this->Element('backend/headerpage',array('titleheader'=>'Pedidos Realizados','shorturl'=>'Lista de Pedidos')); ?>
<?php echo $this->Html->css(array('vendor/chartist/chartist')); ?>

<div class="row">
    <!-- Seccion perfil Izquierdo -->
    <div class="col-md-4 col-lg-3">
      
        <section class="panel">
            <div class="panel-body">
                <div class="thumb-info mb-md">

                    <?php 
                        echo $this->Html->image('usernuevo.jpg', array('class'=>"rounded img-responsive" )); 
                    ?>
                    
                    <div class="thumb-info-title">
                        <span class="thumb-info-inner"><?php  echo (isset($this->request->data['User']['nombre']))? '' : '- - - - - '; ?></span>
                        <span class="thumb-info-type"><?php echo (isset($this->request->data['User']['username']))? $this->request->data['User']['username'] : '------'; ?></span>
                    </div>
                </div>

                <div class="widget-toggle-expand mb-md">
                    <div class="widget-header">
                        <h6>Info Cliente</h6>
                        <div class="widget-toggle">+</div>
                    </div>
                    <div class="widget-content-collapsed">
                        <div class="progress progress-xs light">
                            <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                60%
                            </div>
                        </div>
                    </div>
                    <div class="widget-content-expanded">
                        <ul class="simple-todo-list">
                            <li class="completed">Nro Cliente: <?php echo (isset($this->request->data['User']['id']))? $this->request->data['User']['id'] : '- - - '; ?> </li>
                           <li class="completed">Email: <?php echo (isset($this->request->data['User']['username']))? $this->request->data['User']['username'] : '- - - - - '; ?> </li>
                            <li class="completed">Cuit: <?php echo (isset($this->request->data['Transporte']['cuit']))? $this->request->data['User']['telefono'] : '- - - - - '; ?> </li>
                            <li class="completed">Direccion: <?php echo (isset($this->request->data['User']['localidad']))? $this->request->data['User']['localidad'] : '- - - - - '; ?> </li>
                            <li class="completed">Direccion: <?php echo (isset($this->request->data['User']['direccion']))? $this->request->data['User']['direccion'] : '- - - - - '; ?> </li>
                            <li class="completed">Tel: <?php echo (isset($this->request->data['Transporte']['tel']))? $this->request->data['Transporte']['tel'] : '- - - - - '; ?> </li>
                            
                            
                        </ul>
                    </div>
                </div>

                <hr class="dotted short">
                

            </div>
        </section>


        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                    
                </div>

                <h2 class="panel-title">
                    <span class="label label-primary label-sm text-weight-normal va-middle mr-sm"></span>
                    <span class="va-middle">Rol de Usuario</span>
                    <?php echo $this->Form->create('User', array(
                        'inputDefaults' => array(
                            'div' => 'form-group col-md-12',
                            'wrapInput' => false,
                            'class' => 'form-control'
                        ),
                        'class' => false
                    ));
                    ?>
                </h2>

            </header>
            <div class="panel-body">
                <div class="content">
                    
                    <div col='col-md-12'>
                    <?php 
                        echo $this->Form->hidden('id');
                        echo $this->Form->input('role', array('label'=>false,'options'=>array('admin'=>'Admin', 'mayorista'=>'Mayorista','distribuidor'=>'Distribuidor','transporte'=>'Transporte')));
                    ?>
                    </div>
                    
                    <div class="text-right">
                        <?php 
                            echo $this->Form->submit(__('Guardar'),array('class'=>'mb-xs mt-xs mr-xs btn btn-primary'));
                        ?>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                
            </div>
        </section>

       

    </div>
    <div class="col-md-8 col-lg-9">
        <div class="col-md-12 col-lg-6 col-xl-12">
            <section class="panel panel-featured-left panel-featured-tertiary">
                <div class="panel-body">
                    <div class="widget-summary">
                        <div class="widget-summary-col widget-summary-col-icon">
                            <div class="summary-icon bg-tertiary">
                                <i class="fa fa-shopping-cart"></i>
                            </div>
                        </div>
                        <div class="widget-summary-col">
                            <div class="summary">
                                <h4 class="title">Facturas Pendientes</h4>
                                <div class="info">
                                    <strong class="amount"><?php echo $facturasadeudadas;?></strong>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-md-12 col-lg-6 col-xl-12">
            <section class="panel panel-featured-left panel-featured-secondary">
                <div class="panel-body">
                    <div class="widget-summary">
                        <div class="widget-summary-col widget-summary-col-icon">
                            <div class="summary-icon bg-secondary">
                                <i class="fa fa-usd"></i>
                            </div>
                        </div>
                        <div class="widget-summary-col">
                            <div class="summary">
                                <h4 class="title">Monto Adeudado</h4>
                                <div class="info">
                                    <strong class="amount">$ <?php echo number_format($totaladeudadas,2); ?></strong>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-md-12 col-lg-6 col-xl-12">
            <section class="panel panel-featured-left panel-featured-tertiary">
                <div class="panel-body">
                    <div class="widget-summary">
                        <div class="widget-summary-col widget-summary-col-icon">
                            <div class="summary-icon bg-tertiary">
                                <i class="fa fa-bar-chart"></i>
                            </div>
                        </div>
                        <div class="widget-summary-col">
                            <div class="summary">
                                <h4 class="title">Historial de Pagos</h4>
                                <div class="info">
                                   
                                </div>
                            </div>
                            <div class="summary-footer">
                                <a class="text-muted text-uppercase"><?php echo $this->Html->link('(Ver Mas..)',array('controller'=>'Pagos','action'=>'listadepagos',$this->request->data['User']['id']));?></a>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <div class="panel-actions">
                                <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                            </div>
                            <h2 class="panel-title">Ventas en el Año</h2>
                            <p class="panel-subtitle">Cantidad de Facturado (Y) por Mes (X), por el cliente</p>
                        </header>

                                    <div class="panel-body">
                                        <div id="ChartistLineChartWithArea" class="ct-chart ct-perfect-fourth ct-golden-section"></div>
                        
                                        <!-- See: assets/javascripts/ui-elements/examples.charts.js for the example code. -->
                                    </div>
                                
                    </section>
                </div>
            </div>
        </div>
    </div>
   
</div>

<section class="panel panel-featured panel-featured-info">
	<header class='panel-heading'>
		<h2 class="panel-title">Facturas del Cliente</h2>
	</header>
	<?php echo $this->element('backend/facturas/listafacturas'); ?>
</section>


<style type="text/css">
.cancelada{
	background-color:red;
	color: #fff;
}
.entregado{
	background-color: #36B500;
}
.entregado td{
	color: #fff;
}
.entregado b{
	color:#000;
}
.actions{
	text-align: center;
}
</style>
<?php echo $this->Html->script(array('vendor/chartist/chartist')); ?>
<script type="text/javascript">

var labelslist = <?php echo  json_encode($listamesventas); ?>;
var listaseries = <?php echo json_encode($listameses);  ?>; 
console.log(listaseries);
console.log(labelslist);
    (function() {
        new Chartist.Line('#ChartistLineChartWithArea', {
            labels: listaseries,
            series: [labelslist]
            
        }, {
            low: 0,
            showArea: true
        });
    })();

</script>



