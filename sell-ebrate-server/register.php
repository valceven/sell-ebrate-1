<?php



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


// FIX: do some checks here first before data is added



// TODO: passowrd hash

$options = ['cost' => 12];
$hashed_password = password_hash($password, PASSWORD_DEFAULT, $options);

$sql1 = $conn->prepare("INSERT INTO tblAccount (firstname, lastname, email, password, gender, birhdate) VALUES (?, ?, ?, ?, ?, ?)");
$sql1->bind_param("ssssss", $firstname, $lastname, $email, $hashed_password, $gender, $birthdate);
$sql1->execute();
$user_id = $sql1->insert_id;


$sql2 = $conn->prepare("INSERT INTO tblUser (user_id, street, barangay, municipality, province, country, zipcode) VALUES (?, ?, ?, ?, ?, ?, ?)");
$sql2->bind_param("sssssss", $user_id, $street, $barangay, $municipality, $province, $country, $zipcode);
$sql2->execute();


// TODO: return data here, all of it
$response = new ServerResponse("User registered successfully", [], 200);
echo json_encode($response);
