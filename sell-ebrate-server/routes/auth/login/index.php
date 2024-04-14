<?php

include_once "../../../utils/headers.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $jsonData = getBodyParameters();

  $email = $jsonData["email"];
  $password = $jsonData["password"];

  if (empty($email) || empty($password)) {
    $response = new ServerResponse(error: ["message" => "Missing required fields"]);
    returnJsonHttpResponse(400, $response);
  }

  $sql1 = $conn->prepare("SELECT * FROM tblAccount WHERE email = ?");
  $sql1->bind_param("s", $email);
  $sql1->execute();

  $result = $sql1->get_result();

  if ($result->num_rows == 0) {
    $response = new ServerResponse(error: ["message" => "Invalid credentials"]);
    returnJsonHttpResponse(401, $response);
  }

  $user = $result->fetch_assoc();

  if (!password_verify($password, $user["password"])) {
    $response = new ServerResponse(error: ["message" => "Invalid credentials"]);
    returnJsonHttpResponse(401, $response);
  }


  // TODO: its used twice, maybe best to put it in a function
  $payload = array("userId" => $user["userId"]);
  $hashedPayload = 'Bearer ' . hash_hmac('sha256', json_encode($payload), $secretKey);
  $response = new ServerResponse(data: ["message" => "User logged in successfully", "token" => $hashedPayload]);

  returnJsonHttpResponse(200, $response);
}
