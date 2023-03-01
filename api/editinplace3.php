<?php


include '../inc/config.php';


 $idu=$_GET['idu'];




if (isset($_POST) && count($_POST)>0)
{
	if ($db->connect_errno) 
	{
		die ("<span class='ko'>Fallo al conectar a MySQL: (" . $db->connect_errno . ") " . $db->connect_error."</span>");
	}
	else
	{
		$query=$db->query("update proveedor set ".$_POST["campo"]."='".$_POST["valor"]."' where id_proveedor='".intval($_POST["id"])."' limit 1");
		if ($query) echo "<span class='ok'>Valores modificados correctamente.</span>";
		else echo "<span class='ko'>".$db->error."</span>";
	}
}

if (isset($_GET) && count($_GET)>0)
{
	if ($db->connect_errno) 
	{
		die ("<span class='ko'>Fallo al conectar a MySQL: (" . $db->connect_errno . ") " . $db->connect_error."</span>");
	}
	else
	{   
		// select * from editinplace order by idusuario asc
		
		$query=$db->query("SELECT * FROM `proveedor` where id_proveedor=$idu");
		$datos=array();
		while ($usuarios=$query->fetch_array())
		{
			$datos[]=array(	"id_proveedor"=>$usuarios["id_proveedor"],
							"ci_proveedor"=>$usuarios["ci_proveedor"],
							"nombre_proveedor"=>$usuarios["nombre_proveedor"],
							"telefono_proveedor"=>$usuarios["telefono_proveedor"],
							"correo"=>$usuarios["correo"],
							"cargo"=>$usuarios["cargo"],
							"estado_proveedor"=>$usuarios["estado_proveedor"],
							"fecha_nacimiento"=>$usuarios["fecha_nacimiento"],
							"imagen"=>$usuarios["imagen"]
						
			);
		}
		echo json_encode($datos);
	}
}
?>