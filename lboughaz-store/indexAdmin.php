<?php
 
 session_start();
 require_once('./component.php');
 require_once('./creatdb.php');
 
  
 
 // create instance of Createdb class
 $database = new Creatdb("Productdb", "Producttb","root","","localhost");
 

 
 
$conn1 = mysqli_connect("localhost","root","","Productdb");

if (!isset($_SESSION['admin']))
{
    header("Location: admin.php");

}

if (isset($_POST['add-product'])){
	 
    
	if (!empty($_POST['product_name']) && !empty($_POST['productOldprice']) &&!empty($_POST['productNewprice']) && 
	!empty($_POST['product_image']) &&!empty($_POST['product_category']) &&!empty($_POST['product_Quantity']) &&!empty($_POST['product_Description'])   ){
	$product_name = $_POST['product_name'];
	$product_old_price = $_POST['productOldprice'];
	$product_new_price = $_POST['productNewprice'];
	$product_image =  $_POST['product_image'];
	$product_category = $_POST['product_category'];
	$product_Quantity = $_POST['product_Quantity'];
	$product_Description = $_POST['product_Description'];

           
		$sql = "INSERT INTO producttb (product_name,productOldPrice,productNewPrice,product_image,product_category,Qte,product_Description) VALUE 
		('$product_name','$product_old_price','$product_new_price','$product_image','$product_category','$product_Quantity','$product_Description')";
		 
			$result = mysqli_query($conn1, $sql);
			if ($result) {
				echo "<script>alert('Product added succesfully ! .')</script>";
			 
			} else {
				echo "<script>alert('Woops! Something Wrong Went.')</script>";
			}	
	}
	else {
		echo "<script>alert('some champ is empty  ! .')</script>";
	}
	
		}
		

		
if (isset($_POST['add-hotDeal-product'])){
    
	if (!empty($_POST['product_name']) && !empty($_POST['productOldprice']) &&!empty($_POST['productNewprice']) && 
	!empty($_POST['product_image']) &&!empty($_POST['product_category']) &&!empty($_POST['product_Quantity']) &&!empty($_POST['product_Description'])   ){
	$product_name = $_POST['product_name'];
	$product_old_price = $_POST['productOldprice'];
	$product_new_price = $_POST['productNewprice'];
	$product_image =  $_POST['product_image'];
	$product_category = $_POST['product_category'];
	$product_Quantity = $_POST['product_Quantity'];
	$product_Description = $_POST['product_Description'];
	$product_sale = $_POST['product_sale'];

           
		$sql = " INSERT INTO producthotdeal (product_name,productOldPrice,productNewPrice,product_image,product_sale ,product_Description ,Qte, product_category) VALUE 
		('$product_name','$product_old_price','$product_new_price','$product_image', '$product_sale' ,'$product_Description' , '$product_Quantity' ,'$product_category')";
		 
			$result = mysqli_query($conn1, $sql);
			if ($result) {
				echo "<script>alert('Product added succesfully ! .')</script>";
			 
			} else {
				echo "<script>alert('Woops! Something Wrong Went.')</script>";
			}	
	}
	else {
		echo "<script>alert('some champ is empty  ! .')</script>";
	}
	
		}
		

if (isset($_POST['update-product'])){
	if (!empty($_POST['product_name']) && !empty($_POST['productOldprice']) &&!empty($_POST['productNewprice']) && 
	!empty($_POST['product_image'])  &&!empty($_POST['product_Quantity']) &&!empty($_POST['product_Description'])  &&!empty($_POST['product_category'])   ){
		$product_name = $_POST['product_name'];
		$product_old_price = $_POST['productOldprice'];
		$product_new_price = $_POST['productNewprice'];
		$product_image =  $_POST['product_image'];
		$product_category = $_POST['product_category'];
		$product_Quantity = $_POST['product_Quantity'];
		$product_Description = $_POST['product_Description'];
	    $product_id = $_POST['productid'];
		   
			 
				   $sql1 ="UPDATE producttb SET
				     productOldPrice = '$product_old_price' , productNewPrice = '$product_new_price'
					 ,product_name = '$product_name' ,  product_image = '$product_image',
					 product_category = '$product_category' , Qte = '$product_Quantity',
					 product_Description = '$product_Description'
				     where productid = '$product_id' ";
				   $result1 = mysqli_query($conn1, $sql1);  
				   if ($result1) { 
					    echo "<script>alert('Product updated  ! .')</script>";
				   }
				 		
			   
			    

	}
	   else {
		echo "<script>alert('some champ is empty  ! .')</script>";  
	   }
   }
   
   
