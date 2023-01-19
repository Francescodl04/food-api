<?php
require __DIR__ . '/../../COMMON/connect.php';
require __DIR__ . '/../../MODEL/sessionToken.php';

header("Content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *")

$data = json_decode(file_get_contents("php://input"));

if (empty($data->token) || empty($data->user) || empty($data->expiry)) {
    http_response_code(400);
    echo json_encode(["message" => "Fill every field"]);
    die();
}

$db = new Database();
$db_conn = $db->connect();
$session_token = new SessionToken($db_conn);

if ($session_token->createToken($data->user, $data->token, $data->expiry) == true) {
    echo json_encode(["message" => "Token inserted"]);
} else {
    echo json_encode(["message" => "Token insertion failed"]);
}
?>