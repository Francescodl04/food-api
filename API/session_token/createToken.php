<?php
    require("../../COMMON/connect.php");
    require("../../MODEL/sessionToken.php");

    header("Content-type: application/json; charset=UTF-8");
    header('Access-Control-Allow-Origin: *');

    $data = json_decode(file_get_contents("php://input"));

    if (empty($data->token) || empty($data->user)) {
        http_response_code(400);
        echo json_encode(["message" => "Bad request"]);
        die();
    }

    $db = new Database();
    $db_conn = $db->connect();
    $sessionToken = new SessionToken($db_conn);

    $result = $sessionToken->createToken($data->user, $data->token);

    if ($result != false) {
        http_response_code(200);
        echo json_encode(["response" => true, "userID" => $result]);
    } else {
        http_response_code(401);
        echo json_encode(["response" => false]);
    }
    die();
?>
