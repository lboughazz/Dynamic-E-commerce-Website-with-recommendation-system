<?php
class Creatdb{
   public $username;
   public $password;
   public $servername;
   public $dbname;
   public $table;
   public $con;
    
   function __construct($dbname,$tablename,$username,$password,$servername ){
      $this->username = $username ; 
      $this->password = $password ; 
      $this->servername = $servername ; 
      $this->dbname = $dbname ; 
      $this->tablename = $tablename ; 
    $this->con = mysqli_connect( $servername ,  $username , $password , $dbname );
        /*
        if ($this->con) {
            echo 'succes ! ';
          }
           else { 
               echo 'failed ! ';
           } 
           */
        // query
       // $sql = "CREATE DATABASE IF NOT EXISTS $dbname";

        // execute query
        

//$this->con = mysqli_connect($servername, $username, $password, $dbname);

            // sql to create new table
            $sql = " CREATE TABLE IF NOT EXISTS $tablename
                            (productid INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                             product_name VARCHAR (25) NOT NULL,
                             productOldPrice FLOAT,
                             productNewPrice FLOAT,
                             product_image VARCHAR (100)
                            );";
/*
            if (!mysqli_query($this->con, $sql)){
                echo "Error creating table : " . mysqli_error($this->con);
            }else {
                echo "la creation de table succes !! ";
            }

        */
   }
     public function getConnection(){
        $this->con = mysqli_connect( $this->servername ,  $this->username , $this->password , $this->dbname );
        $conn = $this->con ; 
        return $conn  ;
     }
      // get product from the database with category type
      public function getDataCategory($category){
        $sql1 = "SELECT productid,product_name,productOldPrice,productNewPrice,product_image,product_rate ,category_name  
        FROM producttb  join category   on   product_category  = id_category
        
         and category_name = '$category'  ";
  
        $result = mysqli_query($this->con, $sql1);
  
        if(mysqli_num_rows($result) > 0){
            return $result;
        }
      }


        // get product Hot Deal from the database 
        public function getDataHotDeal(){
            $sql1 = "SELECT * FROM productHotDeal   ";
      
            $result = mysqli_query($this->con, $sql1);
      
            if(mysqli_num_rows($result) > 0){
                return $result;
            }
        } 

   
   
