

<?php
include_once "../../utils/headers.php";


switch ($_SERVER["REQUEST_METHOD"]) {
  case "GET":
    $payload = getAuthPayload();

    $sql1 = "SELECT * FROM tblCart a  JOIN tblCartItem b ON a.cartId = b.cartId AND a.userId = ? JOIN tblProduct c ON b.productId = c.productId";
    $result = $conn->execute_query($sql1, [$payload["accountId"]]);
    $cart = $result->fetch_all(MYSQLI_ASSOC);

    $response = new ServerResponse(data: ["message" => "User cart fetched successfully", "cart" => $cart]);

    returnJsonHttpResponse(200, $response);

  case "POST":

  case "UPDATE":

  case "DELETE":
}