if (isset($_POST['update-hot-Deal'])){
	if (!empty($_POST['product_id']) && !empty($_POST['productOldprice']) &&!empty($_POST['productNewprice'])) {
		$product_id = $_POST['product_id'];
	   $product_old_price = $_POST['productOldprice'];
	   $product_new_price = $_POST['productNewprice'];
	   $product_sale = $_POST['product_sale'];
	   
	
		   $sql = "SELECT * FROM producthotdeal where productid = '$product_id'  ";
			
			   $result = mysqli_query($conn1, $sql);
			   if ($result->num_rows > 0) {
				   $sql1 ="UPDATE producthotdeal SET productOldPrice = $product_old_price , productNewPrice = $product_new_price , product_sale = $product_sale where productid = '$product_id' ";
				   $result1 = mysqli_query($conn1, $sql1);  
				   if ($result1) { 
					    echo "<script>alert('Product updated  ! .')</script>";
				   }
				 		
			   } 
			   else {
				echo "<script>alert('Product not founded  ! .')</script>";	
			   }

	}
	   else {
		echo "<script>alert('some champ is empty  ! .')</script>";  
	   }
   }
   

if (isset($_POST['delete']))
{
	if (!empty($_POST['delete_product_id']) ) {
		$product_id = $_POST['delete_product_id'];
		
		$sql = "SELECT * FROM producttb where productid = '$product_id'  ";
			
		$result = mysqli_query($conn1, $sql);
		if ($result->num_rows > 0) {
			
			$sql1 =" DELETE FROM producttb where productid = '$product_id' ;
		 
			  ";
			 
		 	$result1 = mysqli_query($conn1, $sql1);  
			if ($result1) { 
				 echo "<script>alert('Product deleted  ! .')</script>";
			}
				  
		} 
		else {
		 echo "<script>alert('Product not founded  ! .')</script>";	
		}

	}
    else {
		echo "<script>alert('some champ is empty  ! .')</script>";
	}

}	
if (isset($_POST['delete-hotdeal-product']))
{
	if (!empty($_POST['product_id']) ) {
		$product_id = $_POST['product_id'];
		
		$sql = "SELECT * FROM producthotdeal where productid = '$product_id'  ";
			
		$result = mysqli_query($conn1, $sql);
		if ($result->num_rows > 0) {
			$sql1 =" DELETE FROM producthotdeal where productid = '$product_id' ";
		 	$result1 = mysqli_query($conn1, $sql1);  
			if ($result1) { 
				 echo "<script>alert('Product deleted  ! .')</script>";
			}		  
		} 
		else {
		 echo "<script>alert('Product not founded  ! .')</script>";	
		}

	}
    else {
		echo "<script>alert('some champ is empty  ! .')</script>";
	}

} 	
 
 
?>
<!DOCTYPE html>
<html lang="en">
	<head>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script><meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		 <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<title>Electro - Lboughaz</title>

		<!-- Google font -->
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

		<!-- Bootstrap -->
		<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>

		<!-- Slick -->
		<link type="text/css" rel="stylesheet" href="css/slick.css"/>
		<link type="text/css" rel="stylesheet" href="css/slick-theme.css"/>

		<!-- nouislider -->
		<link type="text/css" rel="stylesheet" href="css/nouislider.min.css"/>

		<!-- Font Awesome Icon -->
		<link rel="stylesheet" href="css/font-awesome.min.css">

		<!-- Custom stlylesheet -->
		<link type="text/css" rel="stylesheet" href="css/style.css"/>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

    </head>

    <body>
		<!-- HEADER -->
		<header>
			<!-- TOP HEADER -->
			<div id="top-header">
				<div class="container">
					<ul class="header-links pull-left">						
						<li><a href="#"><i class="fa fa-envelope-o"></i> email@email.com</a></li>
						<li><a href="#"><i class="fa fa-map-marker"></i> 1734 Stonecoal Road</a></li>
						<?php
						if (isset($_SESSION['admin'])) {
							echo ' <li style ="color:white"><span style="padding-left:50px;"></span>  Welcome-Admin<span style="padding-left:8px;"></span> <a style ="color :white ;font-size:16px;text-shadow: 2px 2px 8px #D81717;">  '. $_SESSION['admin'] .'   </a>    </li> ' ;
					 
						}
						?>			 
						</ul>
					<ul class="header-links pull-right">
						<li><a href="#"><i class="fa fa-dollar"></i> USD</a></li>
						<?php
						if (isset($_SESSION['admin'])) {
						echo '<li><a href="logout.php"><i class="fa fa-user-o"></i> Logout </a></li>';
						}
					 
				    ?>
						</ul>
				</div>
			</div>
			<!-- /TOP HEADER -->

			<!-- MAIN HEADER -->
			<div id="header">
				<!-- container -->
				<div class="container">
					<!-- row -->
					<div class="row">
						<!-- LOGO -->
						<div class="col-md-3">
							<div class="header-logo">
								<a href="index.php" class="logo">
									<img src="./img/logo.png" alt="">
								</a>
							</div>
						</div>
						<!-- /LOGO -->

                </div>
            </div>
        </div>   
		<!-- section title --><br>
		<?php
		if (isset($_SESSION['admin'])){
			echo'<div class="container">
						<div class="section-title">
							<h4 class="title">Welcome Admin :<h4 style ="color:#DA1C1C ;padding; 10px" >'.$_SESSION['admin'].'</h4></h4>
						</div>					
		</div>
		';
		}?>
		
					<!-- /section title -->
