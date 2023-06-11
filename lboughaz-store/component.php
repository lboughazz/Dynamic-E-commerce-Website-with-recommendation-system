<?php

function component($productid,$productname,$productOldPrice,$productNewPrice,$productimg,$productCategory, $product_rate ,$curPageName){
    
    $starsComplet ='';
    $stars = '<i class="fa fa-star"></i>'; 

        for( $i = 0; $i < $product_rate; $i++ ) {
              $starsComplet .=  $stars ;    
          }

   $element = "<div class='product'>
   <br>

   <div class='product-img'>
       <img src='./img/". $productimg . "' alt=''>
       <div class='product-label'>     
           <span class='new'>NEW</span>
       </div>
   </div>
   <br><br>
   <div class='product-body'>
       <p class='product-category'>".$productCategory."</p>
       <br>
       <h3 class='product-name'> ".$productname." </h3>
       <h4 class='product-price'>".$productNewPrice."$ <del class='product-old-price'>".$productOldPrice."$</del></h4>
       <div class='product-rating'>
      ".$starsComplet."
       </div>
       <form   action='product.php?id=".$productid."' method=\"post\">
       <div class='product-btns'>
           <!-- <button class='add-to-wishlist'><i class='fa fa-heart-o'></i><span class='tooltipp'>add to wishlist</span></button>-->
           <!-- <button class='add-to-compare'><i class='fa fa-exchange'></i><span class='tooltipp'>add to compare</span></button>-->
           <button class='quick-view' name = 'productDetail'><i class='fa fa-eye'></i><span class='tooltipp'>quick view</span></button>
       </div>
       </form>
       <form   action='cart.php?id=".$productid."' method=\"post\">
   </div>
   <div style='width: 38%;margin:auto;padding:20px;'><input type='number' name='quantity' class='form-control' value='1' min ='0' max ='20'></div>
   <div class='add-to-cart'>
   
       <button class='add-to-cart-btn' name ='add'><i class='fa fa-shopping-cart' ></i>add to cart</button>
      
   </div> 
   <input type='hidden' name ='productid' value ='".$productid."'>
   <input type='hidden' name='hidden_name' value='".$productname."'>
   <input type='hidden' name='hidden_price' value='".$productNewPrice."'>
   <input type='hidden' name='hidden_category' value='".$productCategory."'>
   <input type='hidden' name='hidden_image' value='".$productimg."'>
   <input type='hidden' name='hidden_pagename' value='".$curPageName."'>
   </form>
</div>
";
    
echo $element ; 
}
 function componentHotDeal($productid,$productname,$productOldPrice,$productNewPrice,$productimg,$productCategory ,$productSale ,$curPageName){
    
    $element =  "<div class='product'>
    <br>
 
    <div class='product-img'>
        <img src='./img/". $productimg . "' alt=''>
        <div class='product-label'>     
            <span class='sale'>".$productSale."%</span>
        </div>
    </div>
    <br><br>
    <div class='product-body'>
        <p class='product-category'>".$productCategory."</p>
        <br>
        <h3 class='product-name'><a href='#'>".$productname."</a></h3>
        <h4 class='product-price'>".$productNewPrice."$ <del class='product-old-price'>".$productOldPrice."$</del></h4>
        <div class='product-rating'>
            <i class='fa fa-star'></i>
            <i class='fa fa-star'></i>
            <i class='fa fa-star'></i>
            <i class='fa fa-star'></i>
            <i class='fa fa-star'></i>
        </div>
        <div class='product-btns'>
            <button class='add-to-wishlist'><i class='fa fa-heart-o'></i><span class='tooltipp'>add to wishlist</span></button>
            <button class='add-to-compare'><i class='fa fa-exchange'></i><span class='tooltipp'>add to compare</span></button>
            <button class='quick-view'><i class='fa fa-eye'></i><span class='tooltipp'>quick view</span></button>
        </div>
        <form   action='cart.php?id=".$productid."' method=\"post\">
    </div>
    <div style='width: 38%;margin:auto;padding:20px;'><input type='number' name='quantity' class='form-control' value='1' min ='0' max ='20'></div>
    <div class='add-to-cart'>
    
        <button class='add-to-cart-btn' name ='add'><i class='fa fa-shopping-cart' ></i> add to cart</button>
       
    </div> 
    <input type='hidden' name ='productid' value ='".$productid."'>
    <input type='hidden' name='hidden_name' value='".$productname."'>
    <input type='hidden' name='hidden_price' value='".$productNewPrice."'>
    <input type='hidden' name='hidden_category' value='".$productCategory."'>
    <input type='hidden' name='hidden_image' value='".$productimg."'>
    <input type='hidden' name='hidden_pagename' value='".$curPageName."'>
    </form>
 </div>
 ";
     
 echo $element ; 
 }
  
 function productDetail($productid,$productname,$productOldPrice,$productNewPrice,$productimg,$productCategory ,$qte,$descripton, $nbr_review ,$curPageName){
     
    $element = ' 
    <!-- Product main img -->
    <div class="col-md-5 col-md-push-2">
        <div id="product-main-img">
            <div class="product-preview">
                <img src="./img/'.$productimg.'" alt="">
            </div>

            <div class="product-preview">
                <img src="./img/'.$productimg.'" alt="">
            </div>

            <div class="product-preview">
                <img src="./img/'.$productimg.'" alt="">
            </div>

            <div class="product-preview">
                <img src="./img/'.$productimg.'" alt="">
            </div>
        </div>
    </div>
    <!-- /Product main img -->

    <!-- Product thumb imgs -->
    <div class="col-md-2  col-md-pull-5">
        <div id="product-imgs">
            <div class="product-preview">
                <img src="./img/'.$productimg.'" alt="">
            </div>

            <div class="product-preview">
                <img src="./img/'.$productimg.'" alt="">
            </div>

            <div class="product-preview">
                <img src="./img/'.$productimg.'" alt="">
            </div>

            <div class="product-preview">
                <img src="./img/'.$productimg.'" alt="">
            </div>
        </div>
    </div>
    <!-- /Product thumb imgs -->

    <div class="col-md-5">
    <div class="product-details">
        <h2 class="product-name">'.$productname.'</h2>
        <div>
             
            <a class="review-link" data-toggle="tab" href="#tab3">'.$nbr_review.' Review(s) | Add your review</a>
        </div>
        <div>
            <h3 class="product-price">$'.$productNewPrice.' <del class="product-old-price">$'.$productOldPrice.'</del></h3>
            <span class="product-available">'.$qte.' Items In Stock</span>
        </div>
        <br>
        <p>'.$descripton.'</p>
        <br>
         <form   action="cart.php?id='.$productid.'" method="post">
        <div class="add-to-cart">
            <div class="qty-label">
                Qty
                <div ><input type="number" name="quantity" class="form-control" value="1" min ="0" max ="20"></div>
                <br>
            </div>
            
            
        <button class="add-to-cart-btn" name ="add"><i class="fa fa-shopping-cart" ></i> add to cart</button>
       
            <input type="hidden" name ="productid" value ="'.$productid.'">
            <input type="hidden" name="hidden_name" value="'.$productname.'">
            <input type="hidden" name="hidden_price" value="'.$productNewPrice.'">
            <input type="hidden" name="hidden_category" value="'.$productCategory.'">
            <input type="hidden" name="hidden_image" value="'.$productimg.'">
            <input type="hidden" name="hidden_pagename" value="'.$curPageName.'">

            </form>
        </div>

        <ul class="product-btns">
           <!-- <li><a href="#"><i class="fa fa-heart-o"></i> add to wishlist</a></li> -->
            
        </ul>

        <ul class="product-links">
            <li>Category:</li>
            <li><a href="#">'.$productCategory.'</a></li>
   
        </ul>

        <ul class="product-links">
            <li>Share:</li>
            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
            <li><a href="#"><i class="fa fa-envelope"></i></a></li>
        </ul>

    </div>
</div>
   
    ' ; 
    echo $element ;
 }

  function Review($username , $rate , $comment , $date ){


    $starsComplet ='';
    $stars = '<i class="fa fa-star"></i>'; 

        for( $i = 1; $i <= $rate; $i++ ) {
              $starsComplet .=  $stars ;    
          }

 

   
  echo    ' 

    <div id="reviews" style = "border: 1px solid gray ;  border-radius: 8px ;padding : 10px ; margin : 10px">
   <ul class="reviews" style = " ">
   <li>
       <div class="review-heading">
           <h5 class="name">'.$username.'</h5>
           <p class="date">'.$date.'</p>
           <div class="review-rating">
           '.$starsComplet.'
           </div>
       </div>
       <div class="review-body">
           <p>'.$comment.'</p>
       </div>
    </li>
  </ul>
  <!-z- Reviews -->
</div>' ; 
 
   }



 
?>