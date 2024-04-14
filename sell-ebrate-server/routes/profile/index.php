<?php
include_once "../../utils/headers.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {

  $jsonData = getBodyParameters();
  $token = getAuthToken();

  $sql1 = $conn->prepare("SELECT * FROM tblAccount WHERE accountId = ?");
  $sql1->bind_param("i", $userId);
  $sql1->execute();

  $result = $sql1->get_result();

  if ($result->num_rows == 0) {
    $response = new ServerResponse(error: ["message" => "User does not exist"]);
    returnJsonHttpResponse(400, $response);
  }

  $user = $result->fetch_assoc();
  $response = new ServerResponse(data: ["message" => "User data fetched successfully", "user" => json_encode($user)]);

  returnJsonHttpResponse(200, $response);
}
