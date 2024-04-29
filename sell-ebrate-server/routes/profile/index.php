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

  case "UPDATE":
    // TODO: Update user data
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

  case "DELETE":
    $token = getAuthPayload();
    $userId = $token["accountId"];

    $sqlDeleteBuyer = $conn->prepare("DELETE FROM tblBuyer WHERE buyerId = ?");
    $sqlDeleteBuyer->bind_param("i", $userId);
    $sqlDeleteBuyer->execute();

    $sqlDeleteSeller = $conn->prepare("DELETE FROM tblSeller WHERE sellerId = ?");
    $sqlDeleteSeller->bind_param("i", $userId);
    $sqlDeleteSeller->execute();

    $sqlDeleteAccount = $conn->prepare("DELETE FROM tblAccount WHERE accountId = ?");
    $sqlDeleteAccount->bind_param("i", $userId);
    $sqlDeleteAccount->execute();

    if ($sqlDeleteAccount->affected_rows > 0) {
      $response = new ServerResponse(data: ["message" => "Account deleted successfully"]);
      returnJsonHttpResponse(200, $response);
    } else {
      $response = new ServerResponse(error: ["message" => "Failed to delete account"]);
      returnJsonHttpResponse(500, $response);
    }
    break;

  default:
    $response = new ServerResponse(error: ["message" => "Invalid request method"]);
    returnJsonHttpResponse(405, $response);
    break;
}
