<?php
    echo $this->Html->css(array('vendor/select2/select2','vendor/select2/select2-bootstrap','vendor/bootstrap-multiselect/bootstrap-multiselect'));
?>

<?php echo $this->Element('backend/headerpage',array('titleheader'=>'Historial de Pagos','shorturl'=>'Lista de Pagos')); ?>


<div class="row">
    <!-- Seccion perfil Izquierdo -->
    <div class="col-xs-12 col-md-4 col-lg-3">
      
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
    <div class="col-xs-12 col-md-8 col-lg-9">
        <div class="col-md-12 col-lg-6 col-xl-12">
                <section class="panel panel-featured-left panel-featured-tertiary">
                    <div class="panel-body">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-tertiary">
                                    <i class="fa fa-user"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title">Volver a la Cuenta</h4>
                                    <div class="info">
                                       Información detallada
                                    </div>
                                </div>
                                <div class="summary-footer">
                                    <a class="text-muted text-uppercase"><?php echo $this->Html->link('(Ver Mas..)',array('controller'=>'Facturas','action'=>'listaporclientes',$this->request->data['User']['id']));?></a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </section>
        </div>
    </div>
    <div class="col-xs-12 col-md-8 col-lg-9">
        
            <section class="panel">
                <header class="panel-heading">           
                    <h2 class="panel-title">Historial de Pagos</h2>
                   
                        <div class="col-xs-12 col-md-12">
                            <?php
                                //debug($this->request->data);
                                //if (isset($this->request->data)){debug($this->request->data);}
                                echo $this->Form->create('Pago', array(
                                'action'=>'caja',
                                
                                'inputDefaults' => array(
                                    'div' => 'form-group',
                                    'wrapInput' => false,
                                    'class' => 'form-control'
                                ),
                                'class' => false
                            )); 
                             echo $this->Form->hidden('user_id',array('value'=>$this->request->data['User']['id']));
                             ?>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Reango de Fechas</label>
                                <div class="col-md-6">
                                    <div class="input-daterange input-group" data-plugin-datepicker>
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <?php if(isset($this->request->data['Pago']['start'])){ ?>
                                                <input type="text" value=<?php echo $this->request->data['Pago']['start']; ?> class="form-control" name="data[Pago][start]">
                                    <?php }else{ ?>
                                                <input type="text" class="form-control" name="data[Pago][start]">
                                    <?php } ?>
                                        <span class="input-group-addon">Hasta</span>
                                         <?php if(isset($this->request->data['Pago']['end'])){ ?>
                                                <input type="text" value=<?php echo $this->request->data['Pago']['end']; ?> class="form-control" name="data[Pago][end]">
                                    <?php }else{ ?>
                                           <input type="text" class="form-control" name="data[Pago][end]">
                                    <?php } ?>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Tipos de Pago</label>
                                <div class="col-md-6">
                                    <select class="form-control" multiple="multiple" data-plugin-options='{ "maxHeight": 200 }' name="data[Pago][tiposdepagos][]" data-plugin-multiselect id="ms_example2">
                                        <?php foreach ($listatipodepagos as $key => $tipopago) { ?>
                                            
                                                <?php echo '<option value="'.$key.'" selected>'.$tipopago.'</option>'; ?>
                                                
                                        <?php } ?>
                                    </select>
                                </div>

                            </div>
                            
                            <?php
                                echo $this->Form->submit(__('Buscar'),array('class'=>'mb-xs mt-xs mr-xs btn btn-default'));
                                echo $this->Form->end();
                            ?>
                                            
                                        
                        </div>
                    <div style="clear:both"></div>
                </header>
                <div class="panel-body">
                    <table class="table table-bordered table-striped table-condensed mb-none">
                        <thead>
                            <tr>
                                <th class="hidden-xs hidden-sm"><?php echo $this->Paginator->sort('id','Nro Pago');?></th>
                                <th class="text-right">Fact</th>
                                <th class="text-right hidden-xs hidden-sm"><?php echo $this->Paginator->sort('tipopago_id','Tipo de Pago'); ?></th>
                                <th class="text-right hidden-lg hidden-md"><?php echo $this->Paginator->sort('tipopago_id','T. Pago'); ?></th>
                                <th class="text-center">$</th>
                                <th class="text-right "><?php echo $this->Paginator->sort('nrocheque','Cheque');?></th>
                                <th class="text-right "><?php echo $this->Paginator->sort('created','Fecha');?></th>
                                <th class="text-right"><?php echo $this->Paginator->sort('status','Estado');?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($pagos as $pago) { ?>

                            <tr>
                                <td class="hidden-xs hidden-sm"><?php echo $pago['Pago']['id']; ?></td>
                                <td class="text-right"><?php echo $this->Html->link('F-'.$pago['Pago']['factura_id'], array('controller'=>'Facturas', 'action'=>'view',$pago['Pago']['factura_id']),array('target'=>'_blank')); ?></td>
                                <td class="text-right hidden-xs hidden-sm"><?php echo $listatipodepagos[$pago['Pago']['tipopago_id']]; ?></td>
                                <td class="text-right hidden-lg hidden-md">
                                <?php 
                                    switch ($pago['Pago']['tipopago_id']) {
                                        case 1:
                                            echo 'EFEC';
                                            break;
                                        case 2:
                                            echo 'DEPO';
                                            break;
                                        case 3:
                                            echo 'CHEQ';
                                            break;

                                        case 4:
                                            echo 'CONTRA';
                                            break;
                                        case 5:
                                            echo 'MP';
                                            break;
                                        case 6:
                                            echo 'AJUSTE';
                                            break;
                                        
                                        default:
                                            echo '--';
                                            break;
                                    }

                                ?>
                                </td>
                                <td class="text-right"><?php echo $pago['Pago']['monto']; ?></td>
                                <td class="text-right"><?php echo $pago['Pago']['nrocheque']; ?></td>
                                <td class="text-right "><?php  echo h(date_format(date_create($pago['Pago']['created']), 'd-m-Y')); ?>&nbsp;</td>
                                <td class="text-right"><?php echo ($pago['Pago']['status'])? 'Ok' : 'CANCE'; ?></td>
                            </tr>
                           
                        <?php } ?>
                            
                            
                           
                        </tbody>
                    </table>
                    <?php
                        echo $this->Paginator->counter(array(
                        'format' => __('Página {:page} de {:pages}')
                        ));
                        ?>  </p>
                        <div class="paging pagination">
                            <?php
                                $this->Paginator->options(array('url' => $this->passedArgs));
                                echo $this->Paginator->prev('< ' . __('Anterior'), array(), null, array('class' => 'prev disabled'));
                                echo $this->Paginator->numbers(array('separator' => ''));
                                echo $this->Paginator->next(__('Siguiente') . ' >', array(), null, array('class' => 'next disabled'));
                            ?>
                        </div>
                </div>
            </section>
    </div>
    
   
</div>

<?php
echo $this->Html->script(array('vendor/select2/select2', 'vendor/bootstrap-multiselect/bootstrap-multiselect' ));
?>

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
