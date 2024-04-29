<?php
include_once "../../utils/headers.php";

switch ($_SERVER["REQUEST_METHOD"]) {
  case "GET":
    $jsonData = getBodyParameters();
    $token = getAuthPayload();

    $sql1 = "SELECT * FROM tblAccount WHERE accountId = ?";
    $result = $conn->execute_query($sql1, [$token['accountId']]);

    if ($result->num_rows == 0) {
      $response = new ServerResponse(error: ["message" => "User does not exist"]);
      returnJsonHttpResponse(400, $response);
    }

    $user = $result->fetch_assoc();
    $response = new ServerResponse(data: ["message" => "User data fetched successfully", "user" => $user]);

    returnJsonHttpResponse(200, $response);
}
