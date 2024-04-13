<?php
include_once "../utils/headers.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $rawData = file_get_contents('php://input');
  $jsonData = json_decode($rawData, true);

  $firstname = $jsonData["firstname"];
  $lastname = $jsonData["lastname"];

  $email = $jsonData["email"];
  $password = $jsonData["password"];

  $gender = $jsonData["gender"];
  $birthdate = $jsonData["birthdate"];

  $address = $jsonData["address"];

  $street = $address["street"];
  $barangay = $address["barangay"];
  $municipality = $address["municipality"];
  $province = $address["province"];
  $country = $address["country"];
  $zipcode = $address["zipcode"];


  // FIX: i hate validation
  /* $requiredFields = ["firstname", "lastname", "email", "password", "gender", "birthdate", "address"]; */

  /* foreach ($requiredFields as $field) { */
  /*   if (empty($jsonData[$field])) { */
  /*     $response = new ServerResponse(data: [], error: ["message" => "Missing required fields"]); */
  /*     returnJsonHttpResponse(400, $response); */
  /*   } */
  /* } */


  $sql_check = $conn->prepare("SELECT * FROM tblAccount WHERE email = ?");
  $sql_check->bind_param("s", $email);
  $sql_check->execute();


  if ($sql_check->get_result()->num_rows != 0) {
    $response = new ServerResponse(data: [], error: ["message" => "Email already exists"]);

    returnJsonHttpResponse(409, $response);
  }


  $options = ['cost' => 12];
  $hashed_password = password_hash($password, PASSWORD_DEFAULT, $options);

  $sql1 = $conn->prepare("INSERT INTO tblAccount (firstname, lastname, email, password, gender, birthdate) VALUES (?, ?, ?, ?, ?, ?)");
  $sql1->bind_param("ssssss", $firstname, $lastname, $email, $hashed_password, $gender, $birthdate);
  $sql1->execute();
  $user_id = $sql1->insert_id;


  $sql2 = $conn->prepare("INSERT INTO tblUser (user_id, street, barangay, municipality, province, country, zipcode) VALUES (?, ?, ?, ?, ?, ?, ?)");
  $sql2->bind_param("sssssss", $user_id, $street, $barangay, $municipality, $province, $country, $zipcode);
  $sql2->execute();


  $sql3 = $conn->prepare("INSERT INTO tblBuyer (buyer_id) VALUES (?)");
  $sql3->bind_param("s", $user_id);
  $sql3->execute();


  $payload = array($user_id);
  $hashed_payload = hash_hmac('sha256', json_encode($payload), $secret_key);
  $response = new ServerResponse(data: ["message" => "User registered successfully", "token" => json_encode($hashed_payload)], error: []);

  returnJsonHttpResponse(200, $response);
}
