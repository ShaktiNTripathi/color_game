<?php
// Start the session
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION["adloggedin"]) || $_SESSION["adloggedin"] !== true) {
    header("location: adlogin");
    exit;
}

// Include the configuration file
require_once "config.php";

// Handle form submissions for updating correct answer or win amount
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form submission is for updating correct answer
    if (isset($_POST['submit_correct'])) {
        $id = $_POST['bet_id'];
        $correct_answer = $_POST['correct_answer'];

        // Update correct answer in cricket_bets table
        $update_query = "UPDATE cricket_bets SET answer_correct = '$correct_answer' WHERE id = $id";
        $update_result = mysqli_query($conn, $update_query);
        if ($update_result) {
            // Success message
            echo "<script>alert('Correct answer updated successfully');</script>";
            // You can redirect the user or do any other action here
        } else {
            // Error message
            echo "<script>alert('Error updating correct answer');</script>";
        }
    }
    // Check if the form submission is for updating win amount
    elseif (isset($_POST['submit_win'])) {
        $id = $_POST['bet_id'];
        $win_amount = $_POST['win_amount'];

        // Update win amount in cricket_bets table
        $update_query = "UPDATE cricket_bets SET win_amount = '$win_amount' WHERE id = $id";
        $update_result = mysqli_query($conn, $update_query);
        if ($update_result) {
            // Fetch bet amount from the database
            $bet_amount_query = "SELECT bet_amount, username FROM cricket_bets WHERE id = $id";
            $bet_amount_result = mysqli_query($conn, $bet_amount_query);
            if ($bet_amount_result && mysqli_num_rows($bet_amount_result) > 0) {
                $bet_row = mysqli_fetch_assoc($bet_amount_result);
                $username = $bet_row['username'];

                // Update user's balance with the specified winning amount
                $update_balance_query = "UPDATE users SET balance = balance + $win_amount WHERE username = '$username'";
                $update_balance_result = mysqli_query($conn, $update_balance_query);
                if ($update_balance_result) {
                    // Success message
                    echo "<script>alert('Win amount added to user wallet balance successfully');</script>";
                    // You can redirect the user or do any other action here
                } else {
                    // Error message
                    echo "<script>alert('Error updating user wallet balance');</script>";
                }
            } else {
                // Error message
                echo "<script>alert('Error retrieving bet information');</script>";
            }
        } else {
            // Error message
            echo "<script>alert('Error updating win amount');</script>";
        }
    }
}

// Fetch data from the cricket_bets table along with question text from cricket_questions
$query = "SELECT cb.*, cq.question 
          FROM cricket_bets AS cb 
          INNER JOIN cricket_questions AS cq ON cb.question = cq.question_id";

$result = mysqli_query($conn, $query);

// Check if query executed successfully
if ($result) {
    // Initialize an empty string to store HTML table rows
    $dataRow = "";

    // Loop through each row of the result set
    while ($row = mysqli_fetch_assoc($result)) {
        // Construct table row with data
        $dataRow .= "<tr>";
        $dataRow .= "<td>" . $row['id'] . "</td>";
        $dataRow .= "<td>" . $row['username'] . "</td>";
        $dataRow .= "<td>" . $row['match_id'] . "</td>";
        $dataRow .= "<td>" . $row['match_name'] . "</td>";
        $dataRow .= "<td>" . $row['question'] . "</td>"; // Display question text directly
        $dataRow .= "<td>" . $row['answer_bet'] . "</td>";
        $dataRow .= "<td><form method='post'><input type='hidden' name='bet_id' value='" . $row['id'] . "'><input type='text' name='correct_answer' value='" . $row['answer_correct'] . "'><button type='submit' name='submit_correct'>Submit Correct Answer</button></form></td>";
        $dataRow .= "<td>" . $row['bet_amount'] . "</td>";
        $dataRow .= "<td><form method='post'><input type='hidden' name='bet_id' value='" . $row['id'] . "'><input type='text' name='win_amount' value='" . $row['win_amount'] . "'><button type='submit' name='submit_win'>Submit Win Amount</button></form></td>";
        $dataRow .= "<td>" . $row['bet_dated'] . "</td>";
        $dataRow .= "</tr>";
    }
} else {
    // Handle query execution error
    $dataRow = "<tr><td colspan='10'>Error retrieving data</td></tr>";
}

?>

<!-- Your HTML code here -->

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
    .sidenav {padding-top: 15px;}
    .sidenav a {font-size: 18px;}
  }
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
  overflow: hidden;

}
body
{
    counter-reset: Serial;           /* Set the Serial counter to 0 */
}


tr td:first-child:before
{
  counter-increment: Serial;      /* Increment the Serial counter */
  content:  counter(Serial); /* Display the counter */
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
#searchbar{
     margin-left: 15%;
     padding:15px;
     border-radius: 10px;
   }
 
   input[type=text] {
      width: 30%;
      -webkit-transition: width 0.15s ease-in-out;
      transition: width 0.15s ease-in-out;
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
                        <h6 class="mb-0"style="
    color: #fff;
">Jhon Doe</h6>
                        <span>Admin</span>
                    </div>
                </div>
                  <div class="navbar-nav w-100">
                    <a href="admin" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="users" class="nav-item nav-link"><i class="fa fa-user"></i>users</a>
                    <a href="adpre" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Next Prediction</a>
                    <a href="cricketmatches" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Cricket Matches</a>
                    <a href="cricketquestion" class="nav-item nav-link"><i class="fas fa-question"></i>Cricket Questions</a>
                    <a href="criketbetting" class="nav-item nav-link"><i class="fas fa-money-bill"></i>Cricket Bets</a>
                    <a href="adreward" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Add Reward</a>
                    <a href="inviterec" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Invite Record</a>                    <a href="adwith" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Withdraw Req</a>
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
                <form class="d-none d-md-flex ms-4">
                    <input class="form-control border-0" type="search" placeholder="Search">
                </form>
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
            <div>
  <table style="background-color: White;">
    <tr>
       <th>ID</th>
            <th>Username</th>
            <th>Match ID</th>
            <th>Match Name</th>
            <th>Question</th>
            <th>Answer Bet</th>
            <th>Answer Correct</th>
            <th>Bet Amount</th>
            <th>Win Amount</th>
            <th>Bet Dated</th>
      
      
    </tr>
    
    <?php echo $dataRow;?>

</table>
</div>

<script>
  function openNav() {
      document.getElementById("mySidenav").style.width = "250px";
      document.getElementById("main").style.marginLeft = "250px";
    }
    
    function closeNav() {
      document.getElementById("mySidenav").style.width = "0";
      document.getElementById("main").style.marginLeft= "0";
    }
// JavaScript code
function search() {
	let input = document.getElementById('searchbar').value
	input=input.toLowerCase();
	let x = document.getElementsByClassName('user');
	
	for (i = 0; i < x.length; i++) {
		if (!x[i].innerHTML.toLowerCase().includes(input)) {
			x[i].style.display="none";
		}
		else {
			x[i].style.display="";				
		}
	}
}

</script>

            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4"style="
    background-color: #efefef !important;
    margin-top: 101px;
    margin-right: -24px;
    margin-left: -25px;
">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="https://t.me/dailywinnersupportbot">Contact Developer</a>                        </div>
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
