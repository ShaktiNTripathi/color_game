<?php
// Receive data from the request
$data = json_decode(file_get_contents('php://input'), true);

// Debug: Log received data
error_log("Received data: " . print_r($data, true));

// Extract data
if (!isset($data['username']) || !isset($data['questionId']) || !isset($data['betAmount']) || !isset($data['selectedAnswer']) || !isset($data['matchId'])) {
    echo json_encode(['success' => false, 'message' => 'Incomplete data']);
    exit;
}

$username = $data['username'];
$questionId = $data['questionId'];
$betAmount = $data['betAmount'];
$selectedAnswer = $data['selectedAnswer'];
$matchId = $data['matchId'];

// Get the current Indian time
date_default_timezone_set('Asia/Kolkata');
$currentDateTime = date('Y-m-d H:i:s');

// Establish PDO connection
try {
    $connect = new PDO("mysql:host=localhost;dbname=club1", "club1", 'club1');
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("PDO Connection Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database connection error']);
    exit;
}

// Validate user's balance (fetch from database)
try {
    $sql_balance = "SELECT balance FROM users WHERE username = :username";
    $stmt_balance = $connect->prepare($sql_balance);
    $stmt_balance->bindParam(':username', $username);
    $stmt_balance->execute();
    $result_balance = $stmt_balance->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("PDO Query Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database query error']);
    exit;
}

// Fetch match details (including match name)
try {
    $sql_match_details = "SELECT match_details FROM matches_data WHERE match_id = :matchId";
    $stmt_match_details = $connect->prepare($sql_match_details);
    $stmt_match_details->bindParam(':matchId', $matchId);
    $stmt_match_details->execute();
    $result_match_details = $stmt_match_details->fetch(PDO::FETCH_ASSOC);
    $matchDetails = $result_match_details['match_details'];
} catch (PDOException $e) {
    error_log("PDO Query Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Failed to fetch match details']);
    exit;
}

// Check if user exists and has sufficient balance
if ($result_balance) {
    $userBalance = $result_balance['balance'];

    if ($userBalance >= $betAmount) {
        // Deduct bet amount from user's balance
        $newBalance = $userBalance - $betAmount;

        try {
            // Begin transaction
            $connect->beginTransaction();

            // Update user's balance in the database
            $sql_update_balance = "UPDATE users SET balance = :newBalance WHERE username = :username";
            $stmt_update_balance = $connect->prepare($sql_update_balance);
            $stmt_update_balance->bindParam(':newBalance', $newBalance);
            $stmt_update_balance->bindParam(':username', $username);
            $stmt_update_balance->execute();

            // Insert bet details into cricket_bets table including the selected answer, match ID, match name, and current time
            $sql_insert_bet = "INSERT INTO cricket_bets (username, match_id, match_name, question, bet_amount, answer_bet, bet_dated) VALUES (:username, :matchId, :matchName, :questionId, :betAmount, :selectedAnswer, :currentDateTime)";
            $stmt_insert_bet = $connect->prepare($sql_insert_bet);
            $stmt_insert_bet->bindParam(':username', $username);
            $stmt_insert_bet->bindParam(':matchId', $matchId);
            $stmt_insert_bet->bindParam(':matchName', $matchDetails); // Include match name
            $stmt_insert_bet->bindParam(':questionId', $questionId);
            $stmt_insert_bet->bindParam(':betAmount', $betAmount);
            $stmt_insert_bet->bindParam(':selectedAnswer', $selectedAnswer);
            $stmt_insert_bet->bindParam(':currentDateTime', $currentDateTime);
            $stmt_insert_bet->execute();

            // Commit transaction
            $connect->commit();

            // Return success response
            echo json_encode(['success' => true, 'message' => 'Bet placed successfully']);
        } catch (PDOException $e) {
            // Rollback transaction and log error
            $connect->rollback();
            error_log("PDOException: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Failed to place bet']);
        }
    } else {
        // Return insufficient balance error
        echo json_encode(['success' => false, 'message' => 'Insufficient balance']);
    }
} else {
    // Return user not found error
    echo json_encode(['success' => false, 'message' => 'User not found']);
}
?>
