<?php
include_once "../../../utils/headers.php";

switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        // Handle GET request
        break;

    case "POST":
        $requiredFieldsAccount = ["firstName", "lastName", "email", "password", "gender", "birthdate"];
        $requiredFieldsUser = ["street", "barangay", "municipality", "province", "country", "zipcode"];

        $jsonData = getBodyParameters();

        // Check required fields
        $fieldsAccount = checkFields($jsonData, $requiredFieldsAccount);
        $fieldsUser = checkFields($jsonData["address"], $requiredFieldsUser);

        // Check if email already exists
        $sql_check = "SELECT * FROM tblAccount WHERE email = ?";
        $result = $conn->execute_query($sql_check, [$fieldsAccount["email"]]);

        if ($result->num_rows != 0) {
            $response = new ServerResponse(error: ["message" => "Email already exists"]);
            returnJsonHttpResponse(409, $response);
        }

        // Hash password
        $options = ['cost' => 12];
        $hashedPassword = password_hash($fieldsAccount["password"], PASSWORD_DEFAULT, $options);

        // Insert into tblAccount
        $sql1 = $conn->prepare("INSERT INTO tblAccount (firstname, lastname, email, password, gender, birthdate) VALUES (?, ?, ?, ?, ?, ?)");
        $sql1->bind_param($fieldsAccount["firstName"], $fieldsAccount["lastName"], $fieldsAccount["email"], $hashedPassword, $fieldsAccount["gender"], date('Y-m-d H:i:s', strtotime($fieldsAccount["birthdate"])));
        $sql1->execute();

        $account = $sql1->get_result()->fetch_assoc();

        // Insert into tblUser
        $sql2 = $conn->prepare("INSERT INTO tblUser (userId, street, barangay, municipality, province, country) VALUES (?, ?, ?, ?, ?, ?)");
        $sql2->bind_param($account["account_id"], $fieldsUser["street"], $fieldsUser["barangay"], $fieldsUser["municipality"], $fieldsUser["province"], $fieldsUser["country"]);
        $sql2->execute();

        // Insert into tblBuyer
        $sql3 = $conn->prepare("INSERT INTO tblBuyer (buyerId) VALUES (?)");
        $sql3->bind_param($account["account_id"]);
        $sql3->execute();

        // Create token
        $hashedToken = createToken($account);
        $response = new ServerResponse(data: ["message" => "User registered successfully", "token" => $hashedToken]);
        returnJsonHttpResponse(200, $response);

    case "UPDATE":
        // Handle UPDATE request
        break;

    case "DELETE":
        // Handle DELETE request
        break;
}