<form action="indexAdmin.php" method="POST"  >  
<div class="card-group" style ="display :flex ; padding : 50px;margin : 25px  " >

  <div class="card " style ="padding : 20px">
    <img src="./img/addProduct.png" style ='width : 120px;height : 120px ' class="card-img-top" alt="..."><br>
    <div class="card-body">
      <h4 class="card-title"  style = "font-size : 22px;color :#25E532">Add Product </h4>
      <p class="card-text">Click this button bellow if you want to add an product to Database.</p>
	  <br><br><br><br>
      <input type="submit" class="btn btn-success"name ="add" value="Add New Product"  >
	   
	 <!-- <input type="submit" class="btn btn-success"name ="add_hot_deal" value="Add to hot Deal"  > -->
    </div>
  </div>
  
  <div class="card"style ="padding : 20px">
     <img src="./img/updateProduct.png" style ='width : 120px;height : 120px ' class="card-img-top" alt="...">
     <div class="card-body">
		<br>
        <h4 class="card-title"  style = "font-size : 22px;color :#1838BA">Update Product</h4>
        <p class="card-text">Click this button bellow if you want to update the Informations of  some product from the Database.</p><br>
	    <div style='width: 40%;  '><input type='number' name='product_id' class='form-control' placeholder ="id : "  min ='0' ></div>
		<br>  
		<input type="submit" class="btn btn-primary"name ="update" value="update Product"  >
		
		 <!--<input type="submit" class="btn btn-primary"name ="update_hotdeal" value="update from Hot Deal"  > -->
     </div>
  </div>
 
  <div class="card"style ="padding : 20px">
    <img src="./img/deleteProduct.png" style ='width : 110px ;height : 110px' class="card-img-top" alt="...">
    <div class="card-body">
		<br>
      <h4 class="card-title"  style = "font-size : 22px;color :#F62121">Delete Product</h4>
      <p class="card-text">Click this button bellow if you want to delete an product from the Database.</p><br><br>
	  <div style='width: 40%;  '><input type='number' name='delete_product_id' class='form-control' placeholder ="id : "  min ='0' ></div>
		<br>
	  <input type="submit" class="btn btn-danger"name ="delete" value="delete Product"  >
	  
	  <!-- <input type="submit" class="btn btn-danger"name ="delete_hotdeal" value="delete from hot deal"  >-->
    </div>
  </div>
