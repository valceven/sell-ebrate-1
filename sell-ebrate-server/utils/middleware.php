

<?php


// automatically makes route protected
// TODO: improve this later on
function getAuthToken()
{
  if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
    $authorizationHeader = $_SERVER['HTTP_AUTHORIZATION'];

    if (preg_match('/^Bearer\s+[a-fA-F0-9]{64}$/', $authorizationHeader, $matches)) {
      $token = $matches[1];
      return $token;
    } else {
      $response = new ServerResponse(error: ["message" => "Invalid Authorization header"]);
      returnJsonHttpResponse(400, $response);
    }
  } else {
    $response = new ServerResponse(error: ["message" => "Authorization header is missing"]);
    returnJsonHttpResponse(401, $response);
  }
}
