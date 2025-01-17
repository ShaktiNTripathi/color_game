<?php
// Fetch questions from the database for the current match
$sql_questions = "SELECT * FROM cricket_questions WHERE match_id = $match_id"; // Filter by match_id
$result_questions = $conn->query($sql_questions);
?>

<!-- Open bet(s) section -->
<?php
if ($result_questions->num_rows > 0) {
    while($row_question = $result_questions->fetch_assoc()) {
        echo '<div class="card question-card" id="qst_' . $row_question["match_id"] . '_question_' . $row_question["question_id"] . '">'; // Use $row_question["match_id"] to ensure the correct match ID is displayed
        echo '<div class="card-header question-header" onclick="toggleQuestion(event)">';
        echo '<span class="question-text">' . $row_question["question"] . '</span>';
        echo '<div class="toggle-icon" id="qst_' . $row_question["match_id"] . '_question_' . $row_question["question_id"] . 'ToggleIcon">';
        echo '<img src="https://kushubmedia.com/build/new-osg-app/slider/1.png" alt="Expand" style="width: 20px; height: 20px;">';
        echo '</div>';
        echo '</div>';
        echo '<div class="card-body question-content" id="qst_' . $row_question["match_id"] . '_question_' . $row_question["question_id"] . 'Content">';
        echo '<div class="row align-items-center">';
        echo '<div class="col-md-4 mb-2">';
        echo '<select class="form-control" id="answer_' . $row_question["question_id"] . '">';
        echo '<option value="">-Select-</option>';
        // Split answers into an array
        $answers = explode(',', $row_question["answers"]);
        // Output each answer as an option
        foreach ($answers as $answer) {
            echo '<option value="' . $answer . '">' . $answer . '</option>';
        }
        echo '</select>';
        echo '</div>';
        echo '<div class="col-md-4 mb-2">';
        // Add an ID for the bet amount input field and a data attribute for the username
        echo '<input type="tel" id="betAmount_' . $row_question["question_id"] . '" class="form-control mb-0" placeholder="Amount" data-username="username">';
        echo '</div>';
        echo '<div class="col-md-3 mb-2">';
        // Add onclick event to call the placeBet function
        echo '<button class="btn btn-primary btn-bet" onclick="placeBet(' . $row_question["question_id"] . ', ' . $row_question["match_id"] . ')">BET NOW</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} else {
    // Display a card with "No questions found for this match" message
    echo '<div class="card">';
    echo '<div class="card-body">';
    echo '<p class="card-text">No questions found for this match</p>';
    echo '</div>';
    echo '</div>';
}
?>
