



<script LANGUAGE="JavaScript">
function confirmDel(url){
//var agree = confirm("¿Realmente desea eliminarlo?");
if (confirm("¿Realmente desea eliminar este Empleado?"))
    window.location.href = url;
else
    return false ;
}
</script>

<?php



$fecha_actual = date ("Y-m-d"); 
$hora = date("H:i:s",time()-3600);
if (isset($_GET['eliminar'])) { 
     $ci=$_GET["cod"]; 
 //datos que vienen del formulario             
if( $ci ==""){
echo "";
}else{



$ip="{$_SERVER['REMOTE_ADDR']}";
$puerto="{$_SERVER['REMOTE_PORT']}"; 

$sql="INSERT INTO `bitacora` ( `fecha_movimientos`, `hora_movimiento`, `ip_ordenador`, `descripcion`, `usuarios_cedula`,`tipo`) VALUES ( '$fecha_actual', '$hora', '$ip', 'Se Elimino un  empleado con el n cedula ".$ci." ', '$adminci', '2');";
$bd->consulta($sql);


                         
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b> Datos Eliminados Correctamente... ';

                               echo '   </div>';

?>
 <?php    
}
}


        if (isset($_GET['eliminar'])) { 

                 $x1=$_GET["codigo"];                    
                if( $x1=="" ){
                    echo "<script> alert('campos vacios')</script>";
                    echo "<br>";
                }else{
                                $sql2="SELECT * FROM `salida` WHERE `salida`.`id_salida`='".$x1."'";
                                $bd->consulta($sql2);
                                while ($fila=$bd->mostrar_registros()) {
                                  $idn= $fila->id_service_id_salida; 
                                  $total= $fila->cantida_salida; 
                                }
                                $sql3="UPDATE `service` SET `service`.`cantida`=`service`.`cantida`+'$total' WHERE `service`.`id_service`='$idn'";
                                $bd->consulta($sql3);
                               
                                $sql4="delete from `salida` where `id_salida`='".$x1."'";
                                $bd->consulta($sql4);
                               

                   
                                            //echo "Datos Guardados Correctamente";
                                            echo '<div class="alert alert-success alert-dismissable">
                                                        <i class="fa fa-check"></i>
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                        <b>Bien!</b> Se Elimino Correctamente... </div>';
                    }
        }


                if (isset($_GET['crear'])) { 

                          $service = utf8_decode($_POST['service']);
                          $cantida = utf8_decode($_POST['cantida']);
                          $fecha = utf8_decode($_POST['fecha']);
                          $proveedor = utf8_decode($_POST['proveedor']);
                          $motivo = utf8_decode($_POST['motivo']);
                        


                        $resultado = str_replace("T", " ", $fecha);

                        if($fecha==""){
                          $resultado= $hoy = date("Y-m-d H:m:s");
                         }


                                 if( $service==""  ){

                                    echo "
                   <script> alert('campos vacios')</script>
                   ";
                                    echo "<br>";
                                }else{
                                  
                                  //consultamos si existe

                                         $consulta="SELECT * FROM `service` where id_service='$service'";
                                         $bd->consulta($consulta);
                                      while ($fila=$bd->mostrar_registros()) { 
                                           $totalactual= $fila->cantida; 
                                           $costoactual= $fila->costo; 
                                           $precioactual= $fila->price_service; 
                                          }
                                          if($costo=="")
                                            $costo=$costoactual;

                                          if($salida=="")
                                            $salida=$precioactual;
                                                  //suma de cantidad actual mas la nueva
                                                   $grantotal=$totalactual-$cantida;

                                                  $editar="UPDATE `service` SET `cantida` = '$grantotal',`price_service` = '$salida',`costo` = '$costo' WHERE `service`.`id_service` = '$service'";
                                                  $bd->consulta($editar);
                    

                                             $sql="INSERT INTO `salida` (`id_salida`, `id_service_id_salida`, `fecha_salida`, `id_proveedor_id_salida`, `cantida_salida`, `motivo_salida`) VALUES (NULL, '$service', '$resultado', '$proveedor', '$cantida', '$motivo')";
                                              $bd->consulta($sql);

                                                        //echo "Datos Guardados Correctamente";
                                                        echo '<div class="alert alert-success alert-dismissable">
                                                                    <i class="fa fa-check"></i>
                                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                                    <b>Bien!</b> Datos Registrados Correctamente... ';
                                                           echo '   </div>';
                                  
    }
}
?>




                    <div class="row">
                        <div class="col-md-12">
                          <a style=" margin-left: 10px;"  title="Registrar Nuevo" class="btn green btn-outline sbold " data-toggle="modal" href="#productoguarda">Nueva Salida </a> 
                          <a style=" margin-left: 10px;" class="btn red btn-outline sbold " title="Actualizar tabla" data-toggle="modal" href="?admin=salida"> <i class="fa fa-refresh" aria-hidden="true"></i> </a> 

                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption font-dark">
                                        <i class="icon-arrow-up font-dark"></i>
                                        <span class="caption-subject bold uppercase">Registros de Salidas </span>
                                       
                                    </div>

                                    <div class="tools "> </div>
                                    
                                </div>

                                <div class="portlet-body">

                                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
                                        <thead>
                                            <tr>
                                                <th  class="all hidden-print">#</th>
                                                <th class="min-phone-l">Material</th>
                                                <th class="min-phone-l">Responsable</th>
                                                <th class="min-phone-l">Cantida</th>
                                                <th class="min-phone-l">Fecha de Movimiento</th>
                                                <th  class="min-phone-l hidden-print noimprimir"> Opciones</th>
                                                <th class="none">Motivo Del Descargo</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                     $consulta="SELECT * FROM `salida` INNER JOIN service ON salida.id_service_id_salida=service.id_service 
                                      INNER JOIN proveedor ON salida.id_proveedor_id_salida =proveedor.id_proveedor ";
                                         $bd->consulta($consulta);
                                      while ($fila=$bd->mostrar_registros()) { ?>
                                        <tr>    
                                        <?php $id= $fila->id_salida; ?>

                                             <td  width="5%"><?php echo $fila->id_salida; ?></td>
                                             <td  width="25%"> <?php echo $fila->name_service; ?></td>
                                             <td  width="25%"> <?php echo $fila->nombre_proveedor; ?></td>
                                             <td  width="25%"><?php echo $fila->cantida_salida; ?></td>
                                             <td  width="20%"><?php echo $fila->fecha_salida; ?>  </td>
                                             <td width="25%" class="hidden-print noprin">
                                                <center>
                                            
                                                  
                                                  <a class="dt-button buttons-pdf buttons-html5 btn blue btn-outline " data-toggle="modal" href="#productover"   title="ver" id="buttonHola" onclick="myFunction(this, '<?php echo $id ?>')" ><i class='fa fa-eye'></i></a>
                                                  <a  class="btn red btn-outline sbold "  title="Eliminar" onclick='if(confirmDel() == false){return false;}' class="btn red btn-outline sbold"  href='?admin=salida&eliminar&codigo=<?php echo $id ?>'><i class=' fa fa-trash'></i></a>

                                                
                                                </center> 
                                             </td>
                                             
                                     
                                              <td><?php echo $fila->motivo_salida; ?></td>
                                             
                                             
                                        </tr>

            


                                          <?php 
                                           }
                                           ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
               

      <script>
          var variableGlobal;
           
          function myFunction(elmnt,clr) { 
           variableGlobal = clr;
              var idd = clr;
              console.log(variableGlobal);
               $.ajax({
                      type: "GET",
                      url: "api/salidas.php?tabla=1&idu="+idd
                  }).done(function(json) 
                      {
                          json = $.parseJSON(json)
                              for(var i=0;i<json.length;i++)
                              {
                                  $('.editinplace').html(
                                      "<div class='col-xs-8'><ul class='list-unstyled' style='line-height: 2'><li><span class='text-success'><i class='fa fa-database'></i></span> <span style='color: #acacac; font-size: 9pt; text-align: left;'>Codigo:</span> <span style='font-size: 9pt; text-align: left;'>"+json[i].id+"</span></li><li><span class='text-success'><i class='fa fa-desktop'></i></span> <span style='color: #acacac; font-size: 9pt; text-align: left;'>Material:</span> <span  data-campo='name_service' style='font-size: 9pt; text-align: left;'>"+json[i].nombre+"</span></li><li><span class='text-success'><i class='fa fa-building-o'></i></span> <span style='color: #acacac; font-size: 9pt; text-align: left;'>Cantidad:</span> <span style='font-size: 9pt; text-align: left;' data-campo='cantida_salida' >"+json[i].cantida+"</span></li><li><span class='text-success'><i class='fa fa-building-o'></i></span> <span style='color: #acacac; font-size: 9pt; text-align: left;'>Fecha:</span> <span style='font-size: 9pt; text-align: left;' data-campo='fecha_salida' >"+json[i].fecha+"</span></li> <li><span class='text-success'><i class='fa fa-database'></i></span> <span style='color: #acacac; font-size: 9pt; text-align: left;'>Proveedor:&nbsp; </span><span data-campo='nombre_proveedor' >"+json[i].proveedor+"</span></li> <li><span class='text-success'><i class='fa fa-database'></i></span> <span style='color: #acacac; font-size: 9pt; text-align: left;'>Motivo:&nbsp; </span><span data-campo='motivo_salida' >"+json[i].motivo+"</span></li></ul></div><div class='col-xs-4'><div class='well'><div style='color: #acacac; font-size: 9pt; text-align: center; padding: 0px; margin-bottom: 6px;'></div><span style='font-size: 9pt; text-align: left;' data-campo='imagen' ><img width='100%' src='./producto/"+json[i].imagen+"'></span></br></div></div>");
                              }

                      });
          }
      </script>
      
      <?php 
     
      ?>
        
