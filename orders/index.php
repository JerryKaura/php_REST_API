<?php

header("Content-Type: application/json; charset=UTF-8");

// files needed to connect to database
include_once '../Config/Database.php';
include_once '../objects/Order.php';

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);

$stmt = $order->read();
$count = $stmt->rowCount();

if($count > 0){


    $orders = array();
    $orders["body"] = array();
    $orders["count"] = $count;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);


        $p  = array(
              "id" => $id,
              "name" => $name,
              "status" => $status==1? "Delivered" : "Undelivered"
        );

        array_push($orders["body"], $p);
    }

    echo json_encode($orders);
}

else {

    echo json_encode(
        array("body" => array(), "count" => 0)
    );
}
?>