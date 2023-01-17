<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/order.php';

$database = new Database();
$db = $database->connect();

$order = new Order($db);

$stmt = $order->getArchiveBriefOrder();

if ($stmt->num_rows > 0) {
    $order_array = array();
    while ($record = mysqli_fetch_assoc($stmt)) // Trasforma una riga in un array e lo fa per tutte le righe di un record.
    {
        $order_array[] = $record;
    }
    $json = json_encode($order_array);
    echo $json;
    return $json;
} else {
    echo "No record";
    http_response_code(204);
}

?>