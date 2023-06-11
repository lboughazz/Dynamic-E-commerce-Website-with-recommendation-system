<?php
namespace Sample;
require_once('paypal.php');

 
    $orderID = $_GET['orderID'];
    

    
    
    use PayPalCheckoutSdk\Core\PayPalHttpClient;
    use PayPalCheckoutSdk\Core\SandboxEnvironment;
    
    ini_set('error_reporting', E_ALL); // or error_reporting(E_ALL);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    
    class process
    {
        /**
         * Returns PayPal HTTP client instance with environment which has access
         * credentials context. This can be used invoke PayPal API's provided the
         * credentials have the access to do so.
         */
        public static function client()
        {
            return new PayPalHttpClient(self::environment());
        }
        
        /**
         * Setting up and Returns PayPal SDK environment with PayPal Access credentials.
         * For demo purpose, we are using SandboxEnvironment. In production this will be
         * ProductionEnvironment.
         */
        public static function environment()
        {
            $clientId = getenv("CLIENT_ID") ?: 'AZh4qc88ELVLAS60OouixBcYCYxjn7xwnkH_P21aRgLLFCLro8DHwS8yZAZOP5d6oNNOWwuuIzxumhVX';
            $clientSecret = getenv("CLIENT_SECRET") ?: 'EJVRlnjajjXjnTlgwBa6eIKelCpODKXHeFitBz3ICvqlJMgUBqgXKBg69-M_jbw0uYy3nzQyAd6Oti6R';
            return new SandboxEnvironment($clientId, $clientSecret);
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