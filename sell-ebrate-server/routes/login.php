<?php
include_once "../utils/headers.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_REQUEST["email"];
  $password = $_REQUEST["password"];

  if (empty($email) || empty($password)) {
    $response = new ServerResponse(data: [], error: ["message" => "Missing required fields"]);
    returnJsonHttpResponse(400, $response);
  }

  $sql1 = $conn->prepare("SELECT * FROM tblAccount WHERE email = ?");
  $sql1->bind_param("s", $email);
  $sql1->execute();

  $result = $sql1->get_result();

  if ($result->num_rows == 0) {
    $response = new ServerResponse(data: [], error: ["message" => "Invalid credentials"]);
    returnJsonHttpResponse(401, $response);
  }

  $user = $result->fetch_assoc();

  if (!password_verify($user["password"], $password)) {
    // TODO: maybe its best this way para secure
    $response = new ServerResponse(data: [], error: ["message" => "Invalid credentials"]);
    returnJsonHttpResponse(401, $response);
  }


  // TODO: its used twice, maybe best to put it in a function
  $payload = array($user["user_id"]);
  $hashed_payload = hash_hmac('sha256', json_encode($payload), $secret_key);
  $response = new ServerResponse(data: ["message" => "User logged in successfully", "token" => json_encode($hashed_payload)], error: []);

  returnJsonHttpResponse(200, $response);
}
