 <header class="header">
    <div class="logo-container">
      <a href="../" class="logo">
        <?php echo $this->Html->image('logo.png',array('height'=>'35px', 'alt'=>'Overall')); ?>
        
      </a>
      <div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
        <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
      </div>
    </div>
  
    <!-- start: search & user box -->
    <div class="header-right">
      <form action="/Productos/lista" id="Buscarprincipal" class="search nav-form">
        <div class="input-group input-search">
          <input type="text" class="form-control" name="busqueda" id="q" placeholder="Productos...">
          <span class="input-group-btn">
            <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
          </span>
        </div>
      </form>
      <form action="/Users/lista" id="Clientesprincipal" class="search nav-form">
        <div class="input-group input-search">
          <input type="text" class="form-control" name="search" id="q" placeholder="Clientes...">
          <span class="input-group-btn">
            <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
          </span>
        </div>
      </form>

      <form action="/Facturas/listartodo" id="Searchprincipal" class="search nav-form">
        <div class="input-group input-search">
          <input type="text" class="form-control" name="search" id="q" placeholder="Pedidos/Facturas...">
          <span class="input-group-btn">
            <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
          </span>
        </div>
      </form>


  
      <span class="separator"></span>
      <ul class="notifications">
          <li>
            <?php if ($nrocontrasinasignar>0){ ?>
                      <?php echo $this->Html->link('<i class="fa fa-truck"></i><span class="badge">'.$nrocontrasinasignar.'</span>',array('controller'=>'facturas','action'=>'facturascontrareembolsosinasignar'),array('class'=>"notification-icon", 'escape'=>false));
            ?>
            <?php  
            }else{?>
            <a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown">
              <i class="fa fa-truck"></i>
              <span class="badge"></span>
            </a>
            <?php } ?>
          </li>
          <li>
            <?php if ($nropagospendientesdeaprobacion>0){ ?>
                      <?php echo $this->Html->link('<i class="glyphicon glyphicon-usd"></i><span class="badge">'.$nropagospendientesdeaprobacion.'</span>',array('controller'=>'Transportes','action'=>'contrareembolsos'),array('class'=>"notification-icon", 'escape'=>false));
            ?>
            <?php  
            }else{?>
            <a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown">
              <i class="glyphicon glyphicon-usd"></i><span class="badge"></span>
            </a>
            <?php } ?>
            
          </li>
          
            <li>
              <a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown">
                <i class="fa fa-download"></i>
                <span class="badge">Listas</span>
              </a>

              
      
              <div class="dropdown-menu notification-menu">
                <div class="notification-title">
                  <span class="pull-right label label-default">2</span>
                  Listas Precios
                </div>
      
                <div class="content">
                  <ul>
                    <li>
                      <?php echo $this->Html->link('<div class="image"><i class="fa fa-cloud-download  bg-info"></i></div><span class="title">Lista de Precios</span>',array('controller'=>'informes','action'=>'generarplanillaprecios'),array('class'=>"clearfix", 'escape'=>false));
                      ?>
                    </li>
                    <li>
                      <?php echo $this->Html->link('<div class="image"><i class="fa fa-cloud-download  bg-info"></i></div><span class="title">Lista Distribuidor</span>',array('controller'=>'informes','action'=>'generarplanillapreciosdistribuidor'),array('class'=>"clearfix", 'escape'=>false));
                      ?>
                      
                    </li>
                    
                  </ul>
      
                 
                </div>
              </div>
            
          </li>
      </ul>
    
        <span class="separator"></span>
  
      
  
      <div id="userbox" class="userbox">
        <a href="#" data-toggle="dropdown">
          <figure class="profile-picture">
            <?php echo $this->Html->image('usernuevo.jpg', array('class'=>'img-circle')); ?>
            
          </figure>
          <div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@okler.com">
            <span class="name"><?php echo $this->Session->read('Auth.User.username'); ?></span>
            <span class="role"><?php echo $this->Session->read('Auth.User.role'); ?></span>
          </div>
  
          <i class="fa custom-caret"></i>
        </a>
  
        <div class="dropdown-menu">
          <ul class="list-unstyled">
            <li class="divider"></li>
            <li>
              <a role="menuitem" tabindex="-1" href="#"><i class="fa fa-user"></i> My Profile</a>
            </li>
            
            <li>
              <?php echo $this->Html->link('<i class="fa fa-power-off"></i> Logout',array('controller'=>'Users','action'=>'logout'),array('escape'=>false, 'role'=>"menuitem", 'tabindex'=>"-1"));
            ?>
              
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- end: search & user box -->
</header>