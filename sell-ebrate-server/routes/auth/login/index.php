<?php

include_once "../../../utils/headers.php";

switch ($_SERVER["REQUEST_METHOD"]) {
  case "GET":

  case "POST":
    $requiredFields = ["email", "password"];

    $jsonData = getBodyParameters();
    $fields = checkFields($jsonData, $requiredFields);

    $sql1 = "SELECT * FROM tblAccount WHERE email = ?";
    $result = $conn->execute_query($sql1, [$fields["email"]]);

    if ($result->num_rows == 0) {
      $response = new ServerResponse(error: ["message" => "Email not found!"]);
      returnJsonHttpResponse(401, $response);
    }

    $user = $result->fetch_assoc();
    if (!password_verify($fields["password"], $user["password"])) {
      $response = new ServerResponse(error: ["message" => "Invalid credentials!"]);
      returnJsonHttpResponse(401, $response);
    }

    $hashedPayload = createToken($user);
    $response = new ServerResponse(data: ["message" => "User logged in successfully", "token" => $hashedPayload]);
    returnJsonHttpResponse(200, $response);

  case "UPDATE":

  case "DELETE":
}