</div>


<div class="card-group" style ="display :flex ; padding : 50px;margin : 12px  " >

  <div class="card " style ="padding : 20px">
    <img src="./img/user1.png" style ='width : 120px;height : 120px ' class="card-img-top" alt="..."><br>
    <div class="card-body">
      <h3 class="card-title" style = "color :#DA1C1C"> View Users </h3><br>
      
	  <h5 class="card-text">Click this button bellow if you want to Display Users who are registred in the Web-Site.<br>choose the Number of users First </h5><br>
	  <div style='width: 40%;  '><input type='number' name='limit_users' class='form-control' placeholder ="id : "  min ='0' ></div>
	 <br>
      <input type="submit" class="btn btn-success"name ="View_users" value="View users"  >
	 
	  
	 <!-- <input type="submit" class="btn btn-success"name ="add_hot_deal" value="Add to hot Deal"  > -->
    </div>
  </div>
  <div class="card " style ="padding : 20px">
    <img src="./img/review.png" style ='width : 120px;height : 120px ' class="card-img-top" alt="..."><br>
    <div class="card-body">
      <h3 class="card-title" style = "color :#DA1C1C"> View Users Review</h3><br>
      <h5 class="card-text">Click this button bellow if you want to Display Users Review in the Web-Site.<br>this will make you   </h5>
	 
		<br><br>	<br><br>
     
	  <input type="submit" class="btn btn-info"name ="View_users_Review" value="View users Review"  >
	  
	 <!-- <input type="submit" class="btn btn-success"name ="add_hot_deal" value="Add to hot Deal"  > -->
    </div>
  </div>
  <div class="card " style ="padding : 20px">
    <img src="./img/order.jpg" style ='width : 120px;height : 120px ' class="card-img-top" alt="..."><br>
    <div class="card-body">
      <h3 class="card-title" style = "color :#DA1C1C"> View Orders </h3><br>
      <h5 class="card-text">Click this button bellow if you want to Display Orders that was requested <br>choose the Number of Orders First ! </h5>
	  <div style='width: 40%;  '><input type='number' name='limit_Orders' class='form-control' placeholder ="id : "  min ='0' ></div>
	  
		<br> 
      <input type="submit" class="btn btn-primary"name ="View_Orders" value="View Orders"  >
	  
	 <!-- <input type="submit" class="btn btn-success"name ="add_hot_deal" value="Add to hot Deal"  > -->
    </div>
  </div>
  <div class="card " style ="padding : 20px">
    <img src="./img/productIcon.png" style ='width : 120px;height : 120px ' class="card-img-top" alt="..."><br>
    <div class="card-body">
      <h3 class="card-title" style = "color :#DA1C1C"> View Products </h3><br>
      <h5 class="card-text">Click this button bellow if you want to Display Products In the Stock 
		<br><br><br><br><br><br><br>
      <input type="submit" class="btn btn-warning"name ="View_Products" value="View Products"  >
	  
	 <!-- <input type="submit" class="btn btn-success"name ="add_hot_deal" value="Add to hot Deal"  > -->
    </div>
  </div>
 
</div>
</form>
<?php

