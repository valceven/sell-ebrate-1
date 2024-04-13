
<?php
include_once "../utils/headers.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  $sql1 = $conn->prepare("SELECT * FROM tblProduct");
  $sql1->bind_param("i", $user_id);
  $sql1->execute();

  $result = $sql1->get_result();

  $products = $result->fetch_assoc();
  $response = new ServerResponse(data: ["message" => "Products data fetched successfully", "user" => json_encode($products)], error: []);

  http_response_code(200);
  echo json_encode($response);
}
