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
    $order_first_array = array();
    $class_orders = array();
    $order_final_array = array();
    while ($record = mysqli_fetch_assoc($stmt)) // Trasforma una riga in un array e lo fa per tutte le righe di un record.
    {
        extract($record);
        $order_record = array(
            'order_id' => $order_id,
            'user_name_surname' => $user_name_surname,
            'class' => $class,
            'pickup_point' => $pickup_point,
            'pickup_time' => $pickup_time,
            'ordered_products' => $ordered_products,
            'total_price' => $total_price
        );
        array_push($order_first_array, $order_record);
    }
    for ($i = 0; $i < count($order_first_array); $i++) {
        $order = array(
            'order_id' => $order_first_array[$i]['order_id'],
            'user_name_surname' => $order_first_array[$i]['user_name_surname'],
            'pickup_point' => $order_first_array[$i]['pickup_point'],
            'pickup_time' => $order_first_array[$i]['pickup_time'],
            'ordered_products' => $order_first_array[$i]['ordered_products'],
            'total_price' => $order_first_array[$i]['total_price']
        );
        array_push($class_orders, $order);
        if (($i != count($order_first_array) - 1 && $order_first_array[$i]['class'] != $order_first_array[$i + 1]['class']) || $i == count($order_first_array) - 1) {
            $final_class_orders = array(
                'class' => $order_first_array[$i]['class'],
                'orders' => $class_orders
            );
            array_push($order_final_array, $final_class_orders);
            $class_orders = array();
        }
    }
    $json = json_encode($order_final_array);
    echo $json;
    return $json;
} else {
    echo "No record";
    http_response_code(204);
}

?>