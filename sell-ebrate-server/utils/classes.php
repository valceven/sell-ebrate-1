<?php


class ServerResponse

{
  public $data;
  public $error;

  public function __construct($data = null, $error = null)
  {
    echo $data;
    $this->data = $data;
    $this->error = $error;
  }
}