if (isset($_POST['View_users'])){
	if (empty($_POST['limit_users'])) {
		echo '<script>alert("Choose the Number Of Users First ...!")</script>';
	}else {

	$limit = $_POST['limit_users'] ; 
	$result = $database->get_Users($limit);
   echo ' 
 
   <div class="row"  style = "margin : 80px ">
	   <div class="col-md-12" >
		   <div class="page-header">
			   <h2  style = "color :red"> List Of Users who Registred  </h2>
			 
		   </div>
		   <table class="table">
			 <thead>
			   <tr style = "color : #0B2A90">
				 <th scope="col">id_user </th>
				 <th scope="col">username</th>
				 <th scope="col">Email</th>
				 <th scope="col">TEL</th>
				<th scope="col">Adresse</th>
			   </tr>
			 </thead>
			 <tbody>';
			 while ($row = mysqli_fetch_assoc($result)){
				echo '
				<tr>
                    <th scope="row" style = "color:#D20808">'.$row['id_user'].'</th>
					<th scope="row">'.$row['username'].'</th>
                    <th scope="row">'.$row['email'].'</th>
					<th scope="row">'.$row['user_tel'].'</th>
					<th scope="row">'.$row['user_adr'].'</th>
                </tr>';
			}
			echo '     </tbody>
            </table>
        </div>
    </div> 
     
';
}
}



if (isset($_POST['View_users_Review'])){
	 
	$result = $database->get_Users_Review();
   echo ' 
 
   <div class="row"  style = "margin : 80px ">
	   <div class="col-md-12" >
		   <div class="page-header">
			   <h2  style = "color :red"> List Of Users Reviews   </h2>
			 
		   </div>
		   <table class="table">
			 <thead>
			   <tr style = "color : #0B2A90">
				 <th scope="col">review id </th>
				 <th scope="col">username</th>
				 <th scope="col">product id</th>
				 <th scope="col">product Name</th>
				<th scope="col">rate</th>
				<th scope="col">commentary</th>
				<th scope="col">review Date</th>
			   </tr>
			 </thead>
			 <tbody>';
			 while ($row = mysqli_fetch_assoc($result)){
				echo '
				<tr>
                    <th scope="row" style = "color:#D20808">'.$row['rev_id'].'</th>
					<th scope="row">'.$row['username'].'</th>
                    <th scope="row">'.$row['prod_id'].'</th>
					<th scope="row">'.$row['product_name'].'</th>
					<th scope="row">'.$row['rate'].'</th>
					<th scope="row">'.$row['commentaire'].'</th>
					<th scope="row">'.$row['review_date'].'</th>
                </tr>';
			}
			echo '     </tbody>
            </table>
        </div>
    </div> 
     
';
}


if (isset($_POST['View_Orders'])){
	if (empty($_POST['limit_Orders'])) {
		echo '<script>alert("Choose the Number Of Orders First ...!")</script>';
	}else {

	$limit = $_POST['limit_Orders'] ; 
	$result = $database->get_Orders($limit);
   echo ' 
 
   <div class="row"  style = "margin : 80px ">
	   <div class="col-md-12" >
		   <div class="page-header">
			   <h2  style = "color :red"> List Of Orders that was requested  </h2>
			 
		   </div>
		   <table class="table">
			 <thead>
			   <tr style = "color : #0B2A90">
				 <th scope="col">order_id </th>
				 <th scope="col">user Name</th>
				 <th scope="col">order_products</th>
				 <th scope="col">order_date</th>
				<th scope="col">order_total_Price</th>
				<th scope="col">order_Methode</th>
				<th scope="col">Paypal_order_Id</th>
			   </tr>
			 </thead>
			 <tbody>';
			 while ($row = mysqli_fetch_assoc($result)){
				echo '
				<tr>
                    <th scope="row" style = "color:#D20808">'.$row['order_id'].'</th>
					<th scope="row">'.$row['username'].'</th>
                    <th scope="row">'.$row['order_products'].'</th>
					<th scope="row">'.$row['order_date'].'</th>
					<th scope="row">'.$row['order_total_Price'].'$</th>
					<th scope="row">'.$row['order_Methode'].'</th>
					<th scope="row">'.$row['Paypal_order_Id'].'</th>
                </tr>';
			}
			echo '     </tbody>
            </table>
        </div>
    </div> 
     
';
}
}



