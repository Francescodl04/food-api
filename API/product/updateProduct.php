<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/product.php';

$database = new Database();
$db = $database->connect();

$data = json_decode(file_get_contents("php://input"));

if(empty($data) || empty($data->id) || empty($data->name) || empty($data->price) || empty($data->quantity)){
    http_response_code(400);
    die(json_encode(array("Message" => "Bad request")));
}


$product = new Product($db);
$stmt = $product->updateProduct($data->id, $data->name, $data->price, $data->quantity);

if ($stmt != false) {
    http_response_code(200);
    echo json_encode(["response" => true]);
} else {
    http_response_code(401);
    echo json_encode(["response" => false]);
}
?>