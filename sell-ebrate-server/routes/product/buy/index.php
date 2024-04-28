<?php
include_once "../../../utils/headers.php";

switch ($_SERVER["REQUEST_METHOD"]) {
    case "POST":
        $requiredFields = ["buyer_id", "product_id", "quantity"];
        $jsonData = getBodyParameters();
        $fields = checkFields($jsonData, $requiredFields);

        // Insert into tblOrder
        $sqlOrder = $conn->prepare("INSERT INTO tblOrder (order_id, buyer_id) VALUES (?, ?)");
        $sqlOrder->bind_param($fields["buyer_id"]);
        $sqlOrder->execute();

        $orderId = $conn->insert_id;

        // Insert into tblOrderItem
        $sqlOrderItem = $conn->prepare("INSERT INTO tblOrderItem (order_id, product_id, quantity) VALUES (?, ?, ?)");
        $sqlOrderItem->bind_param($orderId, $fields["product_id"], $fields["quantity"]);
        $sqlOrderItem->execute();

        $response = new ServerResponse(data: ["message" => "Product bought successfully", "order_id" => $orderId]);
        returnJsonHttpResponse(200, $response);
        break;

    default:
        $response = new ServerResponse(error: ["message" => "Invalid request method"]);
        returnJsonHttpResponse(405, $response);
        break;
}
?>
