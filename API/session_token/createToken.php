<?php
require __DIR__ . '/../../COMMON/connect.php';
require __DIR__ . '/../../MODEL/session_token.php';

header("Content-type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents("php://input"));

if (empty($data->token) || empty($data->user)) {
    http_response_code(400);
    echo json_encode(["message" => "Fill every field"]);
    die();
}

$db = new Database();
$db_conn = $db->connect();
$session_token = new SessionToken($db_conn);

if (createToken($data->user, $data->token) == true) {
    $userID = $user->login($data->email, $data->password);
    echo json_encode(["message" => "Registration completed", "userID" => $userID]);
} else {
    echo json_encode(["message" => "Registration failed successfully "]);
}
?>