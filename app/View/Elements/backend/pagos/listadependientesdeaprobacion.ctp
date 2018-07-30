<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
        </div>
        <h2 class="panel-title">Mas de 21 días</h2>
        <p class="panel-subtitle">Pedidos con Mas de 21 días de entrega.</p>
    </header>
     <div class="panel-body">
        <section  class="col-md-12">
            <fieldset>
                <legend><?php echo __('Historial de Pagos de la Factura'); ?></legend>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tr>
                                <th>Tipo de Pago</th>
                                <th>Datos Cheque</th>
                                <th>Monto ($)</th>
                                <th>Fecha de Pago</th>
                                <th>Modificado</th>
                                <th>Estado</th>
                                <th>Realizado Por</th>
                                <th>Info Extra</th>
                                
                                <th class="actions"><?php echo __('Cancelar'); ?></th>
                        </tr>
                        <?php foreach ($pagos as $pago): ?>
                        <tr>
                            <td><?php echo h($listatipodepagos[$pago['Pago']['tipopago_id']]); ?>&nbsp;</td>
                            <td><?php echo h($pago['Pago']['nrocheque']); ?>&nbsp;</td>
                            <td><?php echo h($pago['Pago']['monto']); ?>&nbsp;</td>
                            <td><?php echo h($pago['Pago']['created']); ?>&nbsp;</td>
                            <td><?php echo h($pago['Pago']['modified']); ?>&nbsp;</td>
                            <td><?php echo ($pago['Pago']['status']=='0')? '<b>Cancelado</b>' : 'Ok'; ?>&nbsp;</td>
                            <td><?php echo h($listaoperadores[$pago['Pago']['operador_id']]); ?>&nbsp;</td>
                            <td><?php echo h($pago['Pago']['infoextra']); ?>&nbsp;</td>
                            <td class="actions">
                                <?php echo $this->Html->link('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $pago['Pago']['id']), array('escape'=>false), __('¿Estás seguro que deseas cancelar  %s?',$pago['Pago']['monto'])); ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                    
                </div>
        
            </fieldset>
            
        </section>
    </div>
</section>
                            