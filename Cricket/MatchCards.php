<?php
// Fetch match data from the database where the bet_end_time is greater than the current time
$sql_matches = "SELECT *, TIMESTAMPDIFF(SECOND, NOW(), bet_end_time) AS time_diff_seconds FROM matches_data WHERE bet_end_time > NOW()";
$result_matches = $conn->query($sql_matches);
?>

<!-- Match cards and Question views -->
<?php
if ($result_matches->num_rows > 0) {
    while($row_match = $result_matches->fetch_assoc()) {
        echo '<div class="col-12 mt-3 games-container" id="matchContainer' . $row_match["match_id"] . '">'; // Container for each match and its associated question view
        echo '<div class="col-12 mt-3 games" data-id="women-t20" onclick="toggleQuestions(event, \'' . $row_match["match_id"] . '\');">';

        echo '<div class="gmvBox border shadow py-2 px-4 d-flex align-items-center justify-content-around">';
        echo '<div class="gxicon">';
        echo '<span id="tmxAIc"><img src="' . $row_match["team1_icon_image"] . '" style="width: 50px; height: 50px;"></span>';
        echo '<span id="tmxANm">' . $row_match["team1_name"] . '</span>';
        echo '</div>';
        // Display the countdown timer
        echo '<div class="betEndTimer" data-time="' . $row_match["time_diff_seconds"] . '"></div>'; // Store time difference in seconds as data attribute
        echo '<div class="gxicon">';
        echo '<span id="tmxBIc"><img src="' . $row_match["team2_icon_image"] . '" style="width: 50px; height: 50px;"></span>';
        echo '<span id="tmxBNm">' . $row_match["team2_name"] . '</span>';
        echo '</div>';
        echo '</div>';

        echo '</div>'; // Close match card container
        
        // Hidden div for questions view
        echo '<div id="match' . $row_match["match_id"] . 'Questions" class="match-questions" style="display: none;">';
        // Fetch questions associated with this match
        $match_id = $row_match["match_id"];
        include 'BetQuestions.php'; // Include the questions view
        echo '</div>';

        echo '</div>'; // Close games-container
    }
} else {
    echo '<div class="col-12 mt-3 games">';
    echo '<div class="gmvBox border shadow py-2 px-4 d-flex align-items-center justify-content-around">';
    echo '<div class="gxicon">';
    echo '<span>No matches found</span>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}
?>