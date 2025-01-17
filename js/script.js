    window.onload = function() {
        initializePage();
        fetchBetHistory();
    };
    
    function initializePage() {
        updateCountdown();
        fetchUserBalance();
        // Add other initialization tasks here if needed
    }

    var loggedInUsername = localStorage.getItem('username');
        function placeBet(questionId, matchId) {
    var betAmountInput = document.getElementById('betAmount_' + questionId);
    var betAmount = betAmountInput.value.trim();

    // Validate the bet amount
    if (betAmount === '' || isNaN(betAmount) || parseFloat(betAmount) <= 0) {
        alert('Please enter a valid bet amount.');
        return;
    }

    // Get the selected answer
    var answerSelect = document.querySelector('#answer_' + questionId);
    var selectedAnswer = answerSelect.value.trim();

    // Validate the selected answer
    if (selectedAnswer === '') {
        alert('Please select an answer.');
        return;
    }

    // Perform balance check
    var userBalance = parseFloat(document.getElementById('u_bal').textContent);
    if (parseFloat(betAmount) > userBalance) {
        alert('Insufficient balance. Please top up your account.');
        return;
    }

    // Make an API call to place the bet
    fetch('Cricket/place_bet.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            username: loggedInUsername, // Include the username here
            questionId: questionId,
            matchId: matchId, // Include the match ID here
            betAmount: betAmount,
            selectedAnswer: selectedAnswer // Include the selected answer
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        // Handle the response
        if (data.success) {
            alert('Bet placed successfully'); // Display success message
        } else {
            alert('Failed to place bet: ' + data.message); // Display error message
        }
    })
    .catch(error => {
        console.error('Error placing bet:', error);
        alert('Error placing bet: ' + error.message); // Display error message
    });
}
    
    function toggleQuestions(event, matchId) {
        // Get the questions container for the current match
        var questionsContainer = document.getElementById('match' + matchId + 'Questions');
        
        // Check if the questions container exists
        if (questionsContainer) {
            // Get all question containers
            var allQuestionsContainers = document.querySelectorAll('.match-questions');
            
            // Loop through all question containers
            allQuestionsContainers.forEach(function(container) {
                // Close all question containers except the current one
                if (container.id !== 'match' + matchId + 'Questions') {
                    container.style.display = 'none';
                }
            });
            
            // Toggle the display of the current questions container
            if (questionsContainer.style.display === 'none') {
                questionsContainer.style.display = 'block';
            } else {
                questionsContainer.style.display = 'none';
            }
        } else {
            console.error('Questions container not found for match ID: ' + matchId);
        }
        // Prevent the click event from bubbling up to the parent elements
        event.stopPropagation();
    }
    
    
    function toggleQuestion(event) {
    var questionHeader = event.currentTarget;
    var questionCard = questionHeader.closest('.question-card');
    var contentElement = questionCard.querySelector('.question-content');
    var toggleIconElement = questionCard.querySelector('.toggle-icon');

    if (contentElement && toggleIconElement) {
        if (contentElement.style.display === 'block') {
            contentElement.style.display = 'none';
            toggleIconElement.innerHTML = '<img src="https://cdn-icons-png.flaticon.com/128/5720/5720464.png" alt="Close" style="width: 20px; height: 20px;">';
        } else {
            contentElement.style.display = 'block';
            toggleIconElement.innerHTML = '<img src="https://cdn-icons-png.flaticon.com/128/5683/5683501.png" alt="Open" style="width: 20px; height: 20px;">';
        }
    } else {
        console.log("Content or toggle icon element not found for question.");
    }
}
    
    function fetchUserBalance() {
        const secretKey = 'pmF%2FmJtSzG7unQfCxL7yaL%2FbB9rYhaR0fPVnN4lO5tvXF8pPDUQ%2FB8LVrHpS%2FwiJQpnVfVKL8QwF9T0IEivwz9nJqpmQcvS'; // Your actual secret key
        const headers = new Headers();
        headers.append('Authorization', 'Bearer ' + secretKey);
    
        // Get the user ID dynamically
        const userId = localStorage.getItem('username'); // Assuming the user ID is stored in localStorage
    
        fetch(`https://mohammadfarmanali.com/9987/src/api/bet.php?action=info&user=${userId}&per=FastParity`, {
            method: 'GET',
            headers: headers
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Round the balance to the nearest whole number
            const roundedBalance = Math.round(data[0].balance);
            document.getElementById('u_bal').textContent = roundedBalance;
        })
        .catch(error => {
            console.error('Error fetching user balance:', error);
        });
    }
    
    // Call the function to update the countdown timer
    updateCountdown();
    
    // Function to update countdown timer
    function updateCountdown() {
        var countdowns = document.querySelectorAll('.betEndTimer');
        countdowns.forEach(function(countdown) {
            var remainingSeconds = parseInt(countdown.dataset.time);
            var timerInterval = setInterval(function() {
                if (remainingSeconds <= 0) {
                    clearInterval(timerInterval);
                    countdown.textContent = "Expired";
                } else {
                    var hours = Math.floor(remainingSeconds / 3600);
                    var minutes = Math.floor((remainingSeconds % 3600) / 60);
                    var seconds = remainingSeconds % 60;
    
                    countdown.textContent = hours.toString().padStart(2, '0') + ':' +
                                             minutes.toString().padStart(2, '0') + ':' +
                                             seconds.toString().padStart(2, '0');
    
                    remainingSeconds--;
                }
            }, 1000);
        });
    }
    
    // Start countdown on page load
    window.onload = function() {
        updateCountdown();
    };
    
  // JavaScript for automatic sliding of banner images
