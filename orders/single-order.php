<?php

    header("Content-Type: application/json; charset=UTF-8");

    // files needed to connect to database
    include_once '../Config/Database.php';
    include_once '../objects/Order.php';

    $database = new Database();
    $db = $database->getConnection();

    $order = new Order($db);

    $order->id = isset($_GET['id']) ? $_GET['id'] : die();

    $order->singleOrder();

    if($order->status == 1){
        $order->status = "Delivered";
    }else{
        $order->status = "Undelivered";
    }

    $p  = array(
        "id" => $order->id,
        "name" => $order->name,
        "status" => $order->status
    );

    echo json_encode($p);

?>