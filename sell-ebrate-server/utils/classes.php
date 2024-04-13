<?php

class ServerResponse

{
  public $message;
  public $data;
  public $statusCode;

  public function __construct($message, $data, $statusCode)
  {
    $this->message = $message;
    $this->data = $data;
    $this->statusCode = $statusCode;
  }
}
