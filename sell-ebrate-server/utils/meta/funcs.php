<?php


/*
 * returnJsonHttpResponse
 * @param $success: Boolean
 * @param $data: Object or Array
 */
function returnJsonHttpResponse($httpCode, $data)
{
  ob_start();
  ob_clean();

  header_remove();
  http_response_code($httpCode);

  echo json_encode($data);
  exit();
}


function getBodyParameters()
{
  $rawData = file_get_contents('php://input');
  $jsonData = json_decode($rawData, true);

  return $jsonData;
}