    // get New product for the home page  from the database
    public function getData(){
      $sql1 = "SELECT productid,product_name,productOldPrice,productNewPrice,product_image, category_name ,product_rate , Qte , product_description
      FROM producttb  join category   on   product_category  = id_category ";

      $result = mysqli_query($this->con, $sql1);

      if(mysqli_num_rows($result) > 0){
          return $result;
      }
  }

// get product detail 
  public function getProductDetail($productid){
    $sql1 = "SELECT productid,product_name,productOldPrice,productNewPrice,product_image, category_name ,Qte,product_description , count(prod_id) as 'nbr_review' 
    FROM producttb  join category   on   product_category  = id_category
    join review on  prod_id  = productid
    
     and productid = '$productid' 
     
     ";

    $result = mysqli_query($this->con, $sql1);

    if(mysqli_num_rows($result) > 0){
        return $result;
    }
}

public function getProductDetail_for_update($productid){
    $sql1 = "SELECT productid,product_name,productOldPrice,productNewPrice,product_image ,Qte,product_description  
    FROM producttb 
    where   productid = '$productid' 
     
     ";

    $result = mysqli_query($this->con, $sql1);

    if(mysqli_num_rows($result) > 0){
        return $result;
    }
}


public function getSearchData($search_content,$search_content_category){
      
    if ($search_content_category == "none") {

         $sql1 = "SELECT productid,product_name,productOldPrice,productNewPrice,product_image,product_rate, category_name  
     FROM producttb  join category   on   product_category  = id_category
    
     and `product_name` LIKE '%$search_content%' 
    
     ORDER BY `product_name` ";

    $result = mysqli_query($this->con, $sql1);

    if(mysqli_num_rows($result) > 0){
        return $result;
    }
    }else {
         if ($search_content =='' ) {
            $sql1 = "SELECT productid,product_name,productOldPrice,productNewPrice,product_image,product_rate, category_name  
            FROM producttb  join category   on   product_category  = id_category
           
            and `category_name` LIKE '%$search_content_category%' 
           
           
            ORDER BY `product_name` ";
       
           $result = mysqli_query($this->con, $sql1);
       
           if(mysqli_num_rows($result) > 0){
               return $result;
           }
         }else { 
             $sql1 = "SELECT productid,product_name,productOldPrice,productNewPrice,product_image,product_rate, category_name  
        FROM producttb  join category   on   product_category  = id_category
       
        and `category_name` LIKE '%$search_content_category%' 
        and `product_name` LIKE '%$search_content%'
       
        ORDER BY `product_name` ";
   
       $result = mysqli_query($this->con, $sql1);
   
       if(mysqli_num_rows($result) > 0){
           return $result;
       }
         }
       

    }
   

}     


// get product review
public function getProductReview($productid){
    $sql1 = "SELECT username,rate,commentaire,review_date
    FROM  Review 
    join users on user_id = id_user
    
    and prod_id = '$productid' 
    ";

    $result = mysqli_query($this->con, $sql1);
 
    if(mysqli_num_rows($result) > 0){
        return $result;
         
    }
    else  {
        return null ; 
    }
}
  
  

public function getorderDetail($orderid){
  

    $sql1 = " SELECT order_id,username,email,user_tel,user_adr,order_date,order_total_Price,order_Methode
     from orders join users on user_id = id_user and order_id = '$orderid' ";

    $result = mysqli_query($this->con, $sql1);

    if(mysqli_num_rows($result) > 0){
        return $result;
    }

}   
public function get_PAYPAL_orderDetail($orderid){
  

    $sql1 = " SELECT username,email,user_tel,user_adr,order_date,order_total_Price,Paypal_order_Id,order_Methode
     from orders join users on user_id = id_user and Paypal_order_Id = '$orderid' ";

    $result = mysqli_query($this->con, $sql1);

    if(mysqli_num_rows($result) > 0){
        return $result;
    }

}   



// get best selling products function 

public function getbestselling(){
    $sql1 = " SELECT *,c.category_name from producttb p join category c on c.id_category = p.product_category and p.productid in 
        (select op.product_id
        from orderProduct op join orders o
        on o.order_id = op.order_id 
        group by product_id
        order by sum(qte) desc); 
        ";
    $result = mysqli_query($this->con, $sql1);
    if(mysqli_num_rows($result) > 0){
        return $result;
    }
    else  {
        return null ;
    }
}

public function get_Recommendation_Product($product_name) {

        $sql= "SELECT productid,product_name,productOldPrice,productNewPrice,product_image, category_name ,product_rate
        FROM producttb  join category   on  ( product_category  = id_category and product_name='$product_name') ";
        $result = mysqli_query($this->con, $sql);
        if(mysqli_num_rows($result) > 0){
            return $result;
        }
        else  {
            return null ;
        }

     }

     public function get_Users($limit) {

        $sql= "SELECT * from users limit $limit ";
        
        $result = mysqli_query($this->con, $sql);
        if(mysqli_num_rows($result) > 0){
            return $result;
        }
        else  {
            return null ;
        }

     }
     public function get_Users_Review() {

        $sql= "SELECT rev_id,username,prod_id,product_name,rate,commentaire,review_date 
        from review join users on user_id = id_user join producttb on prod_id = productid 
        order by  review_date desc";
        
        $result = mysqli_query($this->con, $sql);
        if(mysqli_num_rows($result) > 0){
            return $result;
        }
        else  {
            return null ;
        }

     }
   
      public function get_Orders($limit) {

        $sql= "SELECT order_id,username,order_products,order_date,order_total_Price,order_Methode,Paypal_order_Id 
        from orders join users on user_id = id_user 
        order by order_id desc
         limit $limit 
         ";
        
        $result = mysqli_query($this->con, $sql);
        if(mysqli_num_rows($result) > 0){
            return $result;
        }
        else  {
            return null ;
        }

     }
     



}
?>