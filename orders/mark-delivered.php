<?php
    // required headers
    header("Access-Control-Allow-Origin: http://localhost/php_API/orders/");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    // files needed to connect to database
    include_once '../config/Database.php';
    include_once '../objects/Order.php';
    
    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // instantiate order object
    $order = new Order($db);
    
    // get posted data
    $data = json_decode(file_get_contents("php://input"));
    
    $order->id = $data->id;
    $order->status = $data->status;

    // create the order
    if( $order->markDelivered())
        {
        
            // set response code
            http_response_code(200);
        
            // display message: order was created
            echo json_encode(array("message" => "order was marked delivered successfully!!."));
        }else{
        
            // set response code
            http_response_code(400);
        
            // display message: unable to create order
            echo json_encode(array("message" => "Unable to perfom operation."));
        }

?>