<?php
$cnx = mysqli_connect("localhost","root","","productdb");
//converting the database into a matrix
$q="select user_id,prod_id,rate from review";
$r = mysqli_query($cnx,$q);
$matrix=array();
$prods=array();

while($x=mysqli_fetch_array($r)) {
    $users = mysqli_query($cnx, "select username from users where $x[user_id]=id_user ");
    $products = mysqli_query($cnx, "select product_name from producttb where $x[prod_id]=productid");
    $username = mysqli_fetch_array($users);
    $product_name = mysqli_fetch_array($products);
    //$prods[$i] = $username['username'];
    $matrix[$username['username']][$product_name['product_name']] = $x['rate'];

}
$j=0;


function recom_items($username){

    $matrix=$GLOBALS['matrix'];
    if(array_key_exists($username,$matrix)){
        if(count(getRecommendations($matrix, $username))>0  ){
           return getRecommendations($matrix, $username);}

        else{
        return 0;
            }}
    else{
        return 0;
        }


 }
//print_r(getRecommendations($matrix, "elma")) . "<br>";


function euclideanDistance($U_matrix, $item1, $item2)
{
    $similar = array();
    $sum = 0;

    foreach($U_matrix[$item1] as $key=>$value)
    {
        // check if the user has rated as well this product or not
        if(array_key_exists($key, $U_matrix[$item2]))
            $similar[$key] = 1;
    }

    if(count($similar) == 0)
        return 0;

    foreach($U_matrix[$item1] as $key=>$value)
    {
        if(array_key_exists($key, $U_matrix[$item2]))
            $sum = $sum + pow($value - $U_matrix[$item2][$key], 2);
    }

    return  1/(1 + sqrt($sum));
}



function getRecommendations($U_matrix, $user)
{
    $total = array();
    $simSums = array();
    $ranks = array();
    $sim = 0;

    foreach($U_matrix as $otheruser=>$values)
    {
        if($otheruser != $user)
        {
            $sim = euclideanDistance($U_matrix, $user, $otheruser);
        }

        if($sim > 0)
        {
            foreach($U_matrix[$otheruser] as $key=>$value)
            {
                if(!array_key_exists($key, $U_matrix[$user]))
                {
                    if(!array_key_exists($key, $total)) {
                        $total[$key] = 0;
                    }
                    // predicting of ratings based on the similarity between the items and the user rate
                    $total[$key] += $U_matrix[$otheruser][$key] * $sim;

                    if(!array_key_exists($key, $simSums)) {
                        $simSums[$key] = 0;
                    }
                    $simSums[$key] += $sim;
                }
            }

        }
    }

    foreach($total as $key=>$value)
    {
        $ranks[$key] = $value / $simSums[$key];
    }

    array_multisort($ranks, SORT_DESC);

    return $ranks;

}


?>