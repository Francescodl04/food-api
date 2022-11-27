<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once dirname(__FILE__) . '/../../../COMMON/connect.php';
    include_once dirname(__FILE__) . '/../../../MODEL/ingredientTag.php';

    $database = new Database();
    $db = $database->connect();

    $data = json_decode(file_get_contents("php://input"));

    if(empty($data)){
        http_response_code(400);
        die(json_encode(array("Message" => "Bad request")));
    }

    $ingredientTag = new IngredientTag($db);
    
    if(!empty($record = $ingredientTag->setIngredientTag($data->ingredient_ID, $data->tag_ID)))
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