var currentIndex = 0;
var bannerImages = document.querySelectorAll('.banner-image');
var slideDuration = 2000; // Time in milliseconds for each slide

function showNextImage() {
    // Hide the current image
    bannerImages[currentIndex].style.display = 'none';
    // Calculate the index of the next image
    currentIndex = (currentIndex + 1) % bannerImages.length;
    // Show the next image
    bannerImages[currentIndex].style.display = 'block';
}

// Show the first image initially
bannerImages[currentIndex].style.display = 'block';

// Start automatic sliding every 'slideDuration' milliseconds
setInterval(showNextImage, slideDuration);

    
    
    function goToHomePage() {
        window.location.href = 'https://mohammadfarmanali.com/#/';
    }
    
     document.getElementById('open').classList.add('active');
    
    function showTab(tabName) {
                // Hide all tab contents
                var tabContents = document.querySelectorAll('.tab-content');
                tabContents.forEach(function(tabContent) {
                    tabContent.classList.remove('active');
                });
    
                // Deactivate all tabs
                var tabs = document.querySelectorAll('.tab');
                tabs.forEach(function(tab) {
                    tab.classList.remove('active');
                });
    
                // Show the selected tab content
                var selectedTab = document.getElementById(tabName);
                selectedTab.classList.add('active');
    
                // Activate the selected tab
                var tab = document.querySelector('.tab[data-tab="' + tabName + '"]');
                // tab.classList.add('active');
            }

    // Retrieve the username from local storage
    var loggedInUsernameforbethistory = localStorage.getItem('username');
    
    // Fetch bet history data from the server for the logged-in user
    fetch('https://mohammadfarmanali.com/Cricket/get_bet_history.php?username=' + loggedInUsernameforbethistory)
      .then(response => response.json()) // Parse JSON response
      .then(data => {
        // Handle the fetched data
        renderBetHistory(data);
      })
      .catch(error => {
        console.error('Error fetching bet history:', error);
        // Display error message to the user
        document.getElementById('bet-history').innerHTML = 'Error fetching bet history. Please try again later.';
      });
      // Function to render bet history data
    function renderBetHistory(data) {
      // Access the table body element where the data will be displayed
      const betHistoryTbody = document.getElementById('bet-history');

      // Clear existing content
      betHistoryTbody.innerHTML = '';

      // Iterate over the fetched data and create table rows to display it
      data.forEach(record => {
        // Create table row to display each record
        const tr = document.createElement('tr');

        // Create table data cells to display record fields
        const matchNameTd = document.createElement('td');
        matchNameTd.textContent = record.match_name;

        const betOnTd = document.createElement('td');
        betOnTd.textContent = record.answer_bet;

        const resultTd = document.createElement('td');
        resultTd.textContent = record.answer_correct;

        const winningTd = document.createElement('td');
        winningTd.textContent = record.win_amount;

        const betAmountTd = document.createElement('td'); // Create cell for bet amount
        betAmountTd.textContent = record.bet_amount; // Set bet amount

        const dateTd = document.createElement('td');
        dateTd.textContent = record.bet_dated;

        // Append table data cells to the table row
        tr.appendChild(matchNameTd);
        tr.appendChild(betOnTd);
        tr.appendChild(resultTd);
        tr.appendChild(betAmountTd); // Append bet amount cell
        tr.appendChild(winningTd);
        tr.appendChild(dateTd); // Append date cell

        // Append the created table row to the table body
        betHistoryTbody.appendChild(tr);
      });
    }

