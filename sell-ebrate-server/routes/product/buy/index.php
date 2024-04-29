<?php

include_once "../../../utils/headers.php";

switch ($_SERVER["REQUEST_METHOD"]) {
  case "POST":
    $token = getAuthPayload();
    
    $userId = $token["accountId"];
    $sqlCartItems = $conn->prepare("SELECT productId, quantity FROM tblCartItem WHERE cartId IN (SELECT cartId FROM tblCart WHERE userId = ?)");
    $sqlCartItems->bind_param("i", $userId);
    $sqlCartItems->execute();
    $cartItemsResult = $sqlCartItems->get_result();
    
    if ($cartItemsResult->num_rows === 0) {
      $response = new ServerResponse(error: ["message" => "Cart is empty"]);
      returnJsonHttpResponse(400, $response);
      exit;
    }

    $sqlOrder = $conn->prepare("INSERT INTO tblOrder (buyerId) VALUES (?)");
    $sqlOrder->bind_param("i", $userId);
    $sqlOrder->execute();

    $orderId = $conn->insert_id;

    while ($row = $cartItemsResult->fetch_assoc()) {
      $productId = $row["productId"];
      $quantity = $row["quantity"];

      $sqlOrderItem = $conn->prepare("INSERT INTO tblOrderItem (orderId, productId, quantity) VALUES (?, ?, ?)");
      $sqlOrderItem->bind_param("iii", $orderId, $productId, $quantity);
      $sqlOrderItem->execute();

      $sqlReduceQuantity = $conn->prepare("UPDATE tblProduct SET quantity = quantity - ? WHERE productId = ?");
      $sqlReduceQuantity->bind_param("ii", $quantity, $productId);
      $sqlReduceQuantity->execute();
    }

    $sqlClearCart = $conn->prepare("DELETE FROM tblCartItem WHERE cartId IN (SELECT cartId FROM tblCart WHERE userId = ?)");
    $sqlClearCart->bind_param("i", $userId);
    $sqlClearCart->execute();

    $response = new ServerResponse(data: ["message" => "Products bought successfully", "orderId" => $orderId]);
    returnJsonHttpResponse(200, $response);
    break;

  default:
    $response = new ServerResponse(error: ["message" => "Invalid request method"]);
    returnJsonHttpResponse(405, $response);
    break;
}