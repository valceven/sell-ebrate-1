<?php
include_once "../utils/headers.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  $user_id = $_REQUEST["user_id"];


  if (empty($user_id)) {
    $response = new ServerResponse(data: [], error: ["message" => "Missing required fields"]);

    http_response_code(400);
    echo json_encode($response);
    exit();
  }


  $sql1 = $conn->prepare("SELECT * FROM tblAccount WHERE account_id = ?");
  $sql1->bind_param("i", $user_id);
  $sql1->execute();


  $result = $sql1->get_result();

  if ($result->num_rows == 0) {
    $response = new ServerResponse(data: [], error: ["message" => "User does not exist"]);

    http_response_code(404);
    echo json_encode($response);
    exit();
  }

  $user = $result->fetch_assoc();
  $response = new ServerResponse(data: ["message" => "User data fetched successfully", "user" => json_encode($user)], error: []);

  http_response_code(200);
  echo json_encode($response);
}
