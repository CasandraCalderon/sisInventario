<?php 
  
  if (isset($_GET['factura'])) 
  {
    $estadop=$_POST["estadop"];
    $idp=$_GET["idp"]; 

     $sql4="UPDATE `payments` SET `state_payment` = 'proceso',`date_pago` = '$hoy',`id_accounts_id_payments` = '$estadop' WHERE `payments`.`id_payments` = '$idp';";  
      $bd->consulta($sql4);
       echo '<div class="alert alert-success alert-dismissable">
            <i class="fa fa-check"></i>
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
              </button>
                <b>Bien!</b>Factura Registrada Correctamente.  ';
       echo '</div>';

  } 
  if (isset($_GET['guarda'])) 
  { 

  
      //insert a la tabla de registro de pagos 
      $sql="INSERT INTO `payments` (`id_payments`, `state_payment`, `date_payment`, `id_user_id_payments`, `id_accounts_id_payments`) VALUES (NULL, 'pendiente', '$hoy', '$idlog', '4');";  
      $bd->consulta($sql);

                          //consulta del ultimo registro de base de datos para insertar en el carrito
                        $consulta3="SELECT MAX(id_payments) as idpaymen FROM payments";
                            $bd->consulta($consulta3);
                            if ($fila3=$bd->mostrar_registros()) { 
                             $idpaymen=$fila3->idpaymen;      
                          }
    //recorrer el carro para insertar los datos 
  if(isset($_SESSION["products"]) && count($_SESSION["products"])>0)
  {
    $total      = 0;
    $list_tax     = '';
    foreach($_SESSION["products"] as $product)
    { 
      $product_name = $product["name_service"];
      $product_qty = $product["product_qty"];
      $product_price = $product["price_service"];
      $product_code = $product["id_service"];
      $product_color = $product["product_color"];
      $product_size = $product["product_size"];
      
      $nombre   =  $product_name; 
      "</br>";
      $cantidad =  $product_qty; 
      "</br>";
      $product_price;
      "</br>";            
      //guardar en car 
       $sql2="INSERT INTO `car` (`id_car`, `id_service_car`, `cantidacar`, `id_payment_id_car`, `costo_car`) VALUES (NULL, $product_code, $cantidad, $idpaymen, $product_price);";  
       $bd->consulta($sql2);
     
    }
    ################# Remover producto de carrito ################

     if(isset($_GET["guarda"]) && isset($_SESSION["products"]))
      {
        //borrar carrito despues de guardar
        $_SESSION["products"] = null;
      }

  }
    echo '<div class="alert alert-success alert-dismissable">
            <i class="fa fa-check"></i>
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
              </button>
                <b>Bien!</b>Factura Guardada Correctamente.';
    echo '</div>';

  } 
