<link href="assets/fileinput.css" media="all" rel="stylesheet" type="text/css" />
        
        <script src="assets/fileinput.js" type="text/javascript"></script>

   
      
 
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
        $consulta="SELECT * FROM proveedor where id_proveedor='$x1'";
        $bd->consulta($consulta);
                while ($fila3=$bd->mostrar_registros()) { 
                    $eliminaimagen=$fila3->imagen;
      
                 if($eliminaimagen!="")
                  unlink('./responsables/'.$eliminaimagen.'');
                
        }
    }
                        $sql3="delete from proveedor where id_proveedor='".$x1."'";
                        $bd->consulta($sql3);
                        

           
                                    //echo "Datos Guardados Correctamente";
                                    echo '<div class="alert alert-success alert-dismissable">
                                                <i class="fa fa-check"></i>
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                <b>Bien!</b> Se Elimino Correctamente... </div>';
            }






if (isset($_GET['crear'])) { 


  $fondoe= $_FILES["fondo"];
  $ci_proveedor=$_POST["ci_proveedor"];
  $nombre_proveedor=$_POST["nombre_proveedor"];
  $telefono_proveedor=$_POST["telefono_proveedor"];
  $correo=$_POST["correo"];
  $cargo=$_POST["cargo"];
  $estado_proveedor=$_POST["estado_proveedor"];
  $fecha_nacimiento=$_POST["fecha_nacimiento"];
  $resultado = str_replace("T", " ", $fecha_nacimiento);
        if($fecha_nacimiento==""){
          $resultado= $hoy = date("Y-m-d H:m:s");
         }
                 if( $nombre_proveedor==""  ){

                    echo "
   <script> alert('campos vacios')</script>
   ";
                    echo "<br>";
                                }else{

         if($_FILES["fondo"]!=""){
                                      $reporte = null;
                                      for($x=0; $x<count($_FILES["fondo"]["name"]); $x++)
                                      {
                                         $file = $_FILES["fondo"];
                                        $nombre = $file["name"][$x];
                                         $tipo = $file["type"][$x];
                                        $ruta_provisional = $file["tmp_name"][$x];
                                         $size = $file["size"][$x];
                                        $width = $dimensiones[0];
                                        $height = $dimensiones[1];
                                        $carpeta = "./responsables/";

                                        if($size==0){
                                              $sql="INSERT INTO `proveedor`
                                              (`id_proveedor`,`ci_proveedor`, `nombre_proveedor`, `telefono_proveedor`, `correo`, `cargo`,`fecha_nacimiento`, `estado_proveedor`, `imagen`) VALUES
                                              (NULL, '$ci_proveedor', '$nombre_proveedor', '$telefono_proveedor', '$correo', '$cargo','$hoy', '$estado_proveedor', '');";                 
                                             $bd->consulta($sql);


                                                        //echo "Datos Guardados Correctamente";
                                                        echo '<div class="alert alert-success alert-dismissable">
                                                                    <i class="fa fa-check"></i>
                                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                                    <b>Bien!</b> Datos Registrados Correctamente... ';

                              
                                                           echo '   </div>';
                                        }elseif($tipo != 'image/jpeg' && $tipo != 'image/jpg' && $tipo != 'image/png' && $tipo != 'image/gif')
                                          {


                                             echo "<p style='color: red'>Error $nombre, el archivo no es una imagen  </p>";
                                          }
                                          else if($size > 1024*1024)// 1024*1024 = 1 MB
                                          {
                                              echo "<p style='color: red'>Error $nombre, el tamaño máximo permitido es 1MB</p>";
                                          }else{

                                             $gale="proveedor_";
                                             $name2=$gale.$nombre.$nombre_proveedor;  
                                             $name3 = preg_replace('[\s+]','', $name2);
                                             $src = $carpeta.$name3;
                                               move_uploaded_file($ruta_provisional, $src);
                                             $sql="INSERT INTO `proveedor`
                                             (`id_proveedor`,`ci_proveedor`, `nombre_proveedor`, `telefono_proveedor`, `correo`, `cargo`,`fecha_nacimiento`, `estado_proveedor`, `imagen`) VALUES
                                              (NULL, '$ci_proveedor', '$nombre_proveedor', '$telefono_proveedor', '$correo', '$cargo','$hoy', '$estado_proveedor', '$name3');";   
                                             $bd->consulta($sql);


                                                        //echo "Datos Guardados Correctamente";
                                                        echo '<div class="alert alert-success alert-dismissable">
                                                                    <i class="fa fa-check"></i>
                                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                                    <b>Bien!</b> Datos Registrados Correctamente... ';

                              
                                                           echo '   </div>';
                                          }
                                      }//fin for
                                  }
    }
}
?>

                    <div class="row">
                        <div class="col-md-12">
                          <a style=" margin-left: 10px;" title="Registrar Nuevo" class="btn green btn-outline sbold " data-toggle="modal" href="#productoguarda">Nuevo Responsable </a> 
                          <a style=" margin-left: 10px;" class="btn red btn-outline sbold " title="Actualizar tabla" data-toggle="modal" href="?admin=pedidos"> <i class="fa fa-refresh" aria-hidden="true"></i> </a> 
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption font-dark">
                                        <i class="icon-settings font-dark"></i>
                                        <span class="caption-subject bold uppercase">Lista de Responsables</span>
                                       
                                    </div>

                                    <div class="tools "> </div>
                                    
                                </div>

                                <div class="portlet-body">

                                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
                                        <thead>
                                        <tr>
                                                <th  class="all hidden-print">#</th>
                                                <th class="min-phone-l">Cedula de Identidad</th>
                                                <th class="min-phone-l">Nombre</th>
                                                <th class="none">Telefono</th>
                                                <th class="none">Correo</th>
                                                <th class="none">Fecha de nacimiento</th>
                                                <th class="min-phone-l">Cargo</th>
                                                <th class="min-phone-l">Estado</th>
                                                <th  class="min-phone-l hidden-print noimprimir"> Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                     $consulta="SELECT * FROM `proveedor` ORDER by id_proveedor DESC";
                                         $bd->consulta($consulta);
                                      while ($fila=$bd->mostrar_registros()) { ?>
                                        <tr>    
                                        <?php $id= $fila->id_proveedor; ?>

                                        <td  width="5%"><?php echo $fila->id_proveedor; ?></td>
                                             <td  width="5%"><?php echo $fila->ci_proveedor; ?></td>
                                             <td  width="25%"><?php echo $fila->nombre_proveedor; ?></td>
                                             <td  width="25%"><?php echo $fila->telefono_proveedor; ?></td>
                                             <td  width="25%"> <?php echo $fila->correo; ?>  </td>
                                             <td  width="25%"> <?php echo $fila->fecha_nacimiento; ?>  </td>
                                             <td  width="25%"> <?php echo $fila->cargo; ?>  </td>
                                             <td  width="25%"> <?php echo $fila->estado_proveedor; ?>  </td>
                                             <td width="25%">
                                                <center>
                                                  <a class="dt-button buttons-pdf buttons-html5 btn blue btn-outline " data-toggle="modal" href="#productoedita" title="editar" id="buttonHola" onclick="myFunction2(this, '<?php echo $id ?>')" ><i class='fa fa-edit'></i> </a> 
                                                  <a class="dt-button buttons-pdf buttons-html5 btn blue btn-outline  " data-toggle="modal"  title="Ver" href="#productover" id="buttonHola" onclick="myFunction(this, '<?php echo $id ?>')" ><i class='fa fa-eye'></i></a>
                                                 <!--  <a class="dt-button buttons-pdf cargar buttons-html5 btn blue btn-outline " data-toggle="modal"  title="Cargar imagen" href="#imagenprin1<?php echo $id  ?>"><i class='fa fa-file-image-o'></i></a> -->
                                                 <!-- <a  class="btn red btn-outline sbold derecha"  title="Eliminar" onclick='if(confirmDel() == false){return false;}' class="btn red btn-outline sbold"  href='?admin=productos&eliminar&codigo=<?php echo $id ?>'><i class=' fa fa-trash'></i></a> -->

                                                </center> 
                                             </td>
                                          
                                             
                                            
                                        </tr>
 <div class="modal fade" id="imagenprin1<?php echo $id  ?>" tabindex="-1" role="basic" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Editar imagen del Submodulo: <?php echo  $fila->nombre_proveedor; ?></h4>
                                                </div>
                                              
                                                <div class="modal-footer">
                                                  
                                                  <input id="perfil1<?php echo  $id ?>" name="imagenprin[]" type="file" multiple class="file-loading">
                                                  <script type="text/javascript">
                                                             $("#perfil1<?php echo  $id ?>").fileinput({
                                                                uploadUrl: "admin/guardaproyecto.php?codigo=<?php echo  $id ?>", // server upload action
                                                                uploadAsync: true,
                                                                maxFileCount: 1,
                                                                showBrowse: false,
                                                                browseOnZoneClick: true
                                                            });
                                                   </script>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
            


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
                      url: "api/editinplace3.php?tabla=1&idu="+idd
                  }).done(function(json) 
                      {
                          json = $.parseJSON(json)
                              for(var i=0;i<json.length;i++)
                              {
                                  $('.editinplace3').html(
                                    "<div class='col-xs-6'><ul class='list-unstyled' style='line-height: 2'><li><span class='text-success'><i class='fa fa-database'></i></span> <span style='color: #acacac; font-size: 9pt; text-align: left;'>ID:</span> <span style='font-size: 9pt; text-align: left;'>"+json[i].id_proveedor+"</span></li><li><span class='text-success'><i class='fa fa-desktop'></i></span> <span style='color: #acacac; font-size: 9pt; text-align: left;'>Cedula de Identidad:</span> <span  data-campo='ci_proveedor' style='font-size: 9pt; text-align: left;'>"+json[i].ci_proveedor+"</span></li><li><span class='text-success'><i class='fa fa-building-o'></i></span><span style='color: #acacac; font-size: 9pt; text-align: left;'>Nombre:</span> <span  data-campo='nombre_proveedor' style='font-size: 9pt; text-align: left;'>"+json[i].nombre_proveedor+"</span></li><li><span class='text-success'><i class='fa fa-building-o'></i></span> <span style='color: #acacac; font-size: 9pt; text-align: left;'>Telefono:</span> <span style='font-size: 9pt; text-align: left;' data-campo='telefono_proveedor' >"+json[i].telefono_proveedor+"</span></li> <li><span class='text-success'><i class='fa fa-building-o'></i></span> <span style='color: #acacac; font-size: 9pt; text-align: left;'>Correo:</span> <span style='font-size: 9pt; text-align: left;' data-campo='correo' >"+json[i].correo+"</span></li> <li><span class='text-success'><i class='fa fa-building-o'></i></span> <span style='color: #acacac; font-size: 9pt; text-align: left;'>Fecha de nacimiento:</span> <span style='font-size: 9pt; text-align: left;' data-campo='fecha_nacimiento' >"+json[i].fecha_nacimiento+"</span></li>  <li><span class='text-success'><i class='fa fa-building-o'></i></span> <span style='color: #acacac; font-size: 9pt; text-align: left;'>Cargo:</span> <span style='font-size: 9pt; text-align: left;' data-campo='cargo' >"+json[i].cargo+"</span></li> <li><span class='text-success'><i class='fa fa-database'></i></span> <span style='color: #acacac; font-size: 9pt; text-align: left;'>Estado:&nbsp; </span><a><span class='label label-primary' data-campo='estado_proveedor' >"+json[i].estado_proveedor+"</span></a></li><div style='margin-top: 8px; margin-bottom: 8px; width: 100%; height: 1px; background-color: #d9d9d9;'></div><li><span class='text-success'></span> </div><div class='col-xs-6'><div class='well'><div style='color: #acacac; font-size: 9pt; text-align: center; padding: 0px; margin-bottom: 6px;'>Detalles</div><span style='font-size: 9pt; text-align: left;' data-campo='imagen' ><img width='100%' src='./responsables/"+json[i].imagen+"'></span></br></br></div></div>");
                              }

                      });
          }
      </script>
      <script>
          var variableGlobal;
           
          function myFunction2(elmnt,clr) { 
           variableGlobal = clr;
              var idd = clr;
              console.log(variableGlobal);
               $.ajax({
                      type: "GET",
                      url: "api/editinplace3.php?tabla=1&idu="+idd
                  }).done(function(json) 
                      {
                          json = $.parseJSON(json)
                              for(var i=0;i<json.length;i++)
                              {
                                  $('.editinplace3').html(
                                    "<div class='col-xs-6'><table class='editinplace2 table table-striped table-hover'><tr><td width='20%'><span class='text-success'></span><span style='color: #acacac; font-size: 9pt; text-align: left;'>ID: &nbsp; </td><td class='id'width='80%' >"+json[i].id_proveedor+" </span></td></tr> <tr><td width='20%' ><span class='text-success'></span><span style='color: #acacac; font-size: 9pt; text-align: left;'>Cedula de identidad:</span></td><td class='editable' data-campo='ci_proveedor' width='80%' ><span><a class='link'>"+json[i].ci_proveedor+"</a></span></td></tr> <tr><td width='20%' ><span class='text-success'></span><span style='color: #acacac; font-size: 9pt; text-align: left;'>Nombre:</span></td><td class='editable' data-campo='nombre_proveedor' width='80%' ><span><a class='link'>"+json[i].nombre_proveedor+"</a></span></td></tr> <tr><td width='20%' ><span class='text-success'></span><span style='color: #acacac; font-size: 9pt; text-align: left;'>Telefono:</span></td><td class='editable' data-campo='telefono_proveedor' width='80%' ><span><a class='link'>"+json[i].telefono_proveedor+"</a></span></td></tr><tr><td width='20%' ><span class='text-success'></span><span style='color: #acacac; font-size: 9pt; text-align: left;'>Correo:</span></td><td class='editable' data-campo='correo' width='80%' ><span><a class='link'>"+json[i].correo+"</a></span></td></tr> <tr><td width='20%' ><span class='text-success'></span><span style='color: #acacac; font-size: 9pt; text-align: left;'>Fecha de Nacimiento:</span></td><td class='editable' data-campo='fecha_nacimiento' width='80%' ><span><a class='link'>"+json[i].fecha_nacimiento+"</a></span></td></tr> <tr><td width='20%' ><span class='text-success'></span><span style='color: #acacac; font-size: 9pt; text-align: left;'>Cargo:</span></td><td class='editable' data-campo='cargo' width='80%' ><span><a class='link'>"+json[i].cargo+"</a></span></td></tr> <tr><td width='20%' ><span class='text-success'></span><span style='color: #acacac; font-size: 9pt; text-align: left;'>Estado:</span></td><td class='editable' data-campo='estado_proveedor' width='80%' ><span><a class='link'>"+json[i].estado_proveedor+"</a></span></td></tr> </table></div><div class='col-xs-6'><div class='well'><div style='color: #acacac; font-size: 9pt; text-align: center; padding: 0px; margin-bottom: 6px;'>Detalles</div><span style='font-size: 9pt; text-align: left;' data-campo='imagen' ><img width='100%' src='./responsables/"+json[i].imagen+"'></span></br></br><a class='btn btn-success btn-block movilno' data-toggle='modal' href='#imagenprin' onclick='myFunction3(this, "+json[i].id+")' >Imagen Perfil </a></div></div>");
                              }   
                                 
                              
                      });


                  var td,campo,valor,id;
                  $(document).on("click","td.editable span",function(e)
                  {
                      e.preventDefault();
                      $("td:not(.id)").removeClass("editable");
                      td=$(this).closest("td");
                      campo=$(this).closest("td").data("campo");
                      valor=$(this).text();
                      id=$(this).closest("table").find(".id").text();
                      td.text("").html("<input type='text' name='"+campo+"' value='"+valor+"'><a class='enlace guardar' href='#'>Guardar</a><a class='enlace cancelar' href='#'>Cancelar</a>");
                  });
                  
                  $(document).on("click",".cancelar",function(e)
                  {
                      e.preventDefault();
                      td.html("<span><a class='link'>"+valor+"</a></span>");
                      $("td:not(.id)").addClass("editable");
                  });
                  
                  $(document).on("click",".guardar",function(e)
                  {
                      $(".mensaje").html("<img src='img/loading.gif'>");
                      e.preventDefault();
                      nuevovalor=$(this).closest("td").find("input").val();
                      if(nuevovalor.trim()!="")
                      {
                          $.ajax({
                              type: "POST",
                              url: "api/editinplace3.php",
                              data: { campo: campo, valor: nuevovalor, id:id }
                          })
                          .done(function( msg ) {
                              $(".mensaje").html(msg);
                              td.html("<span><a class='link'>"+nuevovalor+"</a></span>");
                              $("td:not(.id)").addClass("editable");
                              setTimeout(function() {$('.ok,.ko').fadeOut('fast');}, 3000);
                          });
                      }
                      else $(".mensaje").html("<p class='ko'>Debes ingresar un valor</p>");
                  });
          }
      </script>
      <?php 
      $scrip="<script src='assets/fileinput.js' type='text/javascript'></script>";
      ?>
       <script>
        
          function myFunction3(elmnt,clr) { 
           variableGlobal = clr;
           var fileinput;
              var idd = clr;
              console.log(idd);
 
              document.getElementById('miDiv').innerHTML = "<link href='assets/fileinput.css' media='all' rel='stylesheet' type='text/css' /><input id='perfil' name='imagenprin[]' type='file'  class='file-loading'><?php $scrip ?>";

      $("#perfil").fileinput({
                                        uploadUrl: "admin/guardaproyecto.php?codigo="+idd, // server upload action
                                        uploadAsync: true,
                                        maxFileCount: 1,
                                        showBrowse: false,
                                        browseOnZoneClick: true
                                    });

              
          }
      </script>
        
