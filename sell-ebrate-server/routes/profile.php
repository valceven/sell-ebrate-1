<?php
$user_id = $_POST["user_id"];

$sql1 = $mysqli->prepare("SELECT * FROM tblAccount WHERE account_id = ?");
$sql1->bind_param("s", $user_id);
$sql1->execute();

$result = $sql1->get_result();

if ($result->num_rows == 0) {
  $response = new ServerResponse(data: [], error: ["message" => "User does not exist"]);

  http_response_code(404);
  echo json_encode($response);
  exit();
}

$user = $result->fetch_assoc();
$response = new ServerResponse(data: ["message" => "User logged in successfully", "user" => json_encode($user)], error: []);

http_response_code(200);
echo json_encode($response);
