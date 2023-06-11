<?php
    
session_start();
require_once('./component.php');
require_once('./creatdb.php');

 

// create instance of Createdb class
$database = new Creatdb("Productdb", "Producttb","root","","localhost");
$conn = mysqli_connect("localhost","root","","Productdb");

if (isset($_POST['delivery'])) {


    $total = 0 ; 
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

                     $_SESSION["cart"][$key] = $item_array;
                     $total = $total + ($value["item_quantity"] * $value["productNewPrice"]);
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
    $order_Total = $total ;
     
    $sql = "INSERT INTO orders ( user_id,order_products,order_date,order_total_Price,order_Methode,Paypal_order_Id) 
        value (   (select id_user from users where username = '$username') ,'$allItems', '$order_date' , '$order_Total' , 'cash in delivery' , 'null' ) 	
        ";

       
            $sql2 = "select order_id from orders order by order_id desc limit 1";
            $result = mysqli_query($conn, $sql);
            $resultid = mysqli_query($conn,$sql2);
            $r1 = mysqli_fetch_assoc($resultid);
            $_SESSION['order_id'] = $r1['order_id'];
            $order_id = $_SESSION['order_id'];
            foreach ($_SESSION["cart"] as $key => $value) {
            $prod_id =  $value['productid'];
            $qte = $value['item_quantity'];
            $sql3 = "INSERT into orderProduct (order_id,product_id,qte)
            values
            ($order_id,$prod_id,$qte)";
            $result1 = mysqli_query($conn,$sql3);
            }

        if($result1) {
            echo '<script>alert("your order was send it successfully  ");</script>';    
        }

}
$sql2 = "select order_id from orders order by order_id desc limit 1";
$resultid = mysqli_query($conn,$sql2);


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
<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		 <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<title>Electro - Bedri</title>

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
		<script src ='js/countdown.js'>

		</script>

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
						<li><a href="#"><i class="fa fa-envelope-o"></i> mustapha.bedri@gmail.com</a></li>
						<li><a href="#"><i class="fa fa-map-marker"></i> selwan , Rue 1978</a></li>
						<?php
						if (isset($_SESSION['username'])) {
							echo ' <li style ="color:white"><span style="padding-left:50px;"></span>  Welcome<span style="padding-left:8px;"></span> <a style ="color :white ;font-size:16px;text-shadow: 2px 2px 8px #D81717;">  '. $_SESSION['username'] .'   </a>    </li> ' ;
					 
						}
						?>			 
						</ul>
					<ul class="header-links pull-right">
						<li><a href="#"><i class="fa fa-dollar"></i> USD</a></li>
						<?php
						if (isset($_SESSION['username'])) {
						echo '<li><a href="logout.php"><i class="fa fa-user-o"></i> Logout </a></li>';
						}
						else {
							echo '<li><a href="login.php"><i class="fa fa-user-o"></i> sign up </a></li>';
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

						<!-- SEARCH BAR -->
						<div class="col-md-6">
							<div class="header-search">
							<form action="search.php" method="post">
									<select class="input-select">
										<option value="0">All Categories</option>
										<option value="1"> Smartphones </option>
										<option value="2"> Camera </option>
										<option value="3"> Laptops </option>
										<option value="4"> Accessories </option>
									</select>
									<form action="search.php" method="post">
									<input class="input" placeholder="Search here" name = 'search-content'>
									<button class="search-btn" name ='search'>Search</button>    
								</form>
							</div>
						</div>
						<!-- /SEARCH BAR -->

						<!-- ACCOUNT -->
						<div class="col-md-3 clearfix">
							<div class="header-ctn">
								<!-- Wishlist -->
								<div>
									<a href="#">
										<i class="fa fa-heart-o"></i>
										<span>Your Wishlist</span>
										<div class="qty">7</div>
									</a>
								</div>
								<!-- /Wishlist -->
								<!-- cart -->
								<div>
									<a href="cart.php">
										<i class="fa fa-shopping-cart"></i>
										<span>Your Cart</span>
									    <?php

                                    if (isset($_SESSION['cart'])){
	                                    $count = count($_SESSION['cart']);
                                    	echo "<div class='qty'> <span id=\"cart_count\">$count</span></div>";
                                    }else{
                                    	echo "<div class='qty'> <span id=\"cart_count\" >0</span></div>";
                                    }

                                    ?>
									</a>
								</div>
								<!-- Menu Toogle -->
								<div class="menu-toggle">
									<a href="#">
										<i class="fa fa-bars"></i>
										<span>Menu</span>
									</a>
								</div>
								<!-- /Menu Toogle -->
							</div>
						</div>
						<!-- /ACCOUNT -->
					</div>
					<!-- row -->
				</div>
				<!-- container -->
			</div>
			<!-- /MAIN HEADER -->
		</header>
		<!-- /HEADER -->
<br><br>
<hr>

<div class="container">
    <div class="alert alert-success" role="alert"  >
       <h4 class="alert-heading">Thank You For Your Visiting !</h4>
       <p> Your commande was send it succefully ! </p>
        <hr>
      <p class="mb-0">we will Contact with you by the Phone Number or by Email when the commande finish . </p>
   </div>
</div>

<hr>
<div id = "pddf"> 
    <br> <br>
<div   style = "margin: 10px 150px 10px 150px;">
					<!-- row -->
					<div class="row">
						<!-- LOGO -->
						<div class="col-md-3">
							<div class="header-logo" style = "background-color :  #242222 ; border-radius : 10px ;padding :10px">
								<a href="#" class="logo">
									<img src="./img/logo.png" alt="">
								</a>
							</div>
						</div>
                    </div>
 </div>
 <br><br>
       <?php

      while ($row = mysqli_fetch_assoc($resultid)){
        $order_id =  $row['order_id'] ;
       } 
       global $order_id ;
       $result = $database->getorderDetail($order_id);
      while ($row = mysqli_fetch_assoc($result)){
      ?>
            
     <div   style ="margin: 10px 150px 10px 150px;">
        <div class="card" >
               
                <div class=" card-header row mb-4  " style ="background-color: #DBDBDB ; border-radius : 10px ; padding : 15px ; margin: 10px 0px 10px 0px;  " >
                   <br>
                  <h5 style ="color: red "> Commande ID : <?php  echo $row["order_id"];?> </h5>
                   <br>
                  <strong>Commande Date : <?php echo $row["order_date"]; ?></strong> <br>
                  <br>
				  <strong>Commande Methode : <?php echo $row["order_Methode"]; ?></strong> <br>
                  <span class="float-right"> 
                </div>
                <br><br>
            
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <br>
                        <h4 class="mb-3">From:</h4>
                        <div>
                            <strong>Electro -Bedri </strong>
                        </div>
                        <div><h5>  </h5></div>
                        <div><h5> Selwan - Nador - Morocco </h5> </div>
                        <div><h5> Email: electro-bedri@gmail.com </h5></div>
                        <div><h5>  Phone: +212 60250000 </h5></div>
                    </div>
                    <div class="col-sm-6">
                        <br>
                        <h4 class="mb-3">To :</h4>
                        <div>
                            <strong><?php echo $row["username"]; ?> </strong>
                        </div>
                        <div><h5>  </h5></div>
                        <div><h5> Adresse : <?php echo $row["user_adr"]; ?> </h5> </div>
                        <div><h5> Email: <?php echo $row["email"]; ?> </h5></div>
                        <div><h5>  Phone: <?php echo $row["user_tel"]; ?> </h5></div>
                    </div>
                </div>
                <br><hr>
                <div class="table-responsive-sm">
                <table class="table table-bordered">
            <tr>
			     
                <th width="10%">Product Name</th>
                <th width="10%">Quantity</th>
                <th width="13%">Price Details</th>
                <th width="30%">Total Price</th>            
            </tr>

            <?php
                if(!empty($_SESSION["cart"])){
                    $total = 0;
                    foreach ($_SESSION["cart"] as $key => $value) {
                        ?>
                        <tr>
						      <td><?php echo $value["productname"]; ?></td>
							 
                            <td><?php echo $value["item_quantity"]; ?></td>
                            <td>$ <?php echo $value["productNewPrice"]; ?></td>
                            <td>
                                $ <?php echo number_format($value["item_quantity"] * $value["productNewPrice"], 2); ?></td>
                        </tr>
                        <?php
                        $total = $total + ($value["item_quantity"] * $value["productNewPrice"]);
                       }
                        ?>
                        <tr>
                            <td colspan="3" align="right" style = "color :red"><strong>Total</strong></td>
                            <th align="right">$ <?php echo number_format($total, 2); ?></th>          							 
                        </tr>
                        <?php
                    }
					
                ?>
              </table>
                    </div>
                </div>
            </div>
        </div>
        
    </div>



            <?php
         }
      ?> <div  style = "margin: 10px 150px 10px 150px;">
           <form action="" method="post">
			<div style =" text-align : right ">
			<input  type="submit" class="btn btn-success"name ="download" value="download the Commande as a PDF"  >
			</div>
			</form>
      </div>
         
      <br> 
 </div>    
 <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.8.0/html2pdf.bundle.min.js"></script>
 <?php
          if (isset($_POST['download'])  ) {
              echo '
              <script>          
              var element = document.getElementById("pddf");     
            html2pdf(element, { 
               margin:       10,
               filename:     "myCommande.pdf",
               image:        { type: "jpeg", quality: 0.98 },
               html2canvas:  { scale: 2, logging: true, dpi: 192, letterRendering: true },
               jsPDF:        { unit: "mm", format: "a3", orientation: "portrait" }
            });
              </script>' ; 
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
								Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This Web-site is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://electro.com" target="_blank">Lboughaz</a>
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
		<script src="js/slick.min.js"></script>
		<script src="js/nouislider.min.js"></script>
		<script src="js/jquery.zoom.min.js"></script>
		<script src="js/main.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.8.0/html2pdf.bundle.min.js"></script>
</body>
</html>