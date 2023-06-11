<?php
session_start();
require_once('./component.php');
require_once('./creatdb.php');
require_once('paypal.php');

 

// create instance of Createdb class
$database = new Creatdb("Productdb", "Producttb","root","","localhost");

$conn = mysqli_connect("localhost","root","","Productdb");


// for check the order 
if ( isset($_POST['checkout'])) {
	if (isset($_SESSION['username'])) {
        if (!empty($_SESSION['cart'])) {
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
				$result = $database->getProductDetail($value["productid"]);
				$row = mysqli_fetch_assoc($result) ;
					if ($value["item_quantity"] <= $row['Qte']  ) {
						     $_SESSION["cart"][$key] = $item_array;
					}else {
						echo '<script>alert("quantite insufissant ! ");</script>';
						echo '<script>window.location="cart.php"</script>'; 
						exit();                     
					}         
           }		 
        }else {
            echo '<script>alert("there is no products yet in the shopping Cart ! ");</script>';
			echo '<script>window.location="cart.php"</script>';
        }
	}else {
        echo '<script>alert("you have to sign up First  ! ");</script>';
     	echo '<script>window.location="login.php"</script>';	
	}

}

?>


<!DOCTYPE html>
<html lang="en">
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
		<script src ='countdown.js'>

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

		<!-- NAVIGATION -->
		<nav id="navigation">
			<!-- container -->
			<div class="container">
				<!-- responsive-nav -->
				<div id="responsive-nav">
					<!-- NAV -->
					<ul class="main-nav nav navbar-nav">
						<li class="active"><a href="index.php">Home</a></li>
						<li><a href="#hot-deal">Hot Deals</a></li>
						<li><a href="laptop.php">Laptops</a></li>
						<li><a href="smartphone.php">Smartphones</a></li>
						<li><a href="camera.php">Camera</a></li>
						<li><a href="Accessoire.php">Accessories</a></li>
					</ul>
					<!-- /NAV -->
				</div>
				<!-- /responsive-nav -->
			</div>
			<!-- /container -->
		</nav>
        <br><br>
		<!-- /NAVIGATION -->
        <div class="container" style="width: 65% ;">
        <div style="text-align : center ;background-color: #DBDBDB ; border-radius : 10px ; padding : 15px ; margin: 10px 0px 10px 0px;  "><h2>My Order </h2> </div>
        <br>
        <div style="clear: both"></div>
        <h4 class="title2"style = 'color: red'> Order  Details :</h4>
        <br>
        <div class="table-responsive">
            <table class="table table-bordered">
            <tr>
			    <th width="30%">Product Image</th>
                <th width="20%">Product Name</th>
				<th width="16%">Product Category</th>
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
						    <td style = "text-align : center"><img style="width:30%; " src="./img/<?php echo $value["product_image"]; ?>" alt=""></td>
                            <td><?php echo $value["productname"]; ?></td>
							<td><?php echo $value["product_category"]; ?></td>
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
                            <td colspan="4" align="right" style = 'color: red'><strong>Total</strong></td>
                            <th id="total_prix" align="right">$ <?php 
							$tota = $total ;							
							echo number_format($total, 2); ?></th>
                            <td></td>
							 
                        </tr>
                        <?php
                    }
					
                ?>
            </table>
            <div>
			
              <?php 
			  $payment = new paypal();
			     global $tota ;
			    echo $payment->ui($tota);
			  ?>
			</div> 
            <div >			 
			 
			<form action ="delivery.php" method ="post">
			<button style= 'font-size : 15px ;padding : 17px 312px 17px 312px ; border-radius : 40px'  type="submit" class="btn btn-success" name ="delivery"  > Cash on delivery .</button>
			</form>
			</div>
			 <br>
        </div>
       <div style ="text-align : right; color : bleu" >
       <a href="cart.php"><strong> back To My shoping Cart  ! </strong></a>
       </div>
      </div>

        <br><br>
       
	 
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

       </body>
</html>