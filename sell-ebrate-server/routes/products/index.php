
<?php
include_once "../../utils/headers.php";


switch ($_SERVER["REQUEST_METHOD"]) {
  case "GET":
    $sql1 = $conn->prepare("SELECT * FROM tblProduct");
    $sql1->execute();

    $result = $sql1->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
      $products[] = $row;
    }

    $response = new ServerResponse(data: ["message" => "Products data fetched successfully", "products" => $products], error: []);
    returnJsonHttpResponse(200, $response);

  case "POST":
    $jsonData = getBodyParameters();

    $requiredFields = ["sellerId", "productName", "description", "quantity", "price"];


    foreach ($requiredFields as $field) {
      if (empty($jsonData[$field])) {
        returnJsonHttpResponse(400, new ServerResponse(error: ["message" => "Missing required fields!"]));
      }
    }

    $sql1 = $conn->prepare("INSERT INTO tblProduct( " . join() . " ) VALUES(?, ?, ?, ?, ?, ?)");
    $sql1->bind_params("sssid", $sellerId, $productName, $description, $quantity, $price);
    $sql1->execute();

    $response = new ServerResponse(data: ["message" => "Product bought successfully!"]);
    returnJsonHttpResponse(200, $response);

  case "UPDATE":

  case "DELETE":
}
