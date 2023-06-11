<?php

session_start();
require_once('./component.php');
require_once('./creatdb.php');

 

// create instance of Createdb class
$database = new Creatdb("Productdb", "Producttb","root","","localhost");
$conn = mysqli_connect("localhost","root","","Productdb");

if (isset($_POST['submit_review'])){
	if (!isset($_SESSION['username'])) {
		echo '<script>alert("you have to sign up first")</script>';
		echo '<script>window.location = "login.php"</script>';
	}
	else {
		if (!empty($_POST["rating"]) && !empty($_POST["review_content"])  ) {

			$username = $_SESSION['username'] ;
		   $review_content = $_POST["review_content"];
		   $productid = $_GET["id"] ;
		 
		   $date = date('Y-m-d H:i:s'); 
		   $rate = $_POST["rating"];
		   $result = mysqli_query($conn,"SELECT product_rate from producttb where productid = '$productid'");
		   $row = mysqli_fetch_assoc($result) ;

		   if ($row['product_rate'] != 0 ) {
			$New_rate = round( ( $row['product_rate'] + $rate )/ 2 ) ;
		   }else{ 
			$New_rate = $rate ;
		   }
	       
		   
		    $sql = "INSERT INTO review (user_id,prod_id,rate,commentaire,review_date) value 
		    ( (select id_user from users where username = '$username') ,$productid , $rate , '$review_content' , '$date'  ) ";
             $result = mysqli_query($conn, $sql);
            
			 $sql2 = " UPDATE producttb set product_rate = '$New_rate' where productid = '$productid' ";
			  $result2 = mysqli_query($conn, $sql2);

		     if ($result) {
                 echo '<script>alert("your review added succefully !");</script>';
		       }
		}
		else {
			echo '<script>alert("you have to fill all the forms")</script>';
			echo '<script>window.location="product.php?id='.$_GET["id"].'"</script>';
		}    
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

		<title>Electro - HTML Ecommerce Template</title>

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
						<li><a href="hotdeal.php">Hot Deals</a></li>
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
		<!-- /NAVIGATION -->

		<!-- BREADCRUMB -->
		<div id="breadcrumb" class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<ul class="breadcrumb-tree">
							<li><a href="#">Home</a></li>
							<li class="active"><?php
				        $productid = $_GET["id"] ; 
			        	$result = $database->getProductDetail($productid);
				    	while ($row = mysqli_fetch_assoc($result)){
				     	echo $row['product_name'] ;
					 	}   ?></li>
						</ul>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /BREADCRUMB -->

		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
				
      
					<!-- Product details -->

					<?php

					 

					$curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
                    $productid = $_GET["id"] ; 
			     	$result = $database->getProductDetail($productid);
					while ($row = mysqli_fetch_assoc($result)){
					productDetail($row['productid'],$row['product_name'], $row['productOldPrice'],$row['productNewPrice'], $row['product_image'],$row['category_name'] ,$row['Qte'] ,$row['product_description'] , $row['nbr_review']  ,$curPageName);
					}
				
			      
					?>

					<!-- /Product details -->

					<!-- Product tab -->
					<div class="col-md-12">
						<div id="product-tab">
							<!-- product tab nav -->
							<ul class="tab-nav">
								<li class="active"><a data-toggle="tab" href="#tab1">Description</a></li>
								<li><a data-toggle="tab" href="#tab2">Details</a></li>
								<li><a data-toggle="tab" href="#tab3">Reviews </a></li>
							</ul>
							<!-- /product tab nav -->

							<!-- product tab content -->
							<div class="tab-content">
								<!-- tab1  -->
								<div id="tab1" class="tab-pane fade in active">
								
									<div class="row">
										<div class="col-md-12">
											<p> 
											<?php
											 $productid = $_GET["id"] ; 
											$result = $database->getProductDetail($productid);
											while ($row = mysqli_fetch_assoc($result)){
												echo $row['product_description'] ;
											}
											?>
					                        </p>
										</div>
									</div>
								</div>
								<!-- /tab1  -->

								<!-- tab2  -->
								<div id="tab2" class="tab-pane fade in">
									<div class="row">
										<div class="col-md-12">
											<p><?php
											 $productid = $_GET["id"] ; 
											$result = $database->getProductDetail($productid);
											while ($row = mysqli_fetch_assoc($result)){
												echo $row['product_description'] ;
											}
											?></p>
										</div>
									</div>
								</div>
								<!-- /tab2  -->

								<!-- tab3  -->
								<div id="tab3" class="tab-pane fade in">
									<div class="row">
									<div class="container">
                                        <?php
                                        $productid = $_GET["id"] ; 
										$result1 = $database->getProductReview($productid);
										if($result1 == null){
										    echo 'no review yet ! ' ;
									    }else {
											$result = mysqli_query($conn,"SELECT distinct product_rate from producttb where productid = '$productid'");
											$r = mysqli_fetch_assoc($result) ; 
                                             $product_rate = $r['product_rate'];
											 $product_stars ='';
                                             $no_Rating ='';
											 $stars = '<i class=" fa fa-star"></i>'; 

											 for( $i = 0; $i < $product_rate; $i++ ) {
												$product_stars .=  $stars ;    
											}
											if ($product_stars ==''){
												$no_Rating = 'No Rating for this product yet ' ;
                                                }
											?>
                                                          <!-- Rating -->
                                          <div class="col-md-3">
												<div id="rating">
													 <div class="rating-avg">
													    <h4>Product Rating : <?php echo $r['product_rate'] ?></h4>
													    
													    <h5>  <?php echo $no_Rating ?> </h5>
													    <div class="rating-stars">
														<?php echo $product_stars ?>
													    </div>
													 </div>	 
												</div>
											</div>
                                                           <!-- /Rating -->
                                    <div class="col-md-8">
 
                                           <?php
											while ($row = mysqli_fetch_assoc($result1)){
											Review($row['username'],$row['rate'], $row['commentaire'],$row['review_date'] );
										}
										}
										?>
										  <!--
										        <ul class="reviews-pagination">
													<li class="active">1</li>
													<li><a href="#">2</a></li>
													<li><a href="#">3</a></li>
													<li><a href="#">4</a></li>
													<li><a href="#"><i class="fa fa-angle-right"></i></a></li>
												</ul>  -->
                                         </div>
								    	
									<br>
										<!-- /Reviews -->

										<!-- Review Form -->
										<div class="col-md-11">
											<br>
											<div id="review-form">
												<form class="review-form" method = "post">
													<!--<input class="input" type="text" placeholder="Your Name" name = "review-name" >-->
											 	    <!--<input class="input" type="email" placeholder="Your Email" name = "review-Email" >-->
													<textarea class="input" placeholder="Write Your Review here ..." name = "review_content"></textarea>
													<div class="input-rating"  style = 'text-align : right '>
														<strong  >Your Rating: </strong>
														<div class="stars" >
															<input id="star5" name="rating" value="5" type="radio"><label for="star5"></label>
															<input id="star4" name="rating" value="4" type="radio"><label for="star4"></label>
															<input id="star3" name="rating" value="3" type="radio"><label for="star3"></label>
															<input id="star2" name="rating" value="2" type="radio"><label for="star2"></label>
															<input id="star1" name="rating" value="1" type="radio"><label for="star1"></label>
														</div>
													</div>
													<div  style = 'text-align : right ' >
                                                           <button class="primary-btn" name ="submit_review">Submit</button>
													</div>
													
												</form>
											</div>
										</div>
										<!-- /Review Form -->
										</div>
									</div>
								</div>
								<!-- /tab3  -->
							</div>
							<!-- /product tab content  -->
						</div>
					</div>
					<!-- /product tab -->
					
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->
		<hr>
		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">

					<!-- section title -->
					<div class="col-md-12">
						<div class="section-title text-center">
							<h3 class="title">- Product Related -</h3>
						</div>					
					</div>
					<!-- /section title -->
				

					<!-- Products tab & slick -->
					<div class="col-md-12">
						<div class="row">
							<div class="products-tabs">
						 
								<!-- tab -->
								<div id="tab1" class="tab-pane active">
									<div class="products-slick" data-nav="#slick-nav-1">
										
										<!-- product -->
										<?php
                                                  $productid = $_GET["id"] ; 
                                                  $result = $database->getProductDetail($productid);
                                                  while ($row = mysqli_fetch_assoc($result)){
													$product_cat =  $row['category_name'] ;
												} 


												$curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);  
												$result = $database->getDataCategory($product_cat);
												while ($row = mysqli_fetch_assoc($result)){	
													component($row['productid'],$row['product_name'], $row['productOldPrice'],$row['productNewPrice'], $row['product_image'],$row['category_name'] ,$row['product_rate'], $curPageName );
												}
										?>
										<!-- /product -->
									</div>
									<div id="slick-nav-1" class="products-slick-nav"></div>
								</div>
								<!-- /tab -->
							</div>
						</div>
					</div>
					<!-- Products tab & slick -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

		<!-- NEWSLETTER -->
		<div id="newsletter" class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<div class="newsletter">
							<p>Sign Up for the <strong>NEWSLETTER</strong></p>
							<form>
								<input class="input" type="email" placeholder="Enter Your Email">
								<button class="newsletter-btn"><i class="fa fa-envelope"></i> Subscribe</button>
							</form>
							<ul class="newsletter-follow">
								<li>
									<a href="#"><i class="fa fa-facebook"></i></a>
								</li>
								<li>
									<a href="#"><i class="fa fa-twitter"></i></a>
								</li>
								<li>
									<a href="#"><i class="fa fa-instagram"></i></a>
								</li>
								<li>
									<a href="#"><i class="fa fa-pinterest"></i></a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /NEWSLETTER -->

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
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.</p>
								<ul class="footer-links">
									<li><a href="#"><i class="fa fa-map-marker"></i>1734 Stonecoal Road</a></li>
									<li><a href="#"><i class="fa fa-phone"></i>+021-95-51-84</a></li>
									<li><a href="#"><i class="fa fa-envelope-o"></i>email@email.com</a></li>
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
								 
								Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This web-site is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://electro.com" target="_blank">electro</a>
						 
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

	</body>
</html>
