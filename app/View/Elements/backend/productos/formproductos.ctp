<?php echo $this->Element('backend/headerpage',array('titleheader'=>'Productos','shorturl'=>$label)); ?>
<div style="clear:both;"></div>
<?php
    echo $this->Form->create('Producto', array(
    'type'=>'file',
    'id'=>'Productosformulario',
    'inputDefaults' => array(
        'div' => 'form-group',
        'wrapInput' => false,
        'class' => 'form-control'
    ),
    'class' => false
)); ?>

<div class="row">
    <!-- Seccion perfil Izquierdo -->
    <div class="col-md-4 col-lg-3">
      
        <section class="panel">
            <div class="panel-body">
                <div class="thumb-info mb-md">

                    <?php 
                        echo (isset($this->request->data['Producto']['imagen1']) && (!empty($this->request->data['Producto']['imagen1']))) ?
                            $this->Html->image('productos/'.$this->request->data['Producto']['imagen1'], array('class'=>"rounded img-responsive" )) : $this->Html->image('imgnodisponible.png', array('class'=>"rounded img-responsive" )); 
                    ?>
                    
                    <div class="thumb-info-title">
                        <span class="thumb-info-inner"><?php echo (isset($this->request->data['Producto']['nombre']))? $this->request->data['Producto']['nombre'] : '- - - - - '; ?></span>
                        <span class="thumb-info-type"><?php echo (isset($this->request->data['Producto']['disponible']))? 'Disponible' : 'NO Disponible'; ?></span>
                    </div>
                </div>

                <div class="widget-toggle-expand mb-md">
                    <div class="widget-header">
                        <h6>Info Producto</h6>
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
                           <li class="completed">Nombre: <?php echo (isset($this->request->data['Producto']['nombre']))? $this->request->data['Producto']['nombre'] : '- - - - - '; ?> </li>
                            <li class="completed">Status Disponible Ok</li>
                            <li class="completed"> Stock:<?php echo (isset($this->request->data['Producto']['stock']))? $this->request->data['Producto']['stock'] : '- - '; ?></li>
                            
                        </ul>
                    </div>
                </div>

                <hr class="dotted short">
                <div class="clearfix">
                    <button type="submit"  class="btn btn-primary hidden-xs">Guardar Cambios</button>
                    
                </div>

            </div>
        </section>


        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                    
                </div>

                <h2 class="panel-title">
                    <span class="label label-primary label-sm text-weight-normal va-middle mr-sm">$</span>
                    <span class="va-middle">Precios</span>
                </h2>
            </header>
            
            <div class="panel-footer">
                
            </div>
        </section>

       

    </div>
    <!-- Fin perfil Izquierdo -->
    <div class="col-md-8 col-lg-9">

        <div class="tabs">
            <ul class="nav nav-tabs tabs-primary">
                <li class="active">
                    <a href="#overview" data-toggle="tab">Datos Producto</a>
                </li>
                <li>
                    <a href="#edit" data-toggle="tab">Imagenes</a>
                </li>


            </ul>
            <div class="tab-content">
                <div id="overview" class="tab-pane active">
                    <h4 class="mb-md"><?php echo $label ?></h4>
                    <fieldset>
                       
                    <?php
                        echo $this->Form->input('id');
                        echo $this->Form->input('categoria_id',array('label'=>'Categoria','type'=>'select','options'=>$categorias,'required'=>'required','empty'=>'Seleccione Categoria'));
                        echo $this->Form->input('nombre',array('label'=>'Nombre del Producto','required'));
                        echo $this->Form->input('codigo',array('label'=>'Código','required'));
                        echo $this->Form->input('descripcion',array('label'=>'Descripción del Producto','required'=>false));

                        echo $this->Form->input('disponible',array('label'=>'Disponibilidad: ', 'options'=>array('0'=>'No disponible','1'=>'Disponible'),'empty'=>'Disponible/No disponible'));
                        
                        echo $this->Form->input('stock',array('label'=>'Stock: ','required'=>'required'));

                        echo $this->Form->input('preciocompra',array('label'=>'Costo del Producto Neto (s/Iva) $: ','type'=>"number", 'step'=>"any", 'min'=>0,'required'));
                        echo $this->Form->input('iva',array('label'=>'Iva: ','options'=>array('21'=>'21%','10.5'=>'10,5%','0'=>'0%')));
                        echo $this->Form->input('precio',array('label'=>'Precio de Venta Neto (s/Iva) $: ','required'));

                        echo $this->Form->input('orden',array('label'=>'Orden (DOS LETRAS+3 DIG EJ: aa-001', 'data-plugin-masked-input data-input-mask'=>"aa-999", 'placeholder'=>"AA-001"));
                    ?>

                       
                    </fieldset>
                    
                </div>
                <div id="edit" class="tab-pane">
                        <h4 class="mb-xlg"><?php echo __('Imagenes'); ?></h4>
                        <fieldset>
                            <?php
                                echo $this->Form->input('imagen1',array('label'=>'Foto 1','type'=>'file'));
                                if (!empty($this->request->data['Producto']['imagen1'])){
                                echo $this->Html->image('productos/'.$this->request->data['Producto']['imagen1'],array('height'=>80 ,'class'=>'img_listado'));
                                }
                                echo $this->Form->input('imagen2',array('label'=>'Foto 2','type'=>'file'));
                                if (!empty($this->request->data['Producto']['imagen2'])){
                                echo $this->Html->image('productos/'.$this->request->data['Producto']['imagen2'],array('height'=>80 ,'class'=>'img_listado'));
                                }
                                echo $this->Form->input('imagen3',array('label'=>'Foto 3','type'=>'file'));
                                if (!empty($this->request->data['Producto']['imagen3'])){
                                echo $this->Html->image('productos/'.$this->request->data['Producto']['imagen3'],array('height'=>80 ,'class'=>'img_listado'));
                                }
                                echo $this->Form->input('imagen4',array('label'=>'Foto 4','type'=>'file'));
                                if (!empty($this->request->data['Producto']['imagen4'])){
                                echo $this->Html->image('productos/'.$this->request->data['Producto']['imagen4'],array('height'=>80 ,'class'=>'img_listado'));
                                }
                            ?>
                        </fieldset>
                 <?php echo $this->Form->submit(__('Guardar'), array('class' => 'btn btn-primary', 'id'=>'jq_submit'));
                echo $this->Form->end();
                  ?>
                </div>
                

            </div>
    </div>
    

</div>

<?php 
    echo $this->Html->script(array('vendor/jquery-maskedinput/jquery.maskedinput'));

?>
<script type="text/javascript">

$( "#jq_newsubmit" ).click(function() {
  $('#Productosformulario').submit();
});
</script>