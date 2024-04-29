<?php
include_once "../../../utils/headers.php";

switch ($_SERVER["REQUEST_METHOD"]) {
  case "POST":
    $requiredFieldsProduct = ["productName", "description", "quantity", "price"];
    $jsonData = getBodyParameters();
    $token = getAuthPayload();

    // Check required fields
    $fieldsProduct = checkFields($jsonData, $requiredFieldsProduct);

    // Insert into tblProduct
    $sql = $conn->prepare("INSERT INTO tblProduct (sellerId, productName, description, quantity, price) VALUES (?, ?, ?, ?, ?)");
    $sql->bind_param("issid", $token["accountId"], $fieldsProduct["productName"], $fieldsProduct["description"], $fieldsProduct["quantity"], $fieldsProduct["price"]);

    if ($sql->execute()) {
      $productId = $conn->insert_id;
      $response = new ServerResponse(data: ["message" => "Product added successfully", "productId" => $productId]);
      returnJsonHttpResponse(200, $response);
    } else {
      $response = new ServerResponse(error: ["message" => "Failed to add product"]);
      returnJsonHttpResponse(500, $response);
    }
    break;

  default:
    $response = new ServerResponse(error: ["message" => "Invalid request method"]);
    returnJsonHttpResponse(405, $response);
    break;
}
