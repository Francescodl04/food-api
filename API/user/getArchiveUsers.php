<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/user.php';

$database = new Database();
$db = $database->connect();

$user = new User($db);

$stmt = $user->getArchiveUsers();

if ($stmt->num_rows > 0)
{
    $user_arr = array();

    while($record = $stmt->fetch_assoc())
    {
       $user_arr[] = $record;
    }
    http_response_code(200);
    $json = json_encode($user_arr);
    echo $json;

    //return $json;
}
else {
    http_response_code(400);
    echo json_encode(["message" => "No record"]);
}
die();
