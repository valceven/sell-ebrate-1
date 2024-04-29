<?php

include_once "../../../utils/headers.php";

switch ($_SERVER["REQUEST_METHOD"]) {
  case "POST":
    $requiredFields = ["productId", "quantity"];
    $jsonData = getBodyParameters();
    $fields = checkFields($jsonData, $requiredFields);
    $token = getAuthPayload();

    // Insert into tblOrder
    $sqlOrder = $conn->prepare("INSERT INTO tblOrder (buyerId) VALUES (?)");
    $sqlOrder->bind_param("i", $token["accountId"]);
    $sqlOrder->execute();

    $orderId = $conn->insert_id;

    // Insert into tblOrderItem
    $sqlOrderItem = $conn->prepare("INSERT INTO tblOrderItem (orderId, productId, quantity) VALUES (?, ?, ?)");
    $sqlOrderItem->bind_param("iii", $orderId, $fields["productid"], $fields["quantity"]);
    $sqlOrderItem->execute();

    if (true) {
      // TODO: update here
    }


    $response = new ServerResponse(data: ["message" => "Product bought successfully", "orderId" => $orderId]);
    returnJsonHttpResponse(200, $response);
    break;

  default:
    $response = new ServerResponse(error: ["message" => "Invalid request method"]);
    returnJsonHttpResponse(405, $response);
    break;
}
