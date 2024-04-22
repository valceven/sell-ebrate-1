

<?php


include_once "./env.php";

// automatically makes route protected
// TODO: improve this later on
function getAuthPayload()
{

  global $secretKey;

  if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
    $response = new ServerResponse(error: ["message" => "Authorization header is missing"]);
    returnJsonHttpResponse(401, $response);
  }
  $authorizationHeader = $_SERVER['HTTP_AUTHORIZATION'];

  /* if (preg_match('/^Bearer\s(+[a-fA-F0-9]{64})$/', $authorizationHeader, $matches)) { */
  /*   $response = new ServerResponse(error: ["message" => "Invalid Authorization header"]); */
  /*   returnJsonHttpResponse(400, $response); */
  /* } 
  /* $token = $matches[1]; */


  $token = explode(' ', $authorizationHeader)[1];
  list($header, $payload, $signature) = explode('.', $token);

  if (!($signature === hash_hmac('sha256', $header . '.' . $payload, $secretKey))) {
    $response = new ServerResponse(error: ["message" => "Invalid Authorization header"]);
    returnJsonHttpResponse(400, $response);
  }

  return uncleanData($payload);
}