?>


    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption font-dark">
                <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase">tus Factura Sr(a)<b style="color: #2889b9"> 
                    <?php echo  $nombrelog ?> </b>
                    </span>
            </div>
                <div class="tools"></div>
        </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
                    <thead>
                        <tr>
                        <th class="all sorting_desc" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" aria-label="Codigo de Factura: Activar para ordenar la columna ascendente" style="width: 210px;" aria-sort="descending">Codigo de Factura</th>
                            
                            <th class="min-phone-l">Fecha emision</th>
                            <th class="min-phone-l">Estado</th>
                            <th class="none"></th>
                        </tr>
                    </thead>
                         <tbody>
                        <?php  
                                 
                                 //consulta de lista de facturas
                            $consulta="SELECT * FROM payments WHERE id_user_id_payments=$idlog ORDER BY id_payments DESC";
                            $resultado =$bd-> consulta($consulta); 
                            if ($bd->numeroFilas() > 0) { 
                            $bd->consulta($consulta);
                            while ($fila=$bd->mostrar_registros()) { 
                            $id=$fila->id_payments;                                
                                ?>  
                            <tr data-id="<?php echo  $id ?>">
                                <td><?php echo  $fila->id_payments; ?></td>
                                <td><?php echo  $fila->date_payment; ?></td>
                                
                                <td><?php  $p=$fila->state_payment;
                                    if($p=="proceso"){
                                       echo "<p style='color: orange'> Procesando </p>";
                                    }elseif ($p=="aceptado") {
                                        echo "<p style='color: green'> Aprovado</p>";
                                        # code...
                                    }elseif($p=="pendiente"){
                                         echo "<p style='color: red'> Pendiente</p>";
                                    }else{
                                          echo "<p style='color: red'> Pendiente</p>";
                                    }
                                      ?>
                                </td>
                                <td>
                                 <a class="btn red btn-outline sbold derecha" data-toggle="modal" href="#factura<?php echo  $fila->id_payments; ?>">Ver Factura </a>
                                 <?php 
                                 if($p=="pendiente"){
                                 ?>
                                 <a class="btn red btn-outline sbold derecha" data-toggle="modal" href="#r<?php echo  $fila->id_payments; ?>">Registrar Factura</a>
                                 <?php
                                 } 
                                 ?>
                               </td>
                            </tr>

<div class="modal fade" id="r<?php echo  $fila->id_payments; ?>" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
              <h4 class="modal-title">Registrar pago de factura N: <?php echo  $idpago=$fila->id_payments; ?>  </h4>
        </div>
          <div class="modal-body">
             <?php 
        $consulta3="SELECT * FROM payments INNER JOIN user ON payments.id_user_id_payments= user.id_user INNER JOIN car ON car.id_payment_id_car=payments.id_payments INNER JOIN service ON car.id_service_car=service.id_service INNER JOIN administrador ON user.id_admin_id_user=administrador.id_administrador WHERE id_payments=$idpago";
                              $base1 = new GestarBD();
                              $base1->consulta($consulta3);
                              $total2= 0;
                              while($fila1=$base1->mostrar_registros()) 
                              { 
                                ?>
                                      <?php  $fila1->name_service; ?>  
                                      <?php  $fila1->cantidad; ?>
                                      <?php  $total3=$fila1->costo_car; ?>
                                <?php
                                $total2 = $total2 + $total3; // total price
                                ?>

                                <?php  $p=$fila1->state_payment;
                               }
                               ?>
                               <div class="modal-header" > 
                               <label>Seleccione el banco en el que pago</label>
                               <form action="?mod=facturas&factura=factura&idp=<?php echo  $fila->id_payments; ?>" method="post">
                                  <select class="form-control"  name="estadop">
                            <?php 
                            $consulta2="SELECT * FROM `accounts`";
                                  $base1->consulta($consulta2);
                                  while($fila3=$base1->mostrar_registros()) 
                                  {
                                    ?>
                                    
                                      <option class="banco" value="<?php echo $fila3->id_accounts; ?>"><p><?php echo $p=$fila3->name_bank_accounts; ?></p>
                                      </option>
                                      
                                    <?php
                                  } 
                                ?>
                                  </select>
                                  </br>
                                  <button class="btn red btn-outline sbold derecha">Registrar Factura</button>
                                  </form>  
                               </div>

        <div class="modal-footer">
         
          <ul class="list-unstyled amounts">
              <li>
                  <strong>Sub - Total amount:</strong>  <?php echo $total2  ?></li>
                 
              <li>
                  <strong>Gran Total:</strong> <?php echo 0/$total2*100+$total2  ?>
              </li>
          </ul>
        </div>

          </div>
      </div>
  </div>
</div>


<div class="modal fade" id="factura<?php echo  $fila->id_payments; ?>" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">Factura N: <?php echo  $idpago=$fila->id_payments; ?>  </h4>
        </div>
        <div class="modal-header">
         <h4>Servicio  <n style="margin-left: 30%">Cantidad</n>
         <n style="margin-left: 30%">Sub-total</n></h4>
        </div>
      <div class="modal-body">
      <?php 
        $consulta2="SELECT * FROM payments INNER JOIN user ON payments.id_user_id_payments= user.id_user INNER JOIN car ON car.id_payment_id_car=payments.id_payments INNER JOIN service ON car.id_service_car=service.id_service INNER JOIN administrador ON user.id_admin_id_user=administrador.id_administrador WHERE id_payments=$idpago";
                              $base = new GestarBD();
                              $base->consulta($consulta2);
                              $total= 0;
                              while($fila=$base->mostrar_registros()) 
                              { 
                                ?>
                                          <div class="modal-header" >
                                                <h4 class="modal-title" >
                                                <div>
                                                  
                                                  <n style="margin-left: 200px"><?php echo $fila->cantidacar; ?></n>
                                                  <n style="margin-left: -180px"><?php echo $fila->name_service; ?> </n>
                                                  <n style="float: right;"> <?php echo $total1=$fila->costo_car; ?></n>
                                                  </div>
                                                </h4>
                                          </div>
                                <?php
                                $total = ($total + $total1); // total price
                                ?>
                                <?php  $p=$fila->state_payment;
                                 $fecha1=$fila->date_payment;
                               }
                               ?>
        <div class="modal-footer">
          <n style="display: -webkit-box;"><b>Estado de factura:</b> <?php
             if($p=="proceso"){
                                echo "<p style='color: orange'> Procesando </p>";
                                
                                }elseif($p=="pendiente"){
                                     echo "<p style='color: red'> Pendiente</p>";
                                }else{
                                      echo "<p style='color: green'> Aprovada</p>";
                                }

                               
                                ?>
          </n>
          </br>
          <n style="display: -webkit-box;">
          <b>Fecha de Factura:</b><?php  echo $fecha1; ?>
          </n>
          <ul class="list-unstyled amounts" style="margin-top: -5%;">
              <li>
                  <strong>Sub - Total amount:</strong>  <?php echo $total  ?></li>
              
              <li>
                  <strong>Gran Total:</strong> <?php echo 0/$total*100+$total  ?>
              </li>
          </ul>
        </div>
      </div>
      </div>
    </div>
  </div>

                        <?php       }
                                 }                         
                        ?> 
                        </tbody>
                </table>
            </div>
    </div>
</div>