<!--modal guardar nuevo -->
<div class="modal fade" id="productoguarda" tabindex="-1" role="basic" aria-hidden="true">
              <div id="login-overlay" class="modal-dialog">
                <div class="modal-content">
                     <div class="modal-header" style="border-bottom: 4px solid #2e77bc; background-color: #fff; color: #111;">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                          <h2 class="modal-title" id="myModalLabel" style="font-size: 9pt;"><h4><i class="fa fa-eye"></i>&nbsp; Registrar Nuevo Responsable.</h4></h2>
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
                                    <form role="form" action="?admin=pedidos&crear=crear" method="post" enctype="multipart/form-data">              
                                                        <th>Cedula de Identidad</th>
                                                        <th>Nombre</th>
                                </thead>
                                <tbody>
                                  <tr>
                                  <td width="40%"><center>
                                        <input   required type="text" required name="ci_proveedor" required class="form-control">
                                    </td> 
                                    <td width="30%"><center>
                                        <input   required type="text" required name="nombre_proveedor" required class="form-control">
                                    </td>
                                  </tr>
                                </tbody>
                                <thead>
                                  <tr>
                                                        <th>Telefono</th>
                                                        <th>Correo</th>
                                </thead>
                                <tbody>
                                  <tr> 
                                    <td width="50%"><center>
                                        <input class="form-control" required type="text" name="telefono_proveedor" />
                                    </td>
                                    <td width="50%" ><center>
                                      <input class="form-control" required type="text" name="correo" />
                                    </td>
                                    
                                  </tr>
                                  <thead>
                                  <tr>
                                                        <th>Fecha de nacimiento</th>
                                                    
                                </thead>
                                <tbody>
                                  <tr> 
                                  <td width="50%">
                                       <input class="form-control" type="date" name="fecha_nacimiento" value="<?php echo $hoy?>" />
                                    </td> 
                                  </tr>
                                </tbody>
                                </tbody>

                                <thead>
                                  <tr>
                                                        <th>Cargo</th>
                                                        <th>Estado</th>
                                </thead>
                                <tbody>
                                  <tr> 
                                    <td width="50%">
                                    <select class="form-control" name="cargo">
                                        <option value="GERENTE" selected>GERENTE</option>
                                        <option value="PASANTE">PASANTE</option>
                                        <option value="TEC. DE CAMPO">TEC. DE CAMPO</option>
                                        </select>
                                    </td>
                                    <td width="50%">
                                    <select class="form-control" name="estado_proveedor">
                                        <option value="DISPONIBLE" selected>DISPONIBLE</option>
                                        <option value="NO DISPONIBLE">NO DISPONIBLE</option>
                                        <option value="RETIRADO">RESTIRADO</option>
                                        </select>
                                    </td>
                                  </tr>
                                </tbody>
                                <thead>
                                  <tr>
                                               
                                                        <th>Imagen Principal</th>
                                                        
                                </thead>
                                <tbody>
                                  <tr> 
                                    <td width="50%"><center>
                                        <input class="form-control"  type="file" name="fondo[]" />
                                    </td>
                                    <td width="50%"><center>
                                      <center>
                                       <button type="submit" class="btn btn-primary btn-lg" name="lugarguardar" value="Guardar">Registrar</button></center>
                                    </td>
                                    
                                  </tr>
                                </tbody>

                               
                              

                                </form>
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
                          <h2 class="modal-title" id="myModalLabel" style="font-size: 9pt;"><h4><i class="fa fa-eye"></i>&nbsp; Consultar Producto o  servicios.</h4></h2>
                      </div>
                  <div style="margin-top: 1px; background-color: #2e77bc; height: 1px; width: 100%;"></div>
                    <div class="modal-body">
                      
                        <div class="editinplace3 row">

                          
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
                          <h2 class="modal-title" id="myModalLabel" style="font-size: 9pt;"><h4><i class="fa fa-edit"></i>&nbsp; Editar responsable.</h4></h2>
                      </div>
                  <div style="margin-top: 1px; background-color: #2e77bc; height: 1px; width: 100%;"></div>
                    <div class="modal-body">
                        <div class="editinplace3 row">
                           
                               
                        </div>     
                    </div>
                  </div>
              </div>
        </div>
        </div>

        <!-- modal de galeria interna-->
         <div class="modal fade "    id="imagenprin" tabindex="-1" role="basic" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                 <div class="modal-header" style="border-bottom: 4px solid #2e77bc; background-color: #fff; color: #111;">
                         <button  type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                          <h2 class="modal-title" id="myModalLabel" style="font-size: 9pt;"><h4><i class="fa fa-edit"></i>&nbsp; Editar Imagen de producto servicios.</h4></h2>
                      </div>    
                                              <div id="miDiv"></div>
                                                
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
            


  <script type="text/javascript" src="pages/jquery-1.10.2.min.js"></script>

</div>
<link href="assets/fileinput.css" media="all" rel="stylesheet" type="text/css" />
<script src="assets/fileinput.js" type="text/javascript"></script>

