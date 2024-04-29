<?php

include_once "../../utils/headers.php";


switch ($_SERVER["REQUEST_METHOD"]) {
  case "GET":
    $sql1 = "SELECT * FROM tblProduct";

    $result = $conn->execute_query($sql1);

    $products = $result->fetch_all(MYSQLI_ASSOC);

    $response = new ServerResponse(data: ["message" => "Products data fetched successfully", "products" => $products], error: []);
    returnJsonHttpResponse(200, $response);

  case "POST":
    $jsonData = getBodyParameters();
    $requiredFields = ["sellerId", "productName", "description", "quantity", "price"];
    $fields = checkFields($jsonData, $requiredFields);

    // TODO:  get keys
    $sql1 = $conn->prepare("INSERT INTO tblProduct( " . implode(',', $fields) . " ) VALUES(?, ?, ?, ?, ?, ?)");
    $conn->execute_qeury($sql1, $fields);

    $response = new ServerResponse(data: ["message" => "Product added to store successfully!"]);
    returnJsonHttpResponse(200, $response);

  case "UPDATE":


  case "DELETE":
    $requiredFields = ["productId"];
    $jsonData = getBodyParameters();
    $token = getAuthPayload();
    $fields = checkFields($jsonData, $requiredFields);

    $sq1 = "SELECT productId, sellerId FROM tblProduct WHERE productId = ?";
    $result = $conn->execute_query($sql1, [$fields["productId"]]);

    if ($result["sellerId"] != $token) {
      $response = new ServerResponse(error: ["message" => "User does not own this product!"]);
      returnJsonHttpResponse(400, $response);
    }

    $sql2 = "DELETE FROM tblProduct WHERE productId = ?";
    $result = $conn->execute_query($sql1, [$fields["productId"]]);

    $response = new ServerResponse(data: ["message" => "Product deleted successfully!"]);
    returnJsonHttpResponse(200, $response);
}
