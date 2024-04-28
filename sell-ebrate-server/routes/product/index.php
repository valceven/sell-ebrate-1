<?php
include_once "../../utils/headers.php";

switch ($_SERVER["REQUEST_METHOD"]) {

  case "GET":
    // Fetch product data from the database
    $sql = $conn->prepare("SELECT * FROM tblProduct");
    if (!$sql) {
        $response = new ServerResponse(data: [], error: ["message" => "Error in preparing SQL statement"]);
        returnJsonHttpResponse(500, $response);
        exit;
    }

    if (!$sql->execute()) {
        $response = new ServerResponse(data: [], error: ["message" => "Error executing SQL statement"]);
        returnJsonHttpResponse(500, $response);
        exit;
    }

    // Fetch all products as associative arrays
    $result = $conn->execute_query($sql);
    if (!$result) {
        $response = new ServerResponse(data: [], error: ["message" => "Error fetching products from database"]);
        returnJsonHttpResponse(500, $response);
        exit;
    }

    $products = $result->fetch_all(MYSQLI_ASSOC);

    // Prepare response
    $response = new ServerResponse(data: ["message" => "Products data fetched successfully", "products" => $products], error: []);

    // Return JSON response
    returnJsonHttpResponse(200, $response);

  case "POST":
    // Extract JSON data from request body
    $jsonData = getBodyParameters();
    
    // Define required fields
    $requiredFields = ["sellerId", "productName", "description", "quantity", "price"];
    
    // Check if all required fields are present in JSON data
    $fields = checkFields($jsonData, $requiredFields);

    // Prepare SQL query for inserting new product
    $sql = $conn->prepare("INSERT INTO tblProduct (sellerId, productName, description, quantity, price) VALUES (?, ?, ?, ?, ?)");
    if (!$sql) {
        $response = new ServerResponse(data: [], error: ["message" => "Error in preparing SQL statement"]);
        returnJsonHttpResponse(500, $response);
        exit;
    }

    // Execute SQL query with values from JSON data
    $result = $conn->execute_query($sql, [
      $jsonData["sellerId"],
      $jsonData["productName"],
      $jsonData["description"],
      $jsonData["quantity"],
      $jsonData["price"]
    ]);

    if (!$result) {
        $response = new ServerResponse(data: [], error: ["message" => "Error adding product to database"]);
        returnJsonHttpResponse(500, $response);
        exit;
    }

    // Prepare response
    $response = new ServerResponse(data: ["message" => "Product added successfully!"]);
    
    // Return JSON response
    returnJsonHttpResponse(200, $response);

  case "UPDATE":

  case "DELETE":
}
