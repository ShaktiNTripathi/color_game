<?php
// Fetch match data from the database
$current_time = date("Y-m-d H:i:s");
$sql_matches = "SELECT *, TIMESTAMPDIFF(SECOND, NOW(), bet_end_time) AS time_diff_seconds FROM matches_data WHERE bet_end_time < '$current_time'";
$result_matches = $conn->query($sql_matches);
?>

<!-- Match card -->
<!-- PHP: Display match cards -->
<?php
if ($result_matches->num_rows > 0) {
    while($row_match = $result_matches->fetch_assoc()) {
        echo '<div class="col-12 mt-3 games-container" id="matchContainer' . $row_match["match_id"] . '">'; // Container for each match and its associated question view
        echo '<div class="col-12 mt-3 games">';
        
        // Check if the match has ended
echo '<div class="gmvBox border shadow py-2 px-4 d-flex align-items-center justify-content-around">';
echo '<div class="gxicon">';
echo '<span id="tmxAIc"><img src="' . $row_match["team1_icon_image"] . '" style="width: 50px; height: 50px;"></span>';
echo '<span id="tmxANm">' . $row_match["team1_name"] . '</span>';
echo '</div>';
echo '<div class="betEndText">Bet Ended</div>'; // Display "Bet Ended" for all matches with the animation class
echo '<div class="gxicon">';
echo '<span id="tmxBIc"><img src="' . $row_match["team2_icon_image"] . '" style="width: 50px; height: 50px;"></span>';
echo '<span id="tmxBNm">' . $row_match["team2_name"] . '</span>';
echo '</div>';
echo '</div>';

        
        echo '</div>'; // Close match card container
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
