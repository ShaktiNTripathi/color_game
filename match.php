<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title -->
    <title>Example Page</title>
    <!-- Styles -->
    <style>
    
    /* Keyframes for zoom in and zoom out animation */
    @keyframes zoomIn {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.2);
        }
        100% {
            transform: scale(1);
        }
    }

    @keyframes zoomOut {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(0.8);
        }
        100% {
            transform: scale(1);
        }
    }

    /* Bet ended text style */
    .betEndText {
        animation: zoomInOut 2s infinite; /* Apply the zoom in and zoom out animation */
        color: red; /* Set the text color to red */
    }

    /* Class to alternate between zoom in and zoom out animations */
    @keyframes zoomInOut {
        0%, 100% {
            animation-timing-function: ease-in-out;
            transform: scale(1);
        }
        50% {
            animation-timing-function: ease-in-out;
            transform: scale(1.2);
        }
    }
        .question-card {
            margin-bottom: 10px;
        }
        
        .question-header {
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .question-text {
            flex: 1; /* Take up remaining space */
            text-align: center; /* Center the text */
        }

        .toggle-icon {
            margin-left: auto; /* Push the toggle icon to the right */
        }

        .question-content {
            display: none;
        }

        /* Styles for banner container */
        .banner-container {
            max-width: 100%; /* Adjust the maximum width as needed */
            overflow: hidden; /* Ensure images don't overflow the container */
            margin-top: 10px; /* Add a margin of 10 pixels from the top */
        }
        
         
        /* Styles for banner images */
        .banner-image {
            width: auto; /* Let the browser calculate the width based on the image's aspect ratio */
            height: auto; /* Let the browser calculate the height based on the image's aspect ratio */
            max-width: 100%; /* Ensure images don't exceed the container's width */
            display: none; /* Hide all images initially */
            border-radius: 10px; /* Rounded corners */
            transition: transform 0.5s ease; /* Add animation effect */
        }

        /* Apply hover effect to the banner images */
        .banner-image:hover {
            transform: scale(1.05); /* Increase the size on hover */
        }

        /* Styles for match card container */
        .gmvBox {
            border-radius: 10px; /* Rounded corners */
            border: 1px solid #ccc; /* Add a border for better visibility */
            padding: 10px; /* Add padding to give some space inside the card */
        }

        .games {
            margin-bottom: 2px; /* Reduce the margin between match cards */
        }

        /* Tab styles */
        .tab-container {
            margin-top: 20px;
            border-bottom: 1px solid #ccc;
        }

        .tab {
            display: inline-block;
            padding: 10px 20px;
            cursor: pointer;
            border-bottom: 2px solid transparent; /* Add transparent bottom border initially */
            transition: border-color 0.3s ease; /* Add transition effect on border color change */
        }

        .tab.active {
            color: black; /* Change text color to black for active tab */
            border-color: black; /* Change bottom border color to black for active tab */
        }

        .tab:hover {
            border-color: #666; /* Change border color on hover */
        }

        .tab-content {
            display: none;
            padding: 0px;
            border: 1px solid #ccc;
            border-top: none;
            border-radius: 0 0 5px 5px;
            width: 100%; /* Adjust the width */
            height: calc(100vh - 160px); /* Adjust the height according to other fixed elements' height */
            overflow-y: auto; /* Enable vertical scrolling if needed */
        }

        .tab-content.active {
            display: block;
        }
    </style>
</head>

<body>
    <!-- Main container -->
    <div class="row" id="warea">
        <!-- Top navigation -->
        <div class="col-12 nav-top">
            <div class="row" style="background:linear-gradient(270deg,#19398A,#2A3676)">
                <!-- Left section -->
                <div class="col-6 xtl">
                    <!-- Back button and page title -->
                    <span class="nav-back wt" onclick="goToHomePage()"></span>
                    <span class="tf-28"><img src="" height="32">Cricket</span>
                </div>
                <!-- Right section -->
                <div class="col-6 xtr" style="display:flex;place-content:flex-end;align-items:center">
                    <!-- Wallet icon and balance -->
                    <span class="icon wallet color" style="margin-right: 6px;"></span>
                    <span class="jxwb">
                        <!-- PHP: Display user balance -->
                        <?php include 'config.php'; ?>
                        <span class="tf-18 plr-5 text-white" id="u_bal"><?php echo $balance; ?></span>
                        <span class="tf-16">INR</span>
                    </span>
                </div>
            </div>
        </div>
        <!-- Banner view container -->
        <div class="col-12 banner-container">
            <!-- Banner images -->
            <img src="https://kushubmedia.com/build/new-osg-app/slider/3.png" alt="Banner 1" class="banner-image">
            <img src="https://kushubmedia.com/build/new-osg-app/slider/1.png" alt="Banner 2" class="banner-image">
        </div>

        <!-- Tab container -->
        <div class="col-12 tab-container">
            <!-- Tabs -->
            <div class="tab active" onclick="showTab('open')">Open Bets</div>
            <!--<div class="tab" onclick="showTab('closed')">Closed Bets</div>-->
            <div class="tab" onclick="showTab('my')">My Bets</div>
        </div>

        <!-- Tab content -->
        <div id="open" class="tab-content active">
            <!-- Include open bets section -->
            <?php include 'Cricket/MatchCards.php'; ?>
        </div>
        <div id="closed" class="tab-content">
            <!-- Include closed bets section -->
            <?php include 'Cricket/ClosedBets.php'; ?>
        </div>
        <div id="my" class="tab-content">
            <!-- Include my bets section -->
            <?php include 'Cricket/MyBets.php'; ?>
        </div>
    </div>

    <!-- Include the script.js file -->
    <script src="https://mohammadfarmanali.com/js/script.js"></script>

</body>

</html>