if (isset($_POST['View_Products'])){
	 
	$result = $database->getData();
   echo ' 
 
   <div class="row"  style = "margin : 80px ">
	   <div class="col-md-12" >
		   <div class="page-header">
			   <h2  style = "color :red"> List Of Products In the Stock </h2>
			 
		   </div>
		   <table class="table">
			 <thead>
			   <tr style = "color : #0B2A90">
				 <th scope="col">Product Id </th>
				 <th scope="col">Product Name</th>
				 <th scope="col"> Old Price</th>
				 <th scope="col"> New Price</th>
				<th scope="col">Product Image</th>
				<th scope="col">Product Category</th>
				<th scope="col">Product Quantite</th>
				<th scope="col">Product Description</th>
				<th scope="col">Product Rate</th>
			   </tr>
			 </thead>
			 <tbody>';
			 while ($row = mysqli_fetch_assoc($result)){
				echo '
				<tr>
                    <th scope="row" style = "color:#D20808">'.$row['productid'].'</th>
					<th scope="row">'.$row['product_name'].'</th>
                    <th scope="row">'.$row['productOldPrice'].'</th>
					<th scope="row">'.$row['productNewPrice'].'</th>
					<th scope="row"><img style="width:30%;" src="./img/'.$row["product_image"].'" alt=""></th>
					<th scope="row">'.$row['category_name'].'</th>
					<th scope="row" style = "color:#D20808">'.$row['Qte'].' Items</th>
					<th scope="row">'.$row['product_description'].'</th>
					<th scope="row">'.$row['product_rate'].'</th>
                </tr>';
			}
			echo '     </tbody>
            </table>
        </div>
    </div> 
     
';
 
}

if (isset($_POST['add'])){
echo ' <form style = "padding : 80px" action="indexAdmin.php" method="POST">
<div class="mb-3">
  <label for="" class="form-label">Product Name</label>
  <input type="text" class="form-control"  name ="product_name">
</div>
<div class="mb-3" >
  <label for="" class="form-label">Product Old Price</label>
  <input type="number" class="form-control"  name ="productOldprice" min = "0" >
</div>
<div class="mb-3" >
  <label for="" class="form-label">Product New Price</label>
  <input type="number" class="form-control"  name ="productNewprice" min = "0" >
</div>
<div class="mb-3" >
  <label for="" class="form-label">Product Image</label>
  <input type="text" class="form-control"  name ="product_image"	>
</div>
<div class="mb-3" >
  <label for="" class="form-label">Product Description</label>
  <input type="text" class="form-control"  name ="product_Description"	>
</div>
<br>
<div class="mb-3" >
  <label for="" class="form-label">Product Category  :</label>
<select  name="product_category" >
  <option value="2">Smartphone</option>
  <option value="3">laptop</option>
  <option value="1">camera</option>
  <option value="4">accessoires</option>
</select>
<br>
<label for="" class="form-label">Product Quantity  :</label>
<select  name="product_Quantity" >
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
  <option value="6">6</option>
  <option value="7">7</option>
  <option value="8">8</option>
  <option value="9">9</option>
  <option value="10">10</option>
</select>
</div>
 <br>
<button  type="submit" class="btn btn-success" name = "add-product" >add Product</button>
 
</form> ' ;

}
if (isset($_POST['add_hot_deal'])){
	echo ' <form style = "padding : 80px" action="indexAdmin.php" method="POST">
	<div class="mb-3">
	  <label for="" class="form-label">Product Name</label>
	  <input type="text" class="form-control"  name ="product_name">
	</div>
	<div class="mb-3" >
	  <label for="" class="form-label">Product Old Price</label>
	  <input type="number" class="form-control"  name ="productOldprice" min = "0" >
	</div>
	<div class="mb-3" >
	  <label for="" class="form-label">Product New Price</label>
	  <input type="number" class="form-control"  name ="productNewprice" min = "0" >
	</div>
	<div class="mb-3" >
	  <label for="" class="form-label">Product Image</label>
	  <input type="text" class="form-control"  name ="product_image"	>
	</div>
	<div class="mb-3" >
      <label for="" class="form-label">Product Description</label>
      <input type="text" class="form-control"  name ="product_Description"	>
    </div>
	<br>
	<div class="mb-3" >
	  <label for="" class="form-label">Product Category  :</label>
	  <select  name="product_category" >
	  <option value="2">Smartphone</option>
      <option value="3">laptop</option>
      <option value="1">camera</option>
      <option value="4">accessoires</option>
	</select>
	</div>
	<div class="mb-3" >
	<label for="" class="form-label">Product Sales  :</label>
	<select  name="product_sale" >
	<option value="10">10%</option>
	<option value="20">20%</option>
	<option value="30">30%</option>
	<option value="40">40%</option>
	<option value="50">50%</option>
    </select>
	<br><br>
	<label for="" class="form-label">Product Quantity  :</label>
   <select  name="product_Quantity" >
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">7</option>
    <option value="8">8</option>
    <option value="9">9</option>
    <option value="10">10</option>
   </select>
  </div>
	 <br>
	<button  type="submit" class="btn btn-success" name = "add-hotDeal-product" >add Product</button>
	 
	</form> ' ;
	
	}


