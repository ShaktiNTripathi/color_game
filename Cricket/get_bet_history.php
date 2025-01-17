<?php

// Database connection parameters
$host = 'localhost'; // Change this if your database is hosted elsewhere
$username = 'club1';
$password = 'club1';
$dbname = 'club1';

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection error
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Database connection failed: " . $e->getMessage()]);
    exit();
}

// Check if the username parameter is set
if (!isset($_GET['username'])) {
    // If username parameter is not provided, return an error response
    //http_response_code(400); // Bad Request
    echo json_encode(["error" => "Username parameter is missing"]);
    exit();
}

$username = $_GET['username'];

// Prepare SQL query to fetch bet history data for the specified username
$query = "SELECT * FROM cricket_bets WHERE username = :username";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':username', $username);

try {
    // Execute the query
    $stmt->execute();

    // Fetch all bet history records for the specified username
    $bet_history = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return bet history data as JSON
    header('Content-Type: application/json');
    echo json_encode($bet_history ?: []); // Return an empty array if no records found
} catch (PDOException $e) {
    // Handle query execution error
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Error executing SQL query: " . $e->getMessage()]);
}
?>
