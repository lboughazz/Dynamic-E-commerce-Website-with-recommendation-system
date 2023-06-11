<?php

class paypal{

    public function ui($total):string {
          
        $return = <<<HTML
       <!-- Replace "test" with your own sandbox Business account app client ID -->
    <script src="https://www.paypal.com/sdk/js?client-id=AZh4qc88ELVLAS60OouixBcYCYxjn7xwnkH_P21aRgLLFCLro8DHwS8yZAZOP5d6oNNOWwuuIzxumhVX&currency=USD&disable-funding=credit,card"></script>
    <!-- Set up a container element for the button -->
    <div id="paypal-button"></div>
    <script>
      paypal.Buttons({
        style : {
        color: 'blue',
        shape: 'pill',
        label:  'pay',
        width: '20px'
       },

        // Sets up the transaction when a payment button is clicked
        createOrder: (data, actions) => {
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: {$total} ,
                currency_code: 'USD',
              },
              
            }]
          });
        },
        
        // Finalize the transaction after payer approval
        onApprove: function (data, actions) {
        return actions.order.capture().then(function () {
             
            window.location.replace("http://localhost:7878/lboughaz-store/success.php?orderID="+data.orderID+"&total=$total");
        })
    },
         // go to the sepecifie path if the client cancel the order 
         onCancel: function (data) {
        window.location.replace("http://localhost:7878/lboughaz-store/MyOrder.php")
         }

      }).render('#paypal-button');
    </script>
HTML;

     return $return ; 

    }



   
    public function paypalCheck($paymentID, $orderTotal, $payerID, $paymentToken){

      $ch = curl_init();
      $clientId = 'AZh4qc88ELVLAS60OouixBcYCYxjn7xwnkH_P21aRgLLFCLro8DHwS8yZAZOP5d6oNNOWwuuIzxumhVX';
      $secret = 'EJVRlnjajjXjnTlgwBa6eIKelCpODKXHeFitBz3ICvqlJMgUBqgXKBg69-M_jbw0uYy3nzQyAd6Oti6R';
      curl_setopt($ch, CURLOPT_URL, 'https://api.sandbox.paypal.com/v1/'.'oauth2/token');
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_USERPWD, $clientId . ":" . $secret);
      curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
      $result = curl_exec($ch);
      $accessToken = null;
  
  
      if (empty($result)){
          return false;
      }
  
      else {
          $json = json_decode($result);
          $accessToken = $json->access_token;
          $curl = curl_init('https://api.sandbox.paypal.com/v1/'.'payments/payment/' . $paymentID);
          curl_setopt($curl, CURLOPT_POST, false);
          curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($curl, CURLOPT_HEADER, false);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          'Authorization: Bearer ' . $accessToken,
          'Accept: application/json',
          'Content-Type: application/xml'
          ));
          $response = curl_exec($curl);
          $result = json_decode($response);
  
  
          $state = $result->state;
          $payment_total = $result->purchase_units[0]->amount->value;
          $currency = $result->purchase_units[0]->amount->currency_code;
          curl_close($ch);
          curl_close($curl);
  
          
          if($state == 'approved' && $currency == 'USD' && $orderTotal ==  $payment_total){
              return true;
   
          }
          else{
   
              return false;
          }
  
      }
  
  }

}


