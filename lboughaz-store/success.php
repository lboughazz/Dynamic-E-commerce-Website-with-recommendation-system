<?php
session_start();
require_once('./component.php');
require_once('./creatdb.php');

 

// create instance of Createdb class
$database = new Creatdb("Productdb", "Producttb","root","","localhost");
$conn = mysqli_connect("localhost","root","","Productdb");

 $_SESSION['success'] = 'done' ; 
 $orderID = $_GET['orderID'];
     $sql4= "SELECT Paypal_order_Id FROM orders WHERE Paypal_order_Id='$orderID'  ";
	$result = mysqli_query($conn, $sql4);
	if ($result->num_rows > 0) {
		echo '<script>window.location="successPaypal.php"</script>';
	} else {
		if(isset($_SESSION['success']) ){

			$items = [];
			foreach ($_SESSION["cart"] as $key => $value) {
				$item_array = array(
					'productid' => $value["productid"],
					'productname' => $value["productname"],
					'product_image' => $value["product_image"],
					'productNewPrice' =>$value["productNewPrice"],
					'product_category' => $value["product_category"],
					'item_quantity' => $value["item_quantity"],
				);
			   
						 $items[] =  $value["productname"];          
		   }
			
		
		
		
			// for update the quantity of the products  
			foreach ($_SESSION["cart"] as $key => $value) {
				$result = $database->getProductDetail($value["productid"]);
				$row = mysqli_fetch_assoc($result) ;
						$qte = $row['Qte'] - $value["item_quantity"];
						$pro_id = $value["productid"];
						$sql_for_increase_qte = "UPDATE	producttb set Qte = '$qte' where productid = '$pro_id'  "; 
						$result = mysqli_query($conn, $sql_for_increase_qte);            
			  }  
			 
		
		
		
		
			  // for add the order to orders table
			$allItems = implode(' - ', $items);
			$username = $_SESSION['username'] ; 
			$order_date = date('Y-m-d H:i:s'); 
			$order_Total = $_GET['total'];
			$orderID = $_GET['orderID'];
			
			 
			$sql = "INSERT INTO orders (user_id,order_products,order_date,order_total_Price,order_Methode,Paypal_order_Id) 
				value ( (select id_user from users where username = '$username') ,'$allItems', '$order_date' , '$order_Total' ,'by PAYPAL' ,'$orderID' ) 	
				";
				$result = mysqli_query($conn, $sql);
				if($result) {
					echo '<script>alert("your order was send it successfully  ");</script>';   
					echo '<script>window.location="successPaypal.php"</script>';
					
				}
		 
		 }
	}
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	
</body>
</html>