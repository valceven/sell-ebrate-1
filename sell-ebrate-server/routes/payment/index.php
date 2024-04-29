<?php
include_once "../../utils/headers.php";

switch ($_SERVER["REQUEST_METHOD"]) {
  case "POST":
    $token = getAuthPayload();
    
    $sqlOrderItems = $conn->prepare("SELECT productId, quantity FROM tblOrderItem WHERE orderId IN (SELECT orderId FROM tblOrder WHERE buyerId = ? AND isPaid = 0)");
    $sqlOrderItems->bind_param("i", $token["accountId"]);
    $sqlOrderItems->execute();
    $orderItemsResult = $sqlOrderItems->get_result();

    if ($orderItemsResult->num_rows === 0) {
      $response = new ServerResponse(error: ["message" => "No unpaid orders found"]);
      returnJsonHttpResponse(400, $response);
      exit;
    }

    $totalAmount = 0;
    while ($row = $orderItemsResult->fetch_assoc()) {
      $productId = $row["productId"];
      $quantity = $row["quantity"];

      $sqlProduct = $conn->prepare("SELECT price FROM tblProduct WHERE productId = ?");
      $sqlProduct->bind_param("i", $productId);
      $sqlProduct->execute();
      $productResult = $sqlProduct->get_result();
      $product = $productResult->fetch_assoc();
      $price = $product["price"];

      $totalAmount += $price * $quantity;
    }

    // Insert payment record
    $sqlInsertPayment = $conn->prepare("INSERT INTO tblPayment (orderId, buyerId, amount, date) VALUES (?, ?, ?, NOW())");
    $sqlInsertPayment->bind_param("iid", $orderId, $token["accountId"], $totalAmount);
    $sqlInsertPayment->execute();
    $paymentId = $conn->insert_id;

    // Update order to mark as paid
    $sqlUpdateOrder = $conn->prepare("UPDATE tblOrder SET isPaid = 1 WHERE orderId IN (SELECT orderId FROM tblOrder WHERE buyerId = ? AND isPaid = 0)");
    $sqlUpdateOrder->bind_param("i", $token["accountId"]);
    $sqlUpdateOrder->execute();

    $response = new ServerResponse(data: ["message" => "Payment successful", "paymentId" => $paymentId]);
    returnJsonHttpResponse(200, $response);
    break;

  default:
    $response = new ServerResponse(error: ["message" => "Invalid request method"]);
    returnJsonHttpResponse(405, $response);
    break;
}
