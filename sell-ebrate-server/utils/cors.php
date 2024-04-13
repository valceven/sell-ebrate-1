
<?php
// Allow requests from specific origins (replace * with your allowed domains)
header("Access-Control-Allow-Origin: *");

// Allow specific HTTP methods (e.g., GET, POST, OPTIONS)
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

// Allow specific HTTP headers (e.g., Content-Type, Authorization)
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Allow credentials (cookies, authorization headers, etc.) to be sent with requests
header("Access-Control-Allow-Credentials: true");

// Set the Content-Type header for JSON responses
header("Content-Type: application/json");
