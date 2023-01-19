<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/sessionToken.php';

$database = new Database();
$db = $database->connect();

if (!strpos($_SERVER["REQUEST_URI"], "?token=")) // Controlla se l'URI contiene ?ID
{
    http_response_code(400);
    die(json_encode(array("Message" => "Bad request")));
}

$token = explode("?token=", $_SERVER['REQUEST_URI'])[1]; 

if(empty($token)){
    http_response_code(400);
    echo json_encode(["message" => "Token is empty"]);
    die();
}

$sessionToken = new SessionToken($db);

$stmt = $sessionToken->getUserByToken($token);

if ($stmt != false && $stmt->num_rows > 0) 
{
    $sessionToken_arr = array();

    while($record = $stmt->fetch_assoc())
    {
       $sessionToken_arr[] = $record;
    }

    $json = json_encode($sessionToken_arr);
    echo $json;

    return $json;
}
else {
    http_response_code(400);
    echo json_encode(["message" => "No record found"]);
}
die();
?>