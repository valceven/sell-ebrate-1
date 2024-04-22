<?php

include_once "./env.php";

/**
 * Return Json Http Response
 *
 * returns a json response $data;
 *
 * @param int $httpCode 
 * @param any $data 
 * @return string
 **/
function  returnJsonHttpResponse(int $httpCode, $data): string
{
  ob_start();
  ob_clean();

  header_remove();
  http_response_code($httpCode);

  echo json_encode($data);
  exit();
}


/**
 * Get Body Parameters
 *
 * grabs the body parameters of a request and passes it as an assoc
 *
 * @return array
 **/
function getBodyParameters(): array
{
  $rawData = file_get_contents('php://input');
  $jsonData = json_decode($rawData, true);

  return $jsonData;
}


function cleanData($data): string
{
  return base64_encode(urlencode(serialize($data)));
}


function uncleanData(string $data)
{
  return unserialize(urldecode(base64_decode($data)));
}


/**
 * Create Token
 *
 * makes a token out of a bunch of data
 *
 * @return string
 **/
function createToken($user)
{
  global $secretKey;

  $header = cleanData([
    "alg" => "HS256",
    "typ" => "JWT"
  ]);
  $payload = cleanData($user);
  $signature = hash_hmac('sha256', $header . '.' . $payload, $secretKey);

  return 'Bearer ' . $header . '.' . $payload . '.' . $signature;
}



/**
 * Fields Check
 *
 * checks if required fields are present in data
 *
 * @return array
 **/
function checkFields($data, $requiredFields): array
{
  if ($data == null) {
    returnJsonHttpResponse(400, new ServerResponse(error: ["message" => "Missing required fields!"]));
  }

  $fields = [];

  foreach ($requiredFields as $field) {
    if (empty($data[$field])) {
      returnJsonHttpResponse(400, new ServerResponse(error: ["message" => "Missing required fields! Field " . $field . " may be missing..."]));
    }
    $fields[$field] = $data[$field];
  }

  return $fields;
}
