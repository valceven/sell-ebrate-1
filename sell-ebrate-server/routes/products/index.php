
<?php
include_once "../../utils/headers.php";


switch ($_SERVER["REQUEST_METHOD"]) {
  case "GET":
    $sql1 = $conn->prepare("SELECT * FROM tblProduct");
    $sql1->execute();

    $result = $conn->execute_query($sql1);
    $products = $result->fetch_all(MYSQLI_ASSOC);

    $response = new ServerResponse(data: ["message" => "Products data fetched successfully", "products" => $products], error: []);
    returnJsonHttpResponse(200, $response);

  case "POST":
    $jsonData = getBodyParameters();
    $requiredFields = ["sellerId", "productName", "description", "quantity", "price"];
    $fields = [];

    foreach ($requiredFields as $field) {
      if (empty($jsonData[$field])) {
        returnJsonHttpResponse(400, new ServerResponse(error: ["message" => "Missing required fields!"]));
      }
      $fields[$field] = $jsonData[$field];
    }

    // TODO:  get keys
    $sql1 = $conn->prepare("INSERT INTO tblProduct( " . implode(',', $fields) . " ) VALUES(?, ?, ?, ?, ?, ?)");
    $conn->execute_qeury($sql1, $fields);

    $response = new ServerResponse(data: ["message" => "Product bought successfully!"]);
    returnJsonHttpResponse(200, $response);

  case "UPDATE":

  case "DELETE":
}
