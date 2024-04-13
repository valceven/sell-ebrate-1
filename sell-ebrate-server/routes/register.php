<?php
include_once "utils/headers.php";

$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];

$email = $_POST["email"];
$password = $_POST["password"];

$gender = $_POST["gender"];
$birthdate = $_POST["birthdate"];

$street = $_POST["street"];
$barangay = $_POST["barangay"];
$municipality = $_POST["municipality"];
$province = $_POST["province"];
$country = $_POST["country"];
$zipcode = $_POST["zipcode"];


$sql_check = $mysqli->prepare("SELECT * FROM tblAccount WHERE email = ?");
$sql_check->bind_param("s", $email);
$sql_check->execute();

if ($sql1->get_result()->num_rows != 0) {
  $response = new ServerResponse(data: [], error: ["message" => "Email already exists"]);

  http_response_code(409);
  echo json_encode($response);
  exit();
}


$options = ['cost' => 12];
$hashed_password = password_hash($password, PASSWORD_DEFAULT, $options);

$sql1 = $conn->prepare("INSERT INTO tblAccount (firstname, lastname, email, password, gender, birhdate) VALUES (?, ?, ?, ?, ?, ?)");
$sql1->bind_param("ssssss", $firstname, $lastname, $email, $hashed_password, $gender, $birthdate);
$sql1->execute();
$user_id = $sql2->insert_id;


$sql2 = $conn->prepare("INSERT INTO tblUser (user_id, street, barangay, municipality, province, country, zipcode) VALUES (?, ?, ?, ?, ?, ?, ?)");
$sql2->bind_param("sssssss", $user_id, $street, $barangay, $municipality, $province, $country, $zipcode);
$sql2->execute();


$sql3 = $conn->prepare("INSERT INTO tblBuyer (buyer_id) VALUES (?)");
$sql3->bind_param("s", $user_id);
$sql3->execute();



$payload = array($user_id);
$hashed_payload = hash_hmac('sha256', json_encode($payload), $secret_key);
$response = new ServerResponse(data: ["message" => "User registered successfully", "token" => json_encode($hashed_payload)], error: []);

http_response_code(200);
echo json_encode($response);
