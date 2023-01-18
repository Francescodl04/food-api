<?php
    require("../../COMMON/connect.php");
    require("../../MODEL/sessionToken.php");

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    $database = new Database();
    $db = $database->connect();

    $data = json_decode(file_get_contents("php://input"));


    if(empty($data) || empty($data->token) || empty($data->user)){
        http_response_code(400);
        json_encode(array("Message" => "Bad request"));
        die();
    }
    echo($data->token);
    echo($data->user);

    $sessionToken = new SessionToken($db);
    if(!empty($record = $sessionToken->createToken($data->user, $data->token)))
    {
        http_response_code(201);
        echo json_encode(array("Message"=> "Created"));
    }
    else
    {
        http_response_code(503);
        echo json_encode(array("Message"=>'Error'));
    }

?>