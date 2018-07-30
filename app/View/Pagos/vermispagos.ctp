<?php
 echo $this->Html->css(array("vendor/magnific-popup/magnific-popup" ));
?>
<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><?php echo $this->Html->link('Menú',array('controller'=>'categorias', 'action'=>'home')); ?></li>
				  <li class="active">Ver Historial de Pagos</li>
				  <li ><?php echo $this->Html->link('Lista de Pedidos',array('controller'=>'Facturas', 'action'=>'mispedidos')); ?></li>
				</ol>
			</div>
			<div class="review-payment">
				<h2>Historial de Pagos</h2>
			</div>
			 <div class="col-xs-12 col-md-12">
        
            <section class="panel">
                
               <div class="table-responsive cart_info">
                    <table class="table table-condensed">
                        <thead>
                            <tr class="cart_menu">
                                <th class="hidden-xs hidden-sm"><?php echo $this->Paginator->sort('id','Nro Pago');?></th>
                                <th class="text-right">Fact</th>
                                <th class="text-right hidden-xs hidden-sm"><?php echo $this->Paginator->sort('tipopago_id','Tipo de Pago'); ?></th>
                                <th class="text-right hidden-lg hidden-md"><?php echo $this->Paginator->sort('tipopago_id','T. Pago'); ?></th>
                                <th class="text-center">$</th>
                                <th class="text-right "><?php echo $this->Paginator->sort('nrocheque','Cheque');?></th>
                                <th class="text-right "><?php echo $this->Paginator->sort('created','Fecha');?></th>
                               
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($pagos as $pago) { ?>

                            <tr>
                                <td class="hidden-xs hidden-sm"><?php echo $pago['Pago']['id']; ?></td>
                                <td class="text-right"><?php echo $this->Html->link('F-'.$pago['Pago']['factura_id'], array('controller'=>'Facturas', 'action'=>'vermispedidos',$pago['Pago']['factura_id']),array('target'=>'_blank')); ?></td>
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
                            echo $this->Paginator->prev('< ' . __('Anterior - '), array(), null, array('class' => 'prev disabled'));
                            echo $this->Paginator->numbers(array('separator' => ' - '));
                            echo $this->Paginator->next(__(' - Siguiente') . ' >', array(), null, array('class' => 'next disabled'));
                        ?>
                    </div>
                </div>
            </section>
    </div>
		</div>
	</section> <!--/#cart_items-->

	<style type="text/css">
	 thead a, thead a:hover{color: #fff}

	</style>





<style type="text/css">
.white-popup {
  position: relative;
  background: #FFF;
  
  width: auto;
  max-width: 500px;
  margin: 20px auto;
}

</style>
<script type="text/javascript">
$('.open-popup-link').magnificPopup({
  type:'inline',
  midClick: true 
});

</script>