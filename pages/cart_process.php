<?php
session_start(); //iniciar session
include '../inc/config.php';
setlocale(LC_MONETARY,"en_US"); // US formato usa format (see : http://php.net/money_format)
############# #########################
if(isset($_POST["id_service"]))
{
	foreach($_POST as $key => $value){
		$new_product[$key] = filter_var($value, FILTER_SANITIZE_STRING); //create a new product array 
	}
// necesitamos obtener el nombre del producto y el precio de la base de datos.
	$statement = $mysqli_conn->prepare("SELECT name_service, price_service FROM service WHERE id_service=? LIMIT 1");
	$statement->bind_param('s', $new_product['id_service']);
	$statement->execute();
	$statement->bind_result($product_name, $product_price);
	

	while($statement->fetch()){ 
		$new_product["name_service"] = $product_name; 
		$new_product["price_service"] = $product_price;  
		
		if(isset($_SESSION["products"])){  
			if(isset($_SESSION["products"][$new_product['id_service']])) 
			{
				unset($_SESSION["products"][$new_product['id_service']]); 
			}			
		}
		
		$_SESSION["products"][$new_product['id_service']] = $new_product;	
	}
	
 	$total_items = count($_SESSION["products"]); 
	die(json_encode(array('items'=>$total_items)));
}

################## lista de productos en carrito ###################
if(isset($_POST["load_cart"]) && $_POST["load_cart"]==1)
{

	if(isset($_SESSION["products"]) && count($_SESSION["products"])>0){ 
		$cart_box = '<ul class="cart-products-loaded">';
		$total = 0;
		foreach($_SESSION["products"] as $product){ 
			
			$product_name = $product["name_service"]; 
			$product_price = $product["price_service"];
			$product_code = $product["id_service"];
			$product_qty = $product["product_qty"];
			

			 $cart_box .=  "<li> $product_name (Cantidad : $product_qty  ) &mdash; ".sprintf("%01.2f", ($product_price * $product_qty)). " <a href=\"#\" class=\"remove-item\" data-code=\"$product_code\">&times;</a></li>";
			$subtotal = ($product_price * $product_qty);
			$total = ($total + $subtotal);
		}
		$cart_box .= "</ul>";
		$cart_box .= '<div class="cart-products-total">Total : '.sprintf("%01.2f",$total).' <u><a href="?mod=view_cart" title="Revisar carro para generar factura ">Generar factura</a></u></div>';
		die($cart_box); 
	}else{
		die("El carrito esta vacio"); 
	}
}

################# Remover producto de carrito ################
if(isset($_GET["remove_code"]) && isset($_SESSION["products"]))
{
	$product_code   = filter_var($_GET["remove_code"], FILTER_SANITIZE_STRING); 

	if(isset($_SESSION["products"][$product_code]))
	{
		unset($_SESSION["products"][$product_code]);
	}
	
 	$total_items = count($_SESSION["products"]);
	die(json_encode(array('items'=>$total_items)));
}