<!--modal guardar nuevo -->
        <div class="modal fade" id="productoguarda" tabindex="-1" role="basic" aria-hidden="true">
              <div id="login-overlay" class="modal-dialog">
                <div class="modal-content">
                     <div class="modal-header" style="border-bottom: 4px solid #2e77bc; background-color: #fff; color: #111;">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                          <h2 class="modal-title" id="myModalLabel" style="font-size: 9pt;"><h4><i class="glyphicon glyphicon-upload"></i>&nbsp; Registrar Nuevas Salida.</h4></h2>
                      </div>
                      <div style="margin-top: 1px; background-color: #2e77bc; height: 1px; width: 100%;"></div>
                          <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="portlet-body">
                            <div class="table-scrollable">
                              <table class="table table-striped table-hover">
                                <thead>
                                  <tr>
                                  <div id="register_form">
                                    <form  role="form" action="?admin=salida&crear=crear" method="post" enctype="multipart/form-data">              
                                                        <th>Material </th>
                                                        <th>Cantidad</th>
                                </thead>
                                <tbody>
                                  <tr> 
                                    <td width="50%">
                          <?php
                           $consulta="SELECT * FROM  service";
                           $bd->consulta($consulta);?>
                                   * <select class="form-control"  name="service">
                          <?php
                              while ($fila=$bd->mostrar_registros())
                              { ?>
                                      <option  value="<?php echo $id= $fila->id_service; ?>"><p><?php echo $id= $fila->name_service; ?></p> </option> 
                              <?php 
                              }
                              ?>
                                    </select>
                                       
                                    </td>
                                    <td >
                                       *  <input   required type="number" required name="cantida" required class="form-control">
                                    </td>
                                  </tr>
                                </tbody>
                                <thead>
                                  <tr>
                                                        <th>Fecha Movimiento</th>
                                                        <th>Proveedor</th>
                                </thead>
                                <tbody>
                                  <tr> 
                                    <td width="50%">
                                       <input class="form-control" type="datetime-local" name="fecha" value="<?php echo $hoy?>" />
                                    </td>
                                      <td width="50%"><center>
                                   <?php
                                   $consulta="SELECT * FROM  proveedor WHERE estado_proveedor='DISPONIBLE'";
                                   $bd->consulta($consulta);?>
                                           <select class="form-control"  name="proveedor">
                                  <?php
                                    while ($fila=$bd->mostrar_registros())
                                    { ?>
                                            <option  value="<?php echo $id= $fila->id_proveedor; ?>"><p><?php echo $fila->nombre_proveedor; ?></p> </option> 
                                  <?php 
                                  }
                                  ?>
                                    </td>
                                    
                                  </tr>
                                </tbody>
                                
                                 <thead>
                                  <tr>
                                               
                                                        <th colspan="2">Motivo del descargo</th>
                                                        
                                </thead>
                                <tbody>
                                  <tr> 
                                    
                                    <td colspan="2" width="100%"><center>
                                   <textarea class="form-control" name="motivo"></textarea>
                                    </td>
                                    
                                  </tr>
                                </tbody>
                                <tbody>
                                  <tr> 
                                      
                                    <td width="50%" colspan="2"><center>
                                     <center>
                                       <button type="submit" class="btn btn-primary btn-lg" name="lugarguardar" value="Guardar">Registrar</button></center>
                                    </td>
                                   
                                    
                                  </tr>
                                </tbody>
                                </form>
                                </div>
                              </table>
                            </div>
                          </div>  
                        </div>
                           
                </div>
              </div>
        </div>
      </div>
      </div>

        <!--modal editar -->
        <div class="modal fade" id="productover" tabindex="-1" role="basic" aria-hidden="true">
              <div id="login-overlay" class="modal-dialog">
                <div class="modal-content">
                      <div class="modal-header" style="border-bottom: 4px solid #2e77bc; background-color: #fff; color: #111;">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                          <h2 class="modal-title" id="myModalLabel" style="font-size: 9pt;"><h4><i class="fa fa-eye"></i>&nbsp; Datos del Registro de entrada.</h4></h2>
                      </div>
                  <div style="margin-top: 1px; background-color: #2e77bc; height: 1px; width: 100%;"></div>
                    <div class="modal-body">
                        <div class="editinplace row">
                    </div>
                  </div>
              </div>
        </div>
        </div>
        <!--modal editar -->
        <div class="modal fade" id="productoedita" tabindex="-1" role="basic" aria-hidden="true">
              <div id="login-overlay" class="modal-dialog">
                <div class="modal-content">
                      <div class="modal-header" style="border-bottom: 4px solid #2e77bc; background-color: #fff; color: #111;">
                         <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                          <h2 class="modal-title" id="myModalLabel" style="font-size: 9pt;"><h4><i class="fa fa-edit"></i>&nbsp; Editar Cuenta.</h4></h2>
                      </div>
                  <div style="margin-top: 1px; background-color: #2e77bc; height: 1px; width: 100%;"></div>
                    <div class="modal-body">
                        <div class="editinplace2 row">
                           
                               
                        </div>     
                    </div>
                  </div>
              </div>
        </div>
        </div>
  <script type="text/javascript" src="pages/jquery-1.10.2.min.js"></script>
</div>

