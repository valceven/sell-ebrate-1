<?php
include_once "../../../utils/headers.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $jsonData = getBodyParameters();

  $firstName = $jsonData["firstName"];
  $lastName = $jsonData["lastName"];

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
    $response = new ServerResponse(error: ["message" => "Email already exists"]);

    returnJsonHttpResponse(409, $response);
  }


  $options = ['cost' => 12];
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT, $options);

  $sql1 = $conn->prepare("INSERT INTO tblAccount (firstName, lastName, email, password, gender, birthdate) VALUES (?, ?, ?, ?, ?, ?)");
  $sql1->bind_param("ssssss", $firstName, $lastName, $email, $hashedPassword, $gender, date('Y-m-d H:i:s', strtotime($birthdate)));
  $sql1->execute();
  $userId = $sql1->insert_id;


  $sql2 = $conn->prepare("INSERT INTO tblUser (userId, street, barangay, municipality, province, country, zipcode) VALUES (?, ?, ?, ?, ?, ?, ?)");
  $sql2->bind_param("sssssss", $userId, $street, $barangay, $municipality, $province, $country, $zipcode);
  $sql2->execute();


  $sql3 = $conn->prepare("INSERT INTO tblBuyer (buyerId) VALUES (?)");
  $sql3->bind_param("s", $userId);
  $sql3->execute();


  $payload = array($userId);
  $hashedPayload = 'Bearer ' . hash_hmac('sha256', json_encode($payload), $secretKey);
  $response = new ServerResponse(data: ["message" => "User registered successfully", "token" => $hashedPayload]);

  returnJsonHttpResponse(200, $response);
}
