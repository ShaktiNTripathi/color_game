<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$match_id = $team1_name = $team2_name = $team1_icon_url = $team2_icon_url = $bet_end_time = $match_details = "";
$match_id_err = $team1_name_err = $team2_name_err = $team1_icon_url_err = $team2_icon_url_err = $bet_end_time_err = $match_details_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Populate form data
    $match_id = $_POST["match_id"];
    $team1_name = $_POST["team1_name"];
    $team2_name = $_POST["team2_name"];
    $team1_icon_url = $_POST["team1_icon_url"];
    $team2_icon_url = $_POST["team2_icon_url"];
    $bet_end_time = $_POST["bet_end_time"];
    $match_details = $_POST["match_details"];

    // Validate match ID
    if (empty(trim($_POST["match_id"]))) {
        $match_id_err = "Please enter match ID.";
    } else {
        // Prepare a select statement to check if the match ID already exists
        $sql_check = "SELECT match_id FROM matches_data WHERE match_id = ?";
        
        if ($stmt_check = mysqli_prepare($conn, $sql_check)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt_check, "i", $param_match_id_check);

            // Set parameters
            $param_match_id_check = trim($_POST["match_id"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt_check)) {
                // Store result
                mysqli_stmt_store_result($stmt_check);

                if (mysqli_stmt_num_rows($stmt_check) == 1) {
                    $match_id_err = "Warning: This match ID is already assigned to another match.";
                } else {
                    $match_id = trim($_POST["match_id"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt_check);
        }
    }

    // Validate team 1 name
    if (empty(trim($_POST["team1_name"]))) {
        $team1_name_err = "Please enter team 1 name.";
    } else {
        $team1_name = trim($_POST["team1_name"]);
    }

    // Validate team 2 name
    if (empty(trim($_POST["team2_name"]))) {
        $team2_name_err = "Please enter team 2 name.";
    } else {
        $team2_name = trim($_POST["team2_name"]);
    }

    // Validate match details
    if (empty(trim($_POST["match_details"]))) {
        $match_details_err = "Please enter match details.";
    } else {
        $match_details = trim($_POST["match_details"]);
    }

    // Validate team 1 icon URL
    if (empty(trim($_POST["team1_icon_url"]))) {
        $team1_icon_url_err = "Please enter team 1 icon URL.";
    } else {
        $team1_icon_url = trim($_POST["team1_icon_url"]);
    }

    // Validate team 2 icon URL
    if (empty(trim($_POST["team2_icon_url"]))) {
        $team2_icon_url_err = "Please enter team 2 icon URL.";
    } else {
        $team2_icon_url = trim($_POST["team2_icon_url"]);
    }

    // Validate bet end time
    if (empty(trim($_POST["bet_end_time"]))) {
        $bet_end_time_err = "Please enter bet end time.";
    } else {
        $bet_end_time = trim($_POST["bet_end_time"]);
    }

    // Check if all required fields are filled
    if (empty($match_id_err) && empty($team1_name_err) && empty($team2_name_err) && empty($team1_icon_url_err) && empty($team2_icon_url_err) && empty($bet_end_time_err) && empty($match_details_err)) {
        // Prepare an insert statement
        $sql_insert = "INSERT INTO matches_data (match_id, team1_name, team2_name, team1_icon_image, team2_icon_image, bet_end_time, match_details) VALUES (?, ?, ?, ?, ?, ?, ?)";

        if ($stmt_insert = mysqli_prepare($conn, $sql_insert)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt_insert, "issssss", $param_match_id, $param_team1_name, $param_team2_name, $param_team1_icon_url, $param_team2_icon_url, $param_bet_end_time, $param_match_details);

            // Set parameters
            $param_match_id = $match_id;
            $param_team1_name = $team1_name;
            $param_team2_name = $team2_name;
            $param_team1_icon_url = $team1_icon_url;
            $param_team2_icon_url = $team2_icon_url;
            $param_bet_end_time = $bet_end_time;
            $param_match_details = $match_details;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt_insert)) {
                // Set success message
                    $success_message = "Match created successfully!";
                // Redirect to matches_data page
                header("location: add_match.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt_insert);
        }
    }

    // Close connection
    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ADMIN</title>
    <!-- Add your meta tags, stylesheets, and other resources here -->
</head>

<body>
    <!-- Your HTML content goes here -->
</body>

</html>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ADMIN</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="css/app.46643acf.css" rel="preload" as="style">
    <link href="css/chunk-vendors.cf06751b.css" rel="preload" as="style">
    <link href="css/chunk-vendors.cf06751b.css" rel="stylesheet">
    <link href="css/app.46643acf.css" rel="stylesheet">
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="admincss/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="admincss/style.css" rel="stylesheet">
    <style>
        body {
            font-family: "Lato", sans-serif;
        }

        .sidenav {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #111;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }

        .sidenav a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 25px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }

        .sidenav a:hover {
            color: #f1f1f1;
        }

        .sidenav .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }

        #main {
            transition: margin-left .5s;
            padding: 16px;
        }

        @media screen and (max-height: 450px) {
            .sidenav {
                padding-top: 15px;
            }

            .sidenav a {
                font-size: 18px;
            }
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            overflow: hidden;
        }

        body {
            counter-reset: Serial;
            /* Set the Serial counter to 0 */
        }

        tr td:first-child:before {
            counter-increment: Serial;
            /* Increment the Serial counter */
            content: counter(Serial);
            /* Display the counter */
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

        #searchbar {
            margin-left: 15%;
            padding: 15px;
            border-radius: 10px;
        }

        input[type=text] {
            width: 30%;
            -webkit-transition: width 0.15s ease-in-out;
            transition: width 0.15s ease-in-out;
        }

        /* Adjustments */
        #bet_end_time {
            width: 30.5%;
        }

        .submit-btn {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="index.html" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>ADMIN</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="admincss/male-09.jpg" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0" style="color: #fff;">Jhon Doe</h6>
                        <span>Admin</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="admin" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="users" class="nav-item nav-link"><i class="fa fa-user"></i>users</a>
                    <a href="adpre" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Next Prediction</a>
                    <a href="cricketmatches" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Cricket Matches</a>
                    <a href="cricketquestion" class="nav-item nav-link"><i class="fas fa-question"></i>Cricket Questions</a>
                    <a href="adpre" class="nav-item nav-link"><i class="fas fa-money-bill"></i>Cricket Bets</a>
                    <a href="adreward" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Add Reward</a>
                    <a href="inviterec" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Invite Record</a>
                    <a href="adwith" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Withdraw Req</a>
                    <a href="rechargeRequests" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Recharge Req</a>
                    <!--<a href="upi" class="nav-item nav-link"><i class="fa fa-table me-2"></i>upi change</a>-->
                    <a href="adduser" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Add User</a>
                    <a href="notice" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Notice change</a>
                    <a href="delete" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Delete User</a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0" style="background-color: #071251 !important;">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="admincss/male-09.jpg" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex">John Doe</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="/logout" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

            <!-- New Match Form Start -->
<div class="container mt-4">
    <h2>Add New Match</h2>
    <!-- Success Message -->
    <?php if (isset($success_message) && !empty($success_message)) : ?>
        <div class="alert alert-success" role="alert">
            <?php echo $success_message; ?>
        </div>
    <?php endif; ?>
                <!-- End of Success Message -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="form-group">
                        <label for="match_id">Match ID:</label>
                        <input type="text" id="match_id" name="match_id" class="form-control" value="<?php echo $match_id; ?>">
                        <span class="text-danger"><?php echo $match_id_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="team1_name">Team 1 Name:</label>
                        <input type="text" id="team1_name" name="team1_name" class="form-control" value="<?php echo $team1_name; ?>">
                        <span class="text-danger"><?php echo $team1_name_err; ?></span>
                    </div>
            
                    <div class="form-group">
                        <label for="team2_name">Team 2 Name:</label>
                        <input type="text" id="team2_name" name="team2_name" class="form-control" value="<?php echo $team2_name; ?>">
                        <span class="text-danger"><?php echo $team2_name_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="match_details">Match Details:</label>
                        <input type="text" id="match_details" name="match_details" class="form-control" placeholder="Team1 vs Team2" value="<?php echo $match_details; ?>">
                        <span class="text-danger"><?php echo $match_details_err; ?></span>
                    </div>
            
                    <div class="form-group">
                        <label for="team1_icon_url">Team 1 Icon URL:</label>
                        <input type="text" id="team1_icon_url" name="team1_icon_url" class="form-control" value="<?php echo $team1_icon_url; ?>">
                        <span class="text-danger"><?php echo $team1_icon_url_err; ?></span>
                    </div>
            
                    <div class="form-group">
                        <label for="team2_icon_url">Team 2 Icon URL:</label>
                        <input type="text" id="team2_icon_url" name="team2_icon_url" class="form-control" value="<?php echo $team2_icon_url; ?>">
                        <span class="text-danger"><?php echo $team2_icon_url_err; ?></span>
                    </div>
            
                    <div class="form-group">
                        <label for="bet_end_time">Bet End Time:</label>
                        <input type="datetime-local" id="bet_end_time" name="bet_end_time" class="form-control" value="<?php echo $bet_end_time; ?>">
                        <span class="text-danger"><?php echo $bet_end_time_err; ?></span>
                    </div>
            
                    <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                </form>
            </div>
            <!-- New Match Form End -->



            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4" style="background-color: #efefef !important; margin-top: 101px; margin-right: -24px; margin-left: -25px;">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="https://t.me/dailywinnersupportbot">Contact Developer</a>
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            Designed By <a href="#">Nani</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="adminjs/main.js"></script>
</body>

</html>

