<?php
include_once "../../../utils/headers.php";


switch ($_SERVER["REQUEST_METHOD"]) {
  case "GET":

  case "POST":
    // FIX: shorten this using good programming pracitces
    $requiredFieldsAccount = ["firstName", "lastName", "email", "password", "gender", "birthdate"];
    $requiredFieldsUser = ["street", "barangay", "municipality", "province", "country", "zipcode"];

    $jsonData = getBodyParameters();

    $fieldsAccount = checkFields($jsonData, $requiredFieldsAccount);
    $fieldsUser = checkFields($jsonData["address"], $requiredFieldsUser);

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

    $sql_check = "SELECT * FROM tblAccount WHERE email = ?";
    $result = $conn->execute_query($sql_check, [$fieldsAccount["email"]]);

    if ($result->num_rows != 0) {
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

    $hashedPayload = createToken($user);
    $response = new ServerResponse(data: ["message" => "User registered in successfully", "token" => $hashedPayload]);
    returnJsonHttpResponse(200, $response);

  case "UPDATE":

  case "DELETE":
}
