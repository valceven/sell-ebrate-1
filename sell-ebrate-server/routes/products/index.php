
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
}
