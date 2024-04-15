<?php

/**
 * returnJsonHttpResponse
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
 * getBodyParameters
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


/**
 * createToken
 *
 * makes a token out of a bunch of data
 *
 * @return array
 **/
function createToken($data)
{
  $payload = array("userId" => $user["userId"]);
  $hashedPayload = 'Bearer ' . hash_hmac('sha256', json_encode($payload), $secretKey);
}
