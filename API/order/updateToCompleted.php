<?php

/**
 * API per aggiornare lo stato di un ordine in completato e decrementare la disponibilità di ingredienti
 * Realizzato dal gruppo Rossi, Di Lena, Marchetto G., Lavezzi, Ferrari
 * Classe 5F
 * A.S. 2022-2023
**/

header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/order.php';

$database = new Database();
$db = $database->connect();

$order = new Order($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data)) {
    if ($order->updateToCompleted($data->order_ID) > 0) {
        http_response_code(201);
        echo json_encode(array("Update" => "Done"));
    } else {
        http_response_code(503);
        echo json_encode(array("Update" => 'Error'));
    }
} else {
    http_response_code(400);
    die(json_encode(array("Update" => "Bad request")));
}

?>