if (isset($_POST['update'])){
	if (!empty($_POST['product_id'])) {
		$product_id = $_POST['product_id'] ;
		$sql = "SELECT * FROM producttb where productid = '$product_id'  ";
		$result = mysqli_query($conn1, $sql);
		if ($result->num_rows > 0) { 
		$result = $database->getProductDetail($_POST["product_id"]);
		while ($row = mysqli_fetch_assoc($result)){
			echo ' <form style = "padding : 80px" action="indexAdmin.php" method="POST">
			<div class="mb-3">
			  <label for="" class="form-label">Product Name</label>
			  <input type="text" class="form-control"  name ="product_name" value ="'.$row["product_name"].'">
			</div>
			<div class="mb-3" >
			  <label for="" class="form-label">Product Old Price</label>
			  <input type="number" class="form-control"  name ="productOldprice" min = "0" value ="'.$row["productOldPrice"].'" >
			</div>
			<div class="mb-3" >
			  <label for="" class="form-label">Product New Price</label>
			  <input type="number" class="form-control"  name ="productNewprice" min = "0" value ="'.$row["productNewPrice"].'" >
			</div>
			<div class="mb-3" >
			  <label for="" class="form-label">Product Image</label>
			  <input type="text" class="form-control"  name ="product_image" value ="'.$row["product_image"].'"	>
			</div>
			<div class="mb-3" >
			  <label for="" class="form-label">Product Description</label>
			  <input type="text" class="form-control"  name ="product_Description" value ="'.$row["product_description"].'"	>
			</div>
		
			<div class="mb-3" >
			 <br> <br>
			<label for="" class="form-label"  >Product Current Quantity  :</label>
			<input type="text" class="form-control" value ="'.$row["Qte"].' items'.'"	>
		   <br>
			<label for="" class="form-label"  >Product New Quantity  :</label>
			<select  name="product_Quantity"  >
			  <option value="1">1</option>
			  <option value="2">2</option>
			  <option value="3">3</option>
			  <option value="4">4</option>
			  <option value="5">5</option>
			  <option value="6">6</option>
			  <option value="7">7</option>
			  <option value="8">8</option>
			  <option value="9">9</option>
			  <option value="10">10</option>
			</select> <br> <br></div>
			<label for="" class="form-label"  >Product Current Category   :</label>
			<input type="text" class="form-control" value ="'.$row["category_name"].'"	>
		   <br>
			
			<div class="mb-3" >
			<label for="" class="form-label">Product New Category  :</label>
			<select  name="product_category" >
			  <option value="2">Smartphone</option>
			  <option value="3">laptop</option>
			  <option value="1">camera</option>
			  <option value="4">accessoires</option>
			</select>
			</div>
			 <br>
			<button  type="submit" class="btn btn-success" name = "update-product" >Update Product</button>
			<input type="hidden" name ="productid" value ="'.$row["productid"].'">
			 
			</form> ' ;
		 
		 }
		}else {
			echo '<div style = " " class="alert alert-danger" role="alert"> 
			<h5>   there is no product with this id ! </h5>
		  </div> ' ;
		}
	
	}else {
		echo '<div style = " " class="alert alert-danger" role="alert"> 
		<h5>   select product id first ! </h5>
	  </div> ' ;
	}
	
	
	}
	if (isset($_POST['update_hotdeal'])){
		echo ' <form style = "padding : 80px" action=" " method="POST">
		<div class="mb-3">
		  <label for="" class="form-label">Product id</label>
		  <input type="number" class="form-control" min="0" name ="product_id">
		</div>
		<div class="mb-3" >
		  <label for="" class="form-label">Product Old Price</label>
		  <input type="number" class="form-control"  name ="productOldprice" min = "0" >
		</div>
		<div class="mb-3" >
		  <label for="" class="form-label">Product New Price</label>
		  <input type="number" class="form-control"  name ="productNewprice" min = "0" >
		</div>
		<div class="mb-3" >
		<label for="" class="form-label">Product sales</label>
		<select  name="product_sale" >
	    <option value="10">10%</option>
		<option value="20">20%</option>
		<option value="30">30%</option>
		<option value="40">40%</option>
		<option value="50">50%</option>
		</select>
	    </div>
		 
		 <br>
		<button  type="submit" class="btn btn-primary" name = "update-hot-Deal" >Update Product</button>
		 
		</form> ' ;
		
		}

  ?>
		<!-- FOOTER -->
		<footer id="footer">
			<!-- top footer -->
			<div class="section">
				<!-- container -->
				<div class="container">
					<!-- row -->
					<div class="row">
						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">About Us</h3>
								<p>7ena homa a7essan trinom f le3alam (osama-kamal-nasar) klash m3a tnach </p>
								<ul class="footer-links">
									<li><a href="#"><i class="fa fa-map-marker"></i>rakom 3arfin localizasyon </a></li>
									<li><a href="#"><i class="fa fa-phone"></i>9iyed 3ndk 06....</a></li>
									<li><a href="#"><i class="fa fa-envelope-o"></i>baryochino@email.com</a></li>
								</ul>
							</div>
						</div>

						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">Categories</h3>
								<ul class="footer-links">
									<li><a href="#">Hot deals</a></li>
									<li><a href="#">Laptops</a></li>
									<li><a href="#">Smartphones</a></li>
									<li><a href="#">Cameras</a></li>
									<li><a href="#">Accessories</a></li>
								</ul>
							</div>
						</div>

						<div class="clearfix visible-xs"></div>

						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">Information</h3>
								<ul class="footer-links">
									<li><a href="#">About Us</a></li>
									<li><a href="#">Contact Us</a></li>
									<li><a href="#">Privacy Policy</a></li>
									<li><a href="#">Orders and Returns</a></li>
									<li><a href="#">Terms & Conditions</a></li>
								</ul>
							</div>
						</div>

						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">Service</h3>
								<ul class="footer-links">
									<li><a href="#">My Account</a></li>
									<li><a href="#">View Cart</a></li>
									<li><a href="#">Wishlist</a></li>
									<li><a href="#">Track My Order</a></li>
									<li><a href="#">Help</a></li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /row -->
				</div>
				<!-- /container -->
			</div>
			<!-- /top footer -->

			<!-- bottom footer -->
			<div id="bottom-footer" class="section">
				<div class="container">
					<!-- row -->
					<div class="row">
						<div class="col-md-12 text-center">
							<ul class="footer-payments">
								<li><a href="#"><i class="fa fa-cc-visa"></i></a></li>
								<li><a href="#"><i class="fa fa-credit-card"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-paypal"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-mastercard"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-discover"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-amex"></i></a></li>
							</ul>
							<span class="copyright">
								<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
								Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Lboughaz</a>
							<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
							</span>
						</div>
					</div>
						<!-- /row -->
				</div>
				<!-- /container -->
			</div>
			<!-- /bottom footer -->
		</footer>
		<!-- /FOOTER -->
 
		<!-- jQuery Plugins -->
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/popper.js"></script>
		<script src="js/slick.min.js"></script>
		<script src="js/nouislider.min.js"></script>
		<script src="js/jquery.zoom.min.js"></script>
		<script src="js/main.js"></script> 
    